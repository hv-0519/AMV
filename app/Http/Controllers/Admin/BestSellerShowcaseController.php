<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BestSellerShowcase;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BestSellerShowcaseController extends Controller
{
    public function index(): View
    {
        $items    = BestSellerShowcase::orderBy('sort_order')->orderBy('id')->get();
        $interval = SiteSetting::get('carousel_interval', 4);

        return view('admin.best-sellers.index', compact('items', 'interval'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'tag'    => 'nullable|string|max:60',
            'rating' => 'required|numeric|min:1|max:5',
            'image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $path = $request->file('image')->store('best-sellers', 'public');

        BestSellerShowcase::create([
            'name'       => $request->name,
            'tag'        => $request->tag,
            'rating'     => $request->rating,
            'image'      => $path,
            'sort_order' => BestSellerShowcase::max('sort_order') + 1,
            'is_active'  => true,
        ]);

        return back()->with('success', "'{$request->name}' added to the showcase! ✅");
    }

    public function update(Request $request, BestSellerShowcase $bestSeller): RedirectResponse
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'tag'    => 'nullable|string|max:60',
            'rating' => 'required|numeric|min:1|max:5',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = $request->only('name', 'tag', 'rating');

        if ($request->hasFile('image')) {
            if ($bestSeller->image) {
                Storage::disk('public')->delete($bestSeller->image);
            }
            $data['image'] = $request->file('image')->store('best-sellers', 'public');
        }

        $bestSeller->update($data);

        return back()->with('success', "'{$bestSeller->name}' updated! ✅");
    }

    public function toggleActive(BestSellerShowcase $bestSeller): RedirectResponse
    {
        $bestSeller->update(['is_active' => ! $bestSeller->is_active]);

        return back()->with('success', "Visibility updated.");
    }

    public function destroy(BestSellerShowcase $bestSeller): RedirectResponse
    {
        if ($bestSeller->image) {
            Storage::disk('public')->delete($bestSeller->image);
        }
        $bestSeller->delete();

        return back()->with('success', "Item removed.");
    }

    public function updateInterval(Request $request): RedirectResponse
    {
        $request->validate([
            'carousel_interval' => 'required|integer|min:1|max:30',
        ]);

        SiteSetting::set('carousel_interval', $request->carousel_interval);

        return back()->with('success', "Carousel speed updated to {$request->carousel_interval} seconds! ✅");
    }
}

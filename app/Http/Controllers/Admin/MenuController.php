<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $menu_items = $query->orderBy('id')->get();

        return view('admin.menu.index', compact('menu_items'));
    }

    public function create()
    {
        return view('admin.menu.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string',
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'spice_level' => 'nullable|integer|between:1,5',
            'ingredients' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu', 'public');
        }

        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_bestseller'] = $request->boolean('is_bestseller');
        $validated['is_featured'] = $request->boolean('is_featured');

        MenuItem::create($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu item added successfully! 🍽️');
    }

    public function edit(MenuItem $menu_item)
    {
        return view('admin.menu.form', compact('menu_item'));
    }

    public function update(Request $request, MenuItem $menu_item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string',
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'spice_level' => 'nullable|integer|between:1,5',
            'ingredients' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($menu_item->image) {
                Storage::disk('public')->delete($menu_item->image);
            }
            $validated['image'] = $request->file('image')->store('menu', 'public');
        }

        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_bestseller'] = $request->boolean('is_bestseller');
        $validated['is_featured'] = $request->boolean('is_featured');

        $menu_item->update($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu item updated successfully! ✅');
    }

    public function destroy(MenuItem $menu_item)
    {
        if ($menu_item->image) {
            Storage::disk('public')->delete($menu_item->image);
        }
        $menu_item->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu item deleted.');
    }
}

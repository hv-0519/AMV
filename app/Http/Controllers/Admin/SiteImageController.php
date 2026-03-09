<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteImageController extends Controller
{
    public function index(): View
    {
        $images = SiteImage::orderBy('id')->get();
        $galleryImages = \App\Models\GalleryImage::orderBy('sort_order')->get();

        return view('admin.site-images.index', compact('images', 'galleryImages'));
    }

    public function update(Request $request, SiteImage $siteImage): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($siteImage->image) {
            Storage::disk('public')->delete($siteImage->image);
        }

        $path = $request->file('image')->store('site-images', 'public');

        $siteImage->update(['image' => $path]);

        return back()->with('success', "'{$siteImage->label}' image updated successfully! ✅");
    }

    public function destroy(SiteImage $siteImage): RedirectResponse
    {
        if ($siteImage->image) {
            Storage::disk('public')->delete($siteImage->image);
            $siteImage->update(['image' => null]);
        }

        return back()->with('success', "'{$siteImage->label}' image removed.");
    }

    public function uploadGallery(Request $request): RedirectResponse
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('gallery', 'public');
                \App\Models\GalleryImage::create([
                    'image' => $path,
                    'sort_order' => ((int) \App\Models\GalleryImage::max('sort_order')) + 1,
                ]);
            }
        }

        return back()->with('success', 'Gallery images uploaded successfully! 📸');
    }

    public function destroyGallery(\App\Models\GalleryImage $galleryImage): RedirectResponse
    {
        Storage::disk('public')->delete($galleryImage->image);
        $galleryImage->delete();

        return back()->with('success', 'Gallery image deleted! 🗑️');
    }
}

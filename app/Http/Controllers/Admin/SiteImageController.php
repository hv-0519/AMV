<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        $url = cloudinary()->upload(
            $request->file('image')->getRealPath(),
            ['folder' => 'amv/site-images']
        )->getSecurePath();

        $siteImage->update(['image' => $url]);

        return back()->with('success', "'{\$siteImage->label}' image updated successfully! ✅");
    }

    public function destroy(SiteImage $siteImage): RedirectResponse
    {
        $siteImage->update(['image' => null]);

        return back()->with('success', "'{\$siteImage->label}' image removed.");
    }

    public function uploadGallery(Request $request): RedirectResponse
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $url = cloudinary()->upload(
                    $file->getRealPath(),
                    ['folder' => 'amv/gallery']
                )->getSecurePath();

                \App\Models\GalleryImage::create([
                    'image' => $url,
                    'sort_order' => ((int) \App\Models\GalleryImage::max('sort_order')) + 1,
                ]);
            }
        }

        return back()->with('success', 'Gallery images uploaded successfully! 📸');
    }

    public function destroyGallery(\App\Models\GalleryImage $galleryImage): RedirectResponse
    {
        $galleryImage->delete();

        return back()->with('success', 'Gallery image deleted! 🗑️');
    }
}

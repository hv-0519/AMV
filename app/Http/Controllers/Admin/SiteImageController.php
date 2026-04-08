<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteImage;
use App\Services\CloudinaryHelper;
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
        $request->validate(['image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096']);

        $url = (new CloudinaryHelper)->upload(
            $request->file('image')->getRealPath(), 'amv/site-images'
        );

        $siteImage->update(['image' => $url]);
        return back()->with('success', "'{$siteImage->label}' image updated successfully! ✅");
    }

    public function destroy(SiteImage $siteImage): RedirectResponse
    {
        $siteImage->update(['image' => null]);
        return back()->with('success', "'{$siteImage->label}' image removed.");
    }

    public function uploadGallery(Request $request): RedirectResponse
    {
        $request->validate(['images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096']);

        if ($request->hasFile('images')) {
            $helper = new CloudinaryHelper;
            foreach ($request->file('images') as $file) {
                $url = $helper->upload($file->getRealPath(), 'amv/gallery');
                \App\Models\GalleryImage::create([
                    'image'      => $url,
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

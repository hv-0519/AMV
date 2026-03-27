<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Services\RecommendationService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured_items = MenuItem::available()->featured()->take(8)->get();
        $bestsellers    = MenuItem::available()->bestsellers()->take(4)->get();
        return view('pages.home', compact('featured_items', 'bestsellers'));
    }

    public function menu(Request $request, RecommendationService $recommendations)
    {
        $query = MenuItem::available();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $menu_items = $query->get()->groupBy('category');
        $categories = MenuItem::available()->distinct()->pluck('category');

        // Bulk-load top-1 pairing per item — only 2 queries, regardless of menu size
        $allIds  = $menu_items->flatten()->pluck('id')->toArray();
        $pairMap = $recommendations->forMany($allIds);   // [ item_id => MenuItem|null ]

        return view('pages.menu', compact('menu_items', 'categories', 'pairMap'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        return back()
            ->with('success', 'Thank you for reaching out! We\'ll get back to you soon. 🌶️')
            ->with('flash_modal', 'contact-success');
    }

    public function catering()
    {
        return view('pages.catering');
    }

    public function submitCatering(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email',
            'phone'        => 'required|string|max:20',
            'event_date'   => 'required|date|after:today',
            'event_type'   => 'required|string',
            'guests_count' => 'required|integer|min:10',
            'location'     => 'required|string|max:300',
            'message'      => 'nullable|string',
        ]);

        \App\Models\CateringRequest::create($validated);

        return back()
            ->with('success', 'Catering request submitted! Our team will contact you within 24 hours. 🎉')
            ->with('flash_modal', 'catering-success');
    }

    public function franchise()
    {
        return view('pages.franchise');
    }

    public function submitFranchise(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:100',
            'email'               => 'required|email',
            'phone'               => 'required|string|max:20',
            'city'                => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'investment_capacity' => 'required|string',
            'message'             => 'nullable|string',
        ]);

        \App\Models\FranchiseEnquiry::create($validated);

        return back()
            ->with('success', 'Franchise enquiry received! We\'ll connect with you shortly. 🏪')
            ->with('flash_modal', 'franchise-success');
    }

    public function gallery()
    {
        $galleryImages = \App\Models\GalleryImage::orderBy('sort_order')->orderBy('id', 'desc')->get();
        return view('pages.gallery', compact('galleryImages'));
    }

    public function careers()
    {
        return view('pages.careers');
    }
}

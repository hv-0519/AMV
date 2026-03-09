<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FranchiseEnquiry;
use Illuminate\Http\Request;

class FranchiseController extends Controller
{
    public function index(Request $request)
    {
        $query = FranchiseEnquiry::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%')
                  ->orWhere('state', 'like', '%' . $request->search . '%');
            });
        }

        $enquiries = $query->latest()->paginate(15);

        $counts = [
            'all'         => FranchiseEnquiry::count(),
            'new'         => FranchiseEnquiry::where('status', 'new')->count(),
            'contacted'   => FranchiseEnquiry::where('status', 'contacted')->count(),
            'in_progress' => FranchiseEnquiry::where('status', 'in_progress')->count(),
            'approved'    => FranchiseEnquiry::where('status', 'approved')->count(),
            'rejected'    => FranchiseEnquiry::where('status', 'rejected')->count(),
        ];

        return view('admin.franchise.index', compact('enquiries', 'counts'));
    }

    public function show(FranchiseEnquiry $franchise)
    {
        return view('admin.franchise.show', compact('franchise'));
    }

    public function updateStatus(Request $request, FranchiseEnquiry $franchise)
    {
        $request->validate([
            'status' => 'required|in:new,contacted,in_progress,approved,rejected',
        ]);

        $franchise->update(['status' => $request->status]);

        return back()->with('success', "Franchise enquiry status updated to '" . ucfirst(str_replace('_', ' ', $request->status)) . "'! ✅");
    }
}

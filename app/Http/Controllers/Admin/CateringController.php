<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CateringRequest;
use Illuminate\Http\Request;

class CateringController extends Controller
{
    public function index(Request $request)
    {
        $query = CateringRequest::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('event_type', 'like', '%' . $request->search . '%');
            });
        }

        $catering_requests = $query->latest()->paginate(15);

        $counts = [
            'all'       => CateringRequest::count(),
            'new'       => CateringRequest::where('status', 'new')->count(),
            'contacted' => CateringRequest::where('status', 'contacted')->count(),
            'confirmed' => CateringRequest::where('status', 'confirmed')->count(),
            'completed' => CateringRequest::where('status', 'completed')->count(),
            'rejected'  => CateringRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.catering.index', compact('catering_requests', 'counts'));
    }

    public function show(CateringRequest $catering)
    {
        return view('admin.catering.show', compact('catering'));
    }

    public function updateStatus(Request $request, CateringRequest $catering)
    {
        $request->validate([
            'status' => 'required|in:new,contacted,confirmed,completed,rejected',
        ]);

        $catering->update(['status' => $request->status]);

        return back()->with('success', "Catering request status updated to '" . ucfirst($request->status) . "'! ✅");
    }
}

@extends('layouts.admin')
@section('title', 'Franchise Enquiry #' . $franchise->id)

@section('content')
<div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; align-items:start;">

    <!-- Details -->
    <div class="data-card">
        <div class="data-card-header">
            <h3>🏪 Franchise Enquiry #{{ $franchise->id }}</h3>
            <a href="{{ route('admin.franchise.index') }}" class="btn btn-outline btn-sm">← Back</a>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
            <div>
                <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Name</p>
                <p style="font-weight:600;">{{ $franchise->name }}</p>
            </div>
            <div>
                <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Email</p>
                <p>{{ $franchise->email }}</p>
            </div>
            <div>
                <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Phone</p>
                <p>{{ $franchise->phone }}</p>
            </div>
            <div>
                <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">City</p>
                <p>{{ $franchise->city }}</p>
            </div>
            <div>
                <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">State</p>
                <p>{{ $franchise->state }}</p>
            </div>
            <div>
                <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Investment Capacity</p>
                <p><span class="badge badge-info">{{ $franchise->investment_capacity }}</span></p>
            </div>
            @if($franchise->message)
            <div style="grid-column:1/-1;">
                <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Message</p>
                <div style="background:#fff8ef; border-radius:8px; padding:0.8rem; font-size:0.9rem;">{{ $franchise->message }}</div>
            </div>
            @endif
            <div>
                <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Submitted At</p>
                <p style="font-size:0.85rem;">{{ $franchise->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>
    </div>

    <!-- Right Panel: Update Status -->
    <div class="data-card">
        <h3 style="font-size:1rem; margin-bottom:1.2rem;">🔄 Update Status</h3>
        <form method="POST" action="{{ route('admin.franchise.updateStatus', $franchise->id) }}">
            @csrf @method('PATCH')
            <div class="form-group" style="margin-bottom:1rem;">
                <label style="font-size:0.85rem; font-weight:600; color:#444; display:block; margin-bottom:0.4rem;">Enquiry Status</label>
                <select name="status" class="form-control" required>
                    @foreach(['new','contacted','in_progress','approved','rejected'] as $status)
                    <option value="{{ $status }}" {{ $franchise->status == $status ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">
                <i class="fas fa-save"></i> Update Status
            </button>
        </form>

        <div style="margin-top:1.2rem; padding-top:1rem; border-top:1px solid #f0ebe3;">
            <div style="font-size:0.8rem; line-height:2.2; color:#666;">
                <div>🔔 <strong>New</strong> — Just submitted</div>
                <div>📞 <strong>Contacted</strong> — Team has reached out</div>
                <div>🔄 <strong>In Progress</strong> — Under review/discussion</div>
                <div>✅ <strong>Approved</strong> — Franchise approved</div>
                <div>❌ <strong>Rejected</strong> — Not moving forward</div>
            </div>
        </div>
    </div>
</div>
@endsection

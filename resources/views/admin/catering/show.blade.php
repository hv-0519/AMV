@extends('layouts.admin')
@section('title', 'Catering Request #' . $catering->id)

@section('content')
<div class="stack-grid">

    <!-- Details -->
    <div>
        <div class="data-card" style="margin-bottom:1.5rem;">
            <div class="data-card-header">
                <h3>🎉 Catering Request #{{ $catering->id }}</h3>
                <a href="{{ route('admin.catering.index') }}" class="btn btn-outline btn-sm">← Back</a>
            </div>
            <div class="form-grid">
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Name</p>
                    <p style="font-weight:600;">{{ $catering->name }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Email</p>
                    <p>{{ $catering->email }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Phone</p>
                    <p>{{ $catering->phone }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Event Type</p>
                    <p><span class="badge badge-info">{{ $catering->event_type }}</span></p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Event Date</p>
                    <p style="font-weight:600;">📅 {{ $catering->event_date->format('d M Y') }}</p>
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Guests Count</p>
                    <p style="font-weight:600;">👥 {{ $catering->guests_count }} people</p>
                </div>
                <div style="grid-column:1/-1;">
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Location</p>
                    <p>📍 {{ $catering->location }}</p>
                </div>
                @if($catering->message)
                <div style="grid-column:1/-1;">
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Message</p>
                    <div style="background:#fff8ef; border-radius:8px; padding:0.8rem; font-size:0.9rem;">{{ $catering->message }}</div>
                </div>
                @endif
                <div>
                    <p style="font-size:0.75rem; color:#aaa; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">Submitted At</p>
                    <p style="font-size:0.85rem;">{{ $catering->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel: Update Status -->
    <div class="data-card">
        <h3 style="font-size:1rem; margin-bottom:1.2rem;">🔄 Update Status</h3>
        <form method="POST" action="{{ route('admin.catering.updateStatus', $catering->id) }}" class="js-crud-ajax" data-loading="Updating catering request..." data-success="Catering request status updated.">
            @csrf @method('PATCH')
            <div class="form-group" style="margin-bottom:1rem;">
                <label style="font-size:0.85rem; font-weight:600; color:#444; display:block; margin-bottom:0.4rem;">Catering Status</label>
                <select name="status" class="form-control" required>
                    @foreach(['new','contacted','confirmed','completed','rejected'] as $status)
                    <option value="{{ $status }}" {{ $catering->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
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
                <div>✅ <strong>Confirmed</strong> — Booking confirmed</div>
                <div>🎉 <strong>Completed</strong> — Event done</div>
                <div>❌ <strong>Rejected</strong> — Could not fulfill</div>
            </div>
        </div>
    </div>
</div>
@endsection

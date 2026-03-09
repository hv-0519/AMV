@extends('layouts.admin')
@section('title', 'Catering Requests')

@section('content')
<!-- Status Summary -->
<div class="stats-grid" style="grid-template-columns:repeat(6,1fr); margin-bottom:1.5rem;">
    @php
    $statuses = [
        'all'       => ['label' => 'All',       'icon' => 'fas fa-list',   'color' => ''],
        'new'       => ['label' => 'New',        'icon' => 'fas fa-bell',   'color' => 'red'],
        'contacted' => ['label' => 'Contacted',  'icon' => 'fas fa-phone',  'color' => 'blue'],
        'confirmed' => ['label' => 'Confirmed',  'icon' => 'fas fa-check',  'color' => 'green'],
        'completed' => ['label' => 'Completed',  'icon' => 'fas fa-flag',   'color' => 'green'],
        'rejected'  => ['label' => 'Rejected',   'icon' => 'fas fa-times',  'color' => 'red'],
    ];
    @endphp
    @foreach($statuses as $key => $s)
    <a href="{{ route('admin.catering.index', $key !== 'all' ? ['status' => $key] : []) }}" style="text-decoration:none;">
        <div class="stat-card {{ $s['color'] }}" style="{{ request('status') == $key || ($key === 'all' && !request('status')) ? 'border:2px solid var(--saffron);' : '' }}">
            <div class="stat-icon"><i class="{{ $s['icon'] }}"></i></div>
            <div>
                <div class="stat-number" style="font-size:1.3rem;">{{ $counts[$key] ?? 0 }}</div>
                <div class="stat-label">{{ $s['label'] }}</div>
            </div>
        </div>
    </a>
    @endforeach
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>🎉 Catering Requests</h3>
        <form method="GET" action="{{ route('admin.catering.index') }}" style="display:flex; gap:0.5rem;">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone..." class="form-control" style="width:260px;">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Contact</th>
                <th>Event</th>
                <th>Guests</th>
                <th>Location</th>
                <th>Event Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($catering_requests as $catering)
            <tr>
                <td>{{ $catering->id }}</td>
                <td>
                    <div><strong>{{ $catering->name }}</strong></div>
                    <small style="color:#aaa;">{{ $catering->email }}</small><br>
                    <small style="color:#aaa;">{{ $catering->phone }}</small>
                </td>
                <td><span class="badge badge-info">{{ $catering->event_type }}</span></td>
                <td><strong>{{ $catering->guests_count }}</strong> pax</td>
                <td style="font-size:0.85rem; max-width:150px;">{{ Str::limit($catering->location, 40) }}</td>
                <td style="font-size:0.85rem;">{{ $catering->event_date->format('d M Y') }}</td>
                <td>
                    @php
                    $badge = match($catering->status) {
                        'new'       => 'badge-danger',
                        'contacted' => 'badge-info',
                        'confirmed' => 'badge-warning',
                        'completed' => 'badge-success',
                        'rejected'  => 'badge-danger',
                        default     => '',
                    };
                    @endphp
                    <span class="badge {{ $badge }}">{{ ucfirst($catering->status) }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.catering.show', $catering->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; color:#aaa; padding:2rem;">No catering requests found 📭</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $catering_requests->links() }}</div>
</div>
@endsection

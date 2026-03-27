@extends('layouts.admin')
@section('title', 'Franchise Enquiries')

@section('content')
<!-- Status Summary -->
<div class="stats-grid" style="margin-bottom:1.5rem;">
    @php
    $statuses = [
        'all'         => ['label' => 'All',         'icon' => 'fas fa-list',        'color' => ''],
        'new'         => ['label' => 'New',          'icon' => 'fas fa-bell',        'color' => 'red'],
        'contacted'   => ['label' => 'Contacted',    'icon' => 'fas fa-phone',       'color' => 'blue'],
        'in_progress' => ['label' => 'In Progress',  'icon' => 'fas fa-spinner',     'color' => 'blue'],
        'approved'    => ['label' => 'Approved',     'icon' => 'fas fa-check',       'color' => 'green'],
        'rejected'    => ['label' => 'Rejected',     'icon' => 'fas fa-times',       'color' => 'red'],
    ];
    @endphp
    @foreach($statuses as $key => $s)
    <a href="{{ route('admin.franchise.index', $key !== 'all' ? ['status' => $key] : []) }}" style="text-decoration:none;">
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
        <h3>🏪 Franchise Enquiries</h3>
        <form method="GET" action="{{ route('admin.franchise.index') }}" class="inline-tools">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, city..." class="form-control" style="width:260px;">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Applicant</th>
                <th>Location</th>
                <th>Investment</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enquiries as $franchise)
            <tr>
                <td>{{ $franchise->id }}</td>
                <td>
                    <div><strong>{{ $franchise->name }}</strong></div>
                    <small style="color:#aaa;">{{ $franchise->email }}</small><br>
                    <small style="color:#aaa;">{{ $franchise->phone }}</small>
                </td>
                <td>📍 {{ $franchise->full_location }}</td>
                <td><span class="badge badge-info">{{ $franchise->investment_capacity }}</span></td>
                <td>
                    @php
                    $badge = match($franchise->status) {
                        'new'         => 'badge-danger',
                        'contacted'   => 'badge-info',
                        'in_progress' => 'badge-warning',
                        'approved'    => 'badge-success',
                        'rejected'    => 'badge-danger',
                        default       => '',
                    };
                    @endphp
                    <span class="badge {{ $badge }}">{{ $franchise->status_label }}</span>
                </td>
                <td style="font-size:0.82rem; color:#888;">{{ $franchise->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.franchise.show', $franchise->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#aaa; padding:2rem;">No franchise enquiries found 📭</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $enquiries->links() }}</div>
</div>
@endsection

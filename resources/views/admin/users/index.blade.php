@extends('layouts.admin')
@section('title', 'Users')

@section('content')
<!-- Stats -->
<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-number">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Customers</div>
        </div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
        <div>
            <div class="stat-number">{{ $stats['staff'] }}</div>
            <div class="stat-label">Staff Members</div>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-user-plus"></i></div>
        <div>
            <div class="stat-number">{{ $stats['new_today'] }}</div>
            <div class="stat-label">New Today</div>
        </div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>👥 Users</h3>
        <form method="GET" action="{{ route('admin.users.index') }}" class="inline-tools">
            <select name="role" class="form-control" style="width:140px;" onchange="this.form.submit()">
                <option value="">All Roles</option>
                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone..." class="form-control" style="width:240px;">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Orders</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    <div><strong>{{ $user->name }}</strong></div>
                    <small style="color:#aaa;">{{ $user->email }}</small>
                </td>
                <td style="font-size:0.85rem;">{{ $user->phone ?? '—' }}</td>
                <td>
                    <span class="badge {{ $user->role === 'staff' ? 'badge-warning' : 'badge-info' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td><strong>{{ $user->orders_count }}</strong></td>
                <td style="font-size:0.82rem; color:#888;">{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline btn-sm js-crud-modal" data-modal-title="User Details"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline btn-sm js-crud-modal" data-modal-title="Edit User"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" class="js-crud-delete" data-confirm="Delete this user account?" data-success="User deleted successfully.">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#aaa; padding:2rem;">No users found 📭</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $users->links() }}</div>
</div>
@endsection

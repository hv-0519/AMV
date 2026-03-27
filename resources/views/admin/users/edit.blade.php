@extends('layouts.admin')
@section('title', 'Edit User — ' . $user->name)

@section('content')
<div style="max-width:700px;">
    <div class="data-card">
        <div class="data-card-header">
            <h3>✏️ Edit User — {{ $user->name }}</h3>
            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline btn-sm">← Back</a>
        </div>
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="js-crud-ajax" data-loading="Updating user profile..." data-success="User updated successfully.">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" required>
                @error('name') <span style="color:red;font-size:0.82rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" required>
                @error('email') <span style="color:red;font-size:0.82rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $user->phone) }}" placeholder="Optional">
                @error('phone') <span style="color:red;font-size:0.82rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                @error('role') <span style="color:red;font-size:0.82rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                          rows="2" placeholder="Optional">{{ old('address', $user->address) }}</textarea>
                @error('address') <span style="color:red;font-size:0.82rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

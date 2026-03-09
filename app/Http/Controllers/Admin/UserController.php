<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->withCount('orders')->latest()->paginate(20);

        $stats = [
            'total'     => User::where('role', 'customer')->count(),
            'staff'     => User::where('role', 'staff')->count(),
            'new_today' => User::where('role', 'customer')->whereDate('created_at', today())->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function show(User $user)
    {
        $user->load(['orders' => function ($q) {
            $q->latest()->take(10);
        }]);

        $user->loadCount('orders');
        $total_spent = $user->orders()->where('status', 'completed')->sum('total_amount');

        return view('admin.users.show', compact('user', 'total_spent'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string|max:20',
            'role'    => 'required|in:customer,staff',
            'address' => 'nullable|string|max:300',
        ]);

        $user->update($request->only('name', 'email', 'phone', 'role', 'address'));

        return redirect()->route('admin.users.index')
            ->with('success', "User '{$user->name}' updated successfully! ✅");
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete an admin account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User account deleted.');
    }
}

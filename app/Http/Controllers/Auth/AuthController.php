<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Welcome back, ' . Auth::user()->name . '!')
                    ->with('auth_modal', 'welcome')
                    ->with('flash_modal', 'welcome-back');
            }

            if (Auth::user()->role === 'staff') {
                return redirect()->route('admin.orders.index')
                    ->with('success', 'Welcome back, ' . Auth::user()->name . '! 🌶️')
                    ->with('auth_modal', 'welcome')
                    ->with('flash_modal', 'welcome-back');
            }

            return redirect()->intended('/')
                ->with('success', 'Welcome back! Dil Bole Wow!! 🌶️')
                ->with('auth_modal', 'welcome')
                ->with('flash_modal', 'welcome-back');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show register form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        Auth::login($user);

        return redirect('/')
            ->with('success', 'Welcome to AMV Family! 🎉 Dil Bole Wow!!')
            ->with('auth_modal', 'welcome')
            ->with('flash_modal', 'welcome-family');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')
            ->with('success', 'You have been logged out. See you soon! 🌶️')
            ->with('flash_modal', 'logged-out');
    }
}

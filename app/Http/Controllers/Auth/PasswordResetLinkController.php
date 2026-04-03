<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle the forgot password form submission.
     * Sends a reset link to the given email if it exists.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Laravel's Password broker handles token generation,
        // storing in password_reset_tokens table, and sending the mail.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // PASSWORD_RESET_THROTTLED  → too many attempts
        // INVALID_USER              → email not found (we show same message for security)
        // RESET_LINK_SENT           → success
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}

<?php
// ================================================
// FILE: app/Http/Middleware/AdminMiddleware.php
// ================================================
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !in_array($request->user()->role, ['admin', 'staff'])) {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}

// ================================================
// REGISTER IN: bootstrap/app.php (Laravel 11)
// OR: app/Http/Kernel.php (Laravel 10 and below)
// ================================================
// For Laravel 11, add to bootstrap/app.php:
//
// ->withMiddleware(function (Middleware $middleware) {
//     $middleware->alias([
//         'admin' => \App\Http\Middleware\AdminMiddleware::class,
//     ]);
// })
//
// For Laravel 10, add to $routeMiddleware in Kernel.php:
// 'admin' => \App\Http\Middleware\AdminMiddleware::class,

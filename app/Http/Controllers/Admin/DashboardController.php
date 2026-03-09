<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'     => Order::count(),
            'pending_orders'   => Order::where('status', 'pending')->count(),
            'today_revenue'    => Order::whereDate('created_at', today())
                                       ->where('status', 'completed')
                                       ->sum('total_amount'),
            'total_customers'  => User::where('role', 'customer')->count(),
            'menu_items'       => MenuItem::where('is_available', true)->count(),
            'low_stock'        => Stock::whereRaw('quantity <= min_quantity')->count(),
        ];

        $recent_orders = Order::with('user')
            ->withCount('orderItems as items_count')
            ->latest()
            ->take(8)
            ->get();

        $low_stock_items = Stock::whereRaw('quantity <= min_quantity')
            ->orderBy('quantity')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'low_stock_items'));
    }
}

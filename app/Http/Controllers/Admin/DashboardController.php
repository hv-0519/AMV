<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('status', 'completed')
                ->sum('total_amount'),
            'total_customers' => User::where('role', 'customer')->count(),
            'menu_items' => MenuItem::where('is_available', true)->count(),
            'low_stock' => Stock::whereRaw('quantity <= min_quantity')->count(),
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

        $revenueChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenueChart[] = [
                'date' => $date->format('D'),
                'revenue' => Order::whereDate('created_at', $date)
                    ->where('status', 'completed')
                    ->sum('total_amount') ?? 0,
            ];
        }

        $ordersByStatus = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'ready' => Order::where('status', 'ready')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        $topItems = DB::table('order_items')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('menu_items.id', 'menu_items.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $ordersByType = [
            'dine-in' => Order::where('order_type', 'dine-in')->count(),
            'pickup' => Order::where('order_type', 'pickup')->count(),
            'delivery' => Order::where('order_type', 'delivery')->count(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'low_stock_items',
            'revenueChart',
            'ordersByStatus',
            'topItems',
            'ordersByType'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::query();

        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        $stocks = $query->latest()->paginate(20);

        $summary = [
            'total'         => Stock::count(),
            'in_stock'      => Stock::whereRaw('quantity > min_quantity')->count(),
            'low_stock'     => Stock::whereRaw('quantity > 0 AND quantity <= min_quantity')->count(),
            'out_of_stock'  => Stock::where('quantity', '<=', 0)->count(),
            'total_value'   => Stock::selectRaw('SUM(quantity * unit_cost) as total')->value('total'),
        ];

        $recent_movements = StockMovement::with('stock')->latest()->take(8)->get();

        return view('admin.stocks.index', compact('stocks', 'summary', 'recent_movements'));
    }

    public function create()
    {
        return view('admin.stocks.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:150',
            'category'     => 'required|string',
            'quantity'     => 'required|numeric|min:0',
            'min_quantity' => 'required|numeric|min:0',
            'unit'         => 'required|string|max:20',
            'unit_cost'    => 'required|numeric|min:0',
            'supplier'     => 'nullable|string|max:200',
            'notes'        => 'nullable|string',
        ]);

        $stock = Stock::create($validated);

        // Log initial stock
        StockMovement::create([
            'stock_id'   => $stock->id,
            'type'       => 'in',
            'quantity'   => $validated['quantity'],
            'notes'      => 'Initial stock entry',
        ]);

        return redirect()->route('admin.stocks.index')->with('success', 'Stock item added! 📦');
    }

    public function edit(Stock $stock)
    {
        return view('admin.stocks.form', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:150',
            'category'     => 'required|string',
            'quantity'     => 'required|numeric|min:0',
            'min_quantity' => 'required|numeric|min:0',
            'unit'         => 'required|string|max:20',
            'unit_cost'    => 'required|numeric|min:0',
            'supplier'     => 'nullable|string|max:200',
            'notes'        => 'nullable|string',
        ]);

        $old_quantity = $stock->quantity;
        $stock->update($validated);

        // Log if quantity changed
        if ($old_quantity != $validated['quantity']) {
            $diff = $validated['quantity'] - $old_quantity;
            StockMovement::create([
                'stock_id' => $stock->id,
                'type'     => $diff > 0 ? 'in' : 'out',
                'quantity' => abs($diff),
                'notes'    => 'Manual adjustment',
            ]);
        }

        return redirect()->route('admin.stocks.index')->with('success', 'Stock updated! ✅');
    }

    public function restock(Stock $stock)
    {
        return view('admin.stocks.restock', compact('stock'));
    }

    public function processRestock(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
            'notes'    => 'nullable|string',
        ]);

        $stock->increment('quantity', $request->quantity);

        StockMovement::create([
            'stock_id' => $stock->id,
            'type'     => 'in',
            'quantity' => $request->quantity,
            'notes'    => $request->notes ?? 'Restocked',
        ]);

        return redirect()->route('admin.stocks.index')->with('success', "Restocked {$stock->name} by {$request->quantity} {$stock->unit}! 📦");
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('admin.stocks.index')->with('success', 'Stock item removed.');
    }
}

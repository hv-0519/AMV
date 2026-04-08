<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Services\CloudinaryHelper;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::query();
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $menu_items = $query->orderBy('id')->get();
        return view('admin.menu.index', compact('menu_items'));
    }

    public function create()
    {
        return view('admin.menu.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'category'    => 'required|string',
            'price'       => 'required|numeric|min:1',
            'description' => 'required|string',
            'spice_level' => 'nullable|integer|between:1,5',
            'ingredients' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = (new CloudinaryHelper)->upload(
                $request->file('image')->getRealPath(), 'amv/menu'
            );
        }

        $validated['is_available']  = $request->boolean('is_available');
        $validated['is_bestseller'] = $request->boolean('is_bestseller');
        $validated['is_featured']   = $request->boolean('is_featured');

        MenuItem::create($validated);
        return redirect()->route('admin.menu.index')->with('success', 'Menu item added successfully! 🍽️');
    }

    public function edit(MenuItem $menu_item)
    {
        return view('admin.menu.form', compact('menu_item'));
    }

    public function update(Request $request, MenuItem $menu_item)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'category'    => 'required|string',
            'price'       => 'required|numeric|min:1',
            'description' => 'required|string',
            'spice_level' => 'nullable|integer|between:1,5',
            'ingredients' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = (new CloudinaryHelper)->upload(
                $request->file('image')->getRealPath(), 'amv/menu'
            );
        }

        $validated['is_available']  = $request->boolean('is_available');
        $validated['is_bestseller'] = $request->boolean('is_bestseller');
        $validated['is_featured']   = $request->boolean('is_featured');

        $menu_item->update($validated);
        return redirect()->route('admin.menu.index')->with('success', 'Menu item updated successfully! ✅');
    }

    public function destroy(MenuItem $menu_item)
    {
        $menu_item->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu item deleted.');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class MenuApiController extends Controller
{
    /**
     * Return all available menu items grouped by category.
     */
    public function index(): JsonResponse
    {
        $menuItems = MenuItem::available()
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category')
            ->map(
                /**
                 * @param Collection<int, MenuItem> $items
                 * @return array<int, array<string, mixed>>
                 */
                fn (Collection $items): array => MenuItemResource::collection($items)->resolve()
            );

        return response()->json([
            'data' => $menuItems,
        ]);
    }

    /**
     * Return a single available menu item.
     */
    public function show(int $id): MenuItemResource
    {
        $menuItem = MenuItem::available()->findOrFail($id);

        return new MenuItemResource($menuItem);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemPairing extends Model
{
    protected $fillable = [
        'menu_item_id',
        'paired_item_id',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** The item this pairing belongs to */
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class, 'menu_item_id');
    }

    /** The item being recommended */
    public function pairedItem()
    {
        return $this->belongsTo(MenuItem::class, 'paired_item_id');
    }
}

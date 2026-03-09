<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'name', 'category', 'quantity', 'min_quantity', 'unit', 'unit_cost', 'supplier', 'notes',
    ];

    protected $casts = ['unit_cost' => 'decimal:2'];

    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function isLow(): bool
    {
        return $this->quantity > 0 && $this->quantity <= $this->min_quantity;
    }

    public function isOut(): bool
    {
        return $this->quantity <= 0;
    }
}

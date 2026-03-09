<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = ['stock_id', 'type', 'quantity', 'notes'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}

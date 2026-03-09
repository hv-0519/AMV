<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'description', 'price', 'image',
        'spice_level', 'ingredients', 'is_available', 'is_bestseller', 'is_featured',
    ];

    protected $casts = [
        'is_available'  => 'boolean',
        'is_bestseller' => 'boolean',
        'is_featured'   => 'boolean',
        'price'         => 'decimal:2',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeBestsellers($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}

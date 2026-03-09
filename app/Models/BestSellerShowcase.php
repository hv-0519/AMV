<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestSellerShowcase extends Model
{
    protected $fillable = ['name', 'tag', 'rating', 'image', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return [
            'rating'    => 'float',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
        'state',
        'investment_capacity',
        'message',
        'status',
    ];

    /**
     * Get a formatted location string.
     */
    public function getFullLocationAttribute(): string
    {
        return "{$this->city}, {$this->state}";
    }

    /**
     * Get human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    /**
     * Scope: only new enquiries
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope: active pipeline (not rejected/completed)
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['rejected']);
    }
}

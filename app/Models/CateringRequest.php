<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateringRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_date',
        'event_type',
        'guests_count',
        'location',
        'message',
        'status',
    ];

    protected $casts = [
        'event_date'   => 'date',
        'guests_count' => 'integer',
    ];

    /**
     * Get a human-readable status label with color info.
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }

    /**
     * Scope: only new/unhandled requests
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope: upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->whereDate('event_date', '>=', today())
                     ->whereNotIn('status', ['completed', 'rejected']);
    }
}

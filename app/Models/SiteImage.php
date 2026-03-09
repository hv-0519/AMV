<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteImage extends Model
{
    protected $fillable = ['key', 'label', 'image'];

    /**
     * Get the public URL for this image, or null if none uploaded.
     */
    public function getUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Retrieve the image URL for a given key, or null if not set.
     */
    public static function getImage(string $key): ?string
    {
        $record = static::where('key', $key)->first();

        return $record?->url;
    }
}

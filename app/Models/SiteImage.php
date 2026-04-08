<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteImage extends Model
{
    protected $fillable = ['key', 'label', 'image'];

    /**
     * Get the public URL for this image, or null if none uploaded.
     */
    public function getUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        // Cloudinary (and any other CDN) images are stored as full URLs.
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // Legacy: bare filename stored before Cloudinary migration.
        return asset('storage/'.$this->image);
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

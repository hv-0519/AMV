<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['image', 'sort_order', 'format'];

    public function getRandomizedDisplayAttribute()
    {
        $sizes = ['400x300', '300x400', '500x500', '600x400'];
        $formats = ['jpg', 'webp', 'png'];

        $seed = $this->id ?? 0;

        return [
            'size' => $sizes[$seed % count($sizes)],
            'format' => $formats[$seed % count($formats)],
        ];
    }
}

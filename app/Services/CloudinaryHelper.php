<?php

namespace App\Services;

use Cloudinary\Cloudinary;

class CloudinaryHelper
{
    protected Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);
    }

    public function upload(string $filePath, string $folder = 'amv'): string
    {
        $result = $this->cloudinary->uploadApi()->upload($filePath, [
            'folder' => $folder,
        ]);

        return $result['secure_url'];
    }
}

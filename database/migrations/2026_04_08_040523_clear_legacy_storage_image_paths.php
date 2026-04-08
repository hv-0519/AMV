<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Clear any image paths that are still pointing at the local /storage/ disk.
     * After moving to Cloudinary, all valid images are stored as full HTTPS URLs
     * (starting with "http"). Any record whose image column does NOT start with
     * "http" is a leftover bare filename / relative path that will 404 on Render,
     * so we null it out to let the UI fall back to the emoji placeholder.
     */
    public function up(): void
    {
        $tables = [
            'menu_items' => 'image',
            'best_seller_showcases' => 'image',
            'site_images' => 'image',
            'gallery_images' => 'image',
        ];

        foreach ($tables as $table => $column) {
            DB::table($table)
                ->whereNotNull($column)
                ->where($column, 'not like', 'http%')
                ->update([$column => null]);
        }
    }

    public function down(): void
    {
        // Intentionally empty — we cannot recover deleted file references.
    }
};

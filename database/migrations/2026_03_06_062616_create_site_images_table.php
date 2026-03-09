<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_images', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        DB::table('site_images')->insert([
            ['key' => 'hero_dish',           'label' => 'Hero – Signature Dish',        'image' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'about_section',       'label' => 'About – Maharashtra Image',    'image' => null, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'catering_section',    'label' => 'Catering – Why Choose Us',     'image' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_images');
    }
};

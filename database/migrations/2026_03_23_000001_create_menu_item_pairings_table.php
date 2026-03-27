<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_item_pairings', function (Blueprint $table) {
            $table->id();

            // The item being viewed / just ordered
            $table->foreignId('menu_item_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // The item being recommended
            $table->foreignId('paired_item_id')
                  ->constrained('menu_items')
                  ->cascadeOnDelete();

            // Admin-controlled display order (lower = shown first)
            $table->unsignedTinyInteger('sort_order')->default(0);

            // Soft-disable a pairing without deleting it
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // A pair should only exist once per direction
            $table->unique(['menu_item_id', 'paired_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_item_pairings');
    }
};

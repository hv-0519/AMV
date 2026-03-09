<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catering_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('event_date');
            $table->string('event_type');
            $table->integer('guests_count');
            $table->string('location');
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'confirmed', 'completed', 'rejected'])->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catering_requests');
    }
};

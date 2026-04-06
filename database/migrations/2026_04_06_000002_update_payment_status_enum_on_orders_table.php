<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("
            ALTER TABLE orders
            MODIFY payment_status ENUM('pending', 'paid', 'failed', 'refunded')
            NOT NULL DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("
            ALTER TABLE orders
            MODIFY payment_status ENUM('pending', 'paid', 'refunded')
            NOT NULL DEFAULT 'pending'
        ");
    }
};

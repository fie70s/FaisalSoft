<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('routers') && !Schema::hasTable('mikrotik_devices')) {
            Schema::rename('routers', 'mikrotik_devices');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('mikrotik_devices') && !Schema::hasTable('routers')) {
            Schema::rename('mikrotik_devices', 'routers');
        }
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routers', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('serial_number')->unique()->nullable();

            $table->string('ip_address');

            $table->unsignedInteger('api_port')->default(8728);

            $table->string('username');

            $table->text('password');

            $table->string('router_model')->nullable();

            $table->string('router_os')->nullable();

            $table->string('license_level')->nullable();

            $table->string('owner')->nullable();

            $table->string('location')->nullable();

            $table->enum('status', [
                'online',
                'offline'
            ])->default('offline');

            $table->timestamp('last_seen')->nullable();

            $table->longText('notes')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routers');
    }
};
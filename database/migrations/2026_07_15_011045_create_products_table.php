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
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            // اسم المنتج
            $table->string('name');

            // كود المنتج
            $table->string('sku')->unique();

            // وصف المنتج
            $table->text('description')->nullable();

            // صورة المنتج
            $table->string('image')->nullable();

            // السعر
            $table->decimal('price', 10, 2)->default(0);

            // الكمية في المخزون
            $table->integer('quantity')->default(0);

            // الحالة
            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');


            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
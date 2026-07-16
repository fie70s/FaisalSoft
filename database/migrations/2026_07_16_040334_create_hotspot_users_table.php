<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotspot_users', function (Blueprint $table) {

            $table->id();


            // ربط المستخدم بجهاز MikroTik
            $table->foreignId('mikrotik_device_id')
                ->constrained()
                ->cascadeOnDelete();


            // رقم المستخدم داخل MikroTik
            $table->string('mikrotik_id')
                ->index();


            // بيانات المستخدم
            $table->string('username')
                ->index();


            $table->string('profile')
                ->nullable()
                ->index();


            $table->text('comment')
                ->nullable();



            // الحدود
            $table->string('limit_uptime')
                ->nullable();


            $table->unsignedBigInteger('limit_bytes_total')
                ->nullable();



            // الاستهلاك
            $table->unsignedBigInteger('bytes_in')
                ->default(0);


            $table->unsignedBigInteger('bytes_out')
                ->default(0);



            // الوقت المستخدم
            $table->string('uptime')
                ->nullable();



            // الحالة
            $table->boolean('disabled')
                ->default(false);



            // بيانات إضافية
            $table->json('extra')
                ->nullable();



            $table->timestamps();


            // منع التكرار
            $table->unique([
                'mikrotik_device_id',
                'mikrotik_id'
            ]);

        });
    }



    public function down(): void
    {
        Schema::dropIfExists('hotspot_users');
    }
};
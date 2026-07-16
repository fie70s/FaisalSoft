<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('licenses', function (Blueprint $table) {


            $table->id();



            // الجهاز المرتبط بالترخيص

            $table->foreignId('mikro_tik_device_id')
                ->constrained('mikro_tik_devices')
                ->cascadeOnDelete();



            // مفتاح الترخيص

            $table->string('license_key')
                ->unique();




            // نوع الترخيص

            $table->string('type')
                ->default('standard');




            // تاريخ البداية

            $table->date('starts_at');



            // تاريخ الانتهاء

            $table->date('expires_at')
                ->nullable();




            // حالة الترخيص

            $table->enum('status',[

                'active',

                'expired',

                'blocked'

            ])
            ->default('active');




            // ملاحظات

            $table->text('notes')
                ->nullable();



            $table->timestamps();


        });

    }




    public function down(): void
    {

        Schema::dropIfExists('licenses');

    }

};
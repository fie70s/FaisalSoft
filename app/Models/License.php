<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class License extends Model
{

    use HasFactory;



    protected $fillable = [

        'mikro_tik_device_id',

        'license_key',

        'type',

        'starts_at',

        'expires_at',

        'status',

        'notes',

    ];






    protected $casts = [

        'starts_at' => 'date',

        'expires_at' => 'date',

    ];






    public function device()
    {

        return $this->belongsTo(
            MikroTikDevice::class,
            'mikro_tik_device_id'
        );

    }





    public function isActive()
    {

        if($this->status !== 'active'){

            return false;

        }



        if($this->expires_at && now()->greaterThan($this->expires_at)){


            return false;

        }



        return true;


    }


}
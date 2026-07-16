<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MikroTikDevice extends Model
{
    use HasFactory;

    protected $table = 'mikrotik_devices';


    protected $fillable = [

        'name',
        'serial_number',
        'ip_address',
        'api_port',
        'username',
        'password',
        'router_model',
        'router_os',
        'license_level',
        'owner',
        'location',
        'status',
        'last_seen',
        'notes',

    ];


    protected $hidden = [

        'password',

    ];


    public function license()
    {
        return $this->hasOne(
            License::class,
            'mikro_tik_device_id'
        );
    }
}
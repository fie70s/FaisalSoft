<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class HotspotUser extends Model
{

    protected $fillable = [

        'mikrotik_device_id',

        'mikrotik_id',

        'username',

        'profile',

        'comment',

        'limit_uptime',

        'limit_bytes_total',

        'bytes_in',

        'bytes_out',

        'uptime',

        'disabled',

        'extra',

    ];



    protected $casts = [

        'disabled' => 'boolean',

        'extra' => 'array',

        'limit_bytes_total' => 'integer',

        'bytes_in' => 'integer',

        'bytes_out' => 'integer',

    ];



    public function device(): BelongsTo
    {

        return $this->belongsTo(
            MikroTikDevice::class,
            'mikrotik_device_id'
        );

    }



    public function getUsedBytesAttribute()
    {

        return $this->bytes_in + $this->bytes_out;

    }



    public function getRemainingBytesAttribute()
    {

        if(!$this->limit_bytes_total)
        {
            return null;
        }


        $remaining =
            $this->limit_bytes_total
            -
            $this->used_bytes;


        return max(
            0,
            $remaining
        );

    }

}
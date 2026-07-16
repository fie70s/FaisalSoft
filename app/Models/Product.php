<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [

        'name',
        'sku',
        'description',
        'image',
        'price',
        'quantity',
        'status',

    ];



    protected $casts = [

        'price' => 'decimal:2',

    ];

}
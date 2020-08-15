<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 
        'company', 
        'phone_number',
        'address',
        'is_hidden',
    ];

    protected  $primaryKey = 'id';
}

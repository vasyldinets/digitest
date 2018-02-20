<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'cardNumber', 'cardMonth', 'cardYear', 'cardCvv'];
}

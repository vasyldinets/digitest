<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['customerId', 'sellerId', 'amount', 'offset', 'limit', 'date'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cart_id', 'transaction_id'
    ];
}

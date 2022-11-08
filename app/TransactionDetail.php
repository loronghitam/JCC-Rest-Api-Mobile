<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'no_resi', 'total', 'kurir', 'pembayaran', 'status', 'status_pembayaran', 'batas_pembayaran',  'user_id', 'address_id' //'transaction_id',//
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'tahun_pembuatan', 'user_id', 'category_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    public function productDetails()
    {
        return $this->hasOne(
            ProductDetail::class,
            'product_id',
            'id'
        );
    }

    public function category_id()
    {
        return $this->hasOne(
            Category::class,
            'id',
            'category_id'
        );
    }
}

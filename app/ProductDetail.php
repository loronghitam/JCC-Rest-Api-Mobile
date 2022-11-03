<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deskripsi', 'dimensi', 'media',
        'gambar', 'status', 'status_barang', 'kondisi', 'harga'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'product_id'
    ];

    public function category()
    {
        return $this->hasMany(
            Category::class,
            'id',
            'id_category'
        );
    }
}

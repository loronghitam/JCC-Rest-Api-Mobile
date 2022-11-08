<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Searchable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'gambar',
    ];

    // public function searchableAs()
    // {
    //     return 'category_index';
    // }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}

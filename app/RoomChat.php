<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomChat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'user_id', 'condition'
    // ];
}

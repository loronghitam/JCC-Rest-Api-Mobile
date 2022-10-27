<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'receiver_id', 'room_id', 'message'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'room_id'
    ];


    public function getRouteKeyName()
    {
        return 'room_id';
    }


    public function roomChat()
    {
        return $this->hasMany(RoomChat::class, 'chat_id', 'id');
    }
}

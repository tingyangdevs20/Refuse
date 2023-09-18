<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $guarded=[];

    public function chatRoomUsers(){
        return $this->hasMany(ChatRoomUser::class);
    }
}

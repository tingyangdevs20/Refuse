<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChatRoomSession extends Model
{
    protected $guarded=[];

    public function messages(){
        return $this->hasMany(Message::class,'chat_room_id','chat_room_id');
    }
}

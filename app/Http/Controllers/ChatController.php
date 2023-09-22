<?php

namespace App\Http\Controllers;


use App\Model\ChatRoom;
use App\Model\ChatRoomSession;
use App\Model\Contact;
use App\Model\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    private $sessionPrefix = 'chat-room-';


    public function getMessages($session_id){
        $chatRoomSession =  ChatRoomSession::with('messages')->where('session_id',$session_id)->firstOrFail();
        return $chatRoomSession;
    }

    public function createChatRoom(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'number' => 'required|string|max:25'
        ]);
        $validated['group_id'] = 1; //Todo: Set Group id.
        $contact = Contact::firstOrCreate(['number' => $validated['number']], $validated);
        $chatRoom = ChatRoom::create([
            'uuid' => "ch_" . Str::uuid()
        ]);

        $chatRoom->chatRoomUsers()->create([
            'userable_type' => 'contact',
            'userable_id' => $contact->id
        ]);


        $session = ChatRoomSession::create([
            'userable_type' => 'contact',
            'userable_id' => $contact->id,
            'chat_room_id' => $chatRoom->id,
            'session_id' => Str::uuid()
        ]);
        return response()->json(['status' => true, 'data' => [
            'session_id' => $session->session_id,
            'user' => [
                'name' => $validated['name'],
                'phone_number' => $validated['number']
            ]
        ]]);

    }

    public function saveMessage(Request $request, $session_id)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:10000',
        ]);
        $chatRoomSession = ChatRoomSession::where('session_id',$session_id)->firstOrFail();

        Message::create([
            'chat_room_id' => $chatRoomSession['chat_room_id'],
            'message_text' => $validated['text'],
            'userable_type' => $chatRoomSession['userable_type'],
            'userable_id' => $chatRoomSession['userable_id'],
        ]);

        return response()->json(['status'=> true,'message' => "Message sent successfully"]);
    }
}

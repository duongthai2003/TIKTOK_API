<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\GroupChats;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{ 
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        
        $usersChat = [Auth::id(),  $request->receiver_id]; 
        sort($usersChat); 
        $getGroup = GroupChats::where("name_group", implode('_', $usersChat))->first();

    $message = Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message,
        'group_chat_id'=> $getGroup->id,
    ]);
         
        // Phát sự kiện WebSocket
        // event(new MessageSent($message)); // Khi muốn tất cả nhận được sự kiện 
        broadcast(new MessageSent($message))->toOthers();//Khi chỉ muốn gửi đến những người khác  và tránh người phát nhận lại tin nhắn của chính mình.
        
        return response()->json([
            'message' => 'Message sent successfully!',
            'data' => $message
        ], 201);
    }

    public function getMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);   
    }

    public function getUserMessageList()
    {   
    return GroupChats::where('member_1', Auth::id())
    ->orWhere('member_2', Auth::id())
    ->with(['latestMessage' => function ($query) {
        $query->orderBy('created_at', 'desc'); // Lấy tin nhắn mới nhất
    }])
    ->get()
    ->sortByDesc(fn($chat) => optional($chat->latestMessage)->created_at)
    ->map(function ($chat) {
        $idUser = $chat->member_1 == Auth::id() ? $chat->member_2 : $chat->member_1;

        // Lấy thông tin user
        $user = User::where('id', $idUser)->first();
 
        // Lấy tin nhắn mới nhất của user này trong group
        $latestMessage = Message::where('group_chat_id', $chat->id)
            ->where('sender_id', $idUser)->orWhere("receiver_id",$user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return [
            'user' => $user,  // Thông tin user
            'latest_message' => $latestMessage // Tin nhắn mới nhất của user
        ];
    })
    ->values(); // Đảm bảo trả về array chứ không phải object có key số


    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{ 
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
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
        // return "gggggggg";
    }
}

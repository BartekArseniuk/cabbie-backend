<?php

namespace App\Http\Controllers;
use App\Models\PrivateMessage;
use Illuminate\Http\Request;

class PrivateMessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = PrivateMessage::where('receiver_id', $request->user()->id)->get();

        $messages->each(function ($message) {
            $message->sender_email = $message->sender->email;
        });

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
    
        $message = PrivateMessage::create([
            'sender_id' => $request->user()->id,
            'sender_email' => $request->user()->email,
            'receiver_id' => $request->input('receiver_id'),
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'sent_at' => now(),
        ]);
    
        $message->sender_email = $request->user()->email;
    
        return response()->json([
            'message' => 'Message sent successfully!',
            'data' => $message
        ], 201);
    }
    
}
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
            'receiver_email' => 'required|email|exists:users,email',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
    
        $receiver = \App\Models\User::where('email', $request->input('receiver_email'))->firstOrFail();
        
        $message = PrivateMessage::create([
            'sender_id' => $request->user()->id,
            'sender_email' => $request->user()->email,
            'receiver_id' => $receiver->id,
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'sent_at' => now(),
        ]);
    
        return response()->json([
            'message' => 'Message sent successfully!',
            'data' => $message
        ], 201);
    }

    public function markAsRead($id)
    {
        $message = PrivateMessage::findOrFail($id);
        
        $message->is_read = true;
        $message->save();

        return response()->json([
            'message' => 'Message marked as read successfully!',
            'data' => $message
        ]);
    }
}
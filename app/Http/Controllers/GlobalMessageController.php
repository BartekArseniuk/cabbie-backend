<?php

namespace App\Http\Controllers;

use App\Models\GlobalMessage;
use Illuminate\Http\Request;

class GlobalMessageController extends Controller
{
    public function index()
    {
        $messages = GlobalMessage::with('sender')->get();

        $messages->each(function ($message) {
            $message->sender_email = $message->sender->email;
        });

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
    
        $message = GlobalMessage::create([
            'sender_id' => $request->user()->id,
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'sent_at' => now(),
        ]);

        $message->sender_email = $request->user()->email;
    
        return response()->json([
            'message' => 'Global message sent successfully!',
            'data' => $message
        ], 201);
    }

    public function markAsRead($id)
    {
        $message = GlobalMessage::findOrFail($id);
        
        $message->is_read = true;
        $message->save();

        return response()->json([
            'message' => 'Message marked as read successfully!',
            'data' => $message
        ]);
    }

    public function hasUnreadMessages()
    {
        $hasUnreadMessages = GlobalMessage::where('is_read', false)->exists();

        return response()->json([
            'hasUnreadMessages' => $hasUnreadMessages
        ]);
    }
}

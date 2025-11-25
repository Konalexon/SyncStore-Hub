<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LiveStream;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        if ($user->is_banned) {
            return response()->json(['error' => 'You are banned from chat.'], 403);
        }

        $message = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $response = [
            'success' => true,
            'user' => $user->name,
            'message' => $message['message'],
            'avatar' => substr($user->name, 0, 1)
        ];

        // AI Chatbot Integration
        if (str_starts_with($message['message'], '@bot')) {
            $bot = new \App\Services\AIChatbot();
            $query = trim(str_replace('@bot', '', $message['message']));
            $reply = $bot->ask($query);

            $response['bot_reply'] = [
                'user' => 'AI Assistant',
                'message' => $reply,
                'avatar' => 'AI'
            ];
        }

        return response()->json($response);
    }

    // Admin Moderation
    public function pinMessage(Request $request)
    {
        $stream = LiveStream::first();
        if ($stream) {
            $stream->update(['pinned_message' => $request->message]);
        }
        return response()->json(['success' => true]);
    }

    public function banUser(Request $request)
    {
        // Find user by name for simulation simplicity, or ID if available
        $user = User::where('name', $request->username)->first();
        if ($user) {
            $user->update(['is_banned' => true]);
            return response()->json(['success' => true, 'message' => "User {$user->name} banned."]);
        }
        return response()->json(['error' => 'User not found'], 404);
    }
}

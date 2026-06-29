<?php

namespace App\Http\Controllers\LiveChat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Consultations;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Kirim pesan dari customer
    public function sendMessage(Request $request, Consultations $consultation)
    {
        $request->validate(['body' => 'required|string']);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'customer',
            'body'            => $request->body,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'status'  => 'sent',
            'message' => $message,
        ]);
    }

    // Ambil semua pesan (load awal)
    public function getMessages(Consultations $consultation)
    {
        $messages = $consultation->messages()->orderBy('created_at')->get();
        return response()->json($messages);
    }
}
<?php

namespace App\Http\Controllers\livechat;

use App\Http\Controllers\Controller;
use App\Events\MessageSent;
use App\Models\Consultations;
use App\Models\Message;
use App\Jobs\ProcessAiReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    // Kirim pesan dari customer + trigger AI reply
    public function sendMessage(Request $request, Consultation $consultation)
    {
        $request->validate(['body' => 'required|string']);

        // Simpan pesan customer
        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'customer',
            'body'            => $request->body,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        // Kalau status masih open (AI yang handle)
 if (in_array($consultation->status, ['open', 'active'])) {
    $this->aiReply($consultation, $request->body);
}

        return response()->json(['status' => 'sent']);
    }

    // Request alih ke CS
    public function requestCs(Consultations $consultation)
    {
        $consultation->update(['status' => 'redirect_to_cs']);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => null,
            'sender_type'     => 'ai',
            'body'            => 'Baik kak, saya akan mengalihkan ke Customer Service kami. Mohon tunggu sebentar.',
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'redirect_to_cs']);
    }

    private function aiReply(Consultations $consultation, string $userMessage): void
{
    ProcessAiReply::dispatch($consultation, $userMessage);
}

//     // AI reply via Claude API
//   private function aiReply(Consultations $consultation, string $userMessage)
// {
//     $history = $consultation->messages()
//         ->orderBy('created_at')
//         ->get()
//         ->map(fn($m) => [
//             'role'  => $m->sender_type === 'customer' ? 'user' : 'model',
//             'parts' => [['text' => $m->body]],
//         ])
//         ->toArray();

//     $response = Http::timeout(30)->withHeaders([
//         'Content-Type' => 'application/json',
//     ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . config('services.gemini.key'), [
//         'system_instruction' => [
//             'parts' => [['text' => 'Kamu adalah AI assistant untuk KLA Computer, service center laptop, PC, printer, dan server. Bantu customer troubleshoot masalah mereka. Jawab dalam Bahasa Indonesia. Kalau kamu tidak bisa solve masalahnya, tanyakan: "Apakah kakak ingin saya alihkan ke Customer Service kami untuk bantuan lebih lanjut?"']]
//         ],
//         'contents' => $history,
//     ]);

//     $aiText = $response->json('candidates.0.content.parts.0.text') ?? 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.';

//     $aiMessage = Message::create([
//         'consultation_id' => $consultation->id,
//         'user_id'         => null,
//         'sender_type'     => 'ai',
//         'body'            => $aiText,
//     ]);

//     broadcast(new MessageSent($aiMessage));
// }

    // Ambil semua pesan (untuk load awal)
    public function getMessages(Consultations $consultation)
    {
        $messages = $consultation->messages()->orderBy('created_at')->get();
        return response()->json($messages);
    }
}
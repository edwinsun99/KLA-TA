<?php

namespace App\Http\Controllers\livechat;

use App\Http\Controllers\Controller;
use App\Models\Consultations;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    // Kirim pesan dari customer + AI reply langsung
    public function sendMessage(Request $request, Consultations $consultation)
    {
        $request->validate(['body' => 'required|string']);

        // Simpan pesan customer
        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'customer',
            'body'            => $request->body,
        ]);

        $aiMessage = null;

        // AI reply kalau status open/active
        if (in_array($consultation->status, ['open', 'active'])) {
            $aiMessage = $this->aiReply($consultation, $request->body);
        }

        return response()->json([
            'status'     => 'sent',
            'message'    => $message,
            'ai_message' => $aiMessage,
        ]);
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

        return response()->json([
            'status'  => 'redirect_to_cs',
            'message' => $message,
        ]);
    }

    // AI reply synchronous langsung ke Gemini
    private function aiReply(Consultations $consultation, string $userMessage): ?Message
    {
        $history = $consultation->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'role'  => $m->sender_type === 'customer' ? 'user' : 'model',
                'parts' => [['text' => $m->body]],
            ])
            ->toArray();

        try {
            $response = Http::timeout(30)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . config('services.gemini.key'),
                [
                    'system_instruction' => [
                        'parts' => [['text' => 'Kamu adalah AI assistant untuk KLA Computer, service center laptop, PC, printer, dan server. Bantu customer troubleshoot masalah mereka. Jawab dalam Bahasa Indonesia. Kalau kamu tidak bisa solve masalahnya, tanyakan: "Apakah kakak ingin saya alihkan ke Customer Service kami untuk bantuan lebih lanjut?"']]
                    ],
                    'contents' => $history,
                ]
            );

            $aiText = $response->json('candidates.0.content.parts.0.text')
                ?? 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.';

        } catch (\Exception $e) {
            $aiText = 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.';
        }

        return Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => null,
            'sender_type'     => 'ai',
            'body'            => $aiText,
        ]);
    }

    // Ambil semua pesan (untuk polling)
    public function getMessages(Consultations $consultation)
    {
        $messages = $consultation->messages()->orderBy('created_at')->get();
        return response()->json($messages);
    }
}
<?php

namespace App\Jobs;

use App\Events\MessageSent;
use App\Models\Consultations;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessAiReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Consultations $consultation,
        public string $userMessage
    ) {}

    public function handle(): void
    {
        $history = $this->consultation->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'role'  => $m->sender_type === 'customer' ? 'user' : 'model',
                'parts' => [['text' => $m->body]],
            ])
            ->toArray();

        $response = Http::timeout(30)->withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . config('services.gemini.key'), [
            'system_instruction' => [
                'parts' => [['text' => 'Kamu adalah AI assistant untuk KLA Computer, service center laptop, PC, printer, dan server. Bantu customer troubleshoot masalah mereka. Jawab dalam Bahasa Indonesia. Kalau kamu tidak bisa solve masalahnya, tanyakan: "Apakah kakak ingin saya alihkan ke Customer Service kami untuk bantuan lebih lanjut?"']]
            ],
            'contents' => $history,
        ]);

        $aiText = $response->json('candidates.0.content.parts.0.text')
            ?? 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.';

        $aiMessage = Message::create([
            'consultation_id' => $this->consultation->id,
            'user_id'         => null,
            'sender_type'     => 'ai',
            'body'            => $aiText,
        ]);

        broadcast(new MessageSent($aiMessage));
    }
}
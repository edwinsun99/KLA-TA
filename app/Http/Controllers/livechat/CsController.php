<?php

namespace App\Http\Controllers\livechat;

use App\Http\Controllers\Controller;
use App\Models\Consultations;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CsController extends Controller
{

// Taruh di atas class atau bikin helper
private function checkCs() {
    if (Session::get('role') !== 'CS') {
        abort(403, 'Akses ditolak.');
    }
}    

// CS join conversation
    public function joinChat(Consultations $consultation)
    {
            $this->checkCs(); // ← di sini

        $consultation->update([
            'cs_id'  => Session::get('user_id') ?? auth()->id(),
            'status' => 'cs_handling',
        ]);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => 'Halo kak, saya dari tim Customer Service KLA Computer. Ada yang bisa saya bantu?',
        ]);

        return response()->json(['status' => 'cs_handling', 'message' => $message]);
    }

    // CS kirim pesan
    public function sendMessage(Request $request, Consultations $consultation)
    {
                    $this->checkCs(); // ← di sini

        $request->validate(['body' => 'required|string']);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => $request->body,
        ]);

        return response()->json(['status' => 'sent', 'message' => $message]);
    }

    // CS close konsultasi
    public function closeChat(Consultations $consultation)
    {
                $this->checkCs(); // ← di sini

        $consultation->update(['status' => 'closed']);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => 'Konsultasi telah selesai. Terima kasih telah menghubungi KLA Computer!',
        ]);

        return response()->json(['status' => 'closed', 'message' => $message]);
    }

    // CS eskalasi ke KLA
    public function escalateToKla(Request $request, Consultations $consultation)
    {
                $this->checkCs(); // ← di sini

        $request->validate(['notes' => 'required|string']);

        $consultation->update([
            'status' => 'escalated_to_kla',
            'notes'  => $request->notes,
        ]);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => 'Unit kakak perlu dibawa ke service center kami (KLA). Silakan kunjungi KLA Computer dengan membawa unit kakak. ' . $request->notes,
        ]);

        return response()->json(['status' => 'escalated_to_kla', 'message' => $message]);
    }

    // List konsultasi masuk ke CS
    public function index()
    {
                    $this->checkCs(); // ← di sini

        $consultations = Consultations::whereIn('status', ['redirect_to_cs', 'cs_handling'])
            ->with(['customer', 'messages' => fn($q) => $q->latest()->limit(1)])
            ->latest()
            ->get();

        return view('livechat.index', compact('consultations'));
    }

    // Detail konsultasi + chat
    public function show(Consultations $consultation)
    {
                    $this->checkCs(); // ← di sini

        $messages = $consultation->messages()->orderBy('created_at')->get();
        return view('livechat.show', compact('consultation', 'messages'));
    }
}
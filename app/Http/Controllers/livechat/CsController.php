<?php

namespace App\Http\Controllers\livechat;

use App\Http\Controllers\Controller;
use App\Events\MessageSent;
use App\Models\Consultations;
use App\Models\Message;
use Illuminate\Http\Request;

class CsController extends Controller
{
    // CS join conversation
    public function joinChat(Consultation $consultation)
    {
        $consultation->update([
            'cs_id'  => auth()->id(),
            'status' => 'cs_handling',
        ]);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => 'Halo kak, saya ' . auth()->user()->name . ' dari tim Customer Service KLA Computer. Ada yang bisa saya bantu?',
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'cs_handling']);
    }

    // CS kirim pesan
    public function sendMessage(Request $request, Consultation $consultation)
    {
        $request->validate(['body' => 'required|string']);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => $request->body,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'sent']);
    }

    // CS close konsultasi (solved)
    public function closeChat(Consultation $consultation)
    {
        $consultation->update(['status' => 'closed']);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => 'Konsultasi telah selesai. Terima kasih telah menghubungi KLA Computer!',
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'closed']);
    }

    // CS eskalasi ke KLA
    public function escalateToKla(Request $request, Consultations $consultation)
    {
        $request->validate(['notes' => 'required|string']);

        $consultation->update([
            'status'    => 'escalated_to_kla',
            'notes' => $request->notes,
        ]);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => 'Unit kakak perlu dibawa ke service center kami (KLA). Silakan kunjungi KLA Computer dengan membawa unit kakak. ' . $request->kla_notes,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'escalated_to_kla']);
    }

    // List semua konsultasi yang perlu di-handle CS
    public function index()
    {
        $consultations = Consultation::whereIn('status', ['redirect_to_cs', 'cs_handling'])
            ->with(['messages' => fn($q) => $q->latest()->limit(1)])
            ->get();

        return response()->json($consultations);
    }
}
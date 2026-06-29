<?php

namespace App\Http\Controllers\LiveChat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Consultations;
use App\Models\Message;
use Illuminate\Http\Request;

class CsController extends Controller
{
    private function checkCs()
    {
        if (!auth()->check() || strtolower(auth()->user()->role) !== 'cs') {
            abort(403, 'Akses ditolak.');
        }
    }

    // List konsultasi masuk ke CS
    public function index(Request $request)
    {
        $this->checkCs();

        $query = Consultations::whereIn('status', ['active', 'redirect_to_cs', 'cs_handling'])
            ->with(['customer', 'messages' => fn($q) => $q->latest()->limit(1)])
            ->latest();

        // Filter by status
        if ($request->status === 'waiting') {
            $query->whereIn('status', ['active', 'redirect_to_cs']);
        } elseif ($request->status === 'cs_handling') {
            $query->where('status', 'cs_handling');
        }

        $consultations = $query->get();

        return view('livechat.index', compact('consultations'));
    }

    // CS join conversation
    public function joinChat(Consultations $consultation)
    {
        $this->checkCs();
        $csId = auth()->id();

        // Sudah dipegang CS lain → tolak
        if ($consultation->cs_id && $consultation->cs_id !== $csId) {
            return response()->json([
                'status'  => 'already_claimed',
                'message' => 'Konsultasi ini sudah ditangani CS lain.',
            ], 409);
        }

        // CS yang sama join ulang → jangan kirim salam dobel
        if ($consultation->cs_id === $csId && $consultation->status === 'cs_handling') {
            return response()->json(['status' => 'cs_handling', 'message' => null]);
        }

        // Klaim ATOMIK: hanya sukses kalau cs_id masih NULL
        $claimed = Consultations::where('id', $consultation->id)
            ->whereNull('cs_id')
            ->update([
                'cs_id'  => $csId,
                'status' => 'cs_handling',
            ]);

        if (!$claimed) {
            return response()->json([
                'status'  => 'already_claimed',
                'message' => 'Konsultasi ini baru saja diambil CS lain.',
            ], 409);
        }

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => $csId,
            'sender_type'     => 'cs',
            'body'            => 'Halo kak, saya ' . auth()->user()->name . ' dari tim Customer Service KLA Computer. Ada yang bisa saya bantu?',
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'cs_handling', 'message' => $message]);
    }

    // CS kirim pesan
    public function sendMessage(Request $request, Consultations $consultation)
    {
        $this->checkCs();

        $request->validate(['body' => 'required|string']);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => $request->body,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'sent', 'message' => $message]);
    }

    // CS close konsultasi
    public function closeChat(Consultations $consultation)
    {
        $this->checkCs();

        $consultation->update(['status' => 'closed']);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => 'Konsultasi telah selesai. Terima kasih telah menghubungi KLA Computer!',
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'closed', 'message' => $message]);
    }

    // CS eskalasi ke KLA
    public function escalateToKla(Request $request, Consultations $consultation)
    {
        $this->checkCs();

        $request->validate(['kla_notes' => 'required|string']);

        $consultation->update([
            'status'    => 'escalated_to_kla',
            'kla_notes' => $request->kla_notes,
        ]);

        $message = Message::create([
            'consultation_id' => $consultation->id,
            'user_id'         => auth()->id(),
            'sender_type'     => 'cs',
            'body'            => 'Unit kakak perlu dibawa ke service center kami (KLA). Silakan kunjungi KLA Computer dengan membawa unit kakak. ' . $request->kla_notes,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'escalated_to_kla', 'message' => $message]);
    }

    // Detail konsultasi + livechat yg ada di new page pake redirect (dicomment dulu, hapus setelah live chat berhasil)
    // public function show(Consultations $consultation)
    // {
    //     $this->checkCs();
    //     $messages = $consultation->messages()->orderBy('created_at')->get();
    //     return view('livechat.show', compact('consultation', 'messages'));
    // }
}
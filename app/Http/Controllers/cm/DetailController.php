<?php

namespace App\Http\Controllers\cm;

use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Lognote; // ← ini yang harus ditambahkan

class DetailController extends Controller
{
    public function show($id)
    {
        $case = Service::findOrFail($id);
        return view('cm.show', compact('case'));
    }


   public function updateAll(Request $request, $id)
{
    // 1. Validasi gabungan (note dibuat nullable karena CE mungkin hanya ingin ubah status saja)
    $request->validate([
        'status' => 'required|string',
        'note'   => 'nullable|max:500' 
    ]);

    // 2. Ambil data User & Service
    $user = \Auth::user();
    if (!$user) {
        return redirect()->route('login')->with('error', 'Login dulu!');
    }

    $service = Service::findOrFail($id);

    $service->status = $request->status;
    $service->save();

    // 4. Logika Simpan Note (Hanya jika input 'note' diisi)
    if ($request->filled('note')) {
        Lognote::create([
            'cof_id'     => $service->cof_id,
            'username'   => $user->username,
            'logdesc'    => $request->note,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    return redirect()
        ->route('cm.case.show', $id)
        ->with('success', 'Case berhasil diperbarui (Status & Note)!');
}

public function status($id)
{
    $service = Service::findOrFail($id);
    return view('cm.partials.detailcase', compact('service'));
}

public function sendToWhatsapp($id)
{
    $service = Service::findOrFail($id);

    $customerName = $service->customer_name ?? '-';
    $namaType = $service->nama_type ?? '-';
    $cofId = $service->cof_id ?? '-';
    $serialNumber = $service->serial_number ?? '-';
    $productNumber = $service->product_number ?? '-';

    $rawPhone = preg_replace('/[^0-9]/', '', $service->phone_number ?? '');
    $rawPhone = ltrim($rawPhone, '0');
    $phone = str_starts_with($rawPhone, '62') ? $rawPhone : '62' . $rawPhone;

    // Ambil lognote terakhir dari CE
    $note = \DB::table('lognote')
        ->where('cof_id', $service->cof_id)
        ->where('logdesc', 'like', '%Part Number%')
        ->orderByDesc('created_at')
        ->first();

    $partNumber = '-';
    $partName = '-';

    if ($note && !empty($note->logdesc)) {
        $logdesc = $note->logdesc;

        if (preg_match('/Part Number:\s*(.+?)(?:\n|$)/i', $logdesc, $matchPN)) {
            $partNumber = trim($matchPN[1]);
        }

        if (preg_match('/Part Name:\s*(.+?)(?:\n|$)/i', $logdesc, $matchPart)) {
            $partName = trim($matchPart[1]);
        }
    }

    $pesan =
        "Halo {$customerName} 👋\n\n" .
        "Kami dari *KLA Service Center* ingin menginformasikan bahwa unit kakak telah dicek dan ditemukan part yang rusak sehingga perlu penggantian sparepart baru.\n\n" .
        "📱 *Unit* : {$namaType}\n" .
        "🔖 *COF ID* : {$cofId}\n" .
        "🔢 *S/N* : {$serialNumber}\n" .
        "🔢 *P/N* : {$productNumber}\n\n" .

        "🔧 Status saat ini: *Quotation Request*\n\n" .

        "Detail sparepart yang perlu diganti:\n" .
        "• *Part Number* : {$partNumber}\n" .
        "• *Part Name* : {$partName}\n\n" .
        "Mohon konfirmasi terkait pengajuan sparepart agar proses perbaikan dapat dilanjutkan.\n\n" .
        "Terima kasih telah mempercayakan unit kakak kepada kami 🙏";

    $url = "https://wa.me/{$phone}?text=" . urlencode($pesan);

    return redirect()->away($url);
}

    public function previewPdf($id)
    {
        $case = Service::with('branch')->findOrFail($id);

        $branch = $case->branch;
        $branchName = $branch->name ?? 'Unknown Branch';

        $alamat = [
            'line1' => $branch->address ?? 'Alamat tidak tersedia',
            'telp'  => $branch->phone ?? '-',
        ];

        $pdf = Pdf::loadView('cm.pdf.cofsummary', compact('case', 'alamat'));

        $fileName = 'COF_' . $case->cof_id . '_' . str_replace(' ', '_', $branchName) . '.pdf';

        return $pdf->stream($fileName);
    }

    public function lognote($id)
{
    $service = Service::with('notes.user')->findOrFail($id);

    $notes = $service->notes()->latest()->get(); // ambil lognote urut terbaru

    return view('cm.partials.detailcase', compact('service', 'notes'));
}
}

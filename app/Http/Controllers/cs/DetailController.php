<?php

namespace App\Http\Controllers\cs;

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
        return view('cs.show', compact('case'));
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

    // 3. Logika Update Status & Otomatisasi Tanggal
    $service->status = $request->status;

    if ($request->status === 'repair progress') {
        $service->started_date = now();
    }

    if ($request->status === 'finish repair') {
        $service->finished_date = now();
    }

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
        ->route('cs.case.show', $id)
        ->with('success', 'Case berhasil diperbarui (Status & Note)!');
}

public function status($id)
{
    $service = Service::findOrFail($id);
    return view('cs.partials.detailcase', compact('service'));
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

        $pdf = Pdf::loadView('cs.pdf.cofsummary', compact('case', 'alamat'));

        $fileName = 'COF_' . $case->cof_id . '_' . str_replace(' ', '_', $branchName) . '.pdf';

        return $pdf->stream($fileName);
    }

    public function lognote($id)
{
    $service = Service::with('notes.user')->findOrFail($id);

    $notes = $service->notes()->latest()->get(); // ambil lognote urut terbaru

    return view('cs.partials.detailcase', compact('service', 'notes'));
}
}

<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branches;
use App\Models\CofCounter;
use App\Models\Lognote;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan ada ini di atas

class ServiceController extends Controller
{
    // ✅ 1. Method untuk menampilkan daftar service
   public function index()
{
    $user = Auth::user();

    // Pastikan user login
    if (!$user) {
        return redirect()->route('login')->with('error', 'User belum login.');
    }

    // Filter hanya service dari cabang user yang login
    $services = Service::where('branch_id', $user->branch_id)
                       ->latest()
                       ->get();

return view('cs.case', ['cases' => $services]);
}

// app/Models/Service.php
public function scopeForCurrentBranch($query)
{
    $user = Auth::user();
    if ($user) {
        $query->where('branch_id', $user->branch_id);
    }
    return $query;
}

public function getProductType(Request $request)
{
    $product = Product::where('pn', $request->pn)->first();

    return response()->json([
        'nama_type' => $product ? $product->nt : null
    ]);
}

public function previewPdf($id)
{
    $service = Service::with('branch')->findOrFail($id);

    // Mapping alamat berdasarkan prefix
    $addresses = [
        'A' => [
            'line1' => 'Ruko Mataram Plaza Blok D8',
            'line2' => 'Jl. MT. Haryono 427–429, Kota Semarang',
            'line3' => 'Jawa Tengah 50613',
            'telp'  => '08993201657'
        ],
        'B' => [
            'line1' => 'Ruko Slawi Indah Blok B1',
            'line2' => 'Jl. Ahmad Yani No.12, Slawi – Tegal',
            'line3' => 'Jawa Tengah 52413',
            'telp'  => '082132456789'
        ],
        // dan seterusnya...
    ];

    $prefix = $service->branch->prefix;
    $alamat = $addresses[$prefix] ?? $addresses['A']; // default ke A kalau ga ketemu

    $pdf = Pdf::loadView('ce.pdf.cofsummary', compact('service', 'alamat'));

    return $pdf->stream('COF_' . $service->cof_id . '.pdf');
}


// ✅ 2. Method untuk menyimpan data baru
public function store(Request $request)
{
    // Pastikan user login
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login')->with('error', 'User belum login.');
    }

    // Hanya CE yang boleh create case
    if ($user->role !== 'CS') {
        return back()->with('error', 'Akses ditolak, hanya CE yang bisa membuat case!');
    }

    // Ambil branch ID — NO NULL ALLOWED 🔥
    $branchId = $user->branch_id;
    if (!$branchId) {
        return back()->with('error', 'Akun CE tidak memiliki cabang, hubungi Admin!');
    }

    // Ambil prefix branch
    $branch = Branches::find($branchId);
    $prefix = $branch->prefix ?? 'X';

    // Counter COF aman (ga bakal bikin NULL)
    $counter = CofCounter::firstOrCreate(
        ['branch_id' => $branchId],
        ['current_number' => 0]
    );

    // Naikkan angka
    $nextNumber = $counter->current_number + 1;
    $counter->update(['current_number' => $nextNumber]);

// Generate COF-ID BARU 🔥🔥🔥
$year = now()->format('Y');
$month = now()->format('m');
$cofId = $prefix . $year . $month . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

    // Create new case
$service = Service::create([
        'cof_id' => $cofId,
        'status' => 'new',
        'erf_file' => $request->erf_file,
        'branch_id' => $branchId,
        'ce_id' => $user->id,
        'customer_name' => $request->customer_name,
        'email' => $request->email,
        'contact' => $request->contact,
        'phone_number' => $request->phone_number,
        'address' => $request->address,
        'received_date' => $request->received_date,
        'started_date' => $request->started_date,
        'finished_date' => $request->finished_date,
        'brand' => $request->brand,
        'product_number' => $request->product_number,
        'serial_number' => $request->serial_number,
        'nama_type' => $request->nama_type,
        'accessories' => $request->accessories,
        'fault_description' => $request->fault_description,
        'kondisi_unit' => $request->kondisi_unit,
        'repair_summary' => $request->repair_summary,
    ]);
    
    // INSERT lognote pertama jika diisi saat New Case
if ($request->filled('repair_summary')) {
    Lognote::create([
        'cof_id' => $service->cof_id,
        'username' => Auth::user()->username, // ← FIX DISINI
        'logdesc' => $request->repair_summary,
    ]);
}

    return redirect()->route('cs.services.index')
        ->with('success', "Case berhasil ditambahkan! COF-ID: $cofId");
}

}

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
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class ServiceController extends Controller
{
    // ✅ 1. Tampilkan daftar service
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User belum login.');
        }

        $services = Service::where('branch_id', $user->branch_id)
                           ->latest()
                           ->get();

        return view('cs.case', ['cases' => $services]);
    }

    // ✅ 2. Tampilkan form create — kirim $branches ke view
    public function create()
    {
        $branches = Branches::orderBy('name')->get();
        return view('cs.services.create', compact('branches'));
    }

    // ✅ 3. AJAX: ambil daftar CE berdasarkan branch yang dipilih
    public function getCesByBranch(Request $request)
    {
        $ces = User::where('branch_id', $request->branch_id)
                   ->where('role', 'CE')
                   ->get(['id', 'name', 'username']);

        return response()->json($ces);
    }

    // ✅ 4. Auto-fill model type dari product number
    public function getProductType(Request $request)
    {
        $product = Product::where('pn', $request->pn)->first();

        return response()->json([
            'nt' => $product ? $product->nt : null,
        ]);
    }

    // ✅ 5. Preview PDF
    public function previewPdf($id)
    {
        $service = Service::with('branch')->findOrFail($id);

        $addresses = [
            'A' => [
                'line1' => 'Ruko Mataram Plaza Blok D8',
                'line2' => 'Jl. MT. Haryono 427–429, Kota Semarang',
                'line3' => 'Jawa Tengah 50613',
                'telp'  => '08993201657',
            ],
            'B' => [
                'line1' => 'Ruko Slawi Indah Blok B1',
                'line2' => 'Jl. Ahmad Yani No.12, Slawi – Tegal',
                'line3' => 'Jawa Tengah 52413',
                'telp'  => '082132456789',
            ],
        ];

        $prefix  = $service->branch->prefix;
        $alamat  = $addresses[$prefix] ?? $addresses['A'];

        $pdf = Pdf::loadView('ce.pdf.cofsummary', compact('service', 'alamat'));

        return $pdf->stream('COF_' . $service->cof_id . '.pdf');
    }

    // ✅ 6. Simpan service baru
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User belum login.');
        }

        // ✅ FIX: pesan error sudah benar
        if ($user->role !== 'CS') {
            return back()->with('error', 'Akses ditolak, hanya CS yang bisa membuat case!');
        }

        // ✅ FIX: branch dari form (bukan dari user login)
        $branchId = $request->branch_id;

        if (!$branchId) {
            return back()->with('error', 'Cabang wajib dipilih!');
        }

        // ✅ FIX: ce_id dari form
        $ceId = $request->ce_id;
        if (!$ceId) {
            return back()->with('error', 'CE wajib dipilih!');
        }

        // Ambil prefix branch
        $branch = Branches::find($branchId);
        if (!$branch) {
            return back()->with('error', 'Cabang tidak ditemukan!');
        }
        $prefix = $branch->prefix ?? 'X';

        // Counter COF
        $counter = CofCounter::firstOrCreate(
            ['branch_id' => $branchId],
            ['current_number' => 0]
        );

        $nextNumber = $counter->current_number + 1;
        $counter->update(['current_number' => $nextNumber]);

        // Generate COF ID
        $year   = now()->format('Y');
        $month  = now()->format('m');
        $cofId  = $prefix . $year . $month . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // Create service
        $service = Service::create([
            'cof_id'           => $cofId,
            'status'           => 'new',
            'erf_file'         => $request->erf_file,
            'branch_id'        => $branchId,
            'ce_id'            => $ceId,   // ✅ FIX: dari form, bukan user login
            'customer_name'    => $request->customer_name,
            'email'            => $request->email,
            'contact'          => $request->contact,
            'phone_number'     => $request->phone_number,
            'address'          => $request->address,
            'received_date'    => $request->received_date,
            'started_date'     => $request->started_date,
            'finished_date'    => $request->finished_date,
            'brand'            => $request->brand,
            'product_number'   => $request->product_number,
            'serial_number'    => $request->serial_number,
            'nama_type'        => $request->nama_type,
            'accessories'      => $request->accessories,
            'fault_description'=> $request->fault_description,
            'kondisi_unit'     => $request->kondisi_unit,
            'repair_summary'   => $request->repair_summary,
        ]);

        // Insert lognote pertama jika ada repair summary
        if ($request->filled('repair_summary')) {
            Lognote::create([
                'cof_id'   => $service->cof_id,
                'username' => $user->username,
                'logdesc'  => $request->repair_summary,
            ]);
        }

        return redirect()->route('cs.services.index')
            ->with('success', "Case berhasil ditambahkan! COF-ID: $cofId");
    }
}
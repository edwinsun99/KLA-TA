<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\Branches;
use App\Models\CofCounter;
use App\Services\CofIdGenerator;
use Carbon\Carbon; // <-- ini baris penting
use Maatwebsite\Excel\Facades\Excel;
use App\Excel\CofData;
use Illuminate\Support\Facades\Log;
use Throwable;

class CaseController extends Controller
{
    protected $cofIdGenerator;

    public function __construct(CofIdGenerator $cofIdGenerator)
    {
        $this->cofIdGenerator = $cofIdGenerator;
    }

    /**
     * Tampilkan semua case untuk CE sesuai cabangnya.
     */
    public function index()
{
    $user = Auth::user();

    // tampilkan semua case milik cabang CE login (tanpa filter status)
    $cases = Service::where('branch_id', $user->branch_id)
                    ->orderBy('created_at', 'DESC')
                    ->get();

    return view('cs.case', compact('cases'));
}


   private function getEnumValues(string $table, string $column): array
{
    $row = DB::select(DB::raw("SHOW COLUMNS FROM `{$table}` WHERE Field = '{$column}'"));

    if (!isset($row[0])) {
        return [];
    }

    $type = $row[0]->Type; // contoh: enum('new','repair progress',...)
    preg_match("/^enum\((.*)\)$/", $type, $matches);

    if (!isset($matches[1])) {
        return [];
    }

    $vals = array_map(function($v){ return trim($v, "'"); }, explode(',', $matches[1]));
    return $vals;
}
    
public function logdate(Request $request)
{
    // Ambil user login berdasarkan session
    $username = Session::get('username');
    $user = \App\Models\User::where('username', $username)->first();

    if (!$user) {
        return redirect()->route('login')->with('error', 'User tidak ditemukan.');
    }

    // Mulai query hanya untuk cabang CE login
    $query = Service::where('branch_id', $user->branch_id);

    // Ambil input tanggal
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Jika hanya end_date diisi → start_date otomatis 1 hari sebelum
    if ($endDate && !$startDate) {
        $startDate = \Carbon\Carbon::parse($endDate)->subDay()->toDateString();
    }

    // Jika hanya start_date diisi → end_date otomatis hari ini
    if ($startDate && !$endDate) {
        $endDate = \Carbon\Carbon::now()->toDateString();
    }

    // Filter berdasarkan tanggal
    if ($startDate && $endDate) {
        $query->whereBetween('received_date', [$startDate, $endDate]);
    }

    // Ambil hasil (hanya milik branch CE login)
    $services = $query->orderByDesc('received_date')->paginate(10);

    // Kirim ke view
   return view('cs.case', [
    'cases' => $services,
    'start_date' => $startDate,
    'end_date' => $endDate,
]);

}



    public function print($id)
{
    $service = Service::with('branch')->findOrFail($id);

    $pdf = PDF::loadView('pdf.cof', compact('service'));
    return $pdf->stream('COF_'.$service->cof_id.'.pdf');
}


    /**
     * Detail case berdasarkan ID.
     */
    public function show($id)
{
    $service = Service::findOrFail($id);
    return view('cs.case_show', compact('service'));
}

    /**
     * Form untuk create new case.
     */
    public function create()
    {
        return view('cs.newcase');
    }

    /**
     * Simpan data new case ke database.
     */
// public function store(Request $request)
// {
//     // ✅ Validasi input
//     $validated = $request->validate([
//         'customer_name' => 'required|string|max:100',
//         'contact' => 'required|string|max:100',
//         'address' => 'nullable|string|max:500',
//         'email' => 'required|email|max:255',
//         'phone_number' => 'nullable|string|max:20',
//         'received_date' => 'nullable|date',
//         'started_date' => 'nullable|date',
//         'finished_date' => 'nullable|date',
//         'brand' => 'nullable|string|max:255',
//         'product_number' => 'nullable|string|max:100',
//         'serial_number' => 'nullable|string|max:100',
//         'nama_type' => 'nullable|string|max:100',
//         'fault_description' => 'nullable|string',
//         'kondisi_unit' => 'nullable|string',
//         'repair_summary' => 'nullable|string',
//         'status' => 'required|string',
//         'erf_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
//     ]);

//     // ✅ Ambil user login berdasarkan session
//     $user = Auth::user();
//     $user = \App\Models\User::where('un', $username)->first();

//     if (!$user) {
//         return redirect()->route('login')->with('error', 'User tidak ditemukan atau belum login.');
//     }

//     $branchId = $user->branch_id;
//     if (!$branchId) {
//         return back()->with('error', 'Akun CE belum terhubung ke cabang manapun.');
//     }

//     // ✅ Ambil branch & prefix
//     $branch = \App\Models\Branches::find($branchId);
//     $prefix = $branch->prefix ?? 'X'; // fallback prefix kalau null

//     // ✅ Ambil tanggal received (default: hari ini)
//     $receivedDate = $request->received_date
//         ? Carbon::parse($request->received_date)
//         : Carbon::now();

//     $yearMonth = $receivedDate->format('Ym'); // Contoh: 202511

//     // ✅ Cari service terakhir pada bulan & branch yang sama
//     $lastService = \App\Models\Service::where('branch_id', $branchId)
//         ->whereYear('received_date', $receivedDate->year)
//         ->whereMonth('received_date', $receivedDate->month)
//         ->orderBy('id', 'desc')
//         ->first();

//     // ✅ Tentukan nomor urut terakhir (5 digit di akhir COF ID)
//     if ($lastService && preg_match('/\d{5}$/', $lastService->cof_id, $matches)) {
//         $lastNumber = (int) $matches[0];
//     } else {
//         $lastNumber = 0;
//     }

//     $newNumber = $lastNumber + 1;

//     // ✅ Bentuk COF ID baru: PREFIX + YYYYMM + 5 digit urut
//     $cofId = sprintf("%s%s%05d", $prefix, $yearMonth, $newNumber);

//     // ✅ Simpan data case baru
//     $validated['cof_id'] = $cofId;
//     $validated['branch_id'] = $branchId;
//     $validated['ce_id'] = $user->id;
//     $validated['received_date'] = $receivedDate;

//     \App\Models\Service::create($validated);

//     // ✅ Redirect dengan notifikasi sukses
//     return redirect()->route('ce.case.index')
//         ->with('success', 'Case berhasil disimpan dengan COF ID: ' . $cofId);
// }

    public function search(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        $cases = Service::query()
            ->where('branch_id', $user->branch_id)
            ->when($search, function ($query, $search) {
                $query->where('cof_id', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('serial_number', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%");
            })
            ->get();

        return view('cs.case', compact('cases', 'search'));
    }

    /**
     * Export seluruh data ke Excel.
     */
  public function excel()
{
    $branchId = auth()->user()->branch_id;

    return Excel::download(new CofData($branchId), 'CofData.xlsx');
}
}
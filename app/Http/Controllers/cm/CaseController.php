<?php

namespace App\Http\Controllers\cm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Excel\CofDataCM;
use Carbon\Carbon; // <-- ini baris penting
use App\Models\Branches;
use Maatwebsite\Excel\Facades\Excel;

class CaseController extends Controller
{
    
 public function index()
{
    // Ambil semua branch untuk dropdown
    $branches = \App\Models\Branches::all();

    // Ganti ->get() menjadi ->paginate(10)
    // Ini otomatis akan membatasi 10 data dan menangani logika halaman
    $cases = Service::orderByDesc('received_date')->get();

    return view('cm.case', [
        'cases' => $cases,
        'branches' => $branches,
        'selected_branch' => 'all',
        'start_date' => null,
        'end_date' => null
    ]);
}


    public function show($id)
{
    $service = Service::findOrFail($id); // pakai modelmu
    return view('cm.case.show', compact('service'));
}

    public function logdate(Request $request)
{
    $query = Service::query();

    // Ambil semua cabang untuk dropdown
    $branches = \App\Models\Branches::all();

    // Ambil input filter
    $branchId = $request->input('branch_id');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Filter cabang bila dipilih (tidak null)
    if ($branchId && $branchId !== 'all') {
        $query->where('branch_id', $branchId);
    }

    // Auto adjust tanggal
    if ($endDate && !$startDate) {
        $startDate = \Carbon\Carbon::parse($endDate)->subDay()->toDateString();
    }

    if ($startDate && !$endDate) {
        $endDate = \Carbon\Carbon::now()->toDateString();
    }

    // Filter tanggal
    if ($startDate && $endDate) {
        $query->whereBetween('received_date', [$startDate, $endDate]);
    }

    $cases = $query->orderByDesc('received_date')->get();

    return view('cm.case', [
        'cases' => $cases,
        'branches' => $branches,
        'selected_branch' => $branchId,
        'start_date' => $startDate,
        'end_date' => $endDate
    ]);
}

public function search(Request $request)
{
    $search = $request->input('search');

    // Mengambil data cabang untuk dropdown filter agar tidak error/undefined
    $branches = \App\Models\Branches::all();

    // Gunakan plural $cases karena hasilnya adalah collection
    $cases = Service::query()
        ->when($search, function ($query, $search) {
            // Grouping where agar logic OR tidak merusak query filter lainnya
            return $query->where(function ($q) use ($search) {
                $q->where('cof_id', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        })
        ->latest() // Saran: Tampilkan yang terbaru di atas
        ->get();

    return view('cm.case', [
        'cases'           => $cases,
        'search'          => $search,
        'branches'        => $branches,
        'selected_branch' => 'all',
        'start_date'      => null,
        'end_date'        => null
    ]);
}

public function excel()
{
    Carbon::setLocale('id');

    $tanggal = Carbon::now()->translatedFormat('j F Y');

    $fileName = 'COF Report_' . $tanggal . '.xlsx';

    return Excel::download(new CofDataCM, $fileName);
}
}

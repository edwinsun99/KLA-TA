<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\Branches;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Tambahkan ini agar Auth::user() aman

class HomeController extends Controller
{   
    public function index(Request $request)
    {
        // 1. Ambil data user & branch
        $username = Session::get('username');
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User tidak ditemukan.');
        }

        $branchId = $user->branch_id; 

        // 2. STATISTICS CARD (Gunakan $branchId yang konsisten)
        $totalCases = Service::where('branch_id', $branchId)->count();

        $newCasesToday = Service::where('branch_id', $branchId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $casesInProgress = Service::where('branch_id', $branchId)
            ->where('status', 'repair progress')
            ->count();

        $finishedCases = Service::where('branch_id', $branchId)
            ->where('status', 'finish repair')
            ->count();

        // 3. LINE CHART (Kasus Masuk Per Bulan)
        // Tangkap tahun dari request, default ke 2026
        $selectedYear = $request->get('year', date('Y'));
        
        $cases = Service::selectRaw('MONTH(received_date) AS month, COUNT(*) AS total')
                ->where('branch_id', $branchId) // Gunakan $branchId agar sinkron
                ->whereYear('received_date', $selectedYear)
                ->whereNotNull('received_date')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

        $chartMonths = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $chartData = array_fill(0, 12, 0);

        foreach ($cases as $row) {
            if ($row->month >= 1 && $row->month <= 12) {
                $chartData[$row->month - 1] = $row->total;
            }
        }

        // 4. PIE CHART (Distribusi Status)
        $statusSummary = Service::selectRaw('status, COUNT(*) as total')
            ->where('branch_id', $branchId)
            ->whereNotNull('status')
            ->groupBy('status')
            ->get();

        $statusLabels = [
            'new',
            'repair progress',
            'quotation request',
            'quotation approved',
            'quotation cancelled',
            'cancel repair',
            'finish repair'
        ];

        $statusData = [];
        foreach ($statusLabels as $status) {
            $found = $statusSummary->firstWhere('status', $status);
            $statusData[] = $found ? $found->total : 0;
        }

        // 5. RETURN VIEW (Variabel sudah disamakan namanya)
        return view('cs.home', [
            'totalCases'      => $totalCases,
            'newCasesToday'   => $newCasesToday,
            'casesInProgress' => $casesInProgress,
            'finishedCases'   => $finishedCases,
            
            'chartMonths'     => $chartMonths, // ✅ Sudah sinkron
            'chartData'       => $chartData,   // ✅ Sudah sinkron
            'selectedYear'    => $selectedYear,

            'statusLabels'    => $statusLabels,
            'statusData'      => $statusData,
        ]);
    }
}
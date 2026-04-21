<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user() ?: User::where('username', Session::get('username'))->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User tidak ditemukan.');
        }

        // Sementara, karena DB belum punya relasi customer-service
        $services = collect();

        $totalCases = 0;
        $newCasesToday = 0;
        $casesInProgress = 0;
        $finishedCases = 0;
        $activeConsultations = 0;
        $notifications = collect();
        $recentConsultations = collect();
        $recentCases = collect();

        return view('customer.home', compact(
            'totalCases',
            'newCasesToday',
            'casesInProgress',
            'finishedCases',
            'activeConsultations',
            'notifications',
            'recentConsultations',
            'recentCases'
        ));
    }
}
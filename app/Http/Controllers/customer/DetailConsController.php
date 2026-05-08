<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Consultations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailConsController extends Controller
{
    /**
     * Tampilkan detail konsultasi milik customer yang sedang login.
     */
    public function show($id)
    {
        $user = Auth::user();

        $consultation = Consultations::with('customer')
            ->findOrFail($id);

        // Pastikan customer hanya bisa melihat data konsultasinya sendiri
        if ($consultation->customer_id !== $user->id) {
            abort(403, 'Kamu tidak punya akses ke konsultasi ini.');
        }

        return view('customer.detailcons', compact('consultation'));
    }
}
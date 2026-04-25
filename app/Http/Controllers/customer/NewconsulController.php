<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Consultations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NewconsulController extends Controller
{
    public function create()
    {
        $user = $this->resolveCustomer();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        if (strtoupper($user->role) !== 'CUSTOMER') {
            abort(403, 'Akses ditolak.');
        }

        return view('customer.formconsul');
    }

    public function store(Request $request)
    {
        $user = $this->resolveCustomer();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        if (strtoupper($user->role) !== 'CUSTOMER') {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'subject'       => ['required', 'string', 'max:150'],
            'product_group'  => ['required', 'in:PSG,IPG'],
            'category'      => ['required', 'string', 'max:50'],
            // 'device_type'   => ['required', 'string', 'max:50'],
            'brand_model'   => ['nullable', 'string', 'max:100'],
            // 'serial_number' => ['nullable', 'string', 'max:100'],
            'description'   => ['required', 'string', 'max:5000'],
        ]);

        $consultationId = DB::table('consultations')->insertGetId([
            'customer_id'   => $user->id,
            'subject'       => $validated['subject'],
            'product_group' => $validated['product_group'],
            'category'      => $validated['category'],
            // 'device_type'   => $validated['device_type'],
            'brand_model'   => $validated['brand_model'] ?? null,
            // 'serial_number' => $validated['serial_number'] ?? null,
            'description'   => $validated['description'],
            'status'        => 'active',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()
            ->route('consul.act')
            ->with('success', 'Konsultasi berhasil dibuat.');
    }

    private function resolveCustomer(): ?User
    {
        $user = Auth::user();

        if ($user) {
            return $user;
        }

        $username = Session::get('username');

        if (!$username) {
            return null;
        }

        return User::where('username', $username)->first();
    }
}
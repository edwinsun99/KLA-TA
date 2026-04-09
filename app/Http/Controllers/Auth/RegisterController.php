<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'email'    => 'required|email|max:255|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'       => $validated['name'],
            'phone'      => $validated['phone'],
            'email'      => $validated['email'],
            'username'   => $validated['username'],
            'password'   => Hash::make($validated['password']),
            'role'       => 'CUSTOMER',
            'branch_id'  => null,
        ]);

        Auth::login($user);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat.');
    }
}
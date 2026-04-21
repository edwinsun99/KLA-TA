<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLogin(Request $request)
    {
        if (!$request->session()->has('captcha_code')) {
            $captcha = substr(
                str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789'),
                0,
                5
            );

            $request->session()->put('captcha_code', $captcha);
        }

        $captcha = $request->session()->get('captcha_code');

        return view('auth.login', compact('captcha'));
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'captcha_input' => ['required', 'string'],
        ]);

        $captchaSession = strtolower(session('captcha_code', ''));
        $captchaInput = strtolower(trim($request->captcha_input));

        if ($captchaInput !== $captchaSession) {
            $this->refreshCaptcha($request);
            return back()->with('error', 'Captcha salah!')->withInput($request->only('username'));
        }

        $username = trim($request->username);
        $password = $request->password;

        $user = User::where('username', $username)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            $this->refreshCaptcha($request);
            return back()->with('error', 'Username atau password salah.')->withInput($request->only('username'));
        }

        // Login Laravel Auth
        Auth::login($user);
        $request->session()->regenerate();

        // Simpan session lama agar sistem lama tetap aman
        Session::put('login', true);
        Session::put('email', $user->email);
        Session::put('username', $user->username);
        Session::put('role', strtoupper($user->role));
        Session::put('branch_id', $user->branch_id);
        Session::put('user_id', $user->id);
        Session::put('name', $user->name);

        // Hapus captcha setelah login berhasil
        $request->session()->forget('captcha_code');

        $role = strtoupper($user->role);

        return match ($role) {
            'MASTER'   => redirect('/master/home')->with('success', 'Login berhasil sebagai MASTER!'),
            'CM'       => redirect('/cm/home')->with('success', 'Login berhasil sebagai CM!'),
            'CE'       => redirect('/ce/home')->with('success', 'Login berhasil sebagai CE!'),
            'CS'       => redirect('/cs/home')->with('success', 'Login berhasil sebagai CS!'),
            'CUSTOMER' => redirect('/cust/home')->with('success', 'Login berhasil. Selamat datang, ' . ($user->name ?? $user->username) . '!'),
            default    => redirect()->route('login')->with('error', 'Role tidak dikenali.'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    private function refreshCaptcha(Request $request): void
    {
        $captcha = substr(
            str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789'),
            0,
            5
        );

        $request->session()->put('captcha_code', $captcha);
    }
}
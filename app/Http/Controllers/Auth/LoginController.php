<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    
public function showLogin(Request $request)
{
    // Generate captcha hanya jika belum ada
    if (!$request->session()->has('captcha_code')) {
        $captcha = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789'), 0, 5);
        $request->session()->put('captcha_code', $captcha);
    }

    $captcha = $request->session()->get('captcha_code');
    return view('auth.login', compact('captcha'));
}


    public function loginProcess(Request $request)
    {

      $captchaSession = strtolower(session('captcha_code'));
    $captchaInput   = strtolower(trim($request->captcha_input));

    if ($captchaInput !== $captchaSession) {
        return back()->with('error', 'Captcha salah!')->withInput();
    }

        $username = $request->username;
        $password = $request->password;



        $user = User::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            // ✅ 1. Simpan data user ke session (versi lama, tetap dipertahankan)
            Session::put('login', true);
            Session::put('email', $user->email);
            Session::put('username', $user->username);
            Session::put('role', strtoupper($user->role));
            Session::put('branch_id', $user->branch_id);

            // ✅ 2. Sinkronisasi ke sistem Auth Laravel
            Auth::login($user);


    // HAPUS CAPTCHA
    $request->session()->forget('captcha_code');


            // ✅ 3. Redirect sesuai role
            switch (strtoupper($user->role)) {
                case 'MASTER':
                    return redirect('/master/home')->with('success', 'Login berhasil sebagai MASTER!');
                case 'CM':
                    return redirect('/cm/home')->with('success', 'Login berhasil sebagai CM!');
                case 'CE':
                    return redirect('/ce/home')->with('success', 'Login berhasil sebagai CE!');
                case 'CS':
                    return redirect('/cs/home')->with('success', 'Login berhasil sebagai CS!');
                default:
                    return redirect()->route('login')->with('error', 'Role tidak dikenali.');
            }
        } else {
            return redirect()->back()->with('error', 'Username atau password salah.');
        }
    }

    public function logout()
    {
        Auth::logout(); // ✅ tambahkan logout Auth juga
        Session::flush();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
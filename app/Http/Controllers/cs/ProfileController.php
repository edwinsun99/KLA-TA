<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('cs.editprof', compact('user'));
    }

    public function update(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'nullable|email|unique:users,email,' . $user->id,
            'profile_photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:12288',
        ]);

        if ($request->username) {
            $user->username = $request->username;
        } 

        if ($request->email) {
            $user->email = $request->email;
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos', 'public');;
            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profile berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Password lama salah');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }
}

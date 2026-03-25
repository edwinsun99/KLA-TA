<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Branches;
use App\Models\User;

class RoleController extends Controller
{

   public function index()
    {
        $branches = Branches::orderBy('name')->get();
        $users = User::with('branch')->latest()->get();

        return view('master.manage_roles', compact('branches', 'users'));
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:CS,CE',
        ];

        if (in_array($request->role, ['CS', 'CE'])) {
            $rules['branch_id'] = 'required|exists:branches,id';
        } else {
            $rules['branch_id'] = 'nullable';
        }

        $request->validate($rules);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'branch_id' => in_array($request->role, ['CS', 'CE'])
                ? $request->branch_id
                : null,
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'User baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Update username
        if (!empty($request->new_username) && $request->new_username !== $user->username) {
            $user->username = $request->new_username;
        }

        // Update password
        if (!empty($request->new_password)) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('roles.index')->with('success', 'User berhasil dihapus.');
    }
}

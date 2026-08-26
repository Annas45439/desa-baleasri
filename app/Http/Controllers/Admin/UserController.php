<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(12);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'email' => ['required', 'email', 'max:150', 'unique:users,email'], 'password' => ['required', 'string', 'min:6']]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return back()->with('status', 'Pengguna berhasil ditambahkan.');
    }

    public function destroy(User $user)
    {
        abort_if($user->is(auth()->user()), 422, 'Akun yang sedang digunakan tidak dapat dihapus.');
        $user->delete();
        return back()->with('status', 'Pengguna berhasil dihapus.');
    }
}

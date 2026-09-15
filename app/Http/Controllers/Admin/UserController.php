<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // Sembunyikan akun developer dari daftar pengguna agar tidak bisa dilihat atau diotak-atik
        $users = User::where('is_developer', false)->latest()->paginate(12);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', Rule::in(User::roles())],
        ]);

        // Batasi Super Admin desa maksimal 1 via form
        if ($data['role'] === User::ROLE_SUPER_ADMIN && User::where('role', User::ROLE_SUPER_ADMIN)->where('is_developer', false)->count() >= 1) {
            return back()
                ->withErrors(['role' => 'Kuota Super Admin Desa sudah penuh. Pilih role Admin atau Staff.'])
                ->withInput();
        }

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return back()->with('status', 'Pengguna baru berhasil ditambahkan.');
    }

    public function destroy(User $user)
    {
        // Akun Developer tersembunyi & tidak bisa dihapus oleh siapapun
        abort_if($user->isDeveloper(), 403, 'Akun Developer terlindungi dan tidak dapat diubah.');

        // Akun yang sedang login tidak bisa dihapus
        abort_if($user->is(auth()->user()), 422, 'Akun yang sedang digunakan tidak dapat dihapus.');

        $user->delete();
        return back()->with('status', 'Pengguna berhasil dihapus.');
    }

    public function updatePassword(Request $request, User $user)
    {
        abort_if($user->isDeveloper(), 403, 'Akun Developer terlindungi dan tidak dapat diubah.');
        abort_unless(
            (int) $request->session()->pull('password_reauth_user_id') === (int) $user->id,
            403,
            'Verifikasi Google diperlukan sebelum mengubah password.'
        );

        $data = $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user->update(['password' => Hash::make($data['password'])]);

        return back()->with('status', 'Password pengguna berhasil diperbarui.');
    }
}

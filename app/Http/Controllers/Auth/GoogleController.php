<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect user to Google OAuth page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     *
     * Logika pendaftaran Super Admin:
     *  - Database memiliki 2 slot Super Admin: 1 Developer (permanen) + 1 Sekdes/Desa
     *  - Slot Sekdes sengaja dikosongkan. Saat pihak desa login pertama kali
     *    dengan Gmail mereka, akun otomatis dibuat sebagai Super Admin ke-2.
     *  - Jika 2 slot sudah terisi, login hanya diizinkan untuk email yang sudah ada di DB.
     *  - Akun Developer (is_developer = true) tidak bisa didaftarkan lewat Google OAuth.
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $googleEmail = $googleUser->getEmail();

            if ($request->session()->has('password_reauth_user_id')) {
                abort_unless(Auth::check() && hash_equals(strtolower(Auth::user()->email), strtolower($googleEmail)), 403, 'Akun Google harus sama dengan akun admin yang sedang login.');

                $userId = $request->session()->get('password_reauth_user_id');

                return redirect()->route('admin.users.index')
                    ->with('status', 'Verifikasi Google berhasil. Silakan simpan password baru.');
            }

            // Cari apakah email Google sudah ada di database
            $user = User::where('email', $googleEmail)->first();

            if (! $user) {
                // Hitung berapa slot Super Admin yang masih kosong
                // (tidak menghitung akun Developer sebagai "slot desa")
                $desaSlotTerisi = User::where('role', User::ROLE_SUPER_ADMIN)
                    ->where('is_developer', false)
                    ->count();

                if ($desaSlotTerisi >= 1) {
                    // Slot desa sudah terisi, email tidak dikenal
                    return redirect()->route('admin.login')
                        ->withErrors(['email' => "Email ({$googleEmail}) tidak terdaftar. Hubungi Developer atau Super Admin desa untuk mendaftarkan akun Anda."]);
                }

                // Slot desa masih kosong → daftarkan sebagai Super Admin Desa
                $user = User::create([
                    'name'         => $googleUser->getName() ?: 'Super Admin Desa',
                    'email'        => $googleEmail,
                    'password'     => Hash::make(Str::random(32)),
                    'role'         => User::ROLE_SUPER_ADMIN,
                    'is_developer' => false,
                ]);
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            $isFirstLogin = $user->wasRecentlyCreated;

            return redirect()->route('admin.dashboard')
                ->with('status', $isFirstLogin
                    ? "Selamat datang, {$user->name}! Akun Super Admin desa berhasil didaftarkan."
                    : "Selamat datang kembali, {$user->name}!"
                );

        } catch (\Throwable $e) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Gagal melakukan otentikasi Google: ' . $e->getMessage()]);
        }
    }
}

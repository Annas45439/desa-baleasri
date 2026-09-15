<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Slot 1: Developer (permanen, tidak bisa dihapus, tidak muncul di Google OAuth registration)
        // Password diambil dari env DEVELOPER_SEED_PASSWORD, atau generate random jika tidak diset.
        // Setelah seeder dijalankan, ganti password via panel admin — JANGAN hardcode password di sini.
        $password = env('DEVELOPER_SEED_PASSWORD') ?: \Illuminate\Support\Str::random(32);

        User::updateOrCreate(
            ['email' => 'developer@baleasri.desa.id'],
            [
                'name'         => 'Developer',
                'role'         => User::ROLE_SUPER_ADMIN,
                'password'     => Hash::make($password),
                'is_developer' => true,
            ]
        );
    }
}

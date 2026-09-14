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
        // Slot 2: DIKOSONGKAN → akan diisi oleh pihak desa saat login pertama kali dengan Gmail mereka
        User::updateOrCreate(
            ['email' => 'developer@baleasri.desa.id'],
            [
                'name'         => 'Developer',
                'role'         => User::ROLE_SUPER_ADMIN,
                'password'     => Hash::make('dev@baleasri2026'),
                'is_developer' => true,
            ]
        );
    }
}

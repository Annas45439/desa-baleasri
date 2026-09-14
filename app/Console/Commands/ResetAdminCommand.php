<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-email {email : Email baru untuk Super Admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ubah email Super Admin desa jika email lama hilang atau ingin diganti';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $newEmail = strtolower(trim($this->argument('email')));

        if (! filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $this->error('Format email tidak valid.');
            return 1;
        }

        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->first();

        if (! $admin) {
            $admin = User::create([
                'name' => 'Sekdes Baleasri',
                'email' => $newEmail,
                'password' => bcrypt('admin123'),
                'role' => User::ROLE_SUPER_ADMIN,
            ]);
            $this->info("Akun Super Admin baru berhasil dibuat dengan email: {$newEmail}");
            return 0;
        }

        $oldEmail = $admin->email;
        $admin->update(['email' => $newEmail]);

        $this->info("Email Super Admin berhasil diperbarui dari '{$oldEmail}' menjadi '{$newEmail}'.");
        return 0;
    }
}

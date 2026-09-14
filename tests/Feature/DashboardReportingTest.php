<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardReportingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_shows_operational_summary_for_letters_and_complaints(): void
    {
        $user = User::factory()->create([
            'role' => 'super_admin',
        ]);

        Letter::create([
            'nama_lengkap' => 'Warga A',
            'nik' => '3301010101010001',
            'no_telepon' => '081234567890',
            'email' => 'a@example.com',
            'jenis_surat' => 'Domisili',
            'keperluan' => 'Keperluan administrasi',
            'status' => Letter::STATUS_BARU,
            'tanggal_pengajuan' => now(),
        ]);

        Letter::create([
            'nama_lengkap' => 'Warga B',
            'nik' => '3301010101010002',
            'no_telepon' => '081234567891',
            'email' => 'b@example.com',
            'jenis_surat' => 'SKTM',
            'keperluan' => 'Kartu keluarga',
            'status' => Letter::STATUS_SELESAI,
            'tanggal_pengajuan' => now(),
        ]);

        Complaint::create([
            'nama' => 'Warga C',
            'kontak' => '081234567892',
            'kategori' => 'Lingkungan',
            'isi' => 'Sampah menumpuk',
            'status' => 'Baru',
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertOk()
            ->assertSee('Pengajuan Surat')
            ->assertSee('Pengaduan')
            ->assertSee('2');
    }
}

<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminReportingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_report_page_includes_letter_and_complaint_summary(): void
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

        Complaint::create([
            'nama' => 'Warga B',
            'kontak' => '081234567891',
            'kategori' => 'Lingkungan',
            'isi' => 'Sampah menumpuk',
            'status' => 'Diproses',
        ]);

        $this->actingAs($user)
            ->get(route('admin.letters.report'))
            ->assertOk()
            ->assertSee('Laporan Pengajuan Surat')
            ->assertSee('Pengaduan')
            ->assertSee('Diproses');
    }

    public function test_admin_report_export_includes_complaint_rows(): void
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

        Complaint::create([
            'nama' => 'Warga B',
            'kontak' => '081234567891',
            'kategori' => 'Lingkungan',
            'isi' => 'Sampah menumpuk',
            'status' => 'Diproses',
        ]);

        $this->actingAs($user)
            ->get(route('admin.letters.export-report', [
                'period' => 'monthly',
                'year' => now()->year,
                'month' => now()->format('m'),
            ]))
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->assertSee('Warga B')
            ->assertSee('Pengaduan');
    }
}

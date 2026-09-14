<?php

namespace Tests\Feature;

use App\Models\Letter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LetterTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_can_be_searched_by_phone_number(): void
    {
        $letter = Letter::create([
            'nama_lengkap' => 'Budi Santoso',
            'nik' => '3301010101010001',
            'no_telepon' => '081234567890',
            'email' => 'budi@example.com',
            'jenis_surat' => 'Domisili',
            'keperluan' => 'Keperluan administrasi',
            'status' => Letter::STATUS_BARU,
            'tanggal_pengajuan' => now(),
        ]);

        $response = $this->post(route('letters.search'), ['search' => '081234567890']);

        $response->assertStatus(200);
        $response->assertSee($letter->ref_number);
    }
}

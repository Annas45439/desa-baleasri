<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplaintManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_complaint_index_shows_status_summary(): void
    {
        $user = User::factory()->create([
            'role' => 'super_admin',
        ]);

        Complaint::create([
            'nama' => 'Warga A',
            'kontak' => '081234567890',
            'kategori' => 'Infrastruktur',
            'isi' => 'Jalan rusak',
            'status' => 'Baru',
        ]);

        Complaint::create([
            'nama' => 'Warga B',
            'kontak' => '081234567891',
            'kategori' => 'Lingkungan',
            'isi' => 'Sampah menumpuk',
            'status' => 'Diproses',
        ]);

        $this->actingAs($user)
            ->get(route('admin.complaints.index'))
            ->assertOk()
            ->assertSee('Ringkasan Status')
            ->assertSee('Baru')
            ->assertSee('Diproses');
    }
}

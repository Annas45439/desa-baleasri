<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm_applicants', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha', 150);
            $table->string('pemilik', 120);
            $table->string('kategori', 80);
            $table->string('wa', 30);
            $table->string('lokasi', 180);
            $table->text('deskripsi');
            $table->enum('status', ['Menunggu Persetujuan', 'Disetujui', 'Ditolak'])->default('Menunggu Persetujuan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_applicants');
    }
};

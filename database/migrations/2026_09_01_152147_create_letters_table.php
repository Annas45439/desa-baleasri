<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            
            // Data Warga Pengaju
            $table->string('nama_lengkap');
            $table->string('nik')->unique();
            $table->string('no_telepon');
            $table->string('email');
            
            // Data Pengajuan Surat
            $table->enum('jenis_surat', ['Domisili', 'SKTM', 'SKU', 'Kematian', 'Kelahiran', 'Pindah', 'Lainnya']);
            $table->text('keperluan');
            $table->string('dokumen_pendukung')->nullable();
            
            // Status & Proses Admin
            $table->enum('status', ['Baru', 'Diproses', 'Siap Diambil', 'Selesai', 'Ditolak'])->default('Baru');
            $table->string('nomor_surat')->nullable()->unique();
            $table->text('catatan_admin')->nullable();
            $table->string('surat_pdf')->nullable();
            
            // Tracking
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->unsignedBigInteger('diproses_oleh')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('diproses_oleh')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};

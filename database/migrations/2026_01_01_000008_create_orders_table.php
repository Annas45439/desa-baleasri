<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->foreignId('potensi_id')->constrained('potensis')->cascadeOnDelete();
            $table->string('nama', 120);
            $table->string('kontak', 40);
            $table->unsignedSmallInteger('jumlah');
            $table->string('varian', 150)->nullable();
            $table->enum('metode', ['Ambil di lokasi', 'Kirim ke alamat']);
            $table->string('alamat', 500);
            $table->text('catatan')->nullable();
            $table->enum('status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'])->default('Menunggu Konfirmasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

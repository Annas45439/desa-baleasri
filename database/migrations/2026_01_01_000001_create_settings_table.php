<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa')->default('Desa Baleasri');
            $table->string('tagline')->nullable();
            $table->text('deskripsi_hero')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_video')->nullable();
            $table->string('nama_kepala_desa')->nullable();
            $table->text('sambutan')->nullable();
            $table->string('foto_kepala_desa')->nullable();
            $table->unsignedInteger('stat_pendidikan')->default(0);
            $table->unsignedInteger('stat_umkm')->default(0);
            $table->unsignedInteger('stat_wisata')->default(0);
            $table->unsignedInteger('stat_embung')->default(0);
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('jam_operasional')->nullable();
            $table->string('whatsapp_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('settings'); }
};

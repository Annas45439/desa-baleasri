<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('nama_sekretaris_desa')->nullable()->after('foto_kepala_desa');
            $table->string('jabatan_sekretaris_desa')->nullable()->after('nama_sekretaris_desa');
            $table->string('lokasi_sekretaris_desa')->nullable()->after('jabatan_sekretaris_desa');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'nama_sekretaris_desa',
                'jabatan_sekretaris_desa',
                'lokasi_sekretaris_desa',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('ongkir')->nullable()->after('metode');
            $table->string('layanan_kurir', 40)->nullable()->after('ongkir');
            $table->string('kode_pos', 10)->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['ongkir', 'layanan_kurir', 'kode_pos']);
        });
    }
};

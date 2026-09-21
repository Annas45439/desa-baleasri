<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('apbdes', function (Blueprint $table) {
            $table->string('kategori', 120)->nullable()->after('jenis');
            $table->string('sumber_dana', 150)->nullable()->after('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('apbdes', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'sumber_dana']);
        });
    }
};

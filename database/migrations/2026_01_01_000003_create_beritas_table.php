<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('ringkasan')->nullable();
            $table->longText('isi')->nullable();
            $table->string('foto')->nullable();
            $table->string('penulis')->nullable();
            $table->boolean('tampil')->default(true);
            $table->timestamp('tanggal_terbit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('beritas'); }
};

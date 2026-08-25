<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = ['judul', 'slug', 'ringkasan', 'isi', 'foto', 'penulis', 'tampil', 'tanggal_terbit'];
    protected $casts = ['tampil' => 'boolean', 'tanggal_terbit' => 'datetime'];

    protected static function booted(): void
    {
        static::saving(function (Berita $berita) {
            if (empty($berita->slug)) $berita->slug = Str::slug($berita->judul) . '-' . Str::random(5);
            if (empty($berita->tanggal_terbit)) $berita->tanggal_terbit = now();
        });
    }

    public function scopeTampil($query) { return $query->where('tampil', true); }
}

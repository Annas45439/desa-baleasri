<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Potensi extends Model
{
    protected $fillable = ['nama', 'slug', 'kategori', 'tag', 'deskripsi', 'foto', 'kontak_whatsapp', 'tampil', 'urutan'];
    protected $casts = ['tampil' => 'boolean'];

    protected static function booted(): void
    {
        static::saving(function (Potensi $potensi) {
            if (empty($potensi->slug)) {
                $potensi->slug = Str::slug($potensi->nama) . '-' . Str::random(5);
            }
        });
    }

    public function scopeTampil($query) { return $query->where('tampil', true); }
    public function scopeKategori($query, string $kategori) { return $query->where('kategori', $kategori); }
}

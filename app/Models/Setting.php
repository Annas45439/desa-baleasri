<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['nama_desa', 'tagline', 'deskripsi_hero', 'hero_image', 'hero_video', 'nama_kepala_desa', 'sambutan', 'foto_kepala_desa', 'stat_pendidikan', 'stat_umkm', 'stat_wisata', 'stat_embung', 'alamat', 'email', 'jam_operasional', 'whatsapp_admin'];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'nama_desa' => 'Desa Baleasri',
            'tagline' => 'Rumah yang Asri, untuk Warga Baleasri',
        ]);
    }
}

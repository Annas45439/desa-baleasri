<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['nama_desa', 'tagline', 'deskripsi_hero', 'hero_image', 'hero_video', 'nama_kepala_desa', 'sambutan', 'foto_kepala_desa', 'stat_pendidikan', 'stat_umkm', 'stat_wisata', 'stat_embung', 'alamat', 'email', 'jam_operasional', 'whatsapp_admin', 'instagram', 'facebook', 'youtube', 'maps_embed', 'sop_pengajuan', 'estimasi_proses'];

    public static function current(): self
    {
        $defaults = [
            'nama_desa' => 'Desa Baleasri',
            'tagline' => 'Rumah yang Asri, untuk Warga Baleasri',
        ];

        if (! Schema::hasTable((new static)->getTable())) {
            return new static($defaults);
        }

        $setting = static::first();

        if (! $setting) {
            $setting = static::firstOrCreate(['id' => 1], $defaults);
        }

        return $setting;
    }
}

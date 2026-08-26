<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['kode', 'potensi_id', 'nama', 'kontak', 'jumlah', 'varian', 'metode', 'ongkir', 'layanan_kurir', 'alamat', 'kode_pos', 'catatan', 'status'];

    public function produk()
    {
        return $this->belongsTo(Potensi::class, 'potensi_id');
    }
}

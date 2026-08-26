<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model
{
    protected $fillable = ['tahun', 'jenis', 'nama', 'anggaran', 'realisasi', 'keterangan'];
    protected $casts = ['anggaran' => 'decimal:2', 'realisasi' => 'decimal:2'];
}

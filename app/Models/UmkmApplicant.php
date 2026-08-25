<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmApplicant extends Model
{
    protected $fillable = ['nama_usaha', 'pemilik', 'kategori', 'wa', 'lokasi', 'deskripsi', 'status'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['nama', 'kontak', 'kategori', 'isi', 'photo_paths', 'status'];

    protected $casts = [
        'photo_paths' => 'array',
    ];
}

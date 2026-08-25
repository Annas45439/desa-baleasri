<?php

namespace App\Http\Controllers;

use App\Models\UmkmApplicant;
use Illuminate\Http\Request;

class UmkmApplicantController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_usaha' => ['required', 'string', 'max:150'],
            'pemilik' => ['required', 'string', 'max:120'],
            'kategori' => ['required', 'string', 'max:80'],
            'wa' => ['required', 'string', 'max:30'],
            'lokasi' => ['required', 'string', 'max:180'],
            'deskripsi' => ['required', 'string', 'max:2000'],
        ]);

        $data['status'] = 'Menunggu Persetujuan';
        UmkmApplicant::create($data);

        return back()->with('umkm_status', 'Pendaftaran berhasil dikirim. Admin desa akan meninjau usulan Anda.');
    }
}

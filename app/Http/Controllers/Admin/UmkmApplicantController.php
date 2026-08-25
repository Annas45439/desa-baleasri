<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmApplicant;
use Illuminate\Http\Request;

class UmkmApplicantController extends Controller
{
    public function updateStatus(Request $request, UmkmApplicant $applicant)
    {
        $data = $request->validate(['status' => ['required', 'in:Disetujui,Ditolak,Menunggu Persetujuan']]);
        $applicant->update($data);

        return back()->with('status', 'Status pendaftar UMKM berhasil diperbarui.');
    }
}

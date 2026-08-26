<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'kontak' => ['nullable', 'string', 'max:40'],
            'kategori' => ['required', 'string', 'max:80'],
            'isi' => ['required', 'string', 'max:3000'],
        ]);

        Complaint::create($data + ['status' => 'Baru']);

        return back()->with('complaint_status', 'Aduan berhasil dikirim. Terima kasih sudah membantu membangun Baleasri.');
    }
}

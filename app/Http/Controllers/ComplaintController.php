<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'kontak' => ['nullable', 'string', 'max:40'],
            'kategori' => ['required', 'string', 'max:80'],
            'isi' => ['required', 'string', 'max:3000'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $photoPaths = collect($request->file('photos', []))
            ->map(fn ($photo) => $photo->store('pengaduan', 'public'))
            ->all();

        Complaint::create([
            ...$data,
            'photo_paths' => $photoPaths ?: null,
            'status' => 'Baru',
        ]);

        $adminNumber = preg_replace('/[^0-9]/', '', (string) setting('whatsapp_admin'));
        if (str_starts_with($adminNumber, '0')) {
            $adminNumber = '62' . substr($adminNumber, 1);
        }
        $message = "Halo Admin Desa Baleasri, ada pengaduan baru.\n\n"
            . "Nama: {$data['nama']}\n"
            . "Kontak: " . ($data['kontak'] ?? '-') . "\n"
            . "Kategori: {$data['kategori']}\n"
            . "Isi pengaduan:\n{$data['isi']}";

        if ($photoPaths) {
            $message .= "\n\nFoto bukti:";
            foreach ($photoPaths as $photoPath) {
                $message .= "\n" . url(Storage::url($photoPath));
            }
        }

        if ($adminNumber) {
            return redirect()->away('https://wa.me/' . $adminNumber . '?text=' . urlencode($message));
        }

        return back()->with('complaint_status', 'Aduan berhasil disimpan. Nomor WhatsApp admin belum dikonfigurasi.');
    }
}

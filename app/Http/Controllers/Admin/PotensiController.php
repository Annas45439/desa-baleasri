<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Potensi;
use App\Models\UmkmApplicant;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PotensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Potensi::query()->orderBy('kategori')->orderBy('urutan');
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        $potensis = $query->paginate(10)->withQueryString();
        $umkmApplicants = UmkmApplicant::latest()->get();
        return view('admin.potensi.index', compact('potensis', 'umkmApplicants'));
    }

    public function create() { return view('admin.potensi.form', ['potensi' => new Potensi()]); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($request->hasFile('foto')) {
            $data['foto'] = ImageOptimizer::compressAndStore($request->file('foto'), 'potensi');
        }
        Potensi::create($data);
        return redirect()->route('admin.potensi.index')->with('status', 'Potensi desa berhasil ditambahkan.');
    }

    public function edit(Potensi $potensi) { return view('admin.potensi.form', compact('potensi')); }

    public function update(Request $request, Potensi $potensi)
    {
        $data = $this->validated($request);
        if ($request->hasFile('foto')) {
            if ($potensi->foto && Storage::disk('public')->exists($potensi->foto)) {
                Storage::disk('public')->delete($potensi->foto);
            }
            $data['foto'] = ImageOptimizer::compressAndStore($request->file('foto'), 'potensi');
        }
        $potensi->update($data);
        return redirect()->route('admin.potensi.index')->with('status', 'Potensi desa berhasil diperbarui.');
    }

    public function destroy(Potensi $potensi)
    {
        if ($potensi->foto && Storage::disk('public')->exists($potensi->foto)) {
            Storage::disk('public')->delete($potensi->foto);
        }
        $potensi->delete();
        return redirect()->route('admin.potensi.index')->with('status', 'Potensi desa berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:150'], 'kategori' => ['required', 'in:wisata,umkm,galeri'],
            'tag' => ['nullable', 'string', 'max:80'], 'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,avif,heic', 'max:10240'], 'kontak_whatsapp' => ['nullable', 'string', 'max:20'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['tampil'] = $request->boolean('tampil');
        return $data;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index() { return view('admin.berita.index', ['beritas' => Berita::latest('tanggal_terbit')->paginate(10)]); }
    public function create() { return view('admin.berita.form', ['berita' => new Berita()]); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($request->hasFile('foto')) {
            $data['foto'] = ImageOptimizer::compressAndStore($request->file('foto'), 'berita');
        }
        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('status', 'Berita berhasil dipublikasikan.');
    }

    public function edit(Berita $berita) { return view('admin.berita.form', compact('berita')); }

    public function update(Request $request, Berita $berita)
    {
        $data = $this->validated($request);
        if ($request->hasFile('foto')) {
            if ($berita->foto && Storage::disk('public')->exists($berita->foto)) {
                Storage::disk('public')->delete($berita->foto);
            }
            $data['foto'] = ImageOptimizer::compressAndStore($request->file('foto'), 'berita');
        }
        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('status', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->foto && Storage::disk('public')->exists($berita->foto)) {
            Storage::disk('public')->delete($berita->foto);
        }
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('status', 'Berita berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:180'], 'ringkasan' => ['nullable', 'string', 'max:255'],
            'isi' => ['nullable', 'string'], 'foto' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,avif,heic', 'max:10240'],
            'penulis' => ['nullable', 'string', 'max:100'],
        ]);
        $data['tampil'] = $request->boolean('tampil');
        return $data;
    }
}

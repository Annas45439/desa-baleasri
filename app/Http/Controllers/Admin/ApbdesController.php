<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use Illuminate\Http\Request;

class ApbdesController extends Controller
{
    public function index()
    {
        $apbdes = Apbdes::where('tahun', request('tahun', now()->year))->orderBy('jenis')->orderBy('nama')->get();
        return view('admin.apbdes.index', compact('apbdes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['tahun' => ['required', 'integer', 'min:2000', 'max:2100'], 'jenis' => ['required', 'in:Pendapatan,Belanja,Pembiayaan'], 'kategori' => ['nullable', 'string', 'max:120'], 'sumber_dana' => ['nullable', 'string', 'max:150'], 'nama' => ['required', 'string', 'max:180'], 'anggaran' => ['required', 'numeric', 'min:0'], 'realisasi' => ['required', 'numeric', 'min:0'], 'keterangan' => ['nullable', 'string']]);
        Apbdes::create($data);
        return back()->with('status', 'Data APBDes berhasil ditambahkan.');
    }

    public function update(Request $request, Apbdes $apbdes)
    {
        $data = $request->validate(['tahun' => ['required', 'integer', 'min:2000', 'max:2100'], 'jenis' => ['required', 'in:Pendapatan,Belanja,Pembiayaan'], 'kategori' => ['nullable', 'string', 'max:120'], 'sumber_dana' => ['nullable', 'string', 'max:150'], 'nama' => ['required', 'string', 'max:180'], 'anggaran' => ['required', 'numeric', 'min:0'], 'realisasi' => ['required', 'numeric', 'min:0'], 'keterangan' => ['nullable', 'string']]);
        $apbdes->update($data);
        return back()->with('status', 'Data APBDes berhasil diperbarui.');
    }

    public function destroy(Apbdes $apbdes)
    {
        $apbdes->delete();
        return back()->with('status', 'Data APBDes berhasil dihapus.');
    }
}

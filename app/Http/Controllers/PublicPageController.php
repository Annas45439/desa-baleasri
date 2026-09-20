<?php

namespace App\Http\Controllers;

use App\Models\Apbdes;
use App\Models\Berita;
use App\Models\Potensi;
use App\Models\Setting;

class PublicPageController extends Controller
{
    public function profil()
    {
        return view('public.profil', [
            'setting' => Setting::current(),
        ]);
    }

    public function apbdes()
    {
        return view('public.apbdes', [
            'setting' => Setting::current(),
            'years' => Apbdes::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun'),
            'apbdes' => Apbdes::orderByDesc('tahun')->orderBy('jenis')->orderBy('nama')->get(),
        ]);
    }

    public function wisata()
    {
        return view('public.wisata', [
            'setting' => Setting::current(),
            'wisata' => Potensi::kategori('wisata')->tampil()->orderBy('urutan')->get(),
        ]);
    }

    public function galeri()
    {
        return view('public.galeri', [
            'setting' => Setting::current(),
            'galeri' => Potensi::kategori('galeri')->tampil()->orderBy('urutan')->get(),
        ]);
    }

    public function berita()
    {
        return view('public.berita', [
            'setting' => Setting::current(),
            'beritas' => Berita::tampil()->latest('tanggal_terbit')->get(),
        ]);
    }

    public function pengaduan()
    {
        return view('public.pengaduan', [
            'setting' => Setting::current(),
        ]);
    }

}

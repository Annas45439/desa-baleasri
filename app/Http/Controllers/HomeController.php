<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Potensi;
use App\Models\Setting;
use App\Models\UmkmApplicant;

class HomeController extends Controller
{
    public function index()
    {
        $setting = Setting::current();

        $wisata = Potensi::kategori('wisata')->tampil()->orderBy('urutan')->take(3)->get();
        $umkm = Potensi::kategori('umkm')->tampil()->orderBy('urutan')->get();
        $galeri = Potensi::kategori('galeri')->tampil()->orderBy('urutan')->take(6)->get();
        $beritas = Berita::tampil()->latest('tanggal_terbit')->take(3)->get();
        $umkmApplicants = UmkmApplicant::latest()->take(3)->get();

        return view('public.home', compact('setting', 'wisata', 'umkm', 'galeri', 'beritas', 'umkmApplicants'));
    }
}

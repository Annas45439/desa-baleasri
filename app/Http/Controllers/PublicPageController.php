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
        $years = Apbdes::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');
        $selectedYear = (int) request('tahun', $years->first() ?? now()->year);
        $current = Apbdes::where('tahun', $selectedYear)->get();
        $trend = Apbdes::selectRaw('tahun, SUM(anggaran) as anggaran, SUM(realisasi) as realisasi')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        return view('public.apbdes', [
            'setting' => Setting::current(),
            'years' => $years,
            'selectedYear' => $selectedYear,
            'apbdes' => $current->sortBy(['jenis', 'nama'])->values(),
            'categoryTotals' => $current->groupBy(fn ($item) => $item->kategori ?: 'Lainnya')
                ->map(fn ($items) => (float) $items->sum('anggaran'))
                ->sortDesc(),
            'fundTotals' => $current->groupBy(fn ($item) => $item->sumber_dana ?: 'Belum ditentukan')
                ->map(fn ($items) => (float) $items->sum('anggaran'))
                ->sortDesc(),
            'trend' => $trend,
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

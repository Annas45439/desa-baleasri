<?php

namespace App\Http\Controllers;

use App\Models\Potensi;
use App\Models\Setting;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    public function index()
    {
        $umkmGroups = Potensi::kategori('umkm')
            ->tampil()
            ->orderBy('urutan')
            ->get()
            ->groupBy(fn ($item) => $item->tag ?: 'Produk Lokal');

        return view('public.umkm-index', [
            'setting' => Setting::current(),
            'umkmGroups' => $umkmGroups,
        ]);
    }

    public function show(string $kategori)
    {
        $produk = Potensi::kategori('umkm')
            ->tampil()
            ->whereRaw('LOWER(REPLACE(tag, " ", "-")) = ?', [strtolower($kategori)])
            ->orderBy('urutan')
            ->get();

        abort_if($produk->isEmpty(), 404);

        return view('public.umkm', [
            'setting' => Setting::current(),
            'produk' => $produk,
            'kategori' => $produk->first()->tag ?: Str::headline($kategori),
        ]);
    }
}

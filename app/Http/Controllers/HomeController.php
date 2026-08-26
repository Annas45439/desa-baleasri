<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Potensi;
use App\Models\Setting;
use App\Models\VisitorStat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('baleasri_visitor_counted')) {
            VisitorStat::firstOrCreate(['visit_date' => today()])->increment('visitors');
            $request->session()->put('baleasri_visitor_counted', true);
        }

        $setting = Setting::current();

        $wisata = Potensi::kategori('wisata')->tampil()->orderBy('urutan')->take(3)->get();
        $umkm = Potensi::kategori('umkm')->tampil()->orderBy('urutan')->get();
        $galeri = Potensi::kategori('galeri')->tampil()->orderBy('urutan')->take(6)->get();
        $beritas = Berita::tampil()->latest('tanggal_terbit')->take(3)->get();
        $todayVisitors = VisitorStat::whereDate('visit_date', today())->value('visitors') ?? 0;
        $totalVisitors = VisitorStat::sum('visitors');

        return view('public.home', compact('setting', 'wisata', 'umkm', 'galeri', 'beritas', 'todayVisitors', 'totalVisitors'));
    }
}

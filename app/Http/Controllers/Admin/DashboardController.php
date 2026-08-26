<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Potensi;
use App\Models\Setting;
use App\Models\UmkmApplicant;
use App\Models\VisitorStat;
use App\Models\Order;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index()
    {
        $setting = Setting::current();
        $totalUmkm = Potensi::kategori('umkm')->count();
        $umkmTayang = Potensi::kategori('umkm')->tampil()->count();
        $totalWisata = Potensi::kategori('wisata')->count();
        $totalBerita = Berita::count();
        $beritaTerbaru = Berita::latest('tanggal_terbit')->take(5)->get();
        $potensiTerbaru = Potensi::latest()->take(5)->get();
        $umkmApplicants = UmkmApplicant::latest()->take(5)->get();
        $pendingApplicants = UmkmApplicant::where('status', 'Menunggu Persetujuan')->count();
        $pendingOrders = Order::whereIn('status', ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Diproses'])->count();
        $todayVisitors = VisitorStat::whereDate('visit_date', today())->value('visitors') ?? 0;
        $totalVisitors = VisitorStat::sum('visitors');
        $visitorDays = VisitorStat::whereBetween('visit_date', [now()->subDays(6)->toDateString(), today()->toDateString()])->pluck('visitors', 'visit_date');
        $visitorChart = collect(CarbonPeriod::create(now()->subDays(6)->startOfDay(), today()->startOfDay()))->map(function ($date) use ($visitorDays) {
            $key = $date->toDateString();
            return ['label' => $date->format('d/m'), 'visitors' => (int) ($visitorDays[$key] ?? 0)];
        });

        $contentHealth = [
            ['label' => 'Identitas & hero', 'value' => $setting->deskripsi_hero && ($setting->hero_video || $setting->hero_image) ? 100 : ($setting->nama_desa ? 60 : 0), 'tone' => 'teal'],
            ['label' => 'Wisata', 'value' => min(100, $totalWisata * 33), 'tone' => 'violet'],
            ['label' => 'UMKM', 'value' => min(100, $totalUmkm * 20), 'tone' => 'gold'],
            ['label' => 'Berita', 'value' => min(100, $totalBerita * 20), 'tone' => 'coral'],
        ];

        return view('admin.dashboard', compact('setting', 'totalUmkm', 'umkmTayang', 'totalWisata', 'totalBerita', 'beritaTerbaru', 'potensiTerbaru', 'contentHealth', 'umkmApplicants', 'pendingApplicants', 'todayVisitors', 'totalVisitors', 'visitorChart', 'pendingOrders'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Complaint;
use App\Models\Letter;
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

        $letterStats = [
            'total' => Letter::count(),
            'baru' => Letter::where('status', Letter::STATUS_BARU)->count(),
            'diproses' => Letter::where('status', Letter::STATUS_DIPROSES)->count(),
            'siap' => Letter::where('status', Letter::STATUS_SIAP_DIAMBIL)->count(),
            'selesai' => Letter::where('status', Letter::STATUS_SELESAI)->count(),
        ];

        $complaintStats = [
            'total' => Complaint::count(),
            'baru' => Complaint::where('status', 'Baru')->count(),
            'diproses' => Complaint::where('status', 'Diproses')->count(),
            'selesai' => Complaint::where('status', 'Selesai')->count(),
        ];

        $contentHealth = [
            ['label' => 'Identitas & hero', 'value' => $setting->deskripsi_hero && $setting->hero_image ? 100 : ($setting->nama_desa ? 60 : 0), 'tone' => 'teal'],
            ['label' => 'Wisata', 'value' => min(100, $totalWisata * 33), 'tone' => 'violet'],
            ['label' => 'UMKM', 'value' => min(100, $totalUmkm * 20), 'tone' => 'gold'],
            ['label' => 'Berita', 'value' => min(100, $totalBerita * 20), 'tone' => 'coral'],
        ];

        return view('admin.dashboard', compact('setting', 'totalUmkm', 'umkmTayang', 'totalWisata', 'totalBerita', 'beritaTerbaru', 'potensiTerbaru', 'contentHealth', 'umkmApplicants', 'pendingApplicants', 'todayVisitors', 'totalVisitors', 'visitorChart', 'pendingOrders', 'letterStats', 'complaintStats'));
    }

    public function health()
    {
        $checks = [
            'app' => app()->environment(),
            'debug' => config('app.debug'),
            'database' => \Illuminate\Support\Facades\DB::connection()->getPdo() ? 'ok' : 'down',
            'storage' => is_dir(storage_path('app/public')) ? 'ok' : 'missing',
            'session' => config('session.driver'),
            'queue' => config('queue.default'),
        ];

        return response()->json([
            'status' => 'ok',
            'checks' => $checks,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}

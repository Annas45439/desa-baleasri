<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Potensi;
use App\Models\Setting;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Known static village letter services for instant matching.
     */
    protected array $layananSurat = [
        [
            'nama' => 'Surat Keterangan Usaha (SKU)',
            'kategori' => 'Layanan Surat',
            'deskripsi' => 'Pengajuan surat keterangan usaha untuk UMKM, legalitas usaha lokal, dan keperluan perbankan.',
            'url' => '/surat',
            'keywords' => ['sku', 'usaha', 'umkm', 'dagang', 'toko', 'warung', 'bank', 'kredit', 'kur'],
            'badge' => 'Surat Online'
        ],
        [
            'nama' => 'Surat Keterangan Domisili',
            'kategori' => 'Layanan Surat',
            'deskripsi' => 'Pengajuan surat keterangan tempat tinggal / domisili warga atau lembaga di Desa Baleasri.',
            'url' => '/surat',
            'keywords' => ['domisili', 'tempat tinggal', 'alamat', 'pindah', 'keterangan domisili'],
            'badge' => 'Surat Online'
        ],
        [
            'nama' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'kategori' => 'Layanan Surat',
            'deskripsi' => 'Pengajuan SKTM untuk Beasiswa sekolah, KIS/BPJS Kesehatan, keringanan berobat, dan Bantuan Sosial.',
            'url' => '/surat',
            'keywords' => ['sktm', 'tidak mampu', 'beasiswa', 'bpjs', 'kis', 'bantuan', 'bansos', 'sekolah'],
            'badge' => 'Surat Online'
        ],
        [
            'nama' => 'Surat Pengantar SKCK (Catatan Kepolisian)',
            'kategori' => 'Layanan Surat',
            'deskripsi' => 'Surat pengantar kelakuan baik dari desa untuk melengkapi berkas lamaran kerja / pendaftaran CPNS / TNI-Polri.',
            'url' => '/surat',
            'keywords' => ['skck', 'kepolisian', 'polsek', 'polres', 'kerja', 'lamaran', 'cpns', 'tni', 'polri'],
            'badge' => 'Surat Online'
        ],
        [
            'nama' => 'Surat Keterangan Kelahiran',
            'kategori' => 'Layanan Surat',
            'deskripsi' => 'Surat keterangan lahir anak untuk pembuatan Akta Kelahiran di Disdukcapil Magetan.',
            'url' => '/surat',
            'keywords' => ['lahir', 'kelahiran', 'bayi', 'akta', 'capil', 'disdukcapil'],
            'badge' => 'Surat Online'
        ],
        [
            'nama' => 'Surat Keterangan Kematian',
            'kategori' => 'Layanan Surat',
            'deskripsi' => 'Surat keterangan meninggal dunia untuk pengurusan Akta Kematian dan waris.',
            'url' => '/surat',
            'keywords' => ['kematian', 'meninggal', 'wafat', 'akta kematian', 'duka'],
            'badge' => 'Surat Online'
        ],
        [
            'nama' => 'Surat Pengantar Nikah (N1-N4)',
            'kategori' => 'Layanan Surat',
            'deskripsi' => 'Surat pengantar rekomendasi pernikahan untuk KUA Ngariboyo.',
            'url' => '/surat',
            'keywords' => ['nikah', 'kawin', 'kua', 'n1', 'n4', 'pernikahan', 'manten'],
            'badge' => 'Surat Online'
        ],
        [
            'nama' => 'Tracking & Cek Status Surat Warga',
            'kategori' => 'Layanan Surat',
            'deskripsi' => 'Lacak status berkas pengajuan surat online Anda menggunakan Kode Tracking / Nomor HP.',
            'url' => '/surat-tracking',
            'keywords' => ['tracking', 'lacak', 'cek surat', 'status', 'kode tracking', 'nomor hp'],
            'badge' => 'Lacak Online'
        ],
        [
            'nama' => 'Pengaduan & Aspirasi Warga',
            'kategori' => 'Pengaduan Publik',
            'deskripsi' => 'Layanan pengaduan online, aspirasi fasilitas publik, jalan rusak, atau bantuan warga.',
            'url' => '/pengaduan',
            'keywords' => ['aduan', 'pengaduan', 'lapor', 'aspirasi', 'jalan', 'lampu', 'rusak', 'bantuan'],
            'badge' => 'Laporan Online'
        ],
        [
            'nama' => 'Profil & Sejarah Desa Baleasri',
            'kategori' => 'Informasi Desa',
            'deskripsi' => 'Profil desa, daftar Kepala Desa dari masa ke masa, babad 3 wilayah asal, dan data Prodeskel Kemendagri 2025.',
            'url' => '/profil-desa',
            'keywords' => ['sejarah', 'profil', 'kades', 'juremi', 'kemendagri', 'demografi', 'babal', 'asal usul'],
            'badge' => 'Informasi'
        ],
        [
            'nama' => 'Transparansi APBDes & Keuangan Desa',
            'kategori' => 'Informasi Desa',
            'deskripsi' => 'Laporan transparansi pendapatan, belanja, dan pembiayaan anggaran Desa Baleasri.',
            'url' => '/apbdes',
            'keywords' => ['apbdes', 'anggaran', 'keuangan', 'pendapatan', 'belanja', 'transparansi', 'dana desa'],
            'badge' => 'Transparansi'
        ]
    ];

    /**
     * Display full search results page.
     */
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));
        $kategori = $request->input('kategori', 'semua');
        $setting = Setting::current();

        $suratResults = [];
        $beritaResults = collect();
        $potensiResults = collect();

        if (!empty($query)) {
            $qLower = mb_strtolower($query);

            // 1. Search in static surat & village services
            foreach ($this->layananSurat as $item) {
                $matched = false;
                if (str_contains(mb_strtolower($item['nama']), $qLower) || str_contains(mb_strtolower($item['deskripsi']), $qLower)) {
                    $matched = true;
                } else {
                    foreach ($item['keywords'] as $kw) {
                        if (str_contains($kw, $qLower) || str_contains($qLower, $kw)) {
                            $matched = true;
                            break;
                        }
                    }
                }
                if ($matched) {
                    $suratResults[] = $item;
                }
            }

            // 2. Search Berita
            $beritaResults = Berita::where('judul', 'LIKE', "%{$query}%")
                ->orWhere('ringkasan', 'LIKE', "%{$query}%")
                ->orWhere('isi', 'LIKE', "%{$query}%")
                ->latest()
                ->take(15)
                ->get();

            // 3. Search Potensi (Wisata & UMKM)
            $potensiResults = Potensi::where('nama', 'LIKE', "%{$query}%")
                ->orWhere('deskripsi', 'LIKE', "%{$query}%")
                ->orWhere('kategori', 'LIKE', "%{$query}%")
                ->latest()
                ->take(15)
                ->get();
        }

        $totalCount = count($suratResults) + $beritaResults->count() + $potensiResults->count();

        return view('public.search', compact('query', 'kategori', 'setting', 'suratResults', 'beritaResults', 'potensiResults', 'totalCount'));
    }

    /**
     * AJAX Instant Live Search for Hero Dropdown.
     */
    public function liveSearch(Request $request)
    {
        $query = trim($request->input('q', ''));

        if (mb_strlen($query) < 2) {
            return response()->json(['results' => [], 'total' => 0]);
        }

        $qLower = mb_strtolower($query);
        $results = [];

        // 1. Match Services / Surat
        foreach ($this->layananSurat as $item) {
            $matched = false;
            if (str_contains(mb_strtolower($item['nama']), $qLower) || str_contains(mb_strtolower($item['deskripsi']), $qLower)) {
                $matched = true;
            } else {
                foreach ($item['keywords'] as $kw) {
                    if (str_contains($kw, $qLower) || str_contains($qLower, $kw)) {
                        $matched = true;
                        break;
                    }
                }
            }
            if ($matched) {
                $results[] = [
                    'title' => $item['nama'],
                    'category' => $item['kategori'],
                    'snippet' => $item['deskripsi'],
                    'url' => $item['url'],
                    'type' => 'layanan',
                    'badge' => $item['badge']
                ];
                if (count($results) >= 4) break;
            }
        }

        // 2. Match Potensi (Wisata / UMKM)
        $potensi = Potensi::where('nama', 'LIKE', "%{$query}%")
            ->orWhere('deskripsi', 'LIKE', "%{$query}%")
            ->orWhere('kategori', 'LIKE', "%{$query}%")
            ->latest()
            ->take(4)
            ->get();

        foreach ($potensi as $p) {
            $targetUrl = $p->kategori === 'umkm' ? route('orders.create', $p) : route('wisata');
            $results[] = [
                'title' => $p->nama,
                'category' => strtoupper($p->kategori === 'umkm' ? 'Produk UMKM' : ($p->kategori === 'wisata' ? 'Wisata Desa' : 'Galeri')),
                'snippet' => \Illuminate\Support\Str::limit(strip_tags($p->deskripsi), 80),
                'url' => $targetUrl,
                'image' => storage_image_url($p->foto),
                'type' => 'potensi',
                'badge' => ucfirst($p->kategori)
            ];
        }

        // 3. Match Berita
        $berita = Berita::where('judul', 'LIKE', "%{$query}%")
            ->orWhere('ringkasan', 'LIKE', "%{$query}%")
            ->latest()
            ->take(4)
            ->get();

        foreach ($berita as $b) {
            $results[] = [
                'title' => $b->judul,
                'category' => 'Berita Desa',
                'snippet' => \Illuminate\Support\Str::limit(strip_tags($b->ringkasan ?: $b->isi), 80),
                'url' => route('berita.public') . '#berita-' . $b->id,
                'image' => storage_image_url($b->foto),
                'type' => 'berita',
                'badge' => 'Berita'
            ];
        }

        return response()->json([
            'results' => array_slice($results, 0, 8),
            'total' => count($results)
        ]);
    }
}

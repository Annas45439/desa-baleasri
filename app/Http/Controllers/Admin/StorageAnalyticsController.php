<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageAnalyticsController extends Controller
{
    public function index()
    {
        $storagePath = storage_path('app/public');

        $totalBytes = 0;
        $totalFiles = 0;
        $allFiles = [];
        $categories = [
            'berita' => ['name' => 'Berita & Agenda', 'bytes' => 0, 'files' => 0, 'color' => '#F59E0B', 'icon' => 'i-berita'],
            'potensi' => ['name' => 'UMKM & Potensi Desa', 'bytes' => 0, 'files' => 0, 'color' => '#10B981', 'icon' => 'i-umkm'],
            'wisata' => ['name' => 'Destinasi Wisata', 'bytes' => 0, 'files' => 0, 'color' => '#38BDF8', 'icon' => 'i-wisata'],
            'surat' => ['name' => 'Dokumen Layanan Surat', 'bytes' => 0, 'files' => 0, 'color' => '#818CF8', 'icon' => 'i-surat'],
            'complaints' => ['name' => 'Lampiran Pengaduan', 'bytes' => 0, 'files' => 0, 'color' => '#F43F5E', 'icon' => 'i-aduan'],
            'settings' => ['name' => 'Foto Hero & Identitas', 'bytes' => 0, 'files' => 0, 'color' => '#A78BFA', 'icon' => 'i-setting'],
            'lainnya' => ['name' => 'File Lainnya', 'bytes' => 0, 'files' => 0, 'color' => '#64748B', 'icon' => 'i-dash'],
        ];

        if (File::exists($storagePath)) {
            $files = File::allFiles($storagePath);

            foreach ($files as $file) {
                $size = $file->getSize();
                $totalBytes += $size;
                $totalFiles++;

                $relativePath = Str::replaceFirst($storagePath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $relativePathFixed = str_replace('\\', '/', $relativePath);
                $folder = explode('/', $relativePathFixed)[0] ?? 'lainnya';

                $catKey = array_key_exists($folder, $categories) ? $folder : 'lainnya';
                $categories[$catKey]['bytes'] += $size;
                $categories[$catKey]['files']++;

                $allFiles[] = [
                    'name' => $file->getFilename(),
                    'path' => 'storage/' . $relativePathFixed,
                    'category' => $categories[$catKey]['name'],
                    'size' => $size,
                    'formatted_size' => $this->formatBytes($size),
                    'mtime' => $file->getMTime(),
                ];
            }
        }

        // Sort files by size descending for top largest files
        usort($allFiles, fn($a, $b) => $b['size'] <=> $a['size']);
        $topFiles = array_slice($allFiles, 0, 10);

        // Compute percentages and format sizes for categories
        foreach ($categories as $key => $cat) {
            $categories[$key]['formatted_size'] = $this->formatBytes($cat['bytes']);
            $categories[$key]['percentage'] = $totalBytes > 0 ? round(($cat['bytes'] / $totalBytes) * 100, 1) : 0;
        }

        // Determine storage health status
        $health = 'safe';
        $healthMessage = 'Kapasitas penyimpanan hosting dalam kondisi prima dan sangat ringan.';
        
        if ($totalBytes > 2 * 1024 * 1024 * 1024) { // > 2 GB
            $health = 'critical';
            $healthMessage = 'Penyimpanan hosting cukup tinggi. Pertimbangkan kompresi gambar baru.';
        } elseif ($totalBytes > 500 * 1024 * 1024) { // > 500 MB
            $health = 'warning';
            $healthMessage = 'Penyimpanan terisi moderat. Pemantauan berkala disarankan.';
        }

        return view('admin.storage.index', [
            'totalBytes' => $totalBytes,
            'formattedTotal' => $this->formatBytes($totalBytes),
            'totalFiles' => $totalFiles,
            'categories' => $categories,
            'topFiles' => $topFiles,
            'health' => $health,
            'healthMessage' => $healthMessage,
        ]);
    }

    private function formatBytes($bytes, $precision = 2)
    {
        if ($bytes <= 0) return '0 B';
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = floor(log($bytes, 1024));
        $pow = min($pow, count($units) - 1);
        return round($bytes / (1024 ** $pow), $precision) . ' ' . $units[$pow];
    }
}

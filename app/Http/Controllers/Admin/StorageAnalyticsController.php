<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Complaint;
use App\Models\Letter;
use App\Models\Potensi;
use App\Models\Setting;
use Illuminate\Http\Request;
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

        $folderMap = [
            'hero' => 'settings',
            'kepala-desa' => 'settings',
            'pengaduan' => 'complaints',
            'berita' => 'berita',
            'potensi' => 'potensi',
            'wisata' => 'wisata',
            'surat' => 'surat',
        ];

        if (File::exists($storagePath)) {
            $files = File::allFiles($storagePath);

            foreach ($files as $file) {
                $size = $file->getSize();
                $totalBytes += $size;
                $totalFiles++;

                $relativePath = Str::replaceFirst($storagePath, '', $file->getPathname());
                $relativePathFixed = ltrim(str_replace('\\', '/', $relativePath), '/');
                $rawFolder = explode('/', $relativePathFixed)[0] ?? 'lainnya';

                $catKey = $folderMap[$rawFolder] ?? (array_key_exists($rawFolder, $categories) ? $rawFolder : 'lainnya');
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

        // Real Server Hosting Disk Space
        $diskFree = @disk_free_space(base_path());
        $diskTotal = @disk_total_space(base_path());
        $serverDiskUsed = ($diskTotal && $diskFree && $diskTotal > $diskFree) ? ($diskTotal - $diskFree) : 0;
        $serverDiskUsedPercentage = ($diskTotal > 0) ? round(($serverDiskUsed / $diskTotal) * 100, 1) : 0;

        // Determine storage health status
        $health = 'safe';
        $healthMessage = 'Kapasitas penyimpanan hosting dalam kondisi prima dan sangat ringan.';

        if ($totalBytes > 2 * 1024 * 1024 * 1024 || $serverDiskUsedPercentage > 85) { // > 2 GB or > 85% server disk
            $health = 'critical';
            $healthMessage = 'Penyimpanan hosting cukup tinggi. Pertimbangkan kompresi gambar baru.';
        } elseif ($totalBytes > 500 * 1024 * 1024 || $serverDiskUsedPercentage > 65) { // > 500 MB or > 65% server disk
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
            'serverDiskTotal' => $diskTotal ? $this->formatBytes($diskTotal) : 'N/A',
            'serverDiskFree' => $diskFree ? $this->formatBytes($diskFree) : 'N/A',
            'serverDiskUsed' => $serverDiskUsed ? $this->formatBytes($serverDiskUsed) : 'N/A',
            'serverDiskUsedPercentage' => $serverDiskUsedPercentage,
        ]);
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'path' => ['required', 'string', 'max:500'],
        ]);

        $path = ltrim(str_replace('\\', '/', $data['path']), '/');
        if (str_contains($path, '..') || str_starts_with($path, 'storage/')) {
            abort(422, 'Path file tidak valid.');
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($path)) {
            return back()->with('error', 'File tidak ditemukan atau sudah dihapus.');
        }

        $this->detachDatabaseReferences($path);
        $disk->delete($path);

        log_activity('DELETE_STORAGE_FILE', "Menghapus file penyimpanan: {$path}.");

        return back()->with('status', 'File berhasil dihapus dari penyimpanan.');
    }

    private function detachDatabaseReferences(string $path): void
    {
        Setting::query()->each(function (Setting $setting) use ($path): void {
            foreach (['hero_image', 'foto_kepala_desa'] as $field) {
                if ($setting->{$field} === $path) {
                    $setting->update([$field => null]);
                }
            }
        });

        Potensi::where('foto', $path)->update(['foto' => null]);
        Berita::where('foto', $path)->update(['foto' => null]);
        Letter::where(function ($query) use ($path): void {
            $query->where('surat_pdf', $path)->orWhere('dokumen_pendukung', $path);
        })->get()->each(function (Letter $letter) use ($path): void {
            $updates = [];
            if ($letter->surat_pdf === $path) $updates['surat_pdf'] = null;
            if ($letter->dokumen_pendukung === $path) $updates['dokumen_pendukung'] = null;
            if ($updates) $letter->update($updates);
        });

        Complaint::query()->each(function (Complaint $complaint) use ($path): void {
            $photos = array_values(array_filter(
                $complaint->photo_paths ?? [],
                fn (string $photoPath): bool => $photoPath !== $path
            ));
            if ($photos !== ($complaint->photo_paths ?? [])) {
                $complaint->update(['photo_paths' => $photos ?: null]);
            }
        });
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

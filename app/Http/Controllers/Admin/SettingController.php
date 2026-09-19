<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::current();
        $updates = [];

        foreach (['hero_image', 'foto_kepala_desa'] as $field) {
            if ($setting->{$field} && !Storage::disk('public')->exists($setting->{$field})) {
                $updates[$field] = null;
            }
        }

        if ($updates) {
            $setting->update($updates);
        }

        return view('admin.settings.edit', ['setting' => $setting->fresh()]);
    }

    public function deleteMedia(string $field)
    {
        $directories = ['hero_image' => 'hero', 'foto_kepala_desa' => 'kepala-desa'];
        abort_unless(array_key_exists($field, $directories), 404);

        $setting = Setting::current();
        $path = $setting->{$field};

        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $setting->update([$field => null]);
        log_activity('DELETE_SETTING_MEDIA', "Menghapus media pengaturan: {$field}.");

        return back()->with('status', 'Foto berhasil dihapus dan dikembalikan ke avatar default.');
    }

    public function update(Request $request)
    {
        $setting = Setting::current();
        $data = $request->validate([
            'nama_desa' => ['required', 'string', 'max:150'], 'tagline' => ['nullable', 'string', 'max:200'],
            'deskripsi_hero' => ['nullable', 'string'], 'hero_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,avif', 'max:10240'],
            'hero_video' => ['nullable', 'string', 'max:255'],
            'nama_kepala_desa' => ['nullable', 'string', 'max:150'], 'sambutan' => ['nullable', 'string'],
            'foto_kepala_desa' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,avif', 'max:10240'], 'stat_pendidikan' => ['nullable', 'integer', 'min:0'],
            'stat_umkm' => ['nullable', 'integer', 'min:0'], 'stat_wisata' => ['nullable', 'integer', 'min:0'],
            'stat_embung' => ['nullable', 'integer', 'min:0'], 'alamat' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:150'], 'jam_operasional' => ['nullable', 'string', 'max:100'],
            'whatsapp_admin' => ['nullable', 'string', 'max:20'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'maps_embed' => ['nullable', 'string'],
            'sop_pengajuan' => ['nullable', 'string'],
            'estimasi_proses' => ['nullable', 'string', 'max:100'],
            'kontak_darurat' => ['nullable', 'string', 'max:255'],
        ]);
        foreach (['hero_image' => 'hero', 'foto_kepala_desa' => 'kepala-desa'] as $field => $directory) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $oldPath = $setting->{$field};
                $newPath = ImageOptimizer::compressAndStore($request->file($field), $directory);
                $data[$field] = $newPath;

                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            } else {
                unset($data[$field]);
            }
        }


        if (!empty($data['whatsapp_admin'])) {
            $data['whatsapp_admin'] = preg_replace('/[^0-9]/', '', $data['whatsapp_admin']);
            if (str_starts_with($data['whatsapp_admin'], '0')) {
                $data['whatsapp_admin'] = '62' . substr($data['whatsapp_admin'], 1);
            }
        }

        $setting->update($data);
        log_activity('UPDATE_SETTING', "Memperbarui Pengaturan Umum, Media Sosmed, SOP, dan Kontak Darurat Desa.");
        return back()->with('status', 'Pengaturan berhasil disimpan.');
    }

}

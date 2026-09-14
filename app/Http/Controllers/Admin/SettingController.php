<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit() { return view('admin.settings.edit', ['setting' => Setting::current()]); }

    public function update(Request $request)
    {
        $setting = Setting::current();
        $data = $request->validate([
            'nama_desa' => ['required', 'string', 'max:150'], 'tagline' => ['nullable', 'string', 'max:200'],
            'deskripsi_hero' => ['nullable', 'string'], 'hero_image' => ['nullable', 'image', 'max:5120'],
            'nama_kepala_desa' => ['nullable', 'string', 'max:150'], 'sambutan' => ['nullable', 'string'],
            'foto_kepala_desa' => ['nullable', 'image', 'max:4096'], 'stat_pendidikan' => ['nullable', 'integer', 'min:0'],
            'stat_umkm' => ['nullable', 'integer', 'min:0'], 'stat_wisata' => ['nullable', 'integer', 'min:0'],
            'stat_embung' => ['nullable', 'integer', 'min:0'], 'alamat' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:150'], 'jam_operasional' => ['nullable', 'string', 'max:100'],
            'whatsapp_admin' => ['nullable', 'string', 'max:20'],
        ]);
        foreach (['hero_image' => 'hero', 'foto_kepala_desa' => 'kepala-desa'] as $field => $directory) {
            if ($request->hasFile($field)) {
                if ($setting->{$field}) Storage::disk('public')->delete($setting->{$field});
                $data[$field] = $request->file($field)->store($directory, 'public');
            }
        }

        if (!empty($data['whatsapp_admin'])) {
            $data['whatsapp_admin'] = preg_replace('/[^0-9]/', '', $data['whatsapp_admin']);
            if (str_starts_with($data['whatsapp_admin'], '0')) {
                $data['whatsapp_admin'] = '62' . substr($data['whatsapp_admin'], 1);
            }
        }

        $setting->update($data);
        return back()->with('status', 'Pengaturan berhasil disimpan.');
    }

}

<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Potensi;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DefaultDataSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(['id' => 1], ['nama_desa' => 'Desa Baleasri', 'tagline' => 'Rumah yang Asri, untuk Warga Baleasri', 'deskripsi_hero' => 'Website resmi Desa Baleasri.', 'nama_kepala_desa' => 'Kepala Desa Baleasri', 'sambutan' => 'Selamat datang di website resmi Desa Baleasri.', 'stat_pendidikan' => 6, 'stat_umkm' => 5, 'stat_wisata' => 3, 'stat_embung' => 1, 'alamat' => 'Jl. Raya Baleasri, Magetan', 'email' => 'desabaleasri@yahoo.com', 'jam_operasional' => 'Senin-Jumat, 08.00-16.00', 'whatsapp_admin' => '6281234567890']);

        foreach ([['Embung Duwetsewu', 'Wisata Air'], ['Sentra Batik Gedhek', 'Wisata Budaya'], ['Hamparan Sawah', 'Wisata Agraris']] as $index => [$nama, $tag]) {
            Potensi::updateOrCreate(['nama' => $nama, 'kategori' => 'wisata'], ['tag' => $tag, 'tampil' => true, 'urutan' => $index]);
        }
        foreach ([['Kain Batik Gedhek', 'Batik', 'Kain batik dengan motif khas Baleasri.'], ['Sandal Kain Perca', 'Kerajinan', 'Sandal kain perca buatan tangan warga.'], ['Dompet Kulit Asli', 'Kerajinan Kulit', 'Dompet kulit asli dengan jahitan rapi dan awet.'], ['Tas Kulit Baleasri', 'Kerajinan Kulit', 'Tas kulit lokal untuk aktivitas harian.'], ['Sabuk Kulit Baleasri', 'Kerajinan Kulit', 'Sabuk kulit dengan desain sederhana dan kuat.'], ['Tas Anyaman Jali', 'Anyaman', 'Tas anyaman jali ramah lingkungan.'], ['Keripik Buah Lokal', 'Olahan', 'Camilan buah lokal renyah khas desa.']] as $index => [$nama, $tag, $deskripsi]) {
            Potensi::updateOrCreate(['nama' => $nama, 'kategori' => 'umkm'], ['tag' => $tag, 'deskripsi' => $deskripsi, 'tampil' => true, 'urutan' => $index]);
        }
        Berita::updateOrCreate(['judul' => 'Selamat Datang di Website Baru Desa Baleasri'], ['ringkasan' => 'Website resmi Desa Baleasri kini hadir.', 'isi' => 'Pemerintah Desa Baleasri meluncurkan website resmi.', 'penulis' => 'Admin Desa', 'tampil' => true]);
    }
}

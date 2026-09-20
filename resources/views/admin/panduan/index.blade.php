@extends('layouts.admin')

@section('title', 'Panduan Admin')
@section('page-title', 'Panduan Admin')
@section('page-subtitle', 'Buku petunjuk sederhana untuk mengelola website Desa Baleasri.')

@section('content')
<div style="display:grid; gap:22px;">
  <div style="background:linear-gradient(135deg, rgba(16,185,129,0.10), rgba(255,255,255,0.70)); border:1px solid var(--line); border-radius:22px; padding:24px 26px; box-shadow:var(--shadow-md);">
    <div style="font-size:0.72rem; color:var(--emerald-deep); font-weight:800; text-transform:uppercase; letter-spacing:0.12em; margin-bottom:10px;">Panduan Singkat</div>
    <h2 style="font-size:2rem; margin:0 0 10px; color:var(--ink);">Cara kerja panel admin tanpa bingung</h2>
    <p style="margin:0; color:var(--ink-3); line-height:1.75; max-width:900px;">
      Panel admin ini dibuat untuk memudahkan Anda mengelola konten desa tanpa harus paham coding. Jika Anda belum familiar dengan komputer, cukup ikuti langkah-langkah berikut. Semua fitur utama sudah dibuat dengan urutan yang sederhana.
    </p>
  </div>

  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:18px;">
    <div class="glass-card" style="padding:18px; border:1px solid var(--line); border-radius:18px; background:rgba(255,255,255,0.72);">
      <div style="font-size:0.72rem; font-weight:800; color:var(--emerald); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">1. Login</div>
      <p style="margin:0; color:var(--ink-3); line-height:1.7;">
        Masuk ke halaman admin dengan username dan password yang sudah diberikan. Setelah login, Anda akan masuk ke dashboard utama.
      </p>
    </div>

    <div class="glass-card" style="padding:18px; border:1px solid var(--line); border-radius:18px; background:rgba(255,255,255,0.72);">
      <div style="font-size:0.72rem; font-weight:800; color:var(--amber); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">2. Dashboard</div>
      <p style="margin:0; color:var(--ink-3); line-height:1.7;">
        Pada halaman dashboard terlihat ringkasan cepat: jumlah berita, wisata, UMKM, pengaduan, dan aktivitas terbaru. Bagian ini untuk melihat kondisi website secara umum.
      </p>
    </div>

    <div class="glass-card" style="padding:18px; border:1px solid var(--line); border-radius:18px; background:rgba(255,255,255,0.72);">
      <div style="font-size:0.72rem; font-weight:800; color:var(--rose); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">3. Menu Utama</div>
      <p style="margin:0; color:var(--ink-3); line-height:1.7;">
        Di sisi kiri ada menu utama. Gunakan menu itu untuk membuka halaman Profil Desa, Wisata, Galeri, Berita, UMKM, Surat, Pengaduan, dan Pengaturan.
      </p>
    </div>
  </div>

  <div style="background:var(--surface-1); border:1px solid var(--line); border-radius:22px; padding:20px 22px;">
    <div style="font-size:0.72rem; font-weight:800; color:var(--ink-4); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:12px;">Panduan per menu</div>

    <div style="display:grid; gap:18px;">
      <div style="padding:18px 18px 14px; border:1px solid var(--line); border-radius:16px; background:rgba(255,255,255,0.60);">
        <h3 style="margin:0 0 10px; font-size:1.15rem; color:var(--ink);">A. Kelola Profil &amp; Sejarah</h3>
        <ul style="margin:0; padding-left:20px; color:var(--ink-3); line-height:1.9;">
          <li>Buka menu <strong>Profil &amp; Sejarah</strong>.</li>
          <li>Ubah nama desa, deskripsi, sambutan, serta foto kepala desa.</li>
          <li>Pastikan data yang ditulis singkat, jelas, dan tidak bertele-tele.</li>
        </ul>
      </div>

      <div style="padding:18px 18px 14px; border:1px solid var(--line); border-radius:16px; background:rgba(255,255,255,0.60);">
        <h3 style="margin:0 0 10px; font-size:1.15rem; color:var(--ink);">B. Kelola Berita &amp; Agenda</h3>
        <ul style="margin:0; padding-left:20px; color:var(--ink-3); line-height:1.9;">
          <li>Klik menu <strong>Berita &amp; Agenda</strong>.</li>
          <li>Klik tombol <strong>Tambah Baru</strong>.</li>
          <li>Isi judul, isi berita, tanggal, foto, lalu simpan.</li>
          <li>Gunakan berita yang terbaru dan relevan agar website selalu aktif.</li>
        </ul>
      </div>

      <div style="padding:18px 18px 14px; border:1px solid var(--line); border-radius:16px; background:rgba(255,255,255,0.60);">
        <h3 style="margin:0 0 10px; font-size:1.15rem; color:var(--ink);">C. Kelola Wisata &amp; Galeri</h3>
        <ul style="margin:0; padding-left:20px; color:var(--ink-3); line-height:1.9;">
          <li>Untuk wisata, buka menu <strong>Wisata</strong>.</li>
          <li>Untuk foto kegiatan desa, buka menu <strong>Galeri</strong>.</li>
          <li>Upload foto yang jelas, lalu isi nama dan deskripsi singkat.</li>
          <li>Pastikan gambar tidak terlalu besar agar website tetap ringan.</li>
        </ul>
      </div>

      <div style="padding:18px 18px 14px; border:1px solid var(--line); border-radius:16px; background:rgba(255,255,255,0.60);">
        <h3 style="margin:0 0 10px; font-size:1.15rem; color:var(--ink);">D. Kelola UMKM</h3>
        <ul style="margin:0; padding-left:20px; color:var(--ink-3); line-height:1.9;">
          <li>Buka menu <strong>Produk UMKM</strong>.</li>
          <li>Tambahkan produk atau usaha yang ingin dipromosikan.</li>
          <li>Isi foto, nama produk, kategori, dan deskripsi singkat.</li>
          <li>Jika ada pendaftar UMKM baru, cek menu <strong>Pendaftar UMKM</strong>.</li>
        </ul>
      </div>

      <div style="padding:18px 18px 14px; border:1px solid var(--line); border-radius:16px; background:rgba(255,255,255,0.60);">
        <h3 style="margin:0 0 10px; font-size:1.15rem; color:var(--ink);">E. Kelola Surat &amp; Pengaduan</h3>
        <ul style="margin:0; padding-left:20px; color:var(--ink-3); line-height:1.9;">
          <li>Untuk layanan surat, buka menu <strong>Layanan Surat</strong>.</li>
          <li>Cek status pengajuan setiap hari, lalu ubah status sesuai proses.</li>
          <li>Untuk pengaduan, buka menu <strong>Pengaduan</strong>. Lihat yang baru, lalu tindak lanjuti.</li>
          <li>Biasanya pengaduan harus diproses secepat mungkin agar masyarakat merasa dilayani.</li>
        </ul>
      </div>

      <div style="padding:18px 18px 14px; border:1px solid var(--line); border-radius:16px; background:rgba(255,255,255,0.60);">
        <h3 style="margin:0 0 10px; font-size:1.15rem; color:var(--ink);">F. Pengaturan Website</h3>
        <ul style="margin:0; padding-left:20px; color:var(--ink-3); line-height:1.9;">
          <li>Buka menu <strong>Pengaturan</strong>.</li>
          <li>Isi data desa seperti nama desa, alamat, kontak, jam operasional, dan media sosial.</li>
          <li>Perbarui foto hero agar halaman depan tetap fresh dan profesional.</li>
        </ul>
      </div>
    </div>
  </div>

  <div style="background:linear-gradient(135deg, rgba(245,158,11,0.10), rgba(255,255,255,0.75)); border:1px solid var(--line); border-radius:20px; padding:20px 22px;">
    <div style="font-size:0.72rem; font-weight:800; color:var(--amber); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:10px;">Tips penting</div>
    <ul style="margin:0; padding-left:20px; color:var(--ink-3); line-height:1.9;">
      <li>Jangan terlalu banyak mengupload foto yang besar. Foto yang terlalu besar bisa membuat situs lambat.</li>
      <li>Update data desa minimal 1 kali dalam seminggu agar informasi tetap relevan.</li>
      <li>Periksa pengaduan dan surat setiap hari, terutama di pagi hari.</li>
      <li>Jika ragu, jangan takut untuk mengecek menu <strong>Dashboard</strong> dulu untuk melihat apa yang perlu diperbarui.</li>
    </ul>
  </div>

  <div style="background:var(--surface-1); border:1px solid var(--line); border-radius:20px; padding:20px 22px;">
    <div style="font-size:0.72rem; font-weight:800; color:var(--ink-4); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:10px;">Cara mengakhiri pekerjaan</div>
    <p style="margin:0; color:var(--ink-3); line-height:1.8;">
      Setelah selesai memasukkan data, pastikan Anda mengecek hasilnya di halaman depan website. Jika sudah sesuai, cukup klik <strong>Keluar</strong> di bagian bawah menu. Jangan khawatir, semua perubahan sudah otomatis tersimpan ke sistem.
    </p>
  </div>
</div>
@endsection

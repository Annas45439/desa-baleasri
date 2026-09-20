@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Situs')
@section('page-subtitle', 'Atur hero beranda, sambutan kepala desa, statistik, dan kontak.')

@section('content')

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
  @csrf

  <div class="form-card" id="profil" style="margin-bottom:22px;">
    <h3 style="font-family:var(--font-display); margin-bottom:16px;">Identitas & Hero Beranda</h3>

    <div class="form-row">
      <label for="nama_desa">Nama Desa</label>
      <input type="text" id="nama_desa" name="nama_desa" value="{{ old('nama_desa', $setting->nama_desa) }}" required>
    </div>

    <div class="form-row">
      <label for="tagline">Tagline (judul besar di hero)</label>
      <input type="text" id="tagline" name="tagline" value="{{ old('tagline', $setting->tagline) }}">
    </div>

    <div class="form-row">
      <label for="deskripsi_hero">Deskripsi hero</label>
      <textarea id="deskripsi_hero" name="deskripsi_hero">{{ old('deskripsi_hero', $setting->deskripsi_hero) }}</textarea>
    </div>

    <div class="form-row">
      <label for="hero_image">Foto Hero Beranda</label>
      @if($setting->hero_image)
        <div class="current-media">
          <img src="{{ storage_image_url($setting->hero_image) }}" alt="Preview Hero" onerror="this.onerror=null; this.src='{{ asset('assets/logo/cover-placeholder.svg') }}';">
          <button type="submit" class="btn-sm btn-delete"
                  formaction="{{ route('admin.settings.media.destroy', 'hero_image') }}"
                  formmethod="post"
                  onclick="return confirm('Hapus foto hero?');">Hapus Foto</button>
        </div>
      @endif
      <input type="file" id="hero_image" name="hero_image" accept="image/*">
      <p class="hint">Format JPG, PNG, WebP, GIF, atau AVIF. HEIC belum didukung browser. Maksimal 10MB.</p>
    </div>

    <div class="form-row">
      <label for="hero_video">Link Video Background Hero (opsional)</label>
      <input type="text" id="hero_video" name="hero_video" value="{{ old('hero_video', $setting->hero_video) }}" placeholder="https://www.youtube.com/watch?v=nbk-af31BXs atau https://youtu.be/nbk-af31BXs">
      <p class="hint">Gunakan link YouTube atau Google Drive jika tidak ingin menyimpan video di hosting.</p>
    </div>

    <div class="form-row">
      <label for="hero_video_file">Upload Video Hero</label>
      @if($setting->hero_video && \Illuminate\Support\Facades\Storage::disk('public')->exists($setting->hero_video))
        <div class="current-media">
          <video src="{{ asset('storage/' . $setting->hero_video) }}" style="width:220px; height:120px; object-fit:cover; border-radius:10px;" muted playsinline controls></video>
          <button type="submit" class="btn-sm btn-delete"
                  formaction="{{ route('admin.settings.media.destroy', 'hero_video') }}"
                  formmethod="post"
                  onclick="return confirm('Hapus video hero?');">Hapus Video</button>
        </div>
      @endif
      <input type="file" id="hero_video_file" name="hero_video_file" accept="video/mp4,video/webm,video/quicktime">
      <p class="hint">Format MP4, WebM, atau MOV. Maksimal 10MB. Video baru akan menggantikan video lokal sebelumnya agar storage tetap hemat.</p>
    </div>
  </div>

  <div class="form-card" id="administrasi" style="margin-bottom:22px;">
     <h3 style="font-family:var(--font-display); margin-bottom:16px;">Sambutan Kepala Desa</h3>

    <div class="form-row">
      <label for="nama_kepala_desa">Nama Kepala Desa</label>
      <input type="text" id="nama_kepala_desa" name="nama_kepala_desa" value="{{ old('nama_kepala_desa', $setting->nama_kepala_desa) }}">
    </div>

    <div class="form-row">
      <label for="sambutan">Isi Sambutan</label>
      <textarea id="sambutan" name="sambutan" style="min-height:140px;">{{ old('sambutan', $setting->sambutan) }}</textarea>
    </div>

    <div class="form-grid-2">
      <div class="form-row">
        <label for="nama_sekretaris_desa">Nama Sekretaris Desa</label>
        <input type="text" id="nama_sekretaris_desa" name="nama_sekretaris_desa" value="{{ old('nama_sekretaris_desa', $setting->nama_sekretaris_desa ?? 'Tri Anjono') }}" placeholder="Contoh: Tri Anjono">
      </div>
      <div class="form-row">
        <label for="jabatan_sekretaris_desa">Jabatan</label>
        <input type="text" id="jabatan_sekretaris_desa" name="jabatan_sekretaris_desa" value="{{ old('jabatan_sekretaris_desa', $setting->jabatan_sekretaris_desa ?? 'Sekretaris Desa') }}" placeholder="Contoh: Sekretaris Desa">
      </div>
    </div>
    <div class="form-row">
      <label for="lokasi_sekretaris_desa">Lokasi / Instansi</label>
      <input type="text" id="lokasi_sekretaris_desa" name="lokasi_sekretaris_desa" value="{{ old('lokasi_sekretaris_desa', $setting->lokasi_sekretaris_desa ?? 'Kecamatan Ngariboyo, Kabupaten Magetan') }}" placeholder="Contoh: Kecamatan Ngariboyo, Kabupaten Magetan">
    </div>

    <div class="form-row">
      <label for="foto_kepala_desa">Foto Kepala Desa</label>
      @if($setting->foto_kepala_desa)
        <div class="current-media">
          <img src="{{ storage_image_url($setting->foto_kepala_desa) }}" alt="Preview Kades" onerror="this.onerror=null; this.src='{{ asset('assets/logo/kades-placeholder.svg') }}';">
          <button type="submit" class="btn-sm btn-delete"
                  formaction="{{ route('admin.settings.media.destroy', 'foto_kepala_desa') }}"
                  formmethod="post"
                  onclick="return confirm('Hapus foto kepala desa?');">Hapus Foto</button>
        </div>
      @endif
      <input type="file" id="foto_kepala_desa" name="foto_kepala_desa" accept="image/*">
      <p class="hint">Gunakan JPG, PNG, WebP, GIF, atau AVIF agar foto tampil di semua browser. Maksimal 10MB.</p>
    </div>
  </div>

  <div class="form-card" id="apbdes" style="margin-bottom:22px;">
     <h3 style="font-family:var(--font-display); margin-bottom:16px;">Statistik Beranda</h3>
    <div class="form-grid-2">
      <div class="form-row">
        <label for="stat_pendidikan">Sarana Pendidikan</label>
        <input type="number" id="stat_pendidikan" name="stat_pendidikan" value="{{ old('stat_pendidikan', $setting->stat_pendidikan) }}" min="0">
      </div>
      <div class="form-row">
        <label for="stat_umkm">UMKM Unggulan</label>
        <input type="number" id="stat_umkm" name="stat_umkm" value="{{ old('stat_umkm', $setting->stat_umkm) }}" min="0">
      </div>
      <div class="form-row">
        <label for="stat_wisata">Destinasi Wisata</label>
        <input type="number" id="stat_wisata" name="stat_wisata" value="{{ old('stat_wisata', $setting->stat_wisata) }}" min="0">
      </div>
      <div class="form-row">
        <label for="stat_embung">Embung Ikonik</label>
        <input type="number" id="stat_embung" name="stat_embung" value="{{ old('stat_embung', $setting->stat_embung) }}" min="0">
      </div>
    </div>
  </div>

  <div class="form-card" style="margin-bottom:22px;">
    <h3 style="font-family:var(--font-display); margin-bottom:16px;">Kontak & Alamat</h3>
    <div class="form-row">
      <label for="alamat">Alamat</label>
      <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $setting->alamat) }}">
    </div>
    <div class="form-grid-2">
      <div class="form-row">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $setting->email) }}">
      </div>
      <div class="form-row">
        <label for="whatsapp_admin">Nomor WhatsApp Admin</label>
        <input type="text" id="whatsapp_admin" name="whatsapp_admin" value="{{ old('whatsapp_admin', $setting->whatsapp_admin) }}" placeholder="0812xxxxxxx atau 62812xxxxxxx">
        <p class="hint">Nomor ini digunakan untuk menerima pengaduan warga, pengajuan surat, dan pesan layanan lainnya.</p>
      </div>
    </div>
    <div class="form-row">
      <label for="kontak_darurat">Kontak Darurat / Call Center Desa</label>
      <input type="text" id="kontak_darurat" name="kontak_darurat" value="{{ old('kontak_darurat', $setting->kontak_darurat) }}" placeholder="Contoh: Tanggap Darurat Desa: 0812-3456-7890 atau Call Center 112">
      <p class="hint">Teks/Nomor kontak ini ditampilkan pada footer website dan box Layanan Darurat Desa.</p>
    </div>
  </div>

  <div class="form-card" style="margin-bottom:22px;">
    <h3 style="font-family:var(--font-display); margin-bottom:4px;">Sosial Media & Maps</h3>
    <p style="font-size:0.82rem; color:var(--ink-muted); margin-bottom:18px;">Link ini ditampilkan di footer website publik. Kosongkan jika tidak digunakan.</p>

    <div class="form-grid-2">
      <div class="form-row">
        <label for="instagram">Instagram</label>
        <input type="url" id="instagram" name="instagram"
               value="{{ old('instagram', $setting->instagram) }}"
               placeholder="https://instagram.com/desabaleasri">
      </div>
      <div class="form-row">
        <label for="facebook">Facebook</label>
        <input type="url" id="facebook" name="facebook"
               value="{{ old('facebook', $setting->facebook) }}"
               placeholder="https://facebook.com/desabaleasri">
      </div>
      <div class="form-row">
        <label for="youtube">YouTube</label>
        <input type="url" id="youtube" name="youtube"
               value="{{ old('youtube', $setting->youtube) }}"
               placeholder="https://youtube.com/@desabaleasri">
      </div>
    </div>

    <div class="form-row" style="margin-top:4px;">
      <label for="maps_embed">URL Embed Google Maps</label>
      <input type="url" id="maps_embed" name="maps_embed"
             value="{{ old('maps_embed', $setting->maps_embed) }}"
             placeholder="https://www.google.com/maps?q=Desa+Baleasri&output=embed">
      <p class="hint">Buka Google Maps → cari lokasi → klik Bagikan → Sematkan peta → salin URL dari <code>src="..."</code> di dalam iframe.</p>
    </div>
  </div>

  <div class="form-card" style="margin-bottom:22px;">
    <h3 style="font-family:var(--font-display); margin-bottom:4px;">SOP & Informasi Layanan</h3>
    <p style="font-size:0.82rem; color:var(--ink-muted); margin-bottom:18px;">Ditampilkan di halaman beranda (section SOP), halaman pengajuan surat, dan halaman pengaduan.</p>

    <div class="form-grid-2">
      <div class="form-row">
        <label for="estimasi_proses">Estimasi Waktu Proses Surat</label>
        <input type="text" id="estimasi_proses" name="estimasi_proses"
               value="{{ old('estimasi_proses', $setting->estimasi_proses) }}"
               placeholder="1-2 hari kerja">
        <p class="hint">Contoh: <em>1-2 hari kerja</em> atau <em>3-5 hari kerja</em>. Ditampilkan di info pengajuan surat.</p>
      </div>
      <div class="form-row">
        <label for="jam_operasional">Jam Operasional Kantor</label>
        <input type="text" id="jam_operasional" name="jam_operasional"
               value="{{ old('jam_operasional', $setting->jam_operasional) }}"
               placeholder="Senin - Jumat, 08.00 - 16.00 WIB">
      </div>
    </div>

    <div class="form-row">
      <label for="sop_pengajuan">Teks SOP Pengajuan Layanan</label>
      <textarea id="sop_pengajuan" name="sop_pengajuan" style="min-height:120px;"
                placeholder="Isi prosedur layanan yang ditampilkan di halaman beranda, misalnya: Isi formulir → Tunggu verifikasi → Download surat...">{{ old('sop_pengajuan', $setting->sop_pengajuan) }}</textarea>
      <p class="hint">Teks ini menggantikan deskripsi SOP yang sebelumnya statis. Bisa berupa poin-poin alur layanan.</p>
    </div>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Simpan Semua Pengaturan</button>
  </div>
</form>

@endsection

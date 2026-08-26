@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Situs')
@section('page-subtitle', 'Atur hero beranda, sambutan kepala desa, statistik, dan kontak.')

@section('content')

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

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
      <label for="hero_video">Video Hero (diprioritaskan tampil di Beranda)</label>
      @if($setting->hero_video)
        <div class="current-media">
          <video src="{{ asset('storage/'.$setting->hero_video) }}" style="width:120px; height:70px; object-fit:cover; border-radius:10px;" muted></video>
          <span class="hint">Video hero aktif saat ini.</span>
        </div>
        <button type="button" onclick="document.getElementById('hapus-video-form').submit();" class="btn-sm btn-delete" style="margin-bottom:10px;">Hapus Video Hero</button>
      @endif
      <input type="file" id="hero_video" name="hero_video" accept="video/mp4,video/webm,video/quicktime">
      <p class="hint">Format MP4/WebM/MOV, maksimal 50MB. Kalau video kosong, Beranda otomatis pakai Foto Hero di bawah.</p>
    </div>

    <div class="form-row">
      <label for="hero_image">Foto Hero (fallback / dipakai kalau video kosong)</label>
      @if($setting->hero_image)
        <div class="current-media">
          <img src="{{ asset('storage/'.$setting->hero_image) }}" alt="">
        </div>
      @endif
      <input type="file" id="hero_image" name="hero_image" accept="image/*">
      <p class="hint">Format JPG/PNG, maksimal 5MB.</p>
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

    <div class="form-row">
      <label for="foto_kepala_desa">Foto Kepala Desa</label>
      @if($setting->foto_kepala_desa)
        <div class="current-media">
          <img src="{{ asset('storage/'.$setting->foto_kepala_desa) }}" alt="">
        </div>
      @endif
      <input type="file" id="foto_kepala_desa" name="foto_kepala_desa" accept="image/*">
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
        <label for="jam_operasional">Jam Operasional</label>
        <input type="text" id="jam_operasional" name="jam_operasional" value="{{ old('jam_operasional', $setting->jam_operasional) }}">
      </div>
    </div>
    <div class="form-row">
      <label for="whatsapp_admin">Nomor WhatsApp Admin (default untuk tombol Pesan UMKM)</label>
      <input type="text" id="whatsapp_admin" name="whatsapp_admin" value="{{ old('whatsapp_admin', $setting->whatsapp_admin) }}" placeholder="62812xxxxxxx">
    </div>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Simpan Semua Pengaturan</button>
  </div>
</form>

@if($setting->hero_video)
<form id="hapus-video-form" method="POST" action="{{ route('admin.settings.hero-video.destroy') }}" style="display:none;">
  @csrf
  @method('DELETE')
</form>
@endif

@endsection

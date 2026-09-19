@extends('layouts.admin')

@section('title', $potensi->exists ? 'Edit Potensi' : 'Tambah Potensi')
@section('page-title', $potensi->exists ? 'Edit Potensi Desa' : 'Tambah Potensi Desa')
@section('page-subtitle', 'Data ini akan tampil di halaman Wisata / UMKM / Galeri.')

@section('content')

<div class="form-card">
  <form method="POST"
        action="{{ $potensi->exists ? route('admin.potensi.update', $potensi) : route('admin.potensi.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if($potensi->exists) @method('PUT') @endif

    <div class="form-grid-2">
      <div class="form-row">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $potensi->nama) }}" required>
      </div>
      <div class="form-row">
        <label for="kategori">Kategori</label>
        <select id="kategori" name="kategori" required>
          @foreach(['wisata' => 'Wisata', 'umkm' => 'UMKM', 'galeri' => 'Galeri'] as $val => $label)
            <option value="{{ $val }}" {{ old('kategori', $potensi->kategori ?: request('kategori')) === $val ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-row">
      <label for="tag">Tag / Label singkat</label>
      <input type="text" id="tag" name="tag" value="{{ old('tag', $potensi->tag) }}" placeholder="Contoh: Wisata Air, Batik, Kerajinan">
    </div>

    <div class="form-row">
      <label for="deskripsi">Deskripsi</label>
      <textarea id="deskripsi" name="deskripsi" placeholder="Opsional">{{ old('deskripsi', $potensi->deskripsi) }}</textarea>
    </div>

    @if($potensi->kategori === 'umkm' || old('kategori') === 'umkm')
    <div class="form-row">
      <label for="kontak_whatsapp">Nomor WhatsApp Penjual (opsional)</label>
      <input type="text" id="kontak_whatsapp" name="kontak_whatsapp" value="{{ old('kontak_whatsapp', $potensi->kontak_whatsapp) }}" placeholder="62812xxxxxxx">
      <p class="hint">Kosongkan untuk pakai nomor WhatsApp admin default (diatur di menu Pengaturan).</p>
    </div>
    @endif

    <div class="form-row">
      <label for="foto">Foto</label>
      @if($potensi->foto)
        <div class="current-media">
          <img src="{{ storage_image_url($potensi->foto) }}" alt="Preview Foto">
          <span class="hint">Foto saat ini. Unggah baru untuk mengganti.</span>
        </div>
      @endif
      <input type="file" id="foto" name="foto" accept="image/*">
      <p class="hint">Format JPG/PNG, maksimal 4MB.</p>
    </div>

    <div class="form-row">
      <label for="urutan">Urutan Tampil</label>
      <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $potensi->urutan ?? 0) }}" min="0" style="max-width:140px;">
      <p class="hint">Angka lebih kecil tampil lebih dulu.</p>
    </div>

    <div class="form-row">
      <label class="toggle-row">
        <input type="checkbox" name="tampil" value="1" {{ old('tampil', $potensi->exists ? $potensi->tampil : true) ? 'checked' : '' }}>
        Tayangkan di halaman publik
      </label>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">{{ $potensi->exists ? 'Simpan Perubahan' : 'Tambah Potensi' }}</button>
      <a href="{{ route('admin.potensi.index') }}" class="btn btn-sm btn-ghost">Batal</a>
    </div>
  </form>
</div>

@endsection

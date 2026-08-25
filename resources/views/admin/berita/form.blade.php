@extends('layouts.admin')

@section('title', $berita->exists ? 'Edit Berita' : 'Tulis Berita')
@section('page-title', $berita->exists ? 'Edit Berita' : 'Tulis Berita Baru')
@section('page-subtitle', 'Berita akan tampil di beranda situs publik.')

@section('content')

<div class="form-card">
  <form method="POST"
        action="{{ $berita->exists ? route('admin.berita.update', $berita) : route('admin.berita.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if($berita->exists) @method('PUT') @endif

    <div class="form-row">
      <label for="judul">Judul</label>
      <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required>
    </div>

    <div class="form-row">
      <label for="ringkasan">Ringkasan singkat</label>
      <input type="text" id="ringkasan" name="ringkasan" value="{{ old('ringkasan', $berita->ringkasan) }}" maxlength="255" placeholder="Muncul di kartu berita, maks 1-2 kalimat">
    </div>

    <div class="form-row">
      <label for="isi">Isi berita</label>
      <textarea id="isi" name="isi" style="min-height:220px;">{{ old('isi', $berita->isi) }}</textarea>
    </div>

    <div class="form-grid-2">
      <div class="form-row">
        <label for="penulis">Penulis</label>
        <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $berita->penulis) }}" placeholder="Admin Desa">
      </div>
      <div class="form-row">
        <label class="toggle-row" style="margin-top:34px;">
          <input type="checkbox" name="tampil" value="1" {{ old('tampil', $berita->exists ? $berita->tampil : true) ? 'checked' : '' }}>
          Publikasikan sekarang
        </label>
      </div>
    </div>

    <div class="form-row">
      <label for="foto">Foto sampul</label>
      @if($berita->foto)
        <div class="current-media">
          <img src="{{ asset('storage/'.$berita->foto) }}" alt="">
          <span class="hint">Foto saat ini. Unggah baru untuk mengganti.</span>
        </div>
      @endif
      <input type="file" id="foto" name="foto" accept="image/*">
      <p class="hint">Format JPG/PNG, maksimal 4MB.</p>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">{{ $berita->exists ? 'Simpan Perubahan' : 'Publikasikan' }}</button>
      <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-ghost">Batal</a>
    </div>
  </form>
</div>

@endsection

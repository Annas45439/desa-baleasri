@extends('layouts.app')

@section('title', 'Katalog UMKM')

@section('content')
<section style="padding: 60px 0;">
  <div class="container">
    <div class="section-head">
      <span class="kicker">Ekonomi Desa</span>
      <h2>UMKM {{ str_replace('Desa ', '', $setting->nama_desa ?? 'Baleasri') }}.</h2>
      <p>Jelajahi produk warga berdasarkan kategori usaha unggulan atau daftarkan usaha Anda.</p>
    </div>

    <div class="card-grid-3" style="margin-top: 36px;">
      @forelse($umkmGroups as $namaKategori => $produkKategori)
        @php($contoh = $produkKategori->first())
        <a href="{{ route('umkm.show', ['kategori' => Str::slug($namaKategori)]) }}" class="glass-product-card">
          <div class="glass-product-media">
            <img src="{{ storage_image_url($contoh->foto) }}" alt="{{ $namaKategori }}" onerror="this.onerror=null; this.src='{{ asset('assets/logo/cover-placeholder.svg') }}';">
          </div>
          <div class="glass-product-body">
            <span style="font-size:0.68rem; font-weight:800; color:var(--jade-main); text-transform:uppercase; letter-spacing:0.06em;">{{ $produkKategori->count() }} produk</span>
            <h3>{{ $namaKategori }}</h3>
            <p>Lihat ragam produk berkualitas karya pelaku usaha lokal {{ $namaKategori }}.</p>
            <span style="font-size:0.8rem; color:var(--jade-main); font-weight:800; margin-top:auto;">Buka katalog &rarr;</span>
          </div>
        </a>
      @empty
        <div class="glass-card-white" style="grid-column:1 / -1; text-align:center; padding:30px;">
          <p style="color:#586b63;">Belum ada produk UMKM.</p>
        </div>
      @endforelse
    </div>

    <div class="oval-glass-card" id="daftar-umkm" style="margin-top:40px;">
      <div class="section-head" style="margin-bottom:24px;">
        <span class="kicker">Untuk Pelaku Usaha</span>
        <h2>Daftarkan UMKM Anda</h2>
        <p>Isi data singkat berikut. Admin desa akan meninjau dan menghubungi Anda setelah pendaftaran diperiksa.</p>
      </div>

      @if(session('umkm_status'))
        <div style="padding:14px 16px; margin-bottom:20px; border-radius:14px; background:rgba(16,185,129,0.12); color:var(--jade-deep); font-weight:700;">{{ session('umkm_status') }}</div>
      @endif

      @if($errors->any())
        <div style="padding:14px 16px; margin-bottom:20px; border-radius:14px; background:rgba(220,80,65,0.1); color:#9b3428;">
          <strong>Data belum lengkap.</strong>
          <ul style="margin:8px 0 0 18px;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('umkm.apply') }}" method="POST" class="umkm-registration-form">
        @csrf
        <label>Nama usaha<input type="text" name="nama_usaha" value="{{ old('nama_usaha') }}" required maxlength="150" placeholder="Contoh: Batik Baleasri"></label>
        <label>Nama pemilik<input type="text" name="pemilik" value="{{ old('pemilik') }}" required maxlength="120" placeholder="Nama lengkap"></label>
        <label>Kategori usaha<input type="text" name="kategori" value="{{ old('kategori') }}" required maxlength="80" placeholder="Kuliner, kerajinan, jasa..."></label>
        <label>Nomor WhatsApp<input type="text" name="wa" value="{{ old('wa') }}" required maxlength="30" placeholder="08xxxxxxxxxx"></label>
        <label class="full">Lokasi usaha<input type="text" name="lokasi" value="{{ old('lokasi') }}" required maxlength="180" placeholder="Dusun / alamat usaha"></label>
        <label class="full">Deskripsi usaha<textarea name="deskripsi" required maxlength="2000" rows="4" placeholder="Ceritakan produk atau layanan usaha Anda">{{ old('deskripsi') }}</textarea></label>
        <div class="full"><button type="submit" class="btn-oval-primary">Kirim Pendaftaran &rarr;</button></div>
      </form>
    </div>
  </div>
</section>
@endsection


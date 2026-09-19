@extends('layouts.app')

@section('title', 'Katalog UMKM')

@section('content')
<section style="padding: 60px 0;">
  <div class="container">
    <div class="section-head">
      <span class="kicker">Ekonomi Desa</span>
      <h2>UMKM {{ str_replace('Desa ', '', $setting->nama_desa ?? 'Baleasri') }}.</h2>
      <p>Jelajahi produk warga berdasarkan kategori usaha unggulan.</p>
    </div>

    <div class="card-grid-3" style="margin-top: 36px;">
      @forelse($umkmGroups as $namaKategori => $produkKategori)
        @php($contoh = $produkKategori->first())
        <a href="{{ route('umkm.show', ['kategori' => Str::slug($namaKategori)]) }}" class="glass-product-card">
          <div class="glass-product-media">
            <img src="{{ storage_image_url($contoh->foto, 'https://picsum.photos/seed/'.$contoh->slug.'/600/400') }}" alt="{{ $namaKategori }}">
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
  </div>
</section>
@endsection


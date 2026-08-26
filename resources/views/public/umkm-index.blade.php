@extends('layouts.app')

@section('title', 'UMKM Baleasri')

@section('content')
<div class="umkm-page-hero">
  <div class="container">
    <span class="kicker">Ekonomi Desa</span>
    <h1>UMKM Baleasri.</h1>
    <p>Jelajahi produk warga berdasarkan kategori usaha.</p>
  </div>
</div>

<section class="umkm-products-section">
  <div class="container">
    <div class="section-head reveal is-visible">
      <span class="kicker">Katalog Produk</span>
      <h2>Pilih kategori UMKM.</h2>
      <p>Setiap kategori memiliki halaman katalog sendiri agar produk mudah ditemukan.</p>
    </div>
    <div class="umkm-category-grid">
      @forelse($umkmGroups as $namaKategori => $produkKategori)
        @php($contoh = $produkKategori->first())
        <a href="{{ route('umkm.show', ['kategori' => Str::slug($namaKategori)]) }}" class="umkm-category-card reveal is-visible">
          <div class="category-image"><img src="{{ $contoh->foto ? asset('storage/'.$contoh->foto) : 'https://picsum.photos/seed/'.$contoh->slug.'/600/400' }}" alt="{{ $namaKategori }}"></div>
          <div class="category-content"><span class="umkm-cat">{{ $produkKategori->count() }} produk</span><h3>{{ $namaKategori }}</h3><span class="category-link">Buka katalog &rarr;</span></div>
        </a>
      @empty
        <p style="color:#4a564d;">Belum ada produk UMKM.</p>
      @endforelse
    </div>
  </div>
</section>
@endsection

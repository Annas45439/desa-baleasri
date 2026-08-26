@extends('layouts.app')

@section('title', $kategori)

@section('content')
<div class="umkm-page-hero">
  <div class="container">
    <a href="{{ route('home') }}#umkm" class="back-link">&larr; Kembali ke UMKM Baleasri</a>
    <span class="kicker">Katalog UMKM</span>
    <h1>{{ $kategori }}</h1>
    <p>{{ $produk->count() }} produk dari pelaku usaha lokal Desa Baleasri.</p>
  </div>
</div>

<section class="umkm-products-section">
  <div class="container">
    <div class="product-grid">
      @foreach($produk as $item)
        <article class="product-card reveal is-visible">
          <div class="product-image"><img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://picsum.photos/seed/'.$item->slug.'/600/450' }}" alt="{{ $item->nama }}"></div>
          <div class="product-content">
            <span class="umkm-cat">{{ $item->tag ?: $kategori }}</span>
            <h2>{{ $item->nama }}</h2>
            <p>{{ $item->deskripsi ?: 'Produk unggulan warga Desa Baleasri.' }}</p>
            <a href="{{ route('orders.create', $item) }}" class="wa-btn"><svg class="icon"><use href="#ic-wa"/></svg> Pesan Produk</a>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endsection

@extends('layouts.app')

@section('title', $kategori)

@section('content')
<section style="padding: 60px 0;">
  <div class="container">
    <div style="margin-bottom: 24px;">
      <a href="{{ route('umkm.index') }}" style="color:var(--jade-main); font-size:0.8rem; font-weight:800; display:inline-block; margin-bottom:16px;">&larr; Kembali ke UMKM Baleasri</a>
      <div class="section-head">
        <span class="kicker">Katalog UMKM</span>
        <h2>Kategori: {{ $kategori }}</h2>
        <p>{{ $produk->count() }} produk unggulan karya pelaku usaha lokal Desa Baleasri.</p>
      </div>
    </div>

    <div class="card-grid-3">
      @foreach($produk as $item)
        <article class="glass-product-card">
          <div class="glass-product-media">
            <img src="{{ storage_image_url($item->foto) }}" alt="{{ $item->nama }}" onerror="this.onerror=null; this.src='{{ asset('assets/logo/cover-placeholder.svg') }}';">
          </div>
          <div class="glass-product-body">
            <span style="font-size:0.68rem; font-weight:800; color:var(--jade-main); text-transform:uppercase; letter-spacing:0.06em;">{{ $item->tag ?: $kategori }}</span>
            <h3>{{ $item->nama }}</h3>
            <p>{{ $item->deskripsi ?: 'Produk unggulan berkualitas warga Desa Baleasri.' }}</p>
            <a href="{{ route('orders.create', $item) }}" class="wa-btn">Pesan Produk</a>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endsection


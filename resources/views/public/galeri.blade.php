@extends('layouts.app')

@section('title', 'Galeri Desa')

@section('content')
<section class="page-section">
  <div class="container">
    <div class="section-title-box">
      <span class="section-kicker">Dokumentasi Desa</span>
      <h2>Galeri Desa Baleasri</h2>
      <p>Potret kegiatan warga, pelayanan desa, dan suasana Baleasri.</p>
    </div>

    <div class="card-grid-3" style="margin-top:32px;">
      @forelse($galeri as $item)
        <article class="exec-card-item">
          <div class="exec-card-media">
            <img src="{{ storage_image_url($item->foto) }}" alt="{{ $item->nama }}" onerror="this.onerror=null; this.src='{{ asset('assets/logo/cover-placeholder.svg') }}';">
          </div>
          <div class="exec-card-body">
            <span style="font-size:0.75rem; font-weight:700; color:var(--jade-main); text-transform:uppercase; margin-bottom:4px;">{{ $item->tag ?: 'Kegiatan Desa' }}</span>
            <h3>{{ $item->nama }}</h3>
            <p>{{ $item->deskripsi ?: 'Dokumentasi kegiatan dan momen penting Desa Baleasri.' }}</p>
          </div>
        </article>
      @empty
        <div class="glass-card-white" style="grid-column:1 / -1; text-align:center; padding:30px;">
          <p style="color:var(--ink-muted);">Belum ada foto galeri untuk ditampilkan.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>
@endsection
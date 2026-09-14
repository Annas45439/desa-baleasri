@extends('layouts.app')

@section('title', 'Kabar Berita')

@section('content')
<section class="page-section">
  <div class="container">
    <div class="section-title-box">
      <span class="section-kicker">Warta Desa</span>
      <h2>Kabar &amp; Berita Terkini Desa Baleasri</h2>
      <p>Kumpulan publikasi berita resmi, informasi kegiatan pembangunan, dan agenda Pemerintah Desa Baleasri.</p>
    </div>

    <div class="card-grid-3" style="margin-top: 32px;">
      @forelse($beritas as $b)
        <article class="exec-card-item">
          <div class="exec-card-media">
            <img src="{{ $b->foto ? asset('storage/'.$b->foto) : 'https://picsum.photos/seed/'.$b->slug.'/600/400' }}" alt="{{ $b->judul }}">
          </div>
          <div class="exec-card-body">
            <span style="font-size:0.75rem; font-weight:700; color:var(--ink-muted); margin-bottom:4px;">{{ optional($b->tanggal_terbit)->translatedFormat('d M Y') ?? date('d M Y') }}</span>
            <h3>{{ $b->judul }}</h3>
            <p>{{ Str::limit(strip_tags($b->isi), 120) }}</p>
          </div>
        </article>
      @empty
        <div class="card-executive" style="grid-column:1 / -1; text-align:center;">
          <p style="color:var(--ink-muted);">Belum ada warta berita yang dipublikasikan saat ini.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>
@endsection

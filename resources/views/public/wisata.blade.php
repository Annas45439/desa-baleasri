@extends('layouts.app')

@section('title', 'Wisata Desa')

@section('content')
<section class="page-section">
  <div class="container">
    <div class="section-title-box">
      <span class="section-kicker">Destinasi Pariwisata</span>
      <h2>Wisata Desa Baleasri</h2>
      <p>Jelajahi keindahan alam, Embung Duwetsewu, dan sentra kerajinan batik gedhek khas Desa Baleasri, Kecamatan Ngariboyo.</p>
    </div>

    <div class="card-grid-3" style="margin-top: 32px;">
      @forelse($wisata as $w)
        <article class="exec-card-item">
          <div class="exec-card-media">
            <img src="{{ $w->foto ? asset('storage/'.$w->foto) : 'https://picsum.photos/seed/'.$w->slug.'/600/400' }}" alt="{{ $w->nama }}">
          </div>
          <div class="exec-card-body">
            <span style="font-size:0.75rem; font-weight:700; color:var(--jade-main); text-transform:uppercase; margin-bottom:4px;">{{ $w->tag ?? 'Wisata Desa' }}</span>
            <h3>{{ $w->nama }}</h3>
            <p>{{ $w->deskripsi ?: 'Destinasi kebanggaan warga Desa Baleasri, Kecamatan Ngariboyo, Magetan.' }}</p>
          </div>
        </article>
      @empty
        <article class="exec-card-item">
          <div class="exec-card-media">
            <img src="https://picsum.photos/seed/duwetsewu2/600/400" alt="Embung Duwetsewu">
          </div>
          <div class="exec-card-body">
            <span style="font-size:0.75rem; font-weight:700; color:var(--jade-main); text-transform:uppercase; margin-bottom:4px;">Wisata Air</span>
            <h3>Embung Duwetsewu</h3>
            <p>Destinasi wisata air buatan ikonik dengan pemandangan sejuk, menenangkan, dan sarana irigasi pertanian warga.</p>
          </div>
        </article>

        <article class="exec-card-item">
          <div class="exec-card-media">
            <img src="https://picsum.photos/seed/batikgedhek2/600/400" alt="Sentra Batik Gedhek">
          </div>
          <div class="exec-card-body">
            <span style="font-size:0.75rem; font-weight:700; color:var(--jade-main); text-transform:uppercase; margin-bottom:4px;">Wisata Budaya</span>
            <h3>Sentra Batik Gedhek</h3>
            <p>Warisan motif batik khas Desa Baleasri yang diukir dengan ketelitian dan ketelatenan tinggi oleh para pengrajin desa.</p>
          </div>
        </article>

        <article class="exec-card-item">
          <div class="exec-card-media">
            <img src="https://picsum.photos/seed/sawah2/600/400" alt="Hamparan Sawah Baleasri">
          </div>
          <div class="exec-card-body">
            <span style="font-size:0.75rem; font-weight:700; color:var(--jade-main); text-transform:uppercase; margin-bottom:4px;">Wisata Agraris</span>
            <h3>Hamparan Sawah Baleasri</h3>
            <p>Kawasan pertanian padi seluas 110 hektar yang membentang hijau asri khas lanskap perdesaan Kabupaten Magetan.</p>
          </div>
        </article>
      @endforelse
    </div>
  </div>
</section>
@endsection


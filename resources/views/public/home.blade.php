@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<!-- Running Marquee Ticker -->
<div class="marquee-bar-oval">
  <div class="marquee-track">
    @for($i = 0; $i < 2; $i++)
      <span><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c.6 4.4 3.6 7.4 8 8-4.4.6-7.4 3.6-8 8-.6-4.4-3.6-7.4-8-8 4.4-.6 7.4-3.6 8-8Z"/></svg> PEMERINTAH {{ $setting->nama_desa ?? 'DESA BALEASRI' }}</span>
      <span>BALE YANG ASRI — TEMPAT BERMUKIM INDAH &amp; HARMONIS</span>
      <span><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c.6 4.4 3.6 7.4 8 8-4.4.6-7.4 3.6-8 8-.6-4.4-3.6-7.4-8-8 4.4-.6 7.4-3.6 8-8Z"/></svg> EMBUNG DUWETSEWU</span>
      <span>SENTRA BATIK GEDHEK &amp; UMKM UNGGULAN</span>
      <span><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c.6 4.4 3.6 7.4 8 8-4.4.6-7.4 3.6-8 8-.6-4.4-3.6-7.4-8-8 4.4-.6 7.4-3.6 8-8Z"/></svg> KEC. NGARIBOYO, KAB. MAGETAN</span>
    @endfor
  </div>
</div>

<!-- Hero Section (Epic Oval Midnight Jade & Gold) -->
<section class="hero-oval-section">

  {{-- Video Background YouTube --}}
  <div class="hero-video-bg" style="position:absolute; inset:0; z-index:0; overflow:hidden; pointer-events:none;" aria-hidden="true">
    <iframe
      class="hero-video-iframe"
      src="https://www.youtube.com/embed/nbk-af31BXs?autoplay=1&mute=1&loop=1&playlist=nbk-af31BXs&controls=0&showinfo=0&rel=0&iv_load_policy=3&enablejsapi=1&playsinline=1&disablekb=1&modestbranding=1"
      title="Background Video Hero Desa Baleasri"
      allow="autoplay; encrypted-media"
      style="position:absolute; top:50%; left:50%; width:100vw; height:56.25vw; min-height:100vh; min-width:177.77vh; transform:translate(-50%,-50%) scale(1.25); filter:blur(1.5px) brightness(0.80) saturate(1.15); pointer-events:none; border:0;"
      tabindex="-1"
    ></iframe>
    {{-- Overlay cinematic gradient agar teks tetap terbaca --}}
    <div class="hero-video-overlay" style="position:absolute; inset:0; z-index:1; background:linear-gradient(to bottom, rgba(3,28,18,0.55) 0%, rgba(5,46,33,0.40) 40%, rgba(5,46,33,0.65) 80%, rgba(3,22,14,0.88) 100%);"></div>
  </div>

  <div class="container hero-oval-inner">
    <div class="badge-pill-oval">
      <span class="word">BALEASRI</span>
      <span class="desc">Tempat &amp; Rumah yang Indah</span>
      <span style="opacity:0.4;">&bull;</span>
      <span style="font-size:0.75rem; font-weight:800; color:var(--jade-main);">Est. 1887</span>
    </div>

    <h1>Website Resmi Government {{ $setting->nama_desa ?? 'Desa Baleasri' }}</h1>
    <p class="subtitle">
      Kecamatan Ngariboyo, Kabupaten Magetan — Portal Layanan Informasi Publik Terpadu, Transparansi APBDes, Permohonan Surat Online, dan Promosi UMKM Warga.
    </p>

    <div class="hero-actions-oval">
      <a href="{{ route('pengaduan.public') }}" class="btn-oval-primary">Permohonan Surat &amp; Pengaduan &rarr;</a>
      <a href="#sop-pelayanan" class="btn-oval-outline">SOP Pelayanan Publik</a>
      <a href="{{ route('profil.desa') }}" class="btn-oval-outline">Profil &amp; Sejarah 1887</a>
    </div>
  </div>

  <!-- Quick Access Feature Grid (Oval Glass Cards) -->
  <div class="quick-access-oval-wrapper">
    <div class="container">
      <div class="quick-access-oval-grid">
        <a href="{{ route('profil.desa') }}" class="oval-feature-card">
          <div class="oval-icon-box">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12 L12 5 L22 12"/><path d="M6 12v6h12v-6"/></svg>
          </div>
          <h3>Profil Desa</h3>
          <p>Babad 1887 &amp; Data 2025</p>
        </a>

        <a href="{{ route('apbdes.public') }}" class="oval-feature-card">
          <div class="oval-icon-box">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <h3>APBDes</h3>
          <p>Transparansi Anggaran</p>
        </a>

        <a href="{{ route('wisata') }}" class="oval-feature-card">
          <div class="oval-icon-box">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 15 L9 5 L12 10 L15 5 L21 15"/><path d="M3 18.5 Q7 16 12 18.5 T21 18.5"/></svg>
          </div>
          <h3>Wisata Desa</h3>
          <p>Embung &amp; Sentra Batik</p>
        </a>

        <a href="{{ route('umkm.index') }}" class="oval-feature-card">
          <div class="oval-icon-box">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
          </div>
          <h3>Pasar UMKM</h3>
          <p>Produk Lokal Warga</p>
        </a>

        <a href="{{ route('berita.public') }}" class="oval-feature-card">
          <div class="oval-icon-box">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"/></svg>
          </div>
          <h3>Kabar Berita</h3>
          <p>Warta Terbaru Desa</p>
        </a>

        <a href="#sop-pelayanan" class="oval-feature-card">
          <div class="oval-icon-box">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12v18H6z"/><path d="M9 8h6M9 12h6M9 16h4" stroke-linecap="round"/></svg>
          </div>
          <h3>SOP Pelayanan</h3>
          <p>Alur &amp; Jam Layanan</p>
        </a>

        <a href="{{ route('pengaduan.public') }}" class="oval-feature-card">
          <div class="oval-icon-box">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          </div>
          <h3>Layanan Surat</h3>
          <p>Aduan &amp; Administrasi</p>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Sambutan Kepala Desa Section -->
<section class="page-section">
  <div class="container">
    <div class="oval-glass-card">
      <div class="section-head-oval">
        <span class="kicker-oval">Sambutan Resmi</span>
        <h2>Sambutan Kepala Desa Baleasri</h2>
      </div>

      <div style="display:flex; gap:36px; align-items:center; flex-wrap:wrap;">
        <div style="width:170px; height:220px; border-radius:24px; overflow:hidden; flex-shrink:0; border:2px solid var(--glass-border); box-shadow:var(--glass-shadow);">
          @if($setting->foto_kepala_desa)
            <img src="{{ asset('storage/'.$setting->foto_kepala_desa) }}" alt="{{ $setting->nama_kepala_desa ?? 'Juremi' }}" style="width:100%; height:100%; object-fit:cover;">
          @else
            <img src="https://picsum.photos/seed/kadesbaleasri/400/500" alt="Kepala Desa Juremi" style="width:100%; height:100%; object-fit:cover;">
          @endif
        </div>
        <div style="flex-grow:1; min-width:280px;">
          <h3 style="font-family:var(--font-title); font-weight:800; font-size:1.45rem; color:var(--jade-dark); margin-bottom:4px;">
            {{ $setting->nama_kepala_desa ?? 'Juremi' }}
          </h3>
          <p style="font-size:0.85rem; font-weight:700; color:var(--jade-main); margin-bottom:16px;">
            Kepala Desa Baleasri &bull; Periode 2025
          </p>
          <p style="font-size:0.95rem; color:var(--ink-sub); line-height:1.75; font-style:italic; border-left:3px solid var(--gold-main); padding-left:18px;">
            “{{ $setting->sambutan ?: 'Selamat datang di Website Resmi Pemerintah Desa Baleasri. Portal digital ini hadir sebagai wujud keterbukaan informasi publik dan komitmen kami untuk memberikan pelayanan prima yang cepat, transparan, dan akuntabel kepada seluruh masyarakat.' }}”
          </p>
          <div style="margin-top:18px; font-size:0.82rem; color:var(--ink-muted);">
            <strong>Sekretaris Desa:</strong> Tri Anjono &bull; Kecamatan Ngariboyo, Kabupaten Magetan
          </div>
        </div>
      </div>
    </div>

    <!-- Stat Counters Band (Data Prodeskel Kemendagri 2025 Resmi) -->
    <div class="stats-band-oval">
      <div class="stat-oval">
        <div class="n" data-count="2920">0</div>
        <div class="l">Jiwa Penduduk</div>
      </div>
      <div class="stat-oval">
        <div class="n" data-count="916">0</div>
        <div class="l">Kepala Keluarga (KK)</div>
      </div>
      <div class="stat-oval">
        <div class="n" data-count="110">0</div>
        <div class="l">Ha Lahan Padi Sawah</div>
      </div>
      <div class="stat-oval">
        <div class="n" data-count="21">0</div>
        <div class="l">RT Pos Siskamling</div>
      </div>
    </div>
  </div>
</section>

<!-- Ringkasan Pelayanan Publik -->
<section class="page-section" id="sop-pelayanan">
  <div class="container">
    <div class="oval-glass-card" style="display:flex; align-items:center; justify-content:space-between; gap:24px; flex-wrap:wrap;">
      <div style="max-width:680px;">
        <span class="kicker-oval">Pelayanan Publik</span>
        <h2 style="margin:8px 0;">Butuh layanan desa?</h2>
        <p style="margin:0; color:var(--ink-sub);">Ajukan surat, cek status pengajuan, atau sampaikan pengaduan warga melalui satu halaman layanan.</p>
        <p style="margin:12px 0 0; color:var(--ink-muted); font-size:0.88rem;"><strong>Jam layanan:</strong> Senin - Jumat, 08.00 - 16.00 WIB</p>
      </div>
      <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('layanan') }}" class="btn-oval-primary">Buka Layanan &rarr;</a>
        <a href="{{ route('pengaduan.public') }}" class="btn-oval-outline">Sampaikan Pengaduan</a>
      </div>
    </div>
  </div>
</section>

<!-- Destinasi Wisata Spotlight -->
<section class="page-section">
  <div class="container">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px; flex-wrap:wrap; gap:16px;">
      <div class="section-head-oval" style="margin-bottom:0;">
        <span class="kicker-oval">Destinasi Desa</span>
        <h2>Pariwisata Desa Baleasri</h2>
        <p>Pesona keindahan alam, Embung Duwetsewu, dan sentra kerajinan batik gedhek khas desa.</p>
      </div>
      <a href="{{ route('wisata') }}" class="btn-oval-primary" style="padding:10px 24px; font-size:0.85rem;">Halaman Wisata &rarr;</a>
    </div>

    <div class="card-grid-3">
      <article class="oval-item-card">
        <div class="oval-item-media">
          <img src="https://picsum.photos/seed/duwetsewu2/600/400" alt="Embung Duwetsewu">
        </div>
        <div class="oval-item-body">
          <span style="font-size:0.75rem; font-weight:800; color:var(--jade-main); text-transform:uppercase; margin-bottom:4px;">Wisata Air</span>
          <h3>Embung Duwetsewu</h3>
          <p>Destinasi wisata air buatan ikonik dengan pemandangan sejuk, menenangkan, dan sarana irigasi pertanian warga.</p>
          <a href="{{ route('wisata') }}" style="font-size:0.85rem; font-weight:800; color:var(--jade-main); margin-top:auto;">Rincian lokasi &rarr;</a>
        </div>
      </article>

      <article class="oval-item-card">
        <div class="oval-item-media">
          <img src="https://picsum.photos/seed/batikgedhek2/600/400" alt="Sentra Batik Gedhek">
        </div>
        <div class="oval-item-body">
          <span style="font-size:0.75rem; font-weight:800; color:var(--jade-main); text-transform:uppercase; margin-bottom:4px;">Wisata Budaya</span>
          <h3>Sentra Batik Gedhek</h3>
          <p>Warisan motif batik khas Desa Baleasri yang diukir dengan ketelitian dan ketelatenan tinggi oleh para pengrajin desa.</p>
          <a href="{{ route('wisata') }}" style="font-size:0.85rem; font-weight:800; color:var(--jade-main); margin-top:auto;">Rincian lokasi &rarr;</a>
        </div>
      </article>

      <article class="oval-item-card">
        <div class="oval-item-media">
          <img src="https://picsum.photos/seed/sawah2/600/400" alt="Hamparan Sawah Baleasri">
        </div>
        <div class="oval-item-body">
          <span style="font-size:0.75rem; font-weight:800; color:var(--jade-main); text-transform:uppercase; margin-bottom:4px;">Wisata Agraris</span>
          <h3>Hamparan Sawah Baleasri</h3>
          <p>Kawasan pertanian padi seluas 110 hektar yang membentang hijau asri khas lanskap perdesaan Kabupaten Magetan.</p>
          <a href="{{ route('wisata') }}" style="font-size:0.85rem; font-weight:800; color:var(--jade-main); margin-top:auto;">Rincian lokasi &rarr;</a>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- Kabar Berita Section -->
<section class="page-section">
  <div class="container">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px; flex-wrap:wrap; gap:16px;">
      <div class="section-head-oval" style="margin-bottom:0;">
        <span class="kicker-oval">Warta Desa</span>
        <h2>Berita &amp; Informasi Terkini</h2>
        <p>Kumpulan berita resmi dan kegiatan Pemerintah Desa Baleasri.</p>
      </div>
      <a href="{{ route('berita.public') }}" class="btn-oval-primary" style="padding:10px 24px; font-size:0.85rem;">Semua Berita &rarr;</a>
    </div>

    <div class="card-grid-3">
      @forelse($beritas as $b)
        <article class="oval-item-card">
          <div class="oval-item-media">
            <img src="{{ $b->foto ? asset('storage/'.$b->foto) : 'https://picsum.photos/seed/'.$b->slug.'/600/400' }}" alt="{{ $b->judul }}">
          </div>
          <div class="oval-item-body">
            <span style="font-size:0.75rem; font-weight:700; color:var(--ink-muted); margin-bottom:4px;">{{ optional($b->tanggal_terbit)->translatedFormat('d M Y') ?? date('d M Y') }}</span>
            <h3>{{ $b->judul }}</h3>
            <p>{{ Str::limit(strip_tags($b->isi), 100) }}</p>
            <a href="{{ route('berita.public') }}" style="font-size:0.85rem; font-weight:800; color:var(--jade-main); margin-top:auto;">Baca selengkapnya &rarr;</a>
          </div>
        </article>
      @empty
        <div class="oval-glass-card" style="grid-column:1 / -1; text-align:center;">
          <p style="color:var(--ink-muted);">Belum ada warta berita untuk ditampilkan.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- Location Section -->
<section class="page-section">
  <div class="container">
    <div class="section-head-oval">
      <span class="kicker-oval">Lokasi Desa</span>
      <h2>Peta Wilayah Desa Baleasri</h2>
      <p>Kecamatan Ngariboyo, Kabupaten Magetan, Jawa Timur.</p>
    </div>

    <div style="border-radius:var(--radius-card); overflow:hidden; border:1px solid var(--glass-border); height:380px; box-shadow:var(--glass-shadow);">
      <iframe src="https://www.google.com/maps?q=Desa%20Baleasri%2C%20Kecamatan%20Ngariboyo%2C%20Kabupaten%20Magetan&output=embed" width="100%" height="100%" style="border:0;" loading="lazy"></iframe>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  // Counter Animation
  const counters = document.querySelectorAll('[data-count]');
  const counterObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = +el.getAttribute('data-count');
        let cur = 0;
        const step = Math.max(1, Math.ceil(target / 40));
        const timer = setInterval(() => {
          cur += step;
          if (cur >= target) { cur = target; clearInterval(timer); }
          el.textContent = cur;
        }, 40);
        counterObs.unobserve(el);
      }
    });
  }, { threshold: 0.5 });
  counters.forEach(c => counterObs.observe(c));
</script>
@endpush

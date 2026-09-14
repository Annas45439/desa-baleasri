<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $setting->nama_desa ?? 'Desa Baleasri' }} — @yield('title', 'Beranda')</title>
<meta name="description" content="Website Resmi {{ $setting->nama_desa ?? 'Desa Baleasri' }}, Kecamatan Ngariboyo, Kabupaten Magetan — Portal Informasi Publik & Pelayanan Desa">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Plus+Jakarta+Sans:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ secure_asset('assets/css/site.css') }}">
</head>
<body>

<div id="progress"></div>

<!-- Ambient Morphing Glow Circles -->
<div class="bg-ambient-blobs">
  <div class="blob-circle blob-circle-1"></div>
  <div class="blob-circle blob-circle-2"></div>
</div>

<!-- Floating Oval Navigation Pill Header -->
<header class="site-header">
  <nav class="floating-oval-nav">
    <a href="{{ route('home') }}" class="brand">
      <img class="brand-logo" src="{{ secure_asset('assets/logo/logo magetan.png') }}" alt="Logo {{ $setting->nama_desa ?? 'Desa Baleasri' }}">
      <span>{{ str_replace('Desa ', '', $setting->nama_desa ?? 'Baleasri') }}</span>
    </a>

    <div style="display:flex; align-items:center; gap:8px;">
      <a href="{{ route('home') }}#sop-pelayanan" class="nav-cta-oval">
        <span>SOP Pelayanan</span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </nav>

  <nav class="mobile-menu-pillar" aria-label="Mobile Navigation">
    <a href="{{ route('home') }}" class="mobile-menu-pill {{ request()->routeIs('home') ? 'active' : '' }}">
      <span class="mobile-menu-pill__icon">⌂</span>
      <span>Beranda</span>
    </a>
    <a href="{{ route('profil.desa') }}" class="mobile-menu-pill {{ request()->routeIs('profil.desa') ? 'active' : '' }}">
      <span class="mobile-menu-pill__icon">◎</span>
      <span>Profil Desa</span>
    </a>
    <a href="{{ route('apbdes.public') }}" class="mobile-menu-pill {{ request()->routeIs('apbdes.public') ? 'active' : '' }}">
      <span class="mobile-menu-pill__icon">▣</span>
      <span>APBDes</span>
    </a>
    <a href="{{ route('umkm.index') }}" class="mobile-menu-pill {{ request()->routeIs('umkm*') ? 'active' : '' }}">
      <span class="mobile-menu-pill__icon">⌂</span>
      <span>UMKM</span>
    </a>
    <a href="{{ route('home') }}#sop-pelayanan" class="mobile-menu-pill">
      <span class="mobile-menu-pill__icon">▤</span>
      <span>SOP</span>
    </a>
  </nav>
</header>

<!-- Main Content -->
<main style="flex-grow:1; position:relative; z-index:1;">
  @yield('content')
</main>

<!-- Oval Footer -->
<footer class="oval-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <img class="footer-jargon-logo" src="{{ secure_asset('assets/logo/logo jargon maegtan.png') }}" alt="Jargon Kabupaten Magetan">
        <div class="name">Pemerintah {{ $setting->nama_desa ?? 'Desa Baleasri' }}</div>
        <p style="font-size:0.88rem; opacity:0.8;">{{ $setting->tagline ?? 'Kecamatan Ngariboyo, Kabupaten Magetan, Jawa Timur' }}</p>
        @if($setting->alamat)<p style="margin-top:8px; font-size:0.8rem; opacity:0.7;">{{ $setting->alamat }}</p>@endif
      </div>
      <div>
        <h4>Navigasi Portal</h4>
        <ul>
          <li><a href="{{ route('profil.desa') }}">Profil &amp; Sejarah</a></li>
          <li><a href="{{ route('apbdes.public') }}">Infografis APBDes</a></li>
          <li><a href="{{ route('wisata') }}">Wisata Desa</a></li>
          <li><a href="{{ route('umkm.index') }}">Pasar UMKM</a></li>
          <li><a href="{{ route('berita.public') }}">Berita Terbaru</a></li>
        </ul>
      </div>
      <div>
        <h4>Pelayanan</h4>
        <ul>
          <li><a href="{{ route('layanan') }}">Layanan Surat Online</a></li>
          <li><a href="{{ route('home') }}#sop-pelayanan">Informasi Pelayanan Publik</a></li>
          <li><a href="{{ route('layanan') }}">Pengaduan Warga</a></li>
          <li><a href="{{ route('umkm.index') }}">Pendaftaran UMKM</a></li>
          @if($setting->jam_operasional)<li>{{ $setting->jam_operasional }}</li>@endif
        </ul>
      </div>
      <div>
        <h4>Kontak Resmi</h4>
        <ul>
          @if($setting->email)<li>{{ $setting->email }}</li>@endif
          <li>Kecamatan Ngariboyo, Magetan</li>
          <li>Ambulans Desa: 119</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; {{ date('Y') }} Pemerintah {{ $setting->nama_desa ?? 'Desa Baleasri' }}</span>
      <span>Website Resmi Desa &bull; Kecamatan Ngariboyo</span>
    </div>
  </div>
</footer>

<script>
  window.addEventListener('scroll', () => {
    const h = document.documentElement;
    const scrolled = (h.scrollTop) / (h.scrollHeight - h.clientHeight) * 100;
    const p = document.getElementById('progress');
    if (p) p.style.width = scrolled + '%';
  });
</script>
@stack('scripts')
</body>
</html>

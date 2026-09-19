<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $setting->nama_desa ?? 'Desa Baleasri' }} — @yield('title', 'Beranda')</title>
<meta name="description" content="Website Resmi {{ $setting->nama_desa ?? 'Desa Baleasri' }}, Kecamatan Ngariboyo, Kabupaten Magetan — Portal Informasi Publik & Pelayanan Desa">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Plus+Jakarta+Sans:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ secure_asset('assets/css/site.css') }}?v={{ @filemtime(public_path('assets/css/site.css')) }}">
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
          @if($setting->kontak_darurat)
            <li>{{ $setting->kontak_darurat }}</li>
          @elseif($setting->whatsapp_admin)
            <li>WA Admin: +{{ $setting->whatsapp_admin }}</li>
          @endif
          @if($setting->instagram || $setting->facebook || $setting->youtube)
          <li style="margin-top:10px;">
            <span style="font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; opacity:.6;">Ikuti Kami</span>
            <div style="display:flex; gap:10px; margin-top:6px; flex-wrap:wrap;">
              @if($setting->instagram)
              <a href="{{ $setting->instagram }}" target="_blank" rel="noopener"
                 style="display:inline-flex; align-items:center; gap:5px; font-size:0.8rem; font-weight:700; opacity:.85; transition:opacity .2s;" title="Instagram">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                Instagram
              </a>
              @endif
              @if($setting->facebook)
              <a href="{{ $setting->facebook }}" target="_blank" rel="noopener"
                 style="display:inline-flex; align-items:center; gap:5px; font-size:0.8rem; font-weight:700; opacity:.85; transition:opacity .2s;" title="Facebook">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                Facebook
              </a>
              @endif
              @if($setting->youtube)
              <a href="{{ $setting->youtube }}" target="_blank" rel="noopener"
                 style="display:inline-flex; align-items:center; gap:5px; font-size:0.8rem; font-weight:700; opacity:.85; transition:opacity .2s;" title="YouTube">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="currentColor" stroke="none"/></svg>
                YouTube
              </a>
              @endif
            </div>
          </li>
          @endif
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; {{ date('Y') }} Pemerintah {{ $setting->nama_desa ?? 'Desa Baleasri' }}</span>
      <span style="display:inline-flex; align-items:center; gap:6px; background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.22); padding:4px 14px; border-radius:99px; font-size:0.78rem; color:#A7F3D0; font-weight:600;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        Dikunjungi <strong>{{ number_format($totalVisitors ?? 0, 0, ',', '.') }}</strong> kali &bull; Hari ini: <strong>{{ number_format($todayVisitors ?? 0, 0, ',', '.') }}</strong>
      </span>
      <span>Dibuat oleh <strong>KKNT UNESA 2026</strong> &bull; Kecamatan Ngariboyo</span>
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

  document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-revealed');
        }
      });
    }, { threshold: 0.08 });

    document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
  });
</script>
@stack('scripts')
</body>
</html>

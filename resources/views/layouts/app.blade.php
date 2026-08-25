<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $setting->nama_desa ?? 'Desa Baleasri' }} — @yield('title', 'Beranda')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
</head>
<body>

<!-- ===== Sprite ikon custom ===== -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
<defs>
  <symbol id="ic-wisata" viewBox="0 0 24 24">
    <path d="M3 15 L9 5 L12 10 L15 5 L21 15" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" stroke-linecap="round" fill="none"/>
    <path d="M3 18.5 Q7 16 12 18.5 T21 18.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none"/>
  </symbol>
  <symbol id="ic-umkm" viewBox="0 0 24 24">
    <path d="M4 10h16l-1.6 9.2a2 2 0 0 1-2 1.8H7.6a2 2 0 0 1-2-1.8L4 10Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/>
    <path d="M8 10c0-3 1.8-5 4-5s4 2 4 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none"/>
    <path d="M7 13.5h10M7.6 17h8.8" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" opacity="0.6"/>
  </symbol>
  <symbol id="ic-admin" viewBox="0 0 24 24">
    <path d="M5 6.5A1.5 1.5 0 0 1 6.5 5h11A1.5 1.5 0 0 1 19 6.5v11A1.5 1.5 0 0 1 17.5 19h-11A1.5 1.5 0 0 1 5 17.5v-11Z" stroke="currentColor" stroke-width="1.6" fill="none"/>
    <path d="M5.5 6.5 12 12l6.5-5.5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/>
    <circle cx="12" cy="15" r="1.6" fill="currentColor"/>
  </symbol>
  <symbol id="ic-apbdes" viewBox="0 0 24 24">
    <ellipse cx="9" cy="16" rx="6" ry="2.4" stroke="currentColor" stroke-width="1.6" fill="none"/>
    <path d="M3 16v-3c0-1.3 2.7-2.4 6-2.4s6 1.1 6 2.4v3" stroke="currentColor" stroke-width="1.6" fill="none"/>
    <path d="M17 5c-.6 2-.6 3.6 0 5.2.6-1.6.6-3.2 0-5.2Z" fill="currentColor"/>
  </symbol>
  <symbol id="ic-aduan" viewBox="0 0 24 24">
    <path d="M4 12a8 5.6 0 1 1 3.2 4.4L4 18l1-3.4A5.5 5.5 0 0 1 4 12Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/>
    <path d="M12 8.8v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
    <circle cx="12" cy="14.3" r="1" fill="currentColor"/>
  </symbol>
  <symbol id="ic-bale" viewBox="0 0 24 24">
    <path d="M2 12 L12 5 L22 12" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/>
    <path d="M4.5 12 L12 7.6 L19.5 12" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round" fill="none" opacity="0.7"/>
    <path d="M6 12v6h12v-6" stroke="currentColor" stroke-width="1.6" fill="none"/>
    <path d="M10 18v-4h4v4" stroke="currentColor" stroke-width="1.4" fill="none"/>
  </symbol>
  <symbol id="ic-wa" viewBox="0 0 24 24">
    <path d="M12 4.5a7.5 7.5 0 0 0-6.4 11.4L4.8 19.5l3.7-1a7.5 7.5 0 1 0 3.5-14Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/>
    <path d="M9 10.3c.4 2 2 3.3 4 3.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none"/>
  </symbol>
  <symbol id="ic-pin" viewBox="0 0 24 24">
    <path d="M12 21s-6.5-6.1-6.5-11A6.5 6.5 0 0 1 18.5 10c0 4.9-6.5 11-6.5 11Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/>
    <circle cx="12" cy="10" r="2.2" stroke="currentColor" stroke-width="1.6" fill="none"/>
  </symbol>
  <symbol id="ic-warn" viewBox="0 0 24 24">
    <path d="M12 4 L21 19 H3 Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" fill="none"/>
    <path d="M12 10v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    <circle cx="12" cy="16.4" r="0.9" fill="currentColor"/>
  </symbol>
  <symbol id="ic-sparkle" viewBox="0 0 24 24">
    <path d="M12 2c.6 4.4 3.6 7.4 8 8-4.4.6-7.4 3.6-8 8-.6-4.4-3.6-7.4-8-8 4.4-.6 7.4-3.6 8-8Z" fill="currentColor"/>
  </symbol>
</defs>
</svg>
<style>.icon{width:1em; height:1em; display:inline-block; vertical-align:-0.15em;}</style>

<div id="progress"></div>

<header>
  <nav>
    <div class="brand"><div class="mark">{{ Str::substr($setting->nama_desa ?? 'B', 0, 1) }}</div>{{ str_replace('Desa ', '', $setting->nama_desa ?? 'Baleasri') }}</div>
    <ul class="nav-links">
      <li><a href="#layanan">Layanan</a></li>
      <li><a href="#wisata">Wisata</a></li>
      <li><a href="#umkm">UMKM</a></li>
      <li><a href="#galeri">Galeri</a></li>
      <li><a href="#berita">Berita</a></li>
    </ul>
    <a href="#aduan" class="nav-cta">Hubungi Kami <svg class="icon"><use href="#ic-sparkle"/></svg></a>
  </nav>
</header>

@yield('content')

<footer id="aduan">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="name">{{ str_replace('Desa ', '', $setting->nama_desa ?? 'Baleasri') }}</div>
        <p>{{ $setting->tagline ?? '' }}</p>
        @if($setting->alamat)
          <p style="margin-top:10px;">{{ $setting->alamat }}</p>
        @endif
      </div>
      <div><h4>Jelajahi</h4><ul>
        <li><a href="#wisata">Wisata</a></li>
        <li><a href="#umkm">UMKM</a></li>
        <li><a href="#galeri">Galeri</a></li>
        <li><a href="#berita">Berita</a></li>
      </ul></div>
      <div><h4>Kontak</h4><ul>
        @if($setting->email)<li>{{ $setting->email }}</li>@endif
        @if($setting->jam_operasional)<li>{{ $setting->jam_operasional }}</li>@endif
      </ul></div>
      <div><h4>Penting</h4><ul>
        <li>Ambulans: 119</li>
        <li>Polisi: 110</li>
        <li><a href="{{ route('admin.login') }}">Login Admin</a></li>
      </ul></div>
    </div>
    <div class="footer-bottom">
      <span>&copy; {{ date('Y') }} Pemerintah {{ $setting->nama_desa ?? 'Desa Baleasri' }}</span>
      <span>Website Resmi Desa</span>
      <span>Dibuat oleh KKN-T Universitas Negeri Surabaya</span>
    </div>
  </div>
</footer>

<script>
  window.addEventListener('scroll', () => {
    const h = document.documentElement;
    const scrolled = (h.scrollTop) / (h.scrollHeight - h.clientHeight) * 100;
    document.getElementById('progress').style.width = scrolled + '%';
  });
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('is-visible'); });
  }, { threshold: 0.15 });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

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

  document.querySelectorAll('.tilt-card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const r = card.getBoundingClientRect();
      const x = e.clientX - r.left; const y = e.clientY - r.top;
      const rx = ((y / r.height) - 0.5) * -10;
      const ry = ((x / r.width) - 0.5) * 10;
      card.style.transform = `perspective(800px) rotateX(${rx}deg) rotateY(${ry}deg) scale(1.02)`;
    });
    card.addEventListener('mouseleave', () => { card.style.transform = 'perspective(800px) rotateX(0) rotateY(0) scale(1)'; });
  });
</script>
@stack('scripts')
</body>
</html>

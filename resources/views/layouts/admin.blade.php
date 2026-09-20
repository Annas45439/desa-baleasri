<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel Admin — {{ auth()->user()->name ?? 'Desa Baleasri' }} — @yield('title', 'Dashboard')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400..800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ secure_asset('assets/css/admin.css') }}">
@vite(['resources/js/app.js'])
</head>
<body>

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
<defs>
  <symbol id="i-dash" viewBox="0 0 24 24"><rect x="3.5" y="3.5" width="7" height="7" rx="1.6" stroke="currentColor" stroke-width="1.6" fill="none"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.6" stroke="currentColor" stroke-width="1.6" fill="none"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.6" stroke="currentColor" stroke-width="1.6" fill="none"/><rect x="13.5" y="13.5" width="7" height="7" rx="1.6" stroke="currentColor" stroke-width="1.6" fill="none"/></symbol>
  <symbol id="i-bale" viewBox="0 0 24 24"><path d="M2 12 L12 5 L22 12" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/><path d="M6 12v6h12v-6" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M10 18v-4h4v4" stroke="currentColor" stroke-width="1.4" fill="none"/></symbol>
  <symbol id="i-umkm" viewBox="0 0 24 24"><path d="M4 10h16l-1.6 9.2a2 2 0 0 1-2 1.8H7.6a2 2 0 0 1-2-1.8L4 10Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/><path d="M8 10c0-3 1.8-5 4-5s4 2 4 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none"/></symbol>
  <symbol id="i-wisata" viewBox="0 0 24 24"><path d="M3 15 L9 5 L12 10 L15 5 L21 15" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" stroke-linecap="round" fill="none"/><path d="M3 18.5 Q7 16 12 18.5 T21 18.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none"/></symbol>
  <symbol id="i-berita" viewBox="0 0 24 24"><path d="M5 4.5h11a2 2 0 0 1 2 2V19a1 1 0 0 1-1.5.87L15 18.3l-1.5 1.57A1 1 0 0 1 12 19l-1.5.87A1 1 0 0 1 9 19l-1.5.87A1 1 0 0 1 6 19V6.5a2 2 0 0 1 2-2" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/><path d="M9 9h6M9 12.5h6M9 16h3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></symbol>
  <symbol id="i-galeri" viewBox="0 0 24 24"><rect x="3.5" y="4.5" width="17" height="15" rx="2" stroke="currentColor" stroke-width="1.6" fill="none"/><circle cx="8.5" cy="9.5" r="1.6" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M4 17l5-5 4 4 3-3 4 4" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/></symbol>
  <symbol id="i-apbdes" viewBox="0 0 24 24"><ellipse cx="9" cy="16" rx="6" ry="2.4" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M3 16v-3c0-1.3 2.7-2.4 6-2.4s6 1.1 6 2.4v3" stroke="currentColor" stroke-width="1.6" fill="none"/></symbol>
  <symbol id="i-aduan" viewBox="0 0 24 24"><path d="M4 12a8 5.6 0 1 1 3.2 4.4L4 18l1-3.4A5.5 5.5 0 0 1 4 12Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/><path d="M12 8.8v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><circle cx="12" cy="14.3" r="1" fill="currentColor"/></symbol>
  <symbol id="i-setting" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M4 12h2M18 12h2M12 4v2M12 18v2M6.3 6.3l1.4 1.4M16.3 16.3l1.4 1.4M6.3 17.7l1.4-1.4M16.3 7.7l1.4-1.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></symbol>
  <symbol id="i-plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></symbol>
  <symbol id="i-warn" viewBox="0 0 24 24"><path d="M12 4 L21 19 H3 Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" fill="none"/><path d="M12 10v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="16.4" r="0.9" fill="currentColor"/></symbol>
  <symbol id="i-logout" viewBox="0 0 24 24"><path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none"/><path d="M15 8l4 4-4 4M19 12H9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" fill="none"/></symbol>
  <symbol id="i-eye" viewBox="0 0 24 24"><path d="M2 12s3.5-6.5 10-6.5S22 12 22 12s-3.5 6.5-10 6.5S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" fill="none"/><circle cx="12" cy="12" r="2.6" stroke="currentColor" stroke-width="1.6" fill="none"/></symbol>
  <symbol id="i-surat" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="1.6" fill="none"/><polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="1.6" fill="none"/></symbol>
  <symbol id="i-report" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="1.6" fill="none"/><polyline points="14 2 14 8 20 8" stroke="currentColor" stroke-width="1.6" fill="none"/><line x1="16" y1="13" x2="8" y2="13" stroke="currentColor" stroke-width="1.6"/><line x1="16" y1="17" x2="8" y2="17" stroke="currentColor" stroke-width="1.6"/></symbol>
  <symbol id="i-admin" viewBox="0 0 24 24"><path d="M4 9h16l-1.5 10H5.5L4 9Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/><path d="M6 9l1.2-4h9.6L18 9M8 13h8M9 16h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none"/></symbol>
  <symbol id="i-user" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.2" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M5 20c.7-3.4 3.1-5.2 7-5.2s6.3 1.8 7 5.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none"/></symbol>
  <symbol id="i-message" viewBox="0 0 24 24"><path d="M5 5.5h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H10l-4.5 3v-3H5a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" fill="none"/><path d="M7 10h10M7 13h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></symbol>
  <symbol id="i-menu" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></symbol>
  <symbol id="i-close" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></symbol>
  <symbol id="i-storage" viewBox="0 0 24 24"><path d="M4 6h16a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M4 14h16a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" fill="none"/><circle cx="7.5" cy="9" r="1" fill="currentColor"/><circle cx="7.5" cy="17" r="1" fill="currentColor"/></symbol>
</defs>
</svg>

<header class="mobile-header">
  <div class="mobile-brand">
    <img class="mobile-brand-logo" src="{{ secure_asset('assets/logo/logo magetan.png') }}" alt="Logo Desa Baleasri" width="32" height="32" style="width:32px; height:32px; max-width:32px; max-height:32px; object-fit:contain; flex-shrink:0;">
    <div class="txt">Baleasri<small>Panel Admin</small></div>
  </div>
  <button type="button" class="mobile-toggle" id="sidebarToggle" aria-label="Buka Menu Admin">
    <svg class="icon"><use href="#i-menu"/></svg>
  </button>
</header>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="layout">
  <aside class="sidebar" id="sidebar">
    <div class="side-brand">
      <div class="side-brand-info">
        <img class="mark side-brand-logo" src="{{ secure_asset('assets/logo/logo magetan.png') }}" alt="Logo Desa Baleasri" width="36" height="36" style="width:36px; height:36px; max-width:36px; max-height:36px; object-fit:contain; flex-shrink:0;">
        <div class="txt">Baleasri<small>Panel Admin</small></div>
      </div>
      <button type="button" class="sidebar-close" id="sidebarClose" aria-label="Tutup Menu">
        <svg class="icon"><use href="#i-close"/></svg>
      </button>
    </div>

    <div class="side-group">
      <div class="side-label">Menu</div>
      <a href="{{ route('admin.dashboard') }}" class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><svg class="icon"><use href="#i-dash"/></svg> Dashboard</a>
    </div>

    <div class="side-group">
      <div class="side-label">Konten Desa</div>
      <a href="{{ route('admin.settings.edit') }}#profil" class="side-link"><svg class="icon"><use href="#i-bale"/></svg> Profil &amp; Sejarah</a>
      <a href="{{ route('admin.potensi.index', ['kategori' => 'wisata']) }}" class="side-link {{ request('kategori') === 'wisata' ? 'active' : '' }}"><svg class="icon"><use href="#i-wisata"/></svg> Wisata</a>
      <a href="{{ route('admin.potensi.index', ['kategori' => 'galeri']) }}" class="side-link {{ request('kategori') === 'galeri' ? 'active' : '' }}"><svg class="icon"><use href="#i-galeri"/></svg> Galeri</a>
      <a href="{{ route('admin.berita.index') }}" class="side-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}"><svg class="icon"><use href="#i-berita"/></svg> Berita &amp; Agenda</a>
    </div>

    <div class="side-group">
      <div class="side-label">Ekonomi &amp; Layanan</div>
      <a href="{{ route('admin.letters.index') }}" class="side-link {{ request()->routeIs('admin.letters.index') || request()->routeIs('admin.letters.edit') ? 'active' : '' }}"><svg class="icon"><use href="#i-surat"/></svg> Layanan Surat @if($newLetters)<span class="count">{{ $newLetters }}</span>@endif</a>
      <a href="{{ route('admin.letters.report') }}" class="side-link {{ request()->routeIs('admin.letters.report') ? 'active' : '' }}"><svg class="icon"><use href="#i-report"/></svg> Laporan Surat</a>
      <a href="{{ route('admin.potensi.index', ['kategori' => 'umkm']) }}" class="side-link {{ request('kategori') === 'umkm' && !request()->has('pendaftar') ? 'active' : '' }}"><svg class="icon"><use href="#i-umkm"/></svg> Produk UMKM</a>
      <a href="{{ route('admin.orders.index') }}" class="side-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><svg class="icon"><use href="#i-admin"/></svg> Pesanan @if($pendingOrders)<span class="count">{{ $pendingOrders }}</span>@endif</a>
      <a href="{{ route('admin.potensi.index', ['kategori' => 'umkm', 'pendaftar' => 1]) }}#pendaftar-umkm" class="side-link {{ request()->has('pendaftar') ? 'active' : '' }}"><svg class="icon"><use href="#i-umkm"/></svg> Pendaftar UMKM @if($pendingApplicants)<span class="count">{{ $pendingApplicants }}</span>@endif</a>
      <a href="{{ route('admin.complaints.index') }}" class="side-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}"><svg class="icon"><use href="#i-aduan"/></svg> Pengaduan @if($newComplaints)<span class="count">{{ $newComplaints }}</span>@endif</a>
      <a href="{{ route('admin.settings.edit') }}#administrasi" class="side-link"><svg class="icon"><use href="#i-admin"/></svg> Administrasi</a>
      <a href="{{ route('admin.apbdes.index') }}" class="side-link {{ request()->routeIs('admin.apbdes.*') ? 'active' : '' }}"><svg class="icon"><use href="#i-apbdes"/></svg> APBDes</a>
    </div>

    <div class="side-group">
      <div class="side-label">Sistem</div>
      <a href="{{ route('admin.users.index') }}" class="side-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><svg class="icon"><use href="#i-user"/></svg> Pengguna</a>
      <a href="{{ route('admin.settings.edit') }}" class="side-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><svg class="icon"><use href="#i-setting"/></svg> Pengaturan</a>
      <a href="{{ route('admin.storage.index') }}" class="side-link {{ request()->routeIs('admin.storage.*') ? 'active' : '' }}"><svg class="icon"><use href="#i-storage"/></svg> Status Penyimpanan</a>
      <a href="{{ route('admin.activity-logs.index') }}" class="side-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}"><svg class="icon"><use href="#i-report"/></svg> Audit Log Aktivitas</a>
    </div>

    <div class="side-group">
      <div class="side-label">Lainnya</div>
      <a href="{{ route('admin.panduan.index') }}" class="side-link {{ request()->routeIs('admin.panduan.*') ? 'active' : '' }}"><svg class="icon"><use href="#i-book"/></svg> Buku Panduan</a>
      <a href="{{ route('home') }}" target="_blank" class="side-link"><svg class="icon"><use href="#i-eye"/></svg> Lihat Situs</a>
    </div>

    <div class="side-footer">
      <div class="side-user">
        <div class="av">{{ strtoupper(Str::substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
        <div><div class="name">{{ auth()->user()->name ?? 'Admin' }}</div><div class="role">Super Admin</div></div>
      </div>
      <form method="POST" action="{{ route('admin.logout') }}" style="margin-top:10px;">
        @csrf
        <button type="submit" class="side-link" style="width:100%; background:none; border:none; cursor:pointer; text-align:left;">
          <svg class="icon"><use href="#i-logout"/></svg> Keluar
        </button>
      </form>
      <div style="margin-top:14px; padding-top:10px; border-top:1px solid var(--line); font-size:0.68rem; color:var(--ink-4); text-align:center; font-weight:600;">
        Dibuat oleh <strong style="color:var(--emerald);">KKNT UNESA 2026</strong>
      </div>
    </div>
  </aside>

  <main class="main">
    <div class="topbar">
      <div>
        <h1>@yield('page-title', 'Dashboard')</h1>
        <p>@yield('page-subtitle', 'Kelola konten situs desa dari sini.')</p>
      </div>
      @hasSection('page-action')
        @yield('page-action')
      @endif
    </div>

    @if(session('status'))
      <div style="background:var(--teal-soft); color:var(--teal-deep); border:1px solid var(--teal); border-radius:14px; padding:14px 18px; margin-bottom:20px; font-weight:600; font-size:0.88rem;">
        {{ session('status') }}
      </div>
    @endif
    @if(session('error'))
      <div style="background:var(--coral-soft); color:var(--coral); border:1px solid var(--coral); border-radius:14px; padding:14px 18px; margin-bottom:20px; font-weight:600; font-size:0.88rem;">
        {{ session('error') }}
      </div>
    @endif
    @if($errors->any())
      <div style="background:var(--coral-soft); color:var(--coral); border:1px solid var(--coral); border-radius:14px; padding:14px 18px; margin-bottom:20px; font-weight:600; font-size:0.88rem;">
        <ul style="margin:0; padding-left:18px;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('sidebar');
  const toggleBtn = document.getElementById('sidebarToggle');
  const closeBtn = document.getElementById('sidebarClose');
  const overlay = document.getElementById('sidebarOverlay');

  function openSidebar() {
    if (sidebar) sidebar.classList.add('open');
    if (overlay) overlay.classList.add('show');
    document.body.classList.add('sidebar-open');
  }

  function closeSidebar() {
    if (sidebar) sidebar.classList.remove('open');
    if (overlay) overlay.classList.remove('show');
    document.body.classList.remove('sidebar-open');
  }

  if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
  if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
  if (overlay) overlay.addEventListener('click', closeSidebar);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeSidebar();
    }
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 1024) {
      closeSidebar();
    }
  });

  if (sidebar) {
    sidebar.querySelectorAll('.side-link').forEach(link => {
      link.addEventListener('click', () => {
        if (window.innerWidth < 1024) {
          closeSidebar();
        }
      });
    });
  }
});
</script>

</body>
</html>

@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Halo, ' . (auth()->user()->name ?? 'Admin'))
@section('page-subtitle', 'Ini ringkasan konten situs ' . ($setting->nama_desa ?? 'desa') . '.')
@section('page-action')
  <a href="{{ route('admin.potensi.create') }}" class="btn btn-primary"><svg class="icon"><use href="#i-plus"/></svg> Tambah Konten</a>
@endsection

@section('content')

<div class="ai-dashboard-grid">
  <div class="ai-hero-panel">
    <div class="ai-label">BaleAI Assistant</div>
    <h2>Insight hari ini lebih positif.</h2>
    <p>Ringkasan berbasis kelengkapan konten situs: {{ $pendingApplicants }} pendaftar UMKM masih menunggu ditinjau dan {{ $totalBerita }} berita tersedia untuk dipublikasikan.</p>
    <div class="ai-suggestion-grid">
      <div><strong>Promosi UMKM</strong><span>Tinggi</span><p>Promosikan produk yang sudah tayang melalui katalog beranda.</p></div>
      <div><strong>Konten wisata</strong><span>Baru</span><p>Tambahkan foto dan berita terbaru agar destinasi lebih menarik.</p></div>
      <div><strong>Moderasi UMKM</strong><span>Prioritas</span><p>Tinjau pendaftar baru sebelum usaha tampil di katalog.</p></div>
    </div>
  </div>
  <div class="ai-command panel">
    <div class="panel-head"><h2>BaleAI Command</h2><span class="ai-live">live</span></div>
    <div id="aiPrompt" class="ai-prompt"><strong>AI:</strong> “Berikan 3 ide kampanye wisata minggu ini.”</div>
    <div id="aiOutput" class="ai-output">1. Festival Kuliner Desa<br>2. Pameran UMKM malam hari<br>3. Storytelling Wisata Alam</div>
    <button type="button" id="runAiBtn" class="ai-action">Jalankan AI Action</button>
  </div>
</div>

<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--teal-soft); color:var(--teal-deep);"><svg class="icon"><use href="#i-umkm"/></svg></div>
      <span class="trend up">{{ $umkmTayang }} tayang</span>
    </div>
    <div class="num">{{ $totalUmkm }}</div>
    <div class="label">Produk UMKM</div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--violet-soft); color:var(--violet);"><svg class="icon"><use href="#i-wisata"/></svg></div>
      <span class="trend up">Destinasi</span>
    </div>
    <div class="num">{{ $totalWisata }}</div>
    <div class="label">Potensi Wisata</div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--gold-soft); color:#946200;"><svg class="icon"><use href="#i-berita"/></svg></div>
      <span class="trend up">Publikasi</span>
    </div>
    <div class="num">{{ $totalBerita }}</div>
    <div class="label">Berita Terbit</div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:{{ $setting->hero_video ? 'var(--teal-soft)' : 'var(--coral-soft)' }}; color:{{ $setting->hero_video ? 'var(--teal-deep)' : 'var(--coral)' }};"><svg class="icon"><use href="#i-setting"/></svg></div>
      <span class="trend {{ $setting->hero_video ? 'up' : 'warn' }}">{{ $setting->hero_video ? 'Aktif' : 'Belum diisi' }}</span>
    </div>
    <div class="num">{{ $setting->hero_video ? 'Video' : 'Foto' }}</div>
    <div class="label">Mode Hero Beranda</div>
  </div>
</div>

<div class="grid-2">
  <div class="panel">
    <div class="panel-head">
      <h2>Kelengkapan Konten</h2>
      <a href="{{ route('admin.potensi.index') }}">Lihat semua</a>
    </div>
    @foreach($contentHealth as $item)
      <div class="checklist-item">
        <div class="checklist-top">
          <span>{{ $item['label'] }}</span>
          <span class="pct">{{ $item['value'] }}%</span>
        </div>
        <div class="bar-bg"><div class="bar-fill" style="width:{{ $item['value'] }}%; background:var(--{{ $item['tone'] }});"></div></div>
      </div>
    @endforeach
    <div class="status-note">Lengkapi data agar beranda terlihat lebih hidup dan informatif.</div>
  </div>

  <div class="panel">
    <div class="panel-head">
      <h2>Potensi Desa Terbaru</h2>
      <a href="{{ route('admin.berita.index') }}">Kelola semua</a>
    </div>
    <table>
      <thead><tr><th>Nama</th><th>Kategori</th><th>Status</th></tr></thead>
      <tbody>
        @forelse($potensiTerbaru as $p)
          <tr>
            <td>{{ Str::limit($p->nama, 30) }}</td>
            <td style="text-transform:capitalize;">{{ $p->kategori }}</td>
            <td><span class="status-pill {{ $p->tampil ? 'st-selesai' : 'st-baru' }}">{{ $p->tampil ? 'Tayang' : 'Draft' }}</span></td>
          </tr>
        @empty
          <tr><td colspan="3" style="color:var(--text-muted); text-align:center;">Belum ada potensi desa.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="panel" style="margin-bottom:24px;">
  <div class="panel-head">
    <h2>Berita Terbaru</h2>
    <a href="{{ route('admin.berita.index') }}">Kelola semua</a>
  </div>
  <table>
    <thead><tr><th>Judul</th><th>Penulis</th><th>Status</th></tr></thead>
    <tbody>
      @forelse($beritaTerbaru as $b)
        <tr>
          <td>{{ Str::limit($b->judul, 50) }}</td>
          <td>{{ $b->penulis ?? '-' }}</td>
          <td><span class="status-pill {{ $b->tampil ? 'st-selesai' : 'st-baru' }}">{{ $b->tampil ? 'Tayang' : 'Draft' }}</span></td>
        </tr>
      @empty
        <tr><td colspan="3" style="color:var(--text-muted); text-align:center;">Belum ada berita.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="panel-head" style="margin-bottom:14px;"><h2>Aksi Cepat</h2></div>
<div class="quick-grid">
  <a href="{{ route('admin.potensi.create') }}" class="quick-card">
    <div class="qi" style="background:var(--teal-soft); color:var(--teal-deep);"><svg class="icon"><use href="#i-umkm"/></svg></div>
    <h3>Tambah Produk UMKM</h3>
    <p>Unggah produk baru ke katalog</p>
  </a>
  <a href="{{ route('admin.berita.create') }}" class="quick-card">
    <div class="qi" style="background:var(--violet-soft); color:var(--violet);"><svg class="icon"><use href="#i-berita"/></svg></div>
    <h3>Tulis Berita</h3>
    <p>Bagikan kabar terbaru desa</p>
  </a>
  <a href="{{ route('admin.potensi.create') }}?kategori=galeri" class="quick-card">
    <div class="qi" style="background:var(--gold-soft); color:#946200;"><svg class="icon"><use href="#i-galeri"/></svg></div>
    <h3>Unggah Galeri</h3>
    <p>Tambah foto kegiatan desa</p>
  </a>
  <a href="{{ route('admin.settings.edit') }}" class="quick-card">
    <div class="qi" style="background:var(--coral-soft); color:var(--coral);"><svg class="icon"><use href="#i-setting"/></svg></div>
    <h3>Atur Hero & Sambutan</h3>
    <p>Ganti video/foto hero, sambutan kades</p>
  </a>
</div>

<script>
  const aiActions = [
    ['Berikan 3 ide kampanye wisata minggu ini.', '1. Festival Kuliner Desa<br>2. Pameran UMKM malam hari<br>3. Storytelling Wisata Alam'],
    ['Apa prioritas konten hari ini?', '1. Tinjau pendaftar UMKM baru<br>2. Lengkapi foto destinasi wisata<br>3. Terbitkan satu berita terbaru'],
    ['Buat rencana promosi UMKM.', '1. Pilih 3 produk unggulan<br>2. Perbarui foto dan deskripsi<br>3. Bagikan katalog melalui WhatsApp']
  ];
  document.getElementById('runAiBtn')?.addEventListener('click', event => {
    const action = aiActions[Math.floor(Math.random() * aiActions.length)];
    document.getElementById('aiPrompt').innerHTML = '<strong>AI:</strong> “' + action[0] + '”';
    document.getElementById('aiOutput').innerHTML = action[1];
    event.currentTarget.textContent = 'AI Action Selesai';
    setTimeout(() => { event.currentTarget.textContent = 'Jalankan AI Action'; }, 1600);
  });
</script>

@endsection

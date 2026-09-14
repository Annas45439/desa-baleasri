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
      <div class="stat-icon" style="background:var(--coral-soft); color:var(--coral);"><svg class="icon"><use href="#i-eye"/></svg></div>
      <span class="trend up">Hari ini</span>
    </div>
    <div class="num">{{ number_format($todayVisitors) }}</div>
    <div class="label">Pengunjung Hari Ini</div>
  </div>
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
      <div class="stat-icon" style="background:{{ $setting->hero_image ? 'var(--teal-soft)' : 'var(--coral-soft)' }}; color:{{ $setting->hero_image ? 'var(--teal-deep)' : 'var(--coral)' }};"><svg class="icon"><use href="#i-setting"/></svg></div>
      <span class="trend {{ $setting->hero_image ? 'up' : 'warn' }}">{{ $setting->hero_image ? 'Aktif' : 'Belum diisi' }}</span>
    </div>
    <div class="num">{{ $setting->hero_image ? 'Foto' : 'Belum' }}</div>
    <div class="label">Foto Hero Beranda</div>
  </div>
</div>

<div class="panel" style="margin-bottom:24px;">
  <div class="panel-head">
    <div><h2>Operasional Desa</h2><p class="visitor-subtitle">Ringkasan layanan surat dan pengaduan warga.</p></div>
  </div>

  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:18px; margin-top:12px;">
    <div style="background:linear-gradient(135deg, #ecfdf5, #f0fdf4); border:1px solid #bbf7d0; border-radius:16px; padding:18px;">
      <div style="font-size:0.72rem; font-weight:800; letter-spacing:0.12em; text-transform:uppercase; color:var(--jade-main);">Pengajuan Surat</div>
      <div style="font-size:2.2rem; font-weight:800; margin-top:8px; color:var(--ink-main);">{{ $letterStats['total'] }}</div>
      <div style="margin-top:12px; display:flex; flex-wrap:wrap; gap:8px;">
        <span class="status-pill st-baru">Baru {{ $letterStats['baru'] }}</span>
        <span class="status-pill st-proses">Diproses {{ $letterStats['diproses'] }}</span>
        <span class="status-pill st-selesai">Selesai {{ $letterStats['selesai'] }}</span>
      </div>
    </div>

    <div style="background:linear-gradient(135deg, #f5f3ff, #f3e8ff); border:1px solid #ddd6fe; border-radius:16px; padding:18px;">
      <div style="font-size:0.72rem; font-weight:800; letter-spacing:0.12em; text-transform:uppercase; color:#7c3aed;">Pengaduan</div>
      <div style="font-size:2.2rem; font-weight:800; margin-top:8px; color:var(--ink-main);">{{ $complaintStats['total'] }}</div>
      <div style="margin-top:12px; display:flex; flex-wrap:wrap; gap:8px;">
        <span class="status-pill st-baru">Baru {{ $complaintStats['baru'] }}</span>
        <span class="status-pill st-proses">Diproses {{ $complaintStats['diproses'] }}</span>
        <span class="status-pill st-selesai">Selesai {{ $complaintStats['selesai'] }}</span>
      </div>
    </div>
  </div>
</div>

<div class="visitor-panel panel">
  <div class="panel-head">
    <div><h2>Pengunjung Situs</h2><p class="visitor-subtitle">Perkembangan kunjungan unik selama 7 hari terakhir.</p></div>
    <div class="visitor-total"><strong>{{ number_format($totalVisitors) }}</strong><span>Total kunjungan</span></div>
  </div>
  <div class="visitor-chart" aria-label="Grafik pengunjung tujuh hari terakhir">
    @php($maxVisitors = max(1, $visitorChart->max('visitors')))
    @foreach($visitorChart as $day)
      <div class="visitor-day"><div class="visitor-value">{{ $day['visitors'] }}</div><div class="visitor-bar-track"><div class="visitor-bar" style="height:{{ max(6, ($day['visitors'] / $maxVisitors) * 100) }}%;"></div></div><span>{{ $day['label'] }}</span></div>
    @endforeach
  </div>
</div>

<div class="map-panel panel">
  <div class="panel-head">
    <div>
      <h2>Lokasi Desa Baleasri</h2>
      <p class="map-subtitle">Desa Baleasri, Kecamatan Ngariboyo, Kabupaten Magetan.</p>
    </div>
    <a class="map-open-link" href="https://maps.app.goo.gl/cp8v5nr9oPhxgTkd7" target="_blank" rel="noopener">Buka di Google Maps &rarr;</a>
  </div>
  <div class="map-frame-wrap">
    <iframe
      src="https://www.google.com/maps?q=Desa%20Baleasri%2C%20Kecamatan%20Ngariboyo%2C%20Kabupaten%20Magetan&output=embed"
      title="Peta lokasi Desa Baleasri"
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
      allowfullscreen></iframe>
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

<div class="panel" id="pengaduan" style="margin-bottom:24px;">
  <div class="panel-head">
    <h2>Pendaftar UMKM Terbaru</h2>
    <a href="{{ route('admin.potensi.index', ['kategori' => 'umkm', 'pendaftar' => 1]) }}#pendaftar-umkm">Kelola semua</a>
  </div>
  <table>
    <thead><tr><th>Usaha</th><th>Pemilik</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($umkmApplicants as $applicant)
        <tr>
          <td><strong>{{ $applicant->nama_usaha }}</strong><br><small style="color:var(--text-muted);">{{ $applicant->kategori }} · {{ $applicant->lokasi }}</small></td>
          <td>{{ $applicant->pemilik }}</td>
          <td><span class="status-pill {{ $applicant->status === 'Disetujui' ? 'st-selesai' : ($applicant->status === 'Ditolak' ? 'st-baru' : 'st-proses') }}">{{ $applicant->status }}</span></td>
          <td><div class="approval-actions"><form method="POST" action="{{ route('admin.umkm-applicants.status', $applicant) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="Disetujui"><button class="approval-btn approve" type="submit">Setujui</button></form><form method="POST" action="{{ route('admin.umkm-applicants.status', $applicant) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="Ditolak"><button class="approval-btn reject" type="submit">Tolak</button></form></div></td>
        </tr>
      @empty
        <tr><td colspan="4" style="color:var(--text-muted); text-align:center;">Belum ada pendaftar UMKM.</td></tr>
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

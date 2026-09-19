@extends('layouts.admin')

@section('title', 'Status & Analisis Penyimpanan')
@section('page-title', 'Status Penyimpanan Hosting')
@section('page-subtitle', 'Pantau penggunaan ruang disk dan statistik file yang diunggah ke situs desa.')

@section('content')

<!-- Stat Cards -->
<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--teal-soft); color:var(--teal-deep);"><svg class="icon"><use href="#i-dash"/></svg></div>
      <span class="trend up">Total Terpakai</span>
    </div>
    <div class="num">{{ $formattedTotal }}</div>
    <div class="label">Kapasitas Disk Terpakai</div>
  </div>

  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--violet-soft); color:var(--violet);"><svg class="icon"><use href="#i-surat"/></svg></div>
      <span class="trend up">Berkas</span>
    </div>
    <div class="num">{{ number_format($totalFiles) }}</div>
    <div class="label">Total File Diunggah</div>
  </div>

  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:{{ $health === 'safe' ? 'var(--teal-soft)' : ($health === 'warning' ? 'var(--gold-soft)' : 'var(--coral-soft)') }}; color:{{ $health === 'safe' ? 'var(--teal-deep)' : ($health === 'warning' ? 'var(--amber)' : 'var(--coral)') }};"><svg class="icon"><use href="#i-setting"/></svg></div>
      <span class="trend {{ $health === 'safe' ? 'up' : 'warn' }}">{{ strtoupper($health) }}</span>
    </div>
    <div class="num" style="font-size:1.35rem;">
      @if($health === 'safe') 🟢 Optimal
      @elseif($health === 'warning') 🟡 Perhatian
      @else 🔴 Tinggi
      @endif
    </div>
    <div class="label">Kesehatan Hosting</div>
  </div>

  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--gold-soft); color:var(--amber);"><svg class="icon"><use href="#i-berita"/></svg></div>
      <span class="trend up">Terbesar</span>
    </div>
    <div class="num" style="font-size:1.35rem;">{{ count($topFiles) > 0 ? $topFiles[0]['formatted_size'] : '0 B' }}</div>
    <div class="label">Ukuran File Maksimal</div>
  </div>
</div>

<!-- Storage Visual Progress Bar & Health Message -->
<div class="panel" style="margin-bottom:24px;">
  <div class="panel-head">
    <div>
      <h2>Distribusi Penyimpanan Website</h2>
      <p class="visitor-subtitle">{{ $healthMessage }} &bull; Berkas Aplikasi: <strong>{{ $formattedTotal }}</strong> ({{ number_format($totalFiles) }} file diunggah)</p>
    </div>
    @if($serverDiskTotal !== 'N/A')
      <span class="status-pill {{ $health === 'safe' ? 'st-selesai' : ($health === 'warning' ? 'st-proses' : 'st-baru') }}">
        Hosting Disk: {{ $serverDiskUsed }} terpakai dari {{ $serverDiskTotal }}
      </span>
    @else
      <span class="status-pill st-selesai">
        Total Berkas: {{ $formattedTotal }}
      </span>
    @endif
  </div>

  <!-- Multi-colored Segmented Progress Bar -->
  <div style="height:14px; background:var(--surface-3); border-radius:99px; overflow:hidden; display:flex; margin:16px 0 20px; border:1px solid var(--line-2);">
    @foreach($categories as $cat)
      @if($cat['percentage'] > 0)
        <div style="width:{{ $cat['percentage'] }}%; background:{{ $cat['color'] }}; height:100%; transition:width 0.4s ease;" title="{{ $cat['name'] }}: {{ $cat['formatted_size'] }} ({{ $cat['percentage'] }}%)"></div>
      @endif
    @endforeach
  </div>

  <!-- Category Legend Grid -->
  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:14px;">
    @foreach($categories as $cat)
      <div style="background:var(--surface-3); border:1px solid var(--line); border-radius:14px; padding:14px; display:flex; align-items:center; gap:12px;">
        <div style="width:12px; height:12px; border-radius:4px; background:{{ $cat['color'] }}; flex-shrink:0;"></div>
        <div style="flex:1; min-width:0;">
          <div style="font-size:0.8rem; font-weight:700; color:var(--ink); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $cat['name'] }}</div>
          <div style="font-size:0.72rem; color:var(--ink-3); margin-top:2px;">{{ $cat['formatted_size'] }} · {{ $cat['files'] }} file ({{ $cat['percentage'] }}%)</div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- Top Largest Files Table -->
<div class="panel" style="margin-bottom:24px;">
  <div class="panel-head">
    <div>
      <h2>10 File Terbesar di Hosting</h2>
      <p class="visitor-subtitle">Daftar file berukuran paling besar yang memerlukan pemantauan.</p>
    </div>
  </div>

  <div class="data-table" style="border:none; padding:0;">
    <table>
      <thead>
        <tr>
          <th>Nama File</th>
          <th>Kategori</th>
          <th>Ukuran</th>
          <th>Tanggal Unggah</th>
          <th>Pratinjau</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($topFiles as $file)
          <tr>
            <td>
              <strong style="color:var(--ink); font-size:0.86rem; word-break:break-all;">{{ $file['name'] }}</strong>
            </td>
            <td><span class="status-pill st-proses" style="background:rgba(255,255,255,0.06); color:var(--ink-2);">{{ $file['category'] }}</span></td>
            <td><strong style="color:var(--amber);">{{ $file['formatted_size'] }}</strong></td>
            <td><small style="color:var(--ink-3);">{{ date('d M Y, H:i', $file['mtime']) }}</small></td>
            <td>
              <a href="{{ route('media.serve', ['path' => preg_replace('#^storage/#', '', $file['path'])]) }}" target="_blank" class="btn-sm btn-ghost" style="padding:4px 10px; font-size:0.72rem;">
                <svg class="icon"><use href="#i-eye"/></svg> Buka File
              </a>
            </td>
            <td>
              <form method="POST" action="{{ route('admin.storage.destroy') }}" onsubmit="return confirm('Hapus file ini dari penyimpanan? Data yang mengarah ke file ini akan dikosongkan.');">
                @csrf @method('DELETE')
                <input type="hidden" name="path" value="{{ preg_replace('#^storage/#', '', $file['path']) }}">
                <button type="submit" class="btn-sm btn-delete">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align:center; color:var(--ink-3); padding:24px 0;">Belum ada file diunggah di ruang penyimpanan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Optimization Tips Panel -->
<div class="panel">
  <div class="panel-head">
    <h2>💡 Tips Penghematan Ruang Penyimpanan Hosting</h2>
  </div>
  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:14px; margin-top:10px;">
    <div style="background:var(--surface-3); border:1px solid var(--line); border-radius:14px; padding:16px;">
      <h3 style="font-size:0.88rem; font-weight:700; color:var(--emerald); margin-bottom:6px;">1. Kompresi Foto Sebelum Unggah</h3>
      <p style="font-size:0.78rem; color:var(--ink-3); line-height:1.5;">Gunakan alat kompresi gambar gratis seperti TinyPNG atau WebP sebelum mengunggah foto berita atau produk UMKM agar ukuran file di bawah 1 MB.</p>
    </div>
    <div style="background:var(--surface-3); border:1px solid var(--line); border-radius:14px; padding:16px;">
      <h3 style="font-size:0.88rem; font-weight:700; color:var(--sky); margin-bottom:6px;">2. Gunakan Resolusi Proporsional</h3>
      <p style="font-size:0.78rem; color:var(--ink-3); line-height:1.5;">Foto untuk berita dan galeri cukup beresolusi Full HD (1920x1080 px). Hindari mengunggah foto mentah berukuran 10MB+ langsung dari kamera HP.</p>
    </div>
    <div style="background:var(--surface-3); border:1px solid var(--line); border-radius:14px; padding:16px;">
      <h3 style="font-size:0.88rem; font-weight:700; color:var(--amber); margin-bottom:6px;">3. Bersihkan Berkas Tidak Terpakai</h3>
      <p style="font-size:0.78rem; color:var(--ink-3); line-height:1.5;">Secara berkala hapus berita atau draft produk lama yang sudah tidak ditayangkan untuk menjaga performa hosting tetap cepat.</p>
    </div>
  </div>
</div>

@endsection

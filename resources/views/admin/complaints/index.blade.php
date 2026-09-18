@extends('layouts.admin')

@section('title', 'Pengaduan')
@section('page-title', 'Pengaduan Warga')
@section('page-subtitle', 'Tinjau laporan warga dan perbarui status penanganannya.')

@section('content')
<div class="toolbar">
  <div class="filter-tabs">
    <a href="{{ route('admin.complaints.index') }}" class="{{ request('status') ? '' : 'active' }}">Semua</a>
    @foreach(['Baru', 'Diproses', 'Selesai'] as $status)
      <a href="{{ route('admin.complaints.index', ['status' => $status]) }}" class="{{ request('status') === $status ? 'active' : '' }}">{{ $status }}</a>
    @endforeach
  </div>
</div>

<!-- Storage Archive Reminder Banner -->
<div style="background:rgba(129, 140, 248, 0.08); border:1px solid rgba(129, 140, 248, 0.22); border-radius:16px; padding:16px 20px; margin-top:16px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
  <div style="display:flex; align-items:center; gap:14px;">
    <div style="width:40px; height:40px; border-radius:12px; background:var(--violet-soft); color:var(--violet); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
      <svg class="icon" style="font-size:1.25rem;"><use href="#i-aduan"/></svg>
    </div>
    <div>
      <div style="font-size:0.88rem; font-weight:800; color:var(--ink);">💡 Pengingat Arsip Pengaduan Warga</div>
      <div style="font-size:0.78rem; color:var(--ink-3); margin-top:3px; line-height:1.4;">Simpan foto/berkas bukti dari pengaduan yang berstatus <strong>Selesai</strong> ke komputer lokal jika sudah ditindaklanjuti.</div>
    </div>
  </div>
  <a href="{{ route('admin.storage.index') }}" class="btn-sm btn-ghost" style="white-space:nowrap; text-decoration:none;">
    <svg class="icon"><use href="#i-storage"/></svg> Cek Kapasitas Disk
  </a>
</div>

<div class="stat-grid" style="margin:18px 0 24px;">
  <div class="stat-card">
    <div class="num" style="color:var(--ink);">{{ $stats['total'] }}</div>
    <div class="label">Total Pengaduan</div>
  </div>
  <div class="stat-card">
    <div class="num" style="color:var(--rose);">{{ $stats['baru'] }}</div>
    <div class="label">Baru</div>
  </div>
  <div class="stat-card">
    <div class="num" style="color:var(--amber);">{{ $stats['diproses'] }}</div>
    <div class="label">Diproses</div>
  </div>
  <div class="stat-card">
    <div class="num" style="color:var(--emerald);">{{ $stats['selesai'] }}</div>
    <div class="label">Selesai</div>
  </div>
</div>

<div style="margin-bottom:16px; font-weight:700; color:var(--ink-main);">Ringkasan Status</div>

<div class="data-table">
  <table>
    <thead><tr><th>Pelapor</th><th>Kategori</th><th>Isi Aduan</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($complaints as $complaint)
        <tr>
          <td><strong>{{ $complaint->nama }}</strong><br><small>{{ $complaint->kontak ?: 'Kontak tidak dicantumkan' }}</small></td>
          <td>{{ $complaint->kategori }}</td>
          <td style="max-width:360px;">{{ Str::limit($complaint->isi, 120) }}
            @if ($complaint->photo_paths)
              <div style="margin-top:8px; display:flex; flex-wrap:wrap; gap:6px;">
                @foreach ($complaint->photo_paths as $photoPath)
                  <a href="{{ Storage::url($photoPath) }}" target="_blank" rel="noopener">Lihat foto</a>
                @endforeach
              </div>
            @endif
          </td>
          <td><span class="status-pill {{ $complaint->status === 'Selesai' ? 'st-selesai' : ($complaint->status === 'Diproses' ? 'st-proses' : 'st-baru') }}">{{ $complaint->status }}</span></td>
          <td><form method="POST" action="{{ route('admin.complaints.status', $complaint) }}" class="status-form">@csrf @method('PATCH')<select name="status" onchange="this.form.submit()"><option {{ $complaint->status === 'Baru' ? 'selected' : '' }}>Baru</option><option {{ $complaint->status === 'Diproses' ? 'selected' : '' }}>Diproses</option><option {{ $complaint->status === 'Selesai' ? 'selected' : '' }}>Selesai</option></select></form></td>
        </tr>
      @empty
        <tr><td colspan="5" style="text-align:center; color:var(--text-muted); padding:30px 0;">Belum ada pengaduan warga.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div style="margin-top:18px;">{{ $complaints->links() }}</div>
@endsection

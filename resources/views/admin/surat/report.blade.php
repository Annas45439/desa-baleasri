@extends('layouts.admin')

@section('title', 'Laporan Surat')
@section('page-title', 'Laporan Pengajuan Surat')
@section('page-subtitle', 'Rekapitulasi pengajuan surat warga dan statistik penanganannya.')

@section('content')

<a href="{{ route('admin.letters.index') }}" class="btn-sm btn-ghost" style="margin-bottom:20px; text-decoration:none; display:inline-flex;">
  &larr; Kembali ke Daftar Surat
</a>

<!-- Filter Form -->
<div class="form-card" style="margin-bottom:30px; max-width:100%;">
  <form method="GET" action="{{ route('admin.letters.report') }}" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:15px; align-items:flex-end;">

    <div class="form-row" style="margin-bottom:0;">
      <label>Periode</label>
      <select name="period">
        <option value="monthly" {{ request('period') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
        <option value="yearly" {{ request('period') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
      </select>
    </div>

    <div class="form-row" style="margin-bottom:0;">
      <label>Tahun</label>
      <select name="year">
        @for ($y = date('Y'); $y >= 2020; $y--)
          <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
      </select>
    </div>

    <div class="form-row" id="month-filter" style="margin-bottom:0; {{ request('period') === 'yearly' ? 'display:none' : '' }}">
      <label>Bulan</label>
      <select name="month">
        @for ($m = 1; $m <= 12; $m++)
          <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ request('month', date('m')) == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
            {{ \Illuminate\Support\Carbon::createFromFormat('m', $m)->translatedFormat('F') }}
          </option>
        @endfor
      </select>
    </div>

    <div style="display:flex; gap:10px;">
      <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Filter</button>
      <a href="{{ route('admin.letters.export-report', ['period' => request('period', 'monthly'), 'year' => request('year', date('Y')), 'month' => request('month', date('m'))]) }}" class="btn btn-ghost" style="text-decoration:none; white-space:nowrap; justify-content:center;">
        📥 Export CSV
      </a>
    </div>

  </form>
</div>

<!-- Statistics -->
<div class="stat-grid">
  <div class="stat-card">
    <div class="num" style="color:var(--emerald);">{{ $stats['total'] }}</div>
    <div class="label">Total Pengajuan</div>
  </div>
  <div class="stat-card">
    <div class="num" style="color:var(--emerald);">{{ $stats['selesai'] }}</div>
    <div class="label">Selesai</div>
  </div>
  <div class="stat-card">
    <div class="num" style="color:var(--amber);">
      @if ($stats['total'] > 0)
        {{ round($stats['selesai'] / $stats['total'] * 100) }}%
      @else
        0%
      @endif
    </div>
    <div class="label">Tingkat Penyelesaian</div>
  </div>
</div>

<div class="form-card" style="margin-bottom:30px; max-width:100%;">
  <h3 style="margin-top:0; color:var(--ink);">Pengaduan</h3>
  <div class="stat-grid" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="num" style="color:var(--emerald);">{{ $complaintStats['total'] }}</div>
      <div class="label">Total Pengaduan</div>
    </div>
    <div class="stat-card">
      <div class="num" style="color:var(--sky);">{{ $complaintStats['diproses'] }}</div>
      <div class="label">Diproses</div>
    </div>
    <div class="stat-card">
      <div class="num" style="color:var(--emerald);">{{ $complaintStats['selesai'] }}</div>
      <div class="label">Selesai</div>
    </div>
  </div>
</div>

<!-- Breakdown by Type -->
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:20px; margin-bottom:30px;">

  <div class="form-card" style="max-width:100%;">
    <h3 style="margin-top:0;">Berdasarkan Jenis Surat</h3>
    <table style="width:100%; font-size:0.9rem;">
      <tr style="border-bottom:1px solid var(--line);">
        <th style="text-align:left; padding:10px 0;">Jenis</th>
        <th style="text-align:right; padding:10px 0;">Jumlah</th>
      </tr>
      @forelse ($stats['by_jenis'] as $jenis => $count)
      <tr style="border-bottom:1px solid var(--line);">
        <td style="padding:10px 0;">{{ $jenis }}</td>
        <td style="text-align:right; padding:10px 0; font-weight:bold;">{{ $count }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="2" style="padding:10px 0; text-align:center; color:var(--ink-muted);">Belum ada data</td>
      </tr>
      @endforelse
    </table>
  </div>

  <div class="form-card" style="max-width:100%;">
    <h3 style="margin-top:0;">Berdasarkan Status</h3>
    <table style="width:100%; font-size:0.9rem;">
      <tr style="border-bottom:1px solid var(--line);">
        <th style="text-align:left; padding:10px 0;">Status</th>
        <th style="text-align:right; padding:10px 0;">Jumlah</th>
      </tr>
      @forelse ($stats['by_status'] as $status => $count)
      <tr style="border-bottom:1px solid var(--line);">
        <td style="padding:10px 0;">{{ $status }}</td>
        <td style="text-align:right; padding:10px 0; font-weight:bold;">{{ $count }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="2" style="padding:10px 0; text-align:center; color:var(--ink-muted);">Belum ada data</td>
      </tr>
      @endforelse
    </table>
  </div>

</div>

<!-- Detailed List -->
<div class="form-card" style="max-width:100%;">
  <h3 style="margin-top:0; margin-bottom:14px;">Detail Pengajuan</h3>

  <div class="data-table">
    <table>
      <thead>
        <tr>
          <th>Ref. Nomor</th>
          <th>Nama</th>
          <th>Jenis Surat</th>
          <th>Status</th>
          <th>Tgl. Pengajuan</th>
          <th>Nomor Surat</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($letters as $letter)
        <tr>
          <td><strong>{{ $letter->ref_number }}</strong></td>
          <td>{{ $letter->nama_lengkap }}</td>
          <td>{{ $letter->jenis_surat }}</td>
          <td>
            <span class="status-pill {{ in_array($letter->status, ['Siap Diambil', 'Selesai']) ? 'st-selesai' : ($letter->status === 'Diproses' ? 'st-proses' : 'st-baru') }}">
              {{ $letter->status }}
            </span>
          </td>
          <td><small>{{ $letter->tanggal_pengajuan->format('d M Y') }}</small></td>
          <td>{{ $letter->nomor_surat ?? '-' }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="empty-state">Belum ada data untuk periode yang dipilih.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>

<script>
document.querySelector('select[name="period"]')?.addEventListener('change', function() {
  const monthFilter = document.getElementById('month-filter');
  if (monthFilter) monthFilter.style.display = this.value === 'yearly' ? 'none' : 'block';
});
</script>

@endsection

@extends('layouts.admin')

@section('content')

<a href="{{ route('admin.letters.index') }}" style="color:var(--jade-main); text-decoration:none; margin-bottom:20px; display:inline-block;">
  ← Kembali ke Daftar Surat
</a>

<h1 style="font-family:var(--font-title); font-weight:800; font-size:2rem; margin:20px 0;">
  Laporan Pengajuan Surat
</h1>

<!-- Filter Form -->
<div class="form-card" style="margin-bottom:30px;">
  <form method="GET" action="{{ route('admin.letters.report') }}" style="display:grid; grid-template-columns:1fr 1fr 1fr 1fr auto; gap:15px; align-items:flex-end;">

    <div>
      <label style="display:block; font-weight:600; margin-bottom:8px;">Periode</label>
      <select name="period" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
        <option value="monthly" {{ request('period') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
        <option value="yearly" {{ request('period') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
      </select>
    </div>

    <div>
      <label style="display:block; font-weight:600; margin-bottom:8px;">Tahun</label>
      <select name="year" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
        @for ($y = date('Y'); $y >= 2020; $y--)
          <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
      </select>
    </div>

    <div id="month-filter" style="{{ request('period') === 'yearly' ? 'display:none' : '' }}">
      <label style="display:block; font-weight:600; margin-bottom:8px;">Bulan</label>
      <select name="month" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
        @for ($m = 1; $m <= 12; $m++)
          <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ request('month', date('m')) == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
            {{ \Illuminate\Support\Carbon::createFromFormat('m', $m)->translatedFormat('F') }}
          </option>
        @endfor
      </select>
    </div>

    <div>
      <button type="submit" class="btn btn-primary" style="width:100%;">Filter</button>
    </div>

    <div>
      <a href="{{ route('admin.letters.export-report', ['period' => request('period', 'monthly'), 'year' => request('year', date('Y')), 'month' => request('month', date('m'))]) }}" class="btn btn-secondary" style="display:inline-block; text-decoration:none; width:100%; text-align:center;">
        📥 Export CSV
      </a>
    </div>

  </form>
</div>

<!-- Statistics -->
<div class="stat-grid" style="grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));">
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

<div class="form-card" style="margin-bottom:30px;">
  <h3 style="margin-top:0; color:var(--ink);">Pengaduan</h3>
  <div class="stat-grid" style="grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); margin-bottom:0;">
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
<div style="display:grid; grid-template-columns:1fr 1fr; gap:30px; margin-bottom:30px;">

  <div class="form-card">
    <h3 style="margin-top:0;">Berdasarkan Jenis Surat</h3>
    <table style="width:100%; font-size:0.9rem;">
      <tr style="border-bottom:1px solid #e0e0e0;">
        <th style="text-align:left; padding:10px 0;">Jenis</th>
        <th style="text-align:right; padding:10px 0;">Jumlah</th>
      </tr>
      @forelse ($stats['by_jenis'] as $jenis => $count)
      <tr style="border-bottom:1px solid #e0e0e0;">
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

  <div class="form-card">
    <h3 style="margin-top:0;">Berdasarkan Status</h3>
    <table style="width:100%; font-size:0.9rem;">
      <tr style="border-bottom:1px solid #e0e0e0;">
        <th style="text-align:left; padding:10px 0;">Status</th>
        <th style="text-align:right; padding:10px 0;">Jumlah</th>
      </tr>
      @forelse ($stats['by_status'] as $status => $count)
      <tr style="border-bottom:1px solid #e0e0e0;">
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
<div class="form-card">
  <h3 style="margin-top:0;">Detail Pengajuan</h3>

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
            <span style="display:inline-block; padding:4px 10px; border-radius:16px; font-size:0.8rem; font-weight:600; color:white;
              background-color:
              @if ($letter->status === 'Baru') #ffc107
              @elseif ($letter->status === 'Diproses') #2196F3
              @elseif ($letter->status === 'Siap Diambil') #10b981
              @elseif ($letter->status === 'Selesai') #888
              @elseif ($letter->status === 'Ditolak') #dc3545
              @else #999 @endif;">
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
document.querySelector('select[name="period"]').addEventListener('change', function() {
  document.getElementById('month-filter').style.display = this.value === 'yearly' ? 'none' : 'block';
});
</script>

@endsection

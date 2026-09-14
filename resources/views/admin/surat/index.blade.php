@extends('layouts.admin')

@section('content')

<h1 style="font-family:var(--font-title); font-weight:800; font-size:2rem; margin-bottom:30px;">
  Manajemen Surat
</h1>

<!-- Stats Cards -->
<div class="stat-grid" style="grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));">
  <div class="stat-card">
    <div class="num" style="color:var(--emerald);">{{ $stats['total'] }}</div>
    <div class="label">Total Pengajuan</div>
  </div>
  <div class="stat-card">
    <div class="num" style="color:var(--amber);">{{ $stats['baru'] }}</div>
    <div class="label">Baru</div>
  </div>
  <div class="stat-card">
    <div class="num" style="color:var(--sky);">{{ $stats['diproses'] }}</div>
    <div class="label">Diproses</div>
  </div>
  <div class="stat-card">
    <div class="num" style="color:var(--emerald);">{{ $stats['siap'] }}</div>
    <div class="label">Siap Diambil</div>
  </div>
  <div class="stat-card">
    <div class="num" style="color:var(--ink-2);">{{ $stats['selesai'] }}</div>
    <div class="label">Selesai</div>
  </div>
</div>

<!-- Buttons -->
<div style="display:flex; gap:10px; margin-bottom:20px;">
  <a href="{{ route('admin.letters.report') }}" class="btn btn-secondary" style="text-decoration:none;">
    <svg class="icon"><use href="#i-report"/></svg> Lihat Laporan
  </a>
</div>

@if (session('success'))
  <div style="background:#efe; border:1px solid #cfc; border-radius:8px; padding:15px; margin-bottom:20px; color:#060;">
    {{ session('success') }}
  </div>
@endif

<!-- Letters Table -->
<div class="data-table">
  <table>
    <thead>
      <tr>
        <th>Ref. Nomor</th>
        <th>Nama / NIK</th>
        <th>Jenis Surat</th>
        <th>Status</th>
        <th>Tgl. Pengajuan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($letters as $letter)
      <tr>
        <td>
          <strong>{{ $letter->ref_number }}</strong>
        </td>
        <td class="letter-actions">
          <strong>{{ $letter->nama_lengkap }}</strong><br>
          <small>{{ $letter->nik }}</small>
        </td>
        <td>{{ $letter->jenis_surat }}</td>
        <td>
          <span style="display:inline-block; padding:6px 12px; border-radius:20px; font-size:0.85rem; font-weight:600; color:white;
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
        <td>
          <small>{{ $letter->tanggal_pengajuan->format('d M Y H:i') }}</small>
        </td>
        <td>
          <a href="{{ route('admin.letters.edit', $letter) }}" class="btn-sm btn-primary" style="text-decoration:none;">
            Edit
          </a>
          <a href="{{ $letter->wa_notify_url }}" target="_blank" class="btn-sm" style="text-decoration:none; background:#25d366; color:#075e54; font-weight:700;">
            <svg class="icon"><use href="#i-message"/></svg> WA
          </a>
          <form method="POST" action="{{ route('admin.letters.destroy', $letter) }}" style="display:inline;" onsubmit="return confirm('Hapus pengajuan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-sm btn-delete">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="empty-state">Belum ada pengajuan surat.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
{{ $letters->links() }}

@endsection

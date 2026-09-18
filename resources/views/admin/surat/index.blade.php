@extends('layouts.admin')

@section('title', 'Layanan Surat')
@section('page-title', 'Layanan Surat')
@section('page-subtitle', 'Kelola pengajuan surat warga dan status penerbitannya.')

@section('content')

<!-- Stats Cards -->
<div class="stat-grid">
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

<!-- Storage Archive Reminder Banner -->
<div style="background:rgba(16, 185, 129, 0.08); border:1px solid rgba(16, 185, 129, 0.22); border-radius:16px; padding:16px 20px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
  <div style="display:flex; align-items:center; gap:14px;">
    <div style="width:40px; height:40px; border-radius:12px; background:var(--emerald-glow); color:var(--emerald); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
      <svg class="icon" style="font-size:1.25rem;"><use href="#i-storage"/></svg>
    </div>
    <div>
      <div style="font-size:0.88rem; font-weight:800; color:var(--ink);">💡 Pengingat Hemat Penyimpanan Hosting</div>
      <div style="font-size:0.78rem; color:var(--ink-3); margin-top:3px; line-height:1.4;">Disarankan untuk segera mengunduh / menyimpan berkas surat yang berstatus <strong>Selesai</strong> ke komputer lokal agar ruang disk hosting tidak menumpuk.</div>
    </div>
  </div>
  <a href="{{ route('admin.letters.report') }}" class="btn-sm btn-primary" style="white-space:nowrap; text-decoration:none;">
    <svg class="icon"><use href="#i-report"/></svg> Rekap Laporan
  </a>
</div>

@if (session('success'))
  <div style="background:var(--emerald-glow); border:1px solid var(--emerald); border-radius:12px; padding:14px 18px; margin-bottom:20px; color:var(--emerald); font-weight:600; font-size:0.88rem;">
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
          <span class="status-pill {{ in_array($letter->status, ['Siap Diambil', 'Selesai']) ? 'st-selesai' : ($letter->status === 'Diproses' ? 'st-proses' : 'st-baru') }}">
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

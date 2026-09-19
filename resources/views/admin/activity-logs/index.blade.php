@extends('layouts.admin')

@section('title', 'Audit Log Aktivitas Admin')
@section('page-title', 'Audit Log Aktivitas Petugas Desa')
@section('page-subtitle', 'Catatan riwayat aksi dan tindakan petugas desa di panel admin.')

@section('content')
<div class="card" style="margin-bottom: 24px;">
  <!-- Filter & Search Bar -->
  <form method="GET" action="{{ route('admin.activity-logs.index') }}" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center; justify-content:space-between;">
    <div style="display:flex; flex-wrap:wrap; gap:12px; flex-grow:1;">
      <div style="min-width: 240px; flex-grow: 1;">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama petugas, kata kunci aksi, atau IP address..." class="input" style="width:100%; height:40px; font-size:0.85rem;">
      </div>
      <div style="width: 200px;">
        <select name="action" class="input" style="width:100%; height:40px; font-size:0.85rem;" onchange="this.form.submit()">
          <option value="">-- Semua Aksi --</option>
          @foreach($actionTypes as $type)
            <option value="{{ $type }}" {{ $actionFilter === $type ? 'selected' : '' }}>{{ $type }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div style="display:flex; gap:8px;">
      <button type="submit" class="btn btn-emerald" style="height:40px; padding:0 18px; font-size:0.85rem; font-weight:700;">Filter</button>
      @if($search || $actionFilter)
        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-ghost" style="height:40px; padding:0 14px; font-size:0.85rem; display:inline-flex; align-items:center;">Reset</a>
      @endif
    </div>
  </form>
</div>

<div class="card" style="padding:0; overflow:hidden;">
  <div class="table-responsive">
    <table class="table" style="width:100%; border-collapse:collapse; font-size:0.85rem;">
      <thead>
        <tr style="background:var(--bg-subtle); border-bottom:1.5px solid var(--line);">
          <th style="padding:14px 16px; width:175px;">Waktu (WIB)</th>
          <th style="padding:14px 16px; width:180px;">Petugas / Staff</th>
          <th style="padding:14px 16px; width:150px;">Kategori Aksi</th>
          <th style="padding:14px 16px;">Deskripsi Tindakan</th>
          <th style="padding:14px 16px; width:120px; text-align:right;">IP Address</th>
        </tr>
      </thead>
      <tbody>
        @forelse($logs as $log)
          <tr style="border-bottom:1px solid var(--line);">
            <td style="padding:14px 16px; white-space:nowrap; color:var(--ink-3);">
              <div style="font-weight:700; color:var(--ink-main);">
                {{ $log->created_at ? $log->created_at->translatedFormat('d M Y') : '-' }}
              </div>
              <div style="font-size:0.75rem; color:var(--ink-4); margin-top:2px;">
                {{ $log->created_at ? $log->created_at->format('H:i:s') . ' WIB' : '-' }}
              </div>
            </td>

            <td style="padding:14px 16px;">
              <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:50%; background:var(--emerald-soft); color:var(--emerald-deep); font-weight:800; font-size:0.75rem; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                  {{ strtoupper(substr($log->user_name ?? 'S', 0, 2)) }}
                </div>
                <div>
                  <div style="font-weight:700; color:var(--ink-main);">{{ $log->user_name }}</div>
                  <div style="font-size:0.72rem; color:var(--ink-4);">{{ $log->user ? $log->user->role : 'Petugas' }}</div>
                </div>
              </div>
            </td>

            <td style="padding:14px 16px;">
              @php
                $badgeBg = 'rgba(13,138,108,0.12)';
                $badgeColor = 'var(--emerald)';
                
                if (str_contains($log->action, 'LOGIN') || str_contains($log->action, 'LOGOUT')) {
                    $badgeBg = 'rgba(59,130,246,0.12)';
                    $badgeColor = '#2563eb';
                } elseif (str_contains($log->action, 'DELETE') || str_contains($log->action, 'HAPUS')) {
                    $badgeBg = 'rgba(225,29,72,0.12)';
                    $badgeColor = '#e11d48';
                } elseif (str_contains($log->action, 'UPDATE') || str_contains($log->action, 'EDIT')) {
                    $badgeBg = 'rgba(245,158,11,0.12)';
                    $badgeColor = '#d97706';
                }
              @endphp
              <span style="font-size:0.72rem; font-weight:800; background:{{ $badgeBg }}; color:{{ $badgeColor }}; padding:4px 10px; border-radius:99px; text-transform:uppercase; letter-spacing:0.03em;">
                {{ $log->action }}
              </span>
            </td>

            <td style="padding:14px 16px; line-height:1.5; color:var(--ink-main); font-weight:500;">
              {{ $log->description }}
            </td>

            <td style="padding:14px 16px; text-align:right; font-family:monospace; font-size:0.78rem; color:var(--ink-4);">
              {{ $log->ip_address ?: '127.0.0.1' }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="padding:40px; text-align:center; color:var(--ink-4);">
              <div style="font-weight:700; font-size:0.95rem; margin-bottom:4px;">Belum Ada Riwayat Aktivitas</div>
              <div style="font-size:0.82rem;">Riwayat tindakan admin akan otomatis muncul di sini setelah petugas melakukan aktivitas di panel admin.</div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($logs->hasPages())
    <div style="padding:16px 20px; border-top:1px solid var(--line);">
      {{ $logs->links() }}
    </div>
  @endif
</div>
@endsection

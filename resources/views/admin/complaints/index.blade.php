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

<div class="data-table">
  <table>
    <thead><tr><th>Pelapor</th><th>Kategori</th><th>Isi Aduan</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($complaints as $complaint)
        <tr>
          <td><strong>{{ $complaint->nama }}</strong><br><small>{{ $complaint->kontak ?: 'Kontak tidak dicantumkan' }}</small></td>
          <td>{{ $complaint->kategori }}</td>
          <td style="max-width:360px;">{{ Str::limit($complaint->isi, 120) }}</td>
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

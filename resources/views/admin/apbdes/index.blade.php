@extends('layouts.admin')
@section('title', 'APBDes')
@section('page-title', 'APBDes')
@section('page-subtitle', 'Kelola pendapatan, belanja, dan pembiayaan desa.')
@section('content')
<div class="panel">
  <div class="panel-head"><h2>Data APBDes {{ request('tahun', now()->year) }}</h2><span class="status-pill st-selesai">{{ $apbdes->count() }} item</span></div>
  <form method="GET" class="toolbar"><label>Tahun <input type="number" name="tahun" value="{{ request('tahun', now()->year) }}" min="2000" max="2100"></label><button class="btn btn-primary" type="submit">Tampilkan</button></form>
  <div class="data-table" style="padding:0; border:0;"><table><thead><tr><th>Jenis</th><th>Nama</th><th>Anggaran</th><th>Realisasi</th><th>Aksi</th></tr></thead><tbody>
  @forelse($apbdes as $item)<tr><td>{{ $item->jenis }}</td><td><strong>{{ $item->nama }}</strong><br><small>{{ $item->keterangan }}</small></td><td>Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td><td>Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td><td><form method="POST" action="{{ route('admin.apbdes.destroy', $item) }}">@csrf @method('DELETE')<button class="btn-sm btn-delete" type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button></form></td></tr>@empty<tr><td colspan="5" class="empty-state">Belum ada data APBDes.</td></tr>@endforelse
  </tbody></table></div>
</div>
<div class="form-card" style="margin-top:22px; max-width:none;"><h3>Tambah Data APBDes</h3><form method="POST" action="{{ route('admin.apbdes.store') }}" class="form-grid-2">@csrf<div class="form-row"><label>Tahun</label><input type="number" name="tahun" value="{{ request('tahun', now()->year) }}" required></div><div class="form-row"><label>Jenis</label><select name="jenis" required><option>Pendapatan</option><option>Belanja</option><option>Pembiayaan</option></select></div><div class="form-row"><label>Nama Program</label><input type="text" name="nama" required></div><div class="form-row"><label>Anggaran</label><input type="number" name="anggaran" min="0" step="0.01" required></div><div class="form-row"><label>Realisasi</label><input type="number" name="realisasi" min="0" step="0.01" required></div><div class="form-row"><label>Keterangan</label><input type="text" name="keterangan"></div><div class="form-actions"><button class="btn btn-primary" type="submit">Simpan Data</button></div></form></div>
@endsection

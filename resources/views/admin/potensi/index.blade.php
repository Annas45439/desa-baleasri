@extends('layouts.admin')

@section('title', 'Potensi Desa')
@section('page-title', 'Potensi Desa')
@section('page-subtitle', 'Kelola data wisata, UMKM, dan galeri.')
@section('page-action')
  <a href="{{ route('admin.potensi.create') }}" class="btn btn-primary"><svg class="icon"><use href="#i-plus"/></svg> Tambah Potensi</a>
@endsection

@section('content')

<div class="toolbar">
  <div class="filter-tabs">
    <a href="{{ route('admin.potensi.index') }}" class="{{ request('kategori') ? '' : 'active' }}">Semua</a>
    <a href="{{ route('admin.potensi.index', ['kategori' => 'wisata']) }}" class="{{ request('kategori') === 'wisata' ? 'active' : '' }}">Wisata</a>
    <a href="{{ route('admin.potensi.index', ['kategori' => 'umkm']) }}" class="{{ request('kategori') === 'umkm' ? 'active' : '' }}">UMKM</a>
    <a href="{{ route('admin.potensi.index', ['kategori' => 'galeri']) }}" class="{{ request('kategori') === 'galeri' ? 'active' : '' }}">Galeri</a>
  </div>
</div>

<div class="data-table">
  <table>
    <thead>
      <tr><th>Foto</th><th>Nama</th><th>Kategori</th><th>Tag</th><th>Status</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($potensis as $p)
        <tr>
          <td><img class="thumb" src="{{ $p->foto ? asset('storage/'.$p->foto) : 'https://picsum.photos/seed/'.$p->slug.'/100/100' }}" alt=""></td>
          <td style="font-weight:700;">{{ $p->nama }}</td>
          <td style="text-transform:capitalize;">{{ $p->kategori }}</td>
          <td>{{ $p->tag ?? '-' }}</td>
          <td><span class="status-pill {{ $p->tampil ? 'st-selesai' : 'st-baru' }}">{{ $p->tampil ? 'Tayang' : 'Draft' }}</span></td>
          <td style="text-align:right; white-space:nowrap;">
            <a href="{{ route('admin.potensi.edit', $p) }}" class="btn-sm btn-edit">Edit</a>
            <form action="{{ route('admin.potensi.destroy', $p) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus {{ $p->nama }}?');">
              @csrf @method('DELETE')
              <button type="submit" class="btn-sm btn-delete">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px 0;">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

@if(request('kategori') === 'umkm' && request()->has('pendaftar'))
<div class="umkm-applicant-panel" id="pendaftar-umkm">
  <div class="filter-row"><h3 style="font-family:var(--font-display); font-size:1.15rem; font-weight:800;">Pendaftar UMKM</h3><span style="font-size:0.78rem; color:var(--text-muted);">{{ $umkmApplicants->where('status', 'Menunggu Persetujuan')->count() }} menunggu persetujuan</span></div>
  <div class="data-table" style="padding:0; border:0;">
    <table class="umkm-applicant-table"><thead><tr><th>Usaha</th><th>Pemilik</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
      @forelse($umkmApplicants as $applicant)
        <tr><td><strong>{{ $applicant->nama_usaha }}</strong><br><small>{{ $applicant->lokasi }}</small></td><td>{{ $applicant->pemilik }}<br><small>{{ $applicant->wa }}</small></td><td>{{ $applicant->kategori }}</td><td><span class="status-pill {{ $applicant->status === 'Disetujui' ? 'st-selesai' : ($applicant->status === 'Ditolak' ? 'st-baru' : 'st-proses') }}">{{ $applicant->status }}</span></td><td><div class="approval-actions"><form method="POST" action="{{ route('admin.umkm-applicants.status', $applicant) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="Disetujui"><button class="approval-btn approve" type="submit">Setujui</button></form><form method="POST" action="{{ route('admin.umkm-applicants.status', $applicant) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="Ditolak"><button class="approval-btn reject" type="submit">Tolak</button></form></div></td></tr>
      @empty
        <tr><td colspan="5" class="empty-state">Belum ada pendaftar UMKM.</td></tr>
      @endforelse
    </tbody></table>
  </div>
</div>
@endif

<div style="margin-top:18px;">
  {{ $potensis->links() }}
</div>

@endsection

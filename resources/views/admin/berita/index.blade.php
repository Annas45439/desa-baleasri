@extends('layouts.admin')

@section('title', 'Berita')
@section('page-title', 'Berita')
@section('page-subtitle', 'Kelola kabar & pengumuman desa.')
@section('page-action')
  <a href="{{ route('admin.berita.create') }}" class="btn btn-primary"><svg class="icon"><use href="#i-plus"/></svg> Tulis Berita</a>
@endsection

@section('content')

<div class="data-table">
  <table>
    <thead>
      <tr><th>Foto</th><th>Judul</th><th>Penulis</th><th>Tanggal</th><th>Status</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($beritas as $b)
        <tr>
          <td><img class="thumb" src="{{ storage_image_url($b->foto, 'https://picsum.photos/seed/'.$b->slug.'/100/100') }}" alt=""></td>
          <td style="font-weight:700;">{{ Str::limit($b->judul, 40) }}</td>
          <td>{{ $b->penulis ?? '-' }}</td>
          <td>{{ optional($b->tanggal_terbit)->translatedFormat('d M Y') }}</td>
          <td><span class="status-pill {{ $b->tampil ? 'st-selesai' : 'st-baru' }}">{{ $b->tampil ? 'Tayang' : 'Draft' }}</span></td>
          <td style="text-align:right; white-space:nowrap;">
            <a href="{{ route('admin.berita.edit', $b) }}" class="btn-sm btn-edit">Edit</a>
            <form action="{{ route('admin.berita.destroy', $b) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus berita ini?');">
              @csrf @method('DELETE')
              <button type="submit" class="btn-sm btn-delete">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px 0;">Belum ada berita.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:18px;">
  {{ $beritas->links() }}
</div>

@endsection

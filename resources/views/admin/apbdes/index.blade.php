@extends('layouts.admin')
@section('title', 'APBDes')
@section('page-title', 'APBDes')
@section('page-subtitle', 'Kelola pendapatan, belanja, dan pembiayaan desa.')
@section('content')

<div class="panel">
  <div class="panel-head">
    <h2>Data APBDes {{ request('tahun', now()->year) }}</h2>
    <span class="status-pill st-selesai">{{ $apbdes->count() }} item</span>
  </div>
  
  <form method="GET" class="toolbar" style="margin-bottom:16px;">
    <div style="display:flex; align-items:center; gap:10px;">
      <label style="font-size:0.83rem; font-weight:700; color:var(--ink-2);">Tahun:</label>
      <input type="number" name="tahun" value="{{ request('tahun', now()->year) }}" min="2000" max="2100" style="padding:6px 12px; border-radius:9px; border:1px solid var(--line-2); background:var(--surface-3); color:var(--ink); font-family:var(--font-body); width:110px;">
      <button class="btn btn-primary" type="submit" style="padding:7px 16px;">Tampilkan</button>
    </div>
  </form>

  <div class="data-table">
    <table>
      <thead>
        <tr>
          <th>Jenis</th>
          <th>Kategori / Sumber Dana</th>
          <th>Nama Program</th>
          <th>Anggaran</th>
          <th>Realisasi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($apbdes as $item)
          <tr>
            <td><span class="status-pill st-proses">{{ $item->jenis }}</span></td>
            <td><strong>{{ $item->kategori ?: 'Belum dikategorikan' }}</strong><br><small style="color:var(--ink-3);">{{ $item->sumber_dana ?: 'Sumber dana belum diisi' }}</small></td>
            <td><strong>{{ $item->nama }}</strong><br><small style="color:var(--ink-3);">{{ $item->keterangan }}</small></td>
            <td>Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
            <td>
              <details class="apbdes-edit-details">
                <summary class="btn-sm btn-ghost">Edit</summary>
                <form method="POST" action="{{ route('admin.apbdes.update', $item) }}" class="apbdes-edit-form">
                  @csrf
                  @method('PUT')
                  <div class="form-grid-2">
                    <div class="form-row">
                      <label>Tahun *</label>
                      <input type="number" name="tahun" value="{{ $item->tahun }}" min="2000" max="2100" required>
                    </div>
                    <div class="form-row">
                      <label>Jenis *</label>
                      <select name="jenis" required>
                        @foreach(['Pendapatan', 'Belanja', 'Pembiayaan'] as $type)
                          <option value="{{ $type }}" @selected($item->jenis === $type)>{{ $type }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-row">
                      <label>Kategori</label>
                      <input type="text" name="kategori" value="{{ $item->kategori }}" maxlength="120">
                    </div>
                    <div class="form-row">
                      <label>Sumber Dana</label>
                      <input type="text" name="sumber_dana" value="{{ $item->sumber_dana }}" maxlength="150">
                    </div>
                  </div>
                  <div class="form-row">
                    <label>Nama Program / Pos Anggaran *</label>
                    <input type="text" name="nama" value="{{ $item->nama }}" maxlength="180" required>
                  </div>
                  <div class="form-grid-2">
                    <div class="form-row">
                      <label>Anggaran (Rp) *</label>
                      <input type="number" name="anggaran" value="{{ $item->anggaran }}" min="0" step="0.01" required>
                    </div>
                    <div class="form-row">
                      <label>Realisasi (Rp) *</label>
                      <input type="number" name="realisasi" value="{{ $item->realisasi }}" min="0" step="0.01" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" value="{{ $item->keterangan }}" maxlength="1000">
                  </div>
                  <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </form>
              </details>
              <form method="POST" action="{{ route('admin.apbdes.destroy', $item) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn-sm btn-delete" type="submit" onclick="return confirm('Hapus data ini?')">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="empty-state">Belum ada data APBDes untuk tahun {{ request('tahun', now()->year) }}.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="form-card" style="margin-top:22px; max-width:100%;">
  <h3 style="margin-bottom:16px;">Tambah Data APBDes</h3>
  <form method="POST" action="{{ route('admin.apbdes.store') }}">
    @csrf
    <div class="form-grid-2">
      <div class="form-row">
        <label>Tahun *</label>
        <input type="number" name="tahun" value="{{ request('tahun', now()->year) }}" required>
      </div>
      <div class="form-row">
        <label>Kategori Anggaran</label>
        <input type="text" name="kategori" placeholder="Contoh: Pembangunan Desa / Dana Desa">
      </div>
      <div class="form-row">
        <label>Sumber Dana</label>
        <input type="text" name="sumber_dana" placeholder="Contoh: Dana Desa, ADD, PADes">
      </div>
      <div class="form-row">
        <label>Jenis *</label>
        <select name="jenis" required>
          <option>Pendapatan</option>
          <option>Belanja</option>
          <option>Pembiayaan</option>
        </select>
      </div>
    </div>
    
    <div class="form-row">
      <label>Nama Program / Pos Anggaran *</label>
      <input type="text" name="nama" placeholder="Contoh: Dana Desa / Pembangunan Jalan" required>
    </div>

    <div class="form-grid-2">
      <div class="form-row">
        <label>Anggaran (Rp) *</label>
        <input type="number" name="anggaran" min="0" step="0.01" required placeholder="0">
      </div>
      <div class="form-row">
        <label>Realisasi (Rp) *</label>
        <input type="number" name="realisasi" min="0" step="0.01" required placeholder="0">
      </div>
    </div>

    <div class="form-row">
      <label>Keterangan</label>
      <input type="text" name="keterangan" placeholder="Catatan tambahan (opsional)">
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Simpan Data APBDes</button>
    </div>
  </form>
</div>
@endsection

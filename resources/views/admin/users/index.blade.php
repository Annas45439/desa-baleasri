@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Pengguna Sistem')
@section('page-subtitle', 'Kelola akun perangkat desa & hak akses panel admin.')

@section('content')

{{-- Info kuota Super Admin --}}
@php
  $desaSuperAdminCount = \App\Models\User::where('role', \App\Models\User::ROLE_SUPER_ADMIN)->where('is_developer', false)->count();
@endphp

<div style="background:var(--surface-2); border:1px solid var(--line); border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:12px;">
  <span style="font-size:1.4rem;">🔐</span>
  <div>
    <strong style="color:var(--ink);">Super Admin Desa: {{ $desaSuperAdminCount }}/1 Aktif</strong>
    <p style="margin:2px 0 0; font-size:0.82rem; color:var(--ink-3);">
      Akun Super Admin Desa berhak mengelola seluruh berita, potensi UMKM, APBDes, serta menyetujui/mengubah status permohonan surat warga.
    </p>
  </div>
</div>

<div class="data-table" style="margin-bottom:30px;">
  <table>
    <thead>
      <tr>
        <th>Nama / Akun</th>
        <th>Email</th>
        <th>Role Hak Akses</th>
        <th>Bergabung</th>
        <th>Aksi & Password</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td>
          <strong>{{ $user->name }}</strong>
          @if($user->is(auth()->user()))
            <span class="status-pill st-selesai" style="margin-left:6px;">Akun Anda</span>
          @endif
          @if($user->isDeveloper())
            <span class="status-pill" style="margin-left:6px; background:#7c3aed; color:#fff;">🛡 Developer</span>
          @endif
        </td>
        <td>{{ $user->email }}</td>
        <td>
          <span class="status-pill {{ $user->isSuperAdmin() ? 'st-baru' : ($user->isAdmin() ? 'st-proses' : 'st-selesai') }}">
            {{ strtoupper(str_replace('_', ' ', $user->role)) }}
          </span>
        </td>
        <td><small style="color:var(--ink-3);">{{ $user->created_at?->format('d M Y') }}</small></td>
        <td>
          <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
            <details>
              <summary class="btn-sm btn-edit" style="cursor:pointer; list-style:none;">🔑 Ubah Password</summary>
              <a href="{{ route('admin.users.password.reauth', $user) }}" class="btn-sm btn-primary" style="margin-top:10px;">Verifikasi Google terlebih dahulu</a>
              <form method="POST" action="{{ route('admin.users.password', $user) }}" style="margin-top:10px; display:flex; gap:6px; flex-wrap:wrap; background:var(--surface-3); padding:12px; border-radius:10px; border:1px solid var(--line);">
                @csrf
                @method('PATCH')
                <input type="password" name="password" placeholder="Password baru" minlength="6" required style="max-width:140px; padding:6px 10px; font-size:0.8rem;">
                <input type="password" name="password_confirmation" placeholder="Ulangi password" minlength="6" required style="max-width:140px; padding:6px 10px; font-size:0.8rem;">
                <button class="btn-sm btn-primary" type="submit">Simpan</button>
              </form>
            </details>

            @unless($user->is(auth()->user()) || $user->isDeveloper())
              <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn-sm btn-delete" type="submit">Hapus</button>
              </form>
            @endunless

            @if($user->isDeveloper())
              <span style="font-size:0.75rem; color:var(--ink-3); font-style:italic;">Akun permanen</span>
            @endif
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="form-card" style="max-width:720px;">
  <h3 style="color:var(--ink); margin-bottom:4px;">Tambah Pengguna Baru</h3>
  <p style="font-size:0.83rem; color:var(--ink-3); margin-bottom:16px;">Super Admin hanya bisa ditambah jika kuota belum penuh (maks. 2).</p>

  <form method="POST" action="{{ route('admin.users.store') }}">
    @csrf

    <div class="form-grid-2">
      <div class="form-row">
        <label for="name">Nama Lengkap *</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required>
      </div>

      <div class="form-row">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="budi@gmail.com" required>
      </div>
    </div>

    <div class="form-grid-2">
      <div class="form-row">
        <label for="password">Password *</label>
        <input type="password" id="password" name="password" minlength="6" placeholder="Minimal 6 karakter" required>
      </div>

      <div class="form-row">
        <label for="role">Role / Hak Akses *</label>
        <select id="role" name="role" required>
          <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Kelola Konten & Layanan)</option>
          <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff / Petugas Desa</option>
          @if($canAddSuperAdmin)
            <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin (Slot: {{ 2 - $superAdminCount }} tersisa)</option>
          @endif
        </select>
        <small class="hint">
          @if($canAddSuperAdmin)
            Tersisa {{ 2 - $superAdminCount }} slot Super Admin.
          @else
            Kuota Super Admin penuh. Tambahkan sebagai Admin atau Staff.
          @endif
        </small>
      </div>
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Tambah Pengguna</button>
    </div>
  </form>
</div>

@endsection

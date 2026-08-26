@extends('layouts.admin')
@section('title', 'Pengguna')
@section('page-title', 'Pengguna Sistem')
@section('page-subtitle', 'Kelola akun yang dapat mengakses panel admin.')
@section('content')
<div class="data-table"><table><thead><tr><th>Nama</th><th>Email</th><th>Bergabung</th><th>Aksi</th></tr></thead><tbody>@foreach($users as $user)<tr><td><strong>{{ $user->name }}</strong>@if($user->is(auth()->user())) <span class="status-pill st-selesai">Anda</span>@endif</td><td>{{ $user->email }}</td><td>{{ $user->created_at?->format('d M Y') }}</td><td>@unless($user->is(auth()->user()))<form method="POST" action="{{ route('admin.users.destroy', $user) }}">@csrf @method('DELETE')<button class="btn-sm btn-delete" onclick="return confirm('Hapus pengguna ini?')">Hapus</button></form>@endunless</td></tr>@endforeach</tbody></table></div>
<div class="form-card" style="margin-top:22px; max-width:none;"><h3>Tambah Pengguna</h3><form method="POST" action="{{ route('admin.users.store') }}" class="form-grid-2">@csrf<div class="form-row"><label>Nama</label><input name="name" required></div><div class="form-row"><label>Email</label><input type="email" name="email" required></div><div class="form-row"><label>Password</label><input type="password" name="password" minlength="6" required></div><div class="form-actions"><button class="btn btn-primary" type="submit">Tambah Pengguna</button></div></form></div>
@endsection

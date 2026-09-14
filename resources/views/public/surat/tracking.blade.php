@extends('layouts.app')

@section('content')
<div style="max-width:700px; margin:60px auto; padding:0 20px;">

  <h1 style="font-family:var(--font-title); font-weight:800; font-size:2.2rem; margin-bottom:10px;">
    Cek Status Surat
  </h1>
  <p style="font-size:1.1rem; color:var(--ink-muted); margin-bottom:40px;">
    Ketikkan NIK, Email, atau No. Telepon Anda untuk melihat status pengajuan surat.
  </p>

  @if ($errors->any())
    <div style="background-color:#fee; border:1px solid #fcc; border-radius:8px; padding:15px; margin-bottom:30px;">
      <strong style="color:#c00;">{{ $errors->first() }}</strong>
    </div>
  @endif

  @if (session('success'))
    <div style="background-color:#efe; border:1px solid #cfc; border-radius:8px; padding:15px; margin-bottom:30px; color:#060;">
      {!! session('success') !!}
    </div>
  @endif

  <div style="background:white; border:1px solid #e0e0e0; border-radius:12px; padding:40px; box-shadow:0 1px 3px rgba(0,0,0,0.1); margin-bottom:30px;">

    <form method="POST" action="{{ route('letters.search') }}" style="display:flex; gap:10px; margin-bottom:30px;">
      @csrf

      <input type="text" name="search" placeholder="Masukkan NIK, Email, atau No. Telepon..." required
        style="flex:1; padding:12px 15px; border:1px solid #ddd; border-radius:6px; font-size:1rem;">

      <button type="submit" class="btn btn-primary" style="padding:12px 25px; font-size:1rem;">
        Cari Status
      </button>
    </form>

    <!-- Info Box -->
    <div style="background-color:#f9f9f9; border-left:4px solid var(--jade-main); padding:15px; border-radius:4px;">
      <p style="margin:0; color:var(--ink-muted); font-size:0.95rem;">
        💡 Anda bisa menggunakan NIK, Email, atau No. Telepon yang digunakan saat pengajuan surat.
      </p>
    </div>

  </div>

  <!-- Status Timeline Info -->
  <div style="background:white; border:1px solid #e0e0e0; border-radius:12px; padding:30px;">
    <h3 style="font-family:var(--font-title); margin-top:0;">Tahapan Status Surat</h3>

    <div style="display:flex; flex-direction:column; gap:15px;">

      <!-- Status 1 -->
      <div style="display:flex; gap:15px;">
        <div style="flex-shrink:0;">
          <div style="width:40px; height:40px; background:#ffc107; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">
            1
          </div>
        </div>
        <div>
          <strong style="display:block; margin-bottom:5px;">Baru</strong>
          <p style="margin:0; color:var(--ink-muted); font-size:0.95rem;">
            Pengajuan Anda baru diterima dan menunggu untuk diproses oleh admin.
          </p>
        </div>
      </div>

      <!-- Status 2 -->
      <div style="display:flex; gap:15px;">
        <div style="flex-shrink:0;">
          <div style="width:40px; height:40px; background:#2196F3; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">
            2
          </div>
        </div>
        <div>
          <strong style="display:block; margin-bottom:5px;">Diproses</strong>
          <p style="margin:0; color:var(--ink-muted); font-size:0.95rem;">
            Admin sedang memproses pengajuan surat Anda.
          </p>
        </div>
      </div>

      <!-- Status 3 -->
      <div style="display:flex; gap:15px;">
        <div style="flex-shrink:0;">
          <div style="width:40px; height:40px; background:#10b981; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">
            3
          </div>
        </div>
        <div>
          <strong style="display:block; margin-bottom:5px;">Siap Diambil</strong>
          <p style="margin:0; color:var(--ink-muted); font-size:0.95rem;">
            Surat Anda sudah siap! Anda bisa mengunduhnya atau mengambil langsung ke Kantor Desa.
          </p>
        </div>
      </div>

      <!-- Status 4 -->
      <div style="display:flex; gap:15px;">
        <div style="flex-shrink:0;">
          <div style="width:40px; height:40px; background:#888; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">
            ✓
          </div>
        </div>
        <div>
          <strong style="display:block; margin-bottom:5px;">Selesai</strong>
          <p style="margin:0; color:var(--ink-muted); font-size:0.95rem;">
            Proses pengajuan surat sudah selesai.
          </p>
        </div>
      </div>

    </div>

  </div>

</div>
@endsection

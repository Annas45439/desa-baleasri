@extends('layouts.app')

@section('content')
<div style="max-width:800px; margin:60px auto; padding:0 20px;">

  <a href="{{ route('letters.tracking') }}" style="color:var(--jade-main); text-decoration:none; margin-bottom:20px; display:inline-block;">
    ← Kembali ke Cek Status
  </a>

  <h1 style="font-family:var(--font-title); font-weight:800; font-size:2rem; margin:20px 0 10px;">
    Status Pengajuan Surat
  </h1>

  <!-- Status Badge -->
  <div style="display:inline-block; padding:8px 15px; border-radius:20px; font-weight:600; margin-bottom:30px; color:white;
    background-color:
    @if ($letter->status === 'Baru') #ffc107
    @elseif ($letter->status === 'Diproses') #2196F3
    @elseif ($letter->status === 'Siap Diambil') #10b981
    @elseif ($letter->status === 'Selesai') #888
    @elseif ($letter->status === 'Ditolak') #dc3545
    @else #999 @endif;">
    {{ $letter->status }}
  </div>

  <!-- Detail Card -->
  <div style="background:white; border:1px solid #e0e0e0; border-radius:12px; padding:30px; box-shadow:0 1px 3px rgba(0,0,0,0.1); margin-bottom:30px;">

    <!-- Reference Info -->
    <div style="background:#f9f9f9; padding:20px; border-radius:8px; margin-bottom:30px;">
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        <div>
          <label style="display:block; font-size:0.85rem; color:var(--ink-muted); font-weight:600; margin-bottom:5px;">NOMOR REFERENSI</label>
          <div style="font-size:1.3rem; font-weight:bold; font-family:monospace;">{{ $letter->ref_number }}</div>
        </div>
        <div>
          <label style="display:block; font-size:0.85rem; color:var(--ink-muted); font-weight:600; margin-bottom:5px;">JENIS SURAT</label>
          <div style="font-size:1.3rem; font-weight:bold;">{{ $letter->jenis_surat }}</div>
        </div>
      </div>
    </div>

    <!-- Data Pengajuan -->
    <h3 style="font-family:var(--font-title); font-weight:700; margin:30px 0 15px;">Data Pengajuan</h3>
    <table style="width:100%; border-collapse:collapse;">
      <tr style="border-bottom:1px solid #e0e0e0;">
        <td style="padding:12px 0; font-weight:600; width:35%; color:var(--ink-muted);">Nama Lengkap</td>
        <td style="padding:12px 0;">{{ $letter->nama_lengkap }}</td>
      </tr>
      <tr style="border-bottom:1px solid #e0e0e0;">
        <td style="padding:12px 0; font-weight:600; color:var(--ink-muted);">NIK</td>
        <td style="padding:12px 0;">{{ $letter->nik }}</td>
      </tr>
      <tr style="border-bottom:1px solid #e0e0e0;">
        <td style="padding:12px 0; font-weight:600; color:var(--ink-muted);">Email</td>
        <td style="padding:12px 0;">{{ $letter->email }}</td>
      </tr>
      <tr style="border-bottom:1px solid #e0e0e0;">
        <td style="padding:12px 0; font-weight:600; color:var(--ink-muted);">No. Telepon</td>
        <td style="padding:12px 0;">{{ $letter->no_telepon }}</td>
      </tr>
      <tr style="border-bottom:1px solid #e0e0e0;">
        <td style="padding:12px 0; font-weight:600; color:var(--ink-muted);">Keperluan</td>
        <td style="padding:12px 0;">{{ $letter->keperluan }}</td>
      </tr>
      <tr style="border-bottom:1px solid #e0e0e0;">
        <td style="padding:12px 0; font-weight:600; color:var(--ink-muted);">Tanggal Pengajuan</td>
        <td style="padding:12px 0;">{{ $letter->tanggal_pengajuan->translatedFormat('d F Y H:i') }}</td>
      </tr>
    </table>

    <!-- Informasi Proses -->
    @if ($letter->nomor_surat || $letter->tanggal_selesai || $letter->catatan_admin)
    <h3 style="font-family:var(--font-title); font-weight:700; margin:30px 0 15px;">Informasi Proses</h3>
    <table style="width:100%; border-collapse:collapse;">
      @if ($letter->nomor_surat)
      <tr style="border-bottom:1px solid #e0e0e0;">
        <td style="padding:12px 0; font-weight:600; color:var(--ink-muted); width:35%;">Nomor Surat</td>
        <td style="padding:12px 0; font-weight:bold; font-size:1.1rem;">{{ $letter->nomor_surat }}</td>
      </tr>
      @endif
      @if ($letter->tanggal_selesai)
      <tr style="border-bottom:1px solid #e0e0e0;">
        <td style="padding:12px 0; font-weight:600; color:var(--ink-muted);">Tanggal Selesai</td>
        <td style="padding:12px 0;">{{ $letter->tanggal_selesai->translatedFormat('d F Y H:i') }}</td>
      </tr>
      @endif
      @if ($letter->catatan_admin)
      <tr>
        <td style="padding:12px 0; font-weight:600; color:var(--ink-muted);">Catatan Admin</td>
        <td style="padding:12px 0;">{{ $letter->catatan_admin }}</td>
      </tr>
      @endif
    </table>
    @endif

    <!-- Download Button -->
    @if ($letter->status === 'Siap Diambil' || $letter->status === 'Selesai')
    <div style="margin-top:30px; padding-top:30px; border-top:1px solid #e0e0e0;">
      <a href="{{ route('letters.download-pdf', $letter) }}" class="btn btn-primary" style="display:inline-block; padding:12px 25px; text-decoration:none; font-weight:600;">
        📥 Unduh Surat
      </a>
      @if ($letter->dokumen_pendukung)
      <a href="{{ route('letters.download-dokumen', $letter) }}" class="btn btn-secondary" style="display:inline-block; padding:12px 25px; text-decoration:none; font-weight:600; margin-left:10px;">
        📎 Unduh Dokumen
      </a>
      @endif
    </div>
    @endif

  </div>

  <!-- Info Box -->
  <div style="background-color:#f0f8ff; border:1px solid #b3d9ff; border-radius:8px; padding:20px;">
    <h3 style="margin-top:0; color:#0066cc;">ℹ️ Informasi</h3>
    @if ($letter->status === 'Baru')
      <p>Pengajuan surat Anda sedang dalam antrian. Admin akan memproses dalam 1-2 hari kerja.</p>
    @elseif ($letter->status === 'Diproses')
      <p>Surat Anda sedang diproses oleh admin. Tunggu notifikasi email untuk perkembangan selanjutnya.</p>
    @elseif ($letter->status === 'Siap Diambil')
      <p>✅ Surat Anda sudah siap! Anda bisa mengunduhnya sekarang atau mengambilnya langsung ke Kantor Desa.</p>
      <p style="margin:10px 0 0; color:var(--ink-muted); font-size:0.9rem;">
        📍 Kantor Desa: {{ setting('alamat') }}<br>
        🕐 Jam Operasional: {{ setting('jam_operasional') }}
      </p>
    @elseif ($letter->status === 'Selesai')
      <p>✅ Proses pengajuan surat sudah selesai.</p>
    @elseif ($letter->status === 'Ditolak')
      <p style="color:#dc3545;">⚠️ Pengajuan surat Anda ditolak. Silakan hubungi Kantor Desa untuk informasi lebih lanjut.</p>
    @endif
  </div>

</div>
@endsection

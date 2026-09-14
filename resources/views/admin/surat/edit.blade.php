@extends('layouts.admin')

@section('content')

<a href="{{ route('admin.letters.index') }}" style="color:var(--jade-main); text-decoration:none; margin-bottom:20px; display:inline-block;">
  ← Kembali ke Daftar Surat
</a>

<h1 style="font-family:var(--font-title); font-weight:800; font-size:2rem; margin:20px 0;">
  Proses Pengajuan Surat
</h1>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:30px;">

  <!-- Main Form -->
  <div>

    @if ($errors->any())
      <div style="background:var(--rose-soft); border:1px solid var(--rose); color:var(--rose); border-radius:12px; padding:15px; margin-bottom:20px;">
        <strong style="color:var(--rose);">Ada kesalahan:</strong>
        <ul style="margin:10px 0 0 20px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (session('success'))
      <div style="background:var(--emerald-soft); border:1px solid var(--emerald); color:var(--emerald); border-radius:12px; padding:15px; margin-bottom:20px; font-weight:600;">
        {{ session('success') }}
      </div>
    @endif

    <!-- Data Pengaju -->
    <div class="form-card" style="margin-bottom:20px;">
      <h3 style="color:var(--ink); margin-bottom:16px;">Data Pengaju</h3>
      <div class="form-grid-2">
        <div class="form-row">
          <label>Nama Lengkap</label>
          <input type="text" value="{{ $letter->nama_lengkap }}" disabled style="opacity:0.85;">
        </div>
        <div class="form-row">
          <label>NIK</label>
          <input type="text" value="{{ $letter->nik }}" disabled style="opacity:0.85;">
        </div>
      </div>
      <div class="form-grid-2">
        <div class="form-row">
          <label>Email</label>
          <input type="email" value="{{ $letter->email }}" disabled style="opacity:0.85;">
        </div>
        <div class="form-row">
          <label>No. Telepon</label>
          <input type="text" value="{{ $letter->no_telepon }}" disabled style="opacity:0.85;">
        </div>
      </div>
      <div class="form-row">
        <label>Keperluan</label>
        <textarea disabled style="opacity:0.85;">{{ $letter->keperluan }}</textarea>
      </div>
    </div>

    <!-- Form Proses -->
    <form method="POST" action="{{ route('admin.letters.update', $letter) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-card">
        <h3 style="color:var(--ink); margin-bottom:16px;">Proses Surat</h3>

        <div class="form-row">
          <label for="nomor_surat">Nomor Surat *</label>
          <input type="text" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $letter->nomor_surat) }}" placeholder="Contoh: 001/DOMS/2026">
          <small style="color:var(--ink-3); display:block; margin-top:5px;">Nomor surat yang dikeluarkan oleh pemerintah desa</small>
        </div>

        <div class="form-row">
          <label for="surat_pdf">Upload Surat (PDF) *</label>
          <input type="file" id="surat_pdf" name="surat_pdf" accept=".pdf">
          @if ($letter->surat_pdf)
            <div style="margin-top:10px; padding:12px; background:var(--surface-3); border:1px solid var(--line); border-radius:10px;">
              <small style="color:var(--ink-2);">
                <svg class="icon"><use href="#i-surat"/></svg> File sudah diupload: <a href="{{ Storage::url($letter->surat_pdf) }}" target="_blank" style="color:var(--emerald); font-weight:700;">Download Berkas</a>
              </small>
            </div>
          @endif
          <small style="color:var(--ink-3); display:block; margin-top:5px;">Format: PDF maksimal 5MB</small>
        </div>

        <div class="form-row">
          <label for="catatan_admin">Catatan Admin</label>
          <textarea id="catatan_admin" name="catatan_admin" rows="3" placeholder="Masukkan catatan atau informasi tambahan...">{{ old('catatan_admin', $letter->catatan_admin) }}</textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>

    </form>

  </div>

  <!-- Sidebar - Status & Info -->
  <div>

    <!-- Status Update -->
    <div class="form-card" style="margin-bottom:20px;">
      <h3 style="margin-top:0; color:var(--ink);">Ubah Status</h3>

      <form method="POST" action="{{ route('admin.letters.update-status', $letter) }}">
        @csrf
        @method('PATCH')

        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--ink-2);">Status Saat Ini</label>
          <div style="background:var(--surface-3); padding:10px; border-radius:10px; border-left:4px solid var(--emerald);">
            <span style="display:inline-block; padding:6px 12px; border-radius:20px; font-size:0.9rem; font-weight:600; color:white;
              background-color:
              @if ($letter->status === 'Baru') #ffc107
              @elseif ($letter->status === 'Diproses') #2196F3
              @elseif ($letter->status === 'Siap Diambil') #10b981
              @elseif ($letter->status === 'Selesai') #888
              @elseif ($letter->status === 'Ditolak') #dc3545
              @else #999 @endif;">
              {{ $letter->status }}
            </span>
          </div>
        </div>

        <div style="margin-bottom:15px;">
          <label for="status" style="display:block; margin-bottom:8px; font-weight:600;">Ubah Menjadi</label>
          <select name="status" id="status" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
            <option value="">-- Pilih Status --</option>
            @foreach (\App\Models\Letter::getStatusOptions() as $value => $label)
              @if ($value !== $letter->status)
                <option value="{{ $value }}">{{ $label }}</option>
              @endif
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;">Update Status</button>
      </form>
    </div>

    <!-- WhatsApp Notification Card -->
    <div class="form-card" style="margin-bottom:20px; background:linear-gradient(135deg, #075e54, #128c7e); color:white; border:none;">
      <h3 style="margin-top:0; color:white; display:flex; align-items:center; gap:8px;">
        <span><svg class="icon"><use href="#i-message"/></svg> Notifikasi WA</span>
      </h3>
      <p style="font-size:0.88rem; opacity:0.9; margin-bottom:14px; line-height:1.4;">
        Kirim pemberitahuan status surat ke WhatsApp pengaju ({{ $letter->no_telepon }}).
      </p>
      <a href="{{ $letter->wa_notify_url }}" target="_blank" class="btn" style="display:block; text-align:center; background:#25d366; color:#075e54; font-weight:800; text-decoration:none; border-radius:10px; padding:12px 14px; box-shadow:0 4px 12px rgba(37,211,102,0.3);">
        <svg class="icon"><use href="#i-message"/></svg> Kirim Notifikasi via WA
      </a>
    </div>

    <!-- Info Card -->
    <div class="form-card">
      <h3 style="margin-top:0;">Info</h3>

      <div style="font-size:0.9rem; line-height:1.6;">
        <div style="margin-bottom:15px;">
          <label style="color:var(--ink-muted); font-weight:600; display:block;">Ref. Nomor</label>
          <div style="font-family:monospace; font-weight:bold;">{{ $letter->ref_number }}</div>
        </div>

        <div style="margin-bottom:15px;">
          <label style="color:var(--ink-muted); font-weight:600; display:block;">Jenis Surat</label>
          <div>{{ $letter->jenis_surat }}</div>
        </div>

        <div style="margin-bottom:15px;">
          <label style="color:var(--ink-muted); font-weight:600; display:block;">Tgl. Pengajuan</label>
          <div>{{ $letter->tanggal_pengajuan->translatedFormat('d F Y H:i') }}</div>
        </div>

        @if ($letter->tanggal_selesai)
        <div style="margin-bottom:15px;">
          <label style="color:var(--ink-muted); font-weight:600; display:block;">Tgl. Selesai</label>
          <div>{{ $letter->tanggal_selesai->translatedFormat('d F Y H:i') }}</div>
        </div>
        @endif

        @if ($letter->diproses_oleh)
        <div>
          <label style="color:var(--ink-muted); font-weight:600; display:block;">Diproses Oleh</label>
          <div>{{ $letter->processedBy?->name ?? '-' }}</div>
        </div>
        @endif
      </div>
    </div>

    <!-- Dokumen Pendukung -->
    @if ($letter->dokumen_pendukung)
    <div class="form-card">
      <h3 style="margin-top:0;">Dokumen Pendukung</h3>
      <a href="{{ Storage::url($letter->dokumen_pendukung) }}" target="_blank" class="btn btn-secondary" style="display:block; text-align:center; text-decoration:none;">
        📎 Lihat Dokumen
      </a>
    </div>
    @endif

  </div>

</div>

@endsection

@extends('layouts.app')

@section('content')
<div style="max-width:900px; margin:60px auto; padding:0 20px;">

  <h1 style="font-family:var(--font-title); font-weight:800; font-size:2.2rem; margin-bottom:10px;">
    Pengajuan Surat Online
  </h1>
  <p style="font-size:1.1rem; color:var(--ink-muted); margin-bottom:40px;">
    Ajukan surat yang Anda butuhkan dengan mudah dan cepat.
  </p>

  @if ($errors->any())
    <div style="background-color:#fee; border:1px solid #fcc; border-radius:8px; padding:15px; margin-bottom:30px;">
      <strong style="color:#c00;">Ada kesalahan:</strong>
      <ul style="margin:10px 0 0 20px;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div style="background:white; border:1px solid #e0e0e0; border-radius:12px; padding:40px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">

    <form method="POST" action="{{ route('letters.store') }}" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:25px;">
      @csrf

      <!-- Nama Lengkap -->
      <div>
        <label style="display:block; font-weight:600; margin-bottom:8px;">Nama Lengkap *</label>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required 
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px; font-size:1rem;">
      </div>

      <!-- NIK & Email Grid -->
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        <div>
          <label style="display:block; font-weight:600; margin-bottom:8px;">NIK (16 digit) *</label>
          <input type="text" name="nik" value="{{ old('nik') }}" placeholder="Contoh: 3515011234567890" 
            maxlength="16" pattern="[0-9]{16}" required
            style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px; font-size:1rem;">
        </div>
        <div>
          <label style="display:block; font-weight:600; margin-bottom:8px;">Email *</label>
          <input type="email" name="email" value="{{ old('email') }}" required
            style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px; font-size:1rem;">
        </div>
      </div>

      <!-- No. Telepon -->
      <div>
        <label style="display:block; font-weight:600; margin-bottom:8px;">No. WhatsApp/Telepon *</label>
        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" placeholder="Contoh: 62812xxxxxxx" required
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px; font-size:1rem;">
      </div>

      <!-- Jenis Surat -->
      <div>
        <label style="display:block; font-weight:600; margin-bottom:8px;">Jenis Surat yang Diajukan *</label>
        <select name="jenis_surat" required
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px; font-size:1rem;">
          <option value="">-- Pilih Jenis Surat --</option>
          @foreach ($jenisSurat as $value => $label)
            <option value="{{ $value }}" {{ old('jenis_surat') === $value ? 'selected' : '' }}>
              {{ $label }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Keperluan -->
      <div>
        <label style="display:block; font-weight:600; margin-bottom:8px;">Keperluan/Tujuan Surat *</label>
        <textarea name="keperluan" rows="4" placeholder="Jelaskan alasan dan tujuan pengajuan surat ini..." required
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px; font-size:1rem; font-family:inherit;">{{ old('keperluan') }}</textarea>
        <small style="color:var(--ink-muted); display:block; margin-top:5px;">Maksimal 500 karakter</small>
      </div>

      <!-- Dokumen Pendukung -->
      <div>
        <label style="display:block; font-weight:600; margin-bottom:8px;">Dokumen Pendukung (Opsional)</label>
        <input type="file" name="dokumen_pendukung" accept=".pdf,.jpg,.jpeg,.png"
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px; font-size:1rem;">
        <small style="color:var(--ink-muted); display:block; margin-top:5px;">
          Format: PDF, JPG, JPEG, PNG | Maksimal: 5MB
        </small>
      </div>

      <!-- Checkbox Persetujuan -->
      <div style="background-color:#f9f9f9; padding:15px; border-radius:8px; border-left:4px solid var(--jade-main);">
        <label style="display:flex; align-items:flex-start; gap:10px; font-size:0.95rem;">
          <input type="checkbox" name="agree" required style="margin-top:3px;">
          <span>Saya memahami bahwa data yang saya isi adalah benar dan akan digunakan sesuai prosedur layanan surat desa.</span>
        </label>
      </div>

      <!-- Submit Button -->
      <div style="display:flex; gap:15px; margin-top:20px;">
        <button type="submit" class="btn btn-primary" style="padding:12px 30px; font-size:1.05rem; flex:1; text-align:center;">
          Kirim Pengajuan →
        </button>
        <a href="{{ route('home') }}" class="btn btn-secondary" style="padding:12px 30px; font-size:1.05rem; text-align:center; text-decoration:none;">
          Batal
        </a>
      </div>

    </form>

  </div>

  <!-- Info Box -->
  <div style="background-color:#f0f8ff; border:1px solid #b3d9ff; border-radius:8px; padding:20px; margin-top:30px;">
    <h3 style="margin-top:0; color:#0066cc;">ℹ️ Informasi Penting</h3>
    <ul style="margin:10px 0; padding-left:20px;">
      <li>Pengajuan surat akan diproses dalam <strong>{{ setting('estimasi_proses') ?: '1-2 hari kerja' }}</strong></li>
      <li>Anda akan menerima <strong>notifikasi email</strong> untuk setiap perubahan status</li>
      <li>Surat dapat diunduh atau diambil langsung ke Kantor Desa</li>
      <li>Jam operasional: <strong>{{ setting('jam_operasional') }}</strong></li>
    </ul>
  </div>

</div>
@endsection

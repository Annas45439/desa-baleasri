@extends('layouts.app')

@section('title', 'Layanan Desa')

@section('content')
<section class="page-section" style="padding-top:32px;">
  <div class="container" style="max-width:1150px;">
    <div class="section-title-box" style="margin-bottom:26px;">
      <span class="section-kicker">Pelayanan Publik</span>
      <h2>Layanan Desa Baleasri</h2>
      <p>Ajukan surat administrasi atau sampaikan pengaduan warga dalam satu halaman layanan yang mudah diakses.</p>
    </div>

    @if(session('complaint_status'))
      <div style="background:#dcfce7; border:1px solid #86efac; color:#166534; padding:16px 20px; border-radius:12px; font-weight:700; margin-bottom:24px;">
        {{ session('complaint_status') }}
      </div>
    @endif

    <div style="margin-bottom:22px; display:flex; flex-wrap:wrap; gap:12px;">
      <button type="button" class="tab-btn active" data-target="tab-surat" style="border:none; background:var(--jade-main); color:#fff; padding:12px 18px; border-radius:999px; font-weight:800; cursor:pointer;">Layanan Surat</button>
      <button type="button" class="tab-btn" data-target="tab-pengaduan" style="border:none; background:#eef4f2; color:var(--ink-main); padding:12px 18px; border-radius:999px; font-weight:800; cursor:pointer;">Pengaduan Warga</button>
    </div>

    <div class="tab-panel active" id="tab-surat" style="display:block;">
      <div style="background:#fff; border:1px solid #e7efe9; border-radius:22px; padding:28px; box-shadow:0 12px 28px rgba(15,23,42,0.06);">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:20px;">
          <div>
            <div style="font-size:0.75rem; font-weight:800; letter-spacing:0.12em; text-transform:uppercase; color:var(--jade-main);">Layanan Surat</div>
            <h3 style="margin:8px 0 0; font-size:1.6rem; font-family:var(--font-title);">Pengajuan Surat Online</h3>
          </div>
          <div style="padding:10px 14px; border-radius:999px; background:#f1fbf5; color:var(--jade-main); font-weight:700; border:1px solid #d7f5e1;">Proses 1–2 hari kerja</div>
        </div>

        @if ($errors->any())
          <div style="background-color:#fee; border:1px solid #fcc; border-radius:8px; padding:15px; margin-bottom:24px;">
            <strong style="color:#c00;">Ada kesalahan:</strong>
            <ul style="margin:10px 0 0 20px;">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('letters.store') }}" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:25px;">
          @csrf

          <div>
            <label style="display:block; font-weight:600; margin-bottom:8px;">Nama Lengkap *</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; font-size:1rem;">
          </div>

          <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div>
              <label style="display:block; font-weight:600; margin-bottom:8px;">NIK (16 digit) *</label>
              <input type="text" name="nik" value="{{ old('nik') }}" placeholder="Contoh: 3515011234567890" maxlength="16" pattern="[0-9]{16}" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; font-size:1rem;">
            </div>
            <div>
              <label style="display:block; font-weight:600; margin-bottom:8px;">Email *</label>
              <input type="email" name="email" value="{{ old('email') }}" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; font-size:1rem;">
            </div>
          </div>

          <div>
            <label style="display:block; font-weight:600; margin-bottom:8px;">No. WhatsApp/Telepon *</label>
            <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" placeholder="Contoh: 62812xxxxxxx" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; font-size:1rem;">
          </div>

          <div>
            <label style="display:block; font-weight:600; margin-bottom:8px;">Jenis Surat yang Diajukan *</label>
            <select name="jenis_surat" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; font-size:1rem; background:#fff;">
              <option value="">-- Pilih Jenis Surat --</option>
              @foreach (App\Models\Letter::getJenisSuratOptions() as $value => $label)
                <option value="{{ $value }}" {{ old('jenis_surat') === $value ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <label style="display:block; font-weight:600; margin-bottom:8px;">Keperluan/Tujuan Surat *</label>
            <textarea name="keperluan" rows="4" placeholder="Jelaskan alasan dan tujuan pengajuan surat ini..." required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; font-size:1rem; font-family:inherit;">{{ old('keperluan') }}</textarea>
            <small style="color:var(--ink-muted); display:block; margin-top:5px;">Maksimal 500 karakter</small>
          </div>

          <div>
            <label style="display:block; font-weight:600; margin-bottom:8px;">Dokumen Pendukung (Opsional)</label>
            <input type="file" name="dokumen_pendukung" accept=".pdf,.jpg,.jpeg,.png" style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; font-size:1rem; background:#fff;">
            <small style="color:var(--ink-muted); display:block; margin-top:5px;">Format: PDF, JPG, JPEG, PNG | Maksimal: 5MB</small>
          </div>

          <div style="background:#f7faf8; padding:15px; border-radius:12px; border:1px solid #e1efe7; border-left:4px solid var(--jade-main);">
            <label style="display:flex; align-items:flex-start; gap:10px; font-size:0.95rem;">
              <input type="checkbox" name="agree" required style="margin-top:3px;">
              <span>Saya memahami bahwa data yang saya isi adalah benar dan akan digunakan sesuai prosedur layanan surat desa.</span>
            </label>
          </div>

          <div style="display:flex; gap:15px; margin-top:10px; flex-wrap:wrap;">
            <button type="submit" class="btn btn-primary" style="padding:12px 28px; font-size:1rem;">Kirim Pengajuan &rarr;</button>
          </div>
        </form>
      </div>
    </div>

    <div class="tab-panel" id="tab-pengaduan" style="display:none;">
      <div style="display:grid; grid-template-columns: 1.2fr 1fr; gap:32px;">
        <div class="card-executive" style="margin-bottom:0;">
          <h3 style="font-family:var(--font-title); font-weight:800; font-size:1.3rem; margin-bottom:16px;">Formulir Pengaduan Warga</h3>
          <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:16px;">
            @csrf
            <div style="display:flex; flex-direction:column; gap:6px;">
              <label style="font-size:0.85rem; font-weight:700; color:var(--ink-main);">Nama Pelapor *</label>
              <input type="text" name="nama" required placeholder="Nama lengkap Anda" style="border:1px solid rgba(11,25,20,0.15); border-radius:8px; padding:10px 14px; font:inherit;">
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
              <label style="font-size:0.85rem; font-weight:700; color:var(--ink-main);">Kontak (WhatsApp/HP) *</label>
              <input type="text" name="kontak" required placeholder="08xxxxxxxxxx" style="border:1px solid rgba(11,25,20,0.15); border-radius:8px; padding:10px 14px; font:inherit;">
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
              <label style="font-size:0.85rem; font-weight:700; color:var(--ink-main);">Kategori Pelayanan *</label>
              <select name="kategori" required style="border:1px solid rgba(11,25,20,0.15); border-radius:8px; padding:10px 14px; font:inherit; background:#fff;">
                <option value="">Pilih Kategori</option>
                <option value="Layanan Surat">Permohonan Surat Administrasi Online</option>
                <option value="Infrastruktur">Infrastruktur &amp; Sarana Publik</option>
                <option value="Lingkungan">Lingkungan &amp; Kebersihan</option>
                <option value="Pelayanan">Pelayanan Perangkat Desa</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
              <label style="font-size:0.85rem; font-weight:700; color:var(--ink-main);">Isi Permohonan / Aduan *</label>
              <textarea name="isi" required rows="5" placeholder="Jelaskan detail permohonan surat atau kendala yang ingin Anda sampaikan" style="border:1px solid rgba(11,25,20,0.15); border-radius:8px; padding:10px 14px; font:inherit;"></textarea>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
              <label style="font-size:0.85rem; font-weight:700; color:var(--ink-main);">Foto Bukti (opsional, maksimal 5 foto)</label>
              <input type="file" name="photos[]" id="complaint-photos" accept="image/jpeg,image/png,image/webp" multiple style="border:1px solid rgba(11,25,20,0.15); border-radius:8px; padding:10px 14px; font:inherit;">
              <small id="photo-help" style="color:var(--ink-muted);">Foto akan dikompres otomatis sebelum dikirim.</small>
            </div>

            <button type="submit" class="btn-primary-emerald" style="justify-content:center; padding:12px; margin-top:8px;">Kirim Formulir &rarr;</button>
          </form>
        </div>

        <div style="display:flex; flex-direction:column; gap:20px;">
          <div class="card-executive" style="margin-bottom:0;">
            <h3 style="font-family:var(--font-title); font-weight:700; font-size:1.1rem; margin-bottom:12px;">Informasi Jam Operasional</h3>
            <p style="font-size:0.88rem; color:var(--ink-sub); line-height:1.6;">
              <strong>Kantor Desa Baleasri:</strong><br>
              {{ $setting->jam_operasional ?: 'Senin - Jumat: 08:00 - 15:00 WIB' }}<br>
              Kecamatan Ngariboyo, Kabupaten Magetan
            </p>
          </div>

          <div class="card-executive" style="margin-bottom:0; background:var(--jade-dark); color:#ffffff;">
            <h3 style="font-family:var(--font-title); font-weight:700; font-size:1.1rem; color:#ffffff; margin-bottom:12px;">Layanan Darurat Desa</h3>
            <ul style="font-size:0.85rem; display:flex; flex-direction:column; gap:8px; opacity:0.9;">
              <li><strong>Ambulans / Kesehatan:</strong> 119</li>
              <li><strong>Polsek Ngariboyo:</strong> 110</li>
              <li><strong>Bantuan Linmas Desa:</strong> (21 RT Siskamling)</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');

    buttons.forEach(function (button) {
      button.addEventListener('click', function () {
        const target = button.dataset.target;

        buttons.forEach(function (btn) {
          btn.classList.toggle('active', btn === button);
          btn.style.background = btn === button ? 'var(--jade-main)' : '#eef4f2';
          btn.style.color = btn === button ? '#fff' : 'var(--ink-main)';
        });

        panels.forEach(function (panel) {
          panel.style.display = panel.id === target ? 'block' : 'none';
        });
      });
    });

    const photoInput = document.getElementById('complaint-photos');
    const photoHelp = document.getElementById('photo-help');

    if (photoInput) {
      photoInput.addEventListener('change', async function () {
        const files = Array.from(photoInput.files);

        if (files.length > 5) {
          photoInput.value = '';
          photoHelp.textContent = 'Maksimal 5 foto.';
          return;
        }

        if (!files.length) return;

        photoHelp.textContent = 'Mengompres foto...';
        const compressedFiles = await Promise.all(files.map(compressComplaintPhoto));
        const transfer = new DataTransfer();
        compressedFiles.forEach(function (file) { transfer.items.add(file); });
        photoInput.files = transfer.files;
        photoHelp.textContent = compressedFiles.length + ' foto siap dikirim setelah dikompres.';
      });
    }

    function compressComplaintPhoto(file) {
      return new Promise(function (resolve) {
        if (!file.type.startsWith('image/') || file.type === 'image/gif') {
          resolve(file);
          return;
        }

        const image = new Image();
        image.onload = function () {
          const maxSize = 1600;
          const scale = Math.min(1, maxSize / Math.max(image.width, image.height));
          const canvas = document.createElement('canvas');
          canvas.width = Math.round(image.width * scale);
          canvas.height = Math.round(image.height * scale);
          canvas.getContext('2d').drawImage(image, 0, 0, canvas.width, canvas.height);
          canvas.toBlob(function (blob) {
            resolve(new File([blob], file.name.replace(/\.[^.]+$/, '') + '.jpg', { type: 'image/jpeg' }));
          }, 'image/jpeg', 0.75);
        };
        image.src = URL.createObjectURL(file);
      });
    }
  });
</script>
@endpush
@endsection


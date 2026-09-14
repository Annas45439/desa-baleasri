@component('mail::message')
# ⚠️ Pengajuan Surat Baru Masuk

Halo Admin,

Ada pengajuan surat baru yang perlu Anda proses.

## Detail Pengajuan

| Informasi | Keterangan |
|-----------|-----------|
| **Nomor Referensi** | {{ $letter->ref_number }} |
| **Nama Pengaju** | {{ $letter->nama_lengkap }} |
| **NIK** | {{ $letter->nik }} |
| **Email** | {{ $letter->email }} |
| **No. Telepon** | {{ $letter->no_telepon }} |
| **Jenis Surat** | {{ $letter->jenis_surat }} |
| **Waktu Pengajuan** | {{ $letter->tanggal_pengajuan->translatedFormat('d F Y H:i') }} |

## Keperluan

{{ $letter->keperluan }}

@if ($letter->dokumen_pendukung)
## Dokumen Pendukung

File dokumen pendukung telah diupload oleh pengaju.
@endif

---

## Aksi Cepat

@component('mail::button', ['url' => route('admin.letters.edit', $letter)])
Proses Pengajuan
@endcomponent

---

Terima kasih,  
**Sistem Layanan Surat Desa Baleasri**

@endcomponent

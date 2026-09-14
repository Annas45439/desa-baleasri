@component('mail::message')
# Pengaduan Baru Masuk

Ada pengaduan warga baru yang perlu diperiksa.

| Informasi | Keterangan |
|---|---|
| **Nama** | {{ $complaint->nama }} |
| **Kontak** | {{ $complaint->kontak ?: '-' }} |
| **Kategori** | {{ $complaint->kategori }} |
| **Status** | {{ $complaint->status }} |
| **Waktu** | {{ $complaint->created_at?->translatedFormat('d F Y H:i') }} |

## Isi Pengaduan

{{ $complaint->isi }}

@if ($complaint->photo_paths)
Foto bukti tersedia di panel admin.
@endif

@component('mail::button', ['url' => route('admin.complaints.index')])
Buka Panel Pengaduan
@endcomponent

Terima kasih,  
**Sistem Layanan Desa Baleasri**
@endcomponent

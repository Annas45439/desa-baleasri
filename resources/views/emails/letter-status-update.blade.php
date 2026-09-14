@component('mail::message')
# Update Status Surat Anda

Halo **{{ $letter->nama_lengkap }}**,

Status pengajuan surat Anda telah diperbarui.

## Informasi Terbaru

| Informasi | Keterangan |
|-----------|-----------|
| **Nomor Referensi** | {{ $letter->ref_number }} |
| **Jenis Surat** | {{ $letter->jenis_surat }} |
| **Status Sebelumnya** | {{ $oldStatus }} |
| **Status Saat Ini** | <strong style="color: #10b981;">{{ $newStatus }}</strong> |
| **Nomor Surat** | {{ $letter->nomor_surat ?? 'Belum ditetapkan' }} |

@if ($letter->status === 'Siap Diambil')

## 🎉 Surat Anda Siap!

Surat yang Anda ajukan sudah selesai diproses dan siap untuk diambil. Anda dapat:

1. **Mengunduh Surat** melalui link di bawah
2. **Mengambil Langsung** ke Kantor Desa Baleasri

@component('mail::button', ['url' => route('letters.download-pdf', $letter)])
Unduh Surat
@endcomponent

### Jam Operasional Kantor Desa
{{ setting('jam_operasional') }}

### Alamat Kantor Desa
{{ setting('alamat') }}

@elseif ($letter->status === 'Diproses')

## ⏳ Surat Sedang Diproses

Tim kami sedang mempersiapkan surat Anda. Kami akan memberitahu Anda ketika surat sudah siap diambil atau diunduh.

@elseif ($letter->status === 'Ditolak')

## ⚠️ Pengajuan Ditolak

Sayangnya pengajuan surat Anda tidak dapat kami proses. Silakan hubungi Kantor Desa untuk informasi lebih lanjut.

@endif

## Catatan Admin

@if ($letter->catatan_admin)
{{ $letter->catatan_admin }}
@else
-
@endif

---

Terima kasih,  
**Pemerintah Desa Baleasri**

@endcomponent

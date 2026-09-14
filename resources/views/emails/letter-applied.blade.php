@component('mail::message')
# Pengajuan Surat Telah Diterima

Halo **{{ $letter->nama_lengkap }}**,

Terima kasih telah mengajukan surat kepada Pemerintah Desa Baleasri. Permohonan Anda telah kami terima dan akan diproses sesuai dengan prosedur yang berlaku.

## Detail Pengajuan

| Informasi | Keterangan |
|-----------|-----------|
| **Nomor Referensi** | {{ $letter->ref_number }} |
| **Jenis Surat** | {{ $letter->jenis_surat }} |
| **Nama Lengkap** | {{ $letter->nama_lengkap }} |
| **NIK** | {{ $letter->nik }} |
| **Email** | {{ $letter->email }} |
| **No. Telepon** | {{ $letter->no_telepon }} |
| **Tanggal Pengajuan** | {{ $letter->tanggal_pengajuan->translatedFormat('d F Y H:i') }} |
| **Status** | Baru (Dalam Antrian) |

## Informasi Keperluan

{{ $letter->keperluan }}

## Langkah Selanjutnya

1. Admin kami akan memproses pengajuan Anda dalam **1-2 hari kerja**
2. Anda akan menerima notifikasi email ketika status berubah
3. Ketika surat sudah siap, Anda dapat mengunduhnya melalui email atau mengambil langsung ke Kantor Desa

## Cek Status Surat Anda

Anda dapat cek status pengajuan surat kapan saja melalui website dengan menggunakan:
- **Nomor Referensi**: {{ $letter->ref_number }}
- **NIK**: {{ $letter->nik }}

@component('mail::button', ['url' => route('letters.tracking')])
Cek Status Surat
@endcomponent

## Pertanyaan?

Jika ada pertanyaan, silakan hubungi kami:

📧 Email: {{ setting('email') }}
📞 WhatsApp: {{ setting('whatsapp_admin') }}
📍 Alamat: {{ setting('alamat') }}

---

Terima kasih,  
**Pemerintah Desa Baleasri**

@endcomponent

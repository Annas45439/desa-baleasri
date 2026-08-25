# Desa Baleasri — Laravel Starter (Full: Model, Migration, Controller, Admin Panel)

Paket ini berisi kode custom untuk website profil desa dengan:
- Halaman publik (Beranda) bergaya desain `demo.html` — hero video/foto, statistik, wisata, UMKM (tombol pesan WhatsApp), galeri, berita.
- Panel admin (login + dashboard + CRUD) bergaya desain `admin.html`.
- Upload foto (Potensi Desa, Berita, foto Kepala Desa) & upload **video hero** dari menu Pengaturan.
- 2 seeder: akun admin pertama + data contoh (wisata, UMKM, berita) biar situs nggak kosong pas pertama dibuka.

## Cara pakai

### 1. Siapkan project Laravel kosong
Sandbox saya tidak punya akses Packagist, jadi bagian ini kamu jalankan sendiri:
```
composer create-project laravel/laravel desa-baleasri
```

### 2. Salin semua file dari zip ini
Timpa/salin folder `app/`, `database/`, `resources/`, `routes/`, `public/assets/` dari zip ini ke dalam project Laravel yang baru dibuat. Strukturnya sudah sama persis.

### 3. **WAJIB** — Daftarkan middleware admin
Ini langkah yang paling sering kelewat. Tanpa ini, semua route `/admin/*` (selain login) tidak akan terlindungi.

**Kalau project kamu Laravel 11+** (ada file `bootstrap/app.php`), buka file itu, cari bagian `->withMiddleware(...)`, tambahkan alias:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin.auth' => \App\Http\Middleware\RedirectIfNotAdmin::class,
    ]);
})
```
Kalau file `bootstrap/app.php` kamu belum ada bagian `withMiddleware`, tambahkan block itu sebelum `->create();`.

**Kalau project kamu Laravel 10** (ada file `app/Http/Kernel.php`), buka file itu, cari array `$middlewareAliases` (atau `$routeMiddleware` di versi lebih lama), tambahkan baris:
```php
'admin.auth' => \App\Http\Middleware\RedirectIfNotAdmin::class,
```

### 4. Setup `.env`
Isi bagian database sesuai server MySQL kamu (contoh untuk Laragon, password default kosong):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=desa_baleasri
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Install & migrasi
```
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
```
`storage:link` **wajib** — tanpa ini foto & video upload tidak akan muncul di browser.

### 6. Naikkan batas upload untuk video (penting!)
Default PHP membatasi upload sekitar 2–8MB, sedangkan video hero bisa lebih besar. Buka `php.ini` (di Laragon: Menu → PHP → php.ini), cari dan ubah:
```
upload_max_filesize = 64M
post_max_size = 64M
```
Lalu restart service (di Laragon: klik "Stop All" lalu "Start All"). Kalau tidak diubah, upload video besar akan gagal dengan pesan generik atau halaman kosong.

### 7. Jalankan
```
php artisan serve
```
- Situs publik: `http://127.0.0.1:8000/`
- Login admin: `http://127.0.0.1:8000/admin/login`
  - Email: `admin@baleasri.desa.id`
  - Password: `ganti-password-ini` — **ganti setelah login pertama** (belum ada fitur ganti password di panel; sementara bisa lewat `php artisan tinker`: `User::first()->update(['password' => Hash::make('password-baru')]);`)

## Struktur fitur

| Fitur | Lokasi admin |
|---|---|
| Login/logout | `/admin/login` |
| Dashboard & ringkasan | `/admin/dashboard` |
| CRUD Potensi Desa (Wisata/UMKM/Galeri) + upload foto | `/admin/potensi` |
| CRUD Berita + upload foto | `/admin/berita` |
| Hero video/foto, sambutan Kades, statistik, kontak | `/admin/pengaturan` |

Video hero **diprioritaskan** tampil di Beranda; kalau kosong, otomatis fallback ke foto hero, lalu ke gambar placeholder kalau keduanya kosong.

## Kalau ada error

Kirim screenshot pesan error lengkap (termasuk kalau ada "Class not found", "Route not defined", atau halaman putih/500), saya bantu debug dari situ. Error paling umum:
- **419 Page Expired** saat submit form → jalankan `php artisan config:clear` dan pastikan cookie/session aktif.
- **Foto/video tidak muncul** → belum jalankan `php artisan storage:link`.
- **Route `/admin/dashboard` tidak keluar apa-apa / error 500 soal middleware** → lihat langkah 3 di atas, alias `admin.auth` belum didaftarkan.

# Arsitektur Desa Baleasri

## Ringkasan

Desa Baleasri adalah aplikasi Laravel 12 untuk portal informasi desa, layanan publik, surat, pengaduan, UMKM, berita, dan panel admin.

## Struktur Utama

| Area | Lokasi | Tanggung jawab |
|---|---|---|
| HTTP entrypoint | `public/index.php` | Memulai Laravel untuk request web |
| Azure entrypoint | `index.php` saat runtime | Shim yang memanggil `public/index.php` karena App Service memakai root repository |
| Bootstrap | `bootstrap/app.php` | Route, middleware, command, exception |
| Route | `routes/web.php` | URL publik, auth Google, dan admin |
| Controller | `app/Http/Controllers` | Orkestrasi request dan response |
| Model | `app/Models` | Akses data Eloquent |
| Migration | `database/migrations` | Perubahan schema database |
| Seeder | `database/seeders` | Data awal dan akun developer |
| Public view | `resources/views/public` | Halaman yang dapat diakses warga |
| Admin view | `resources/views/admin` | Dashboard dan CRUD admin |
| Shared layout | `resources/views/layouts` | Layout publik dan admin |
| CSS publik | `public/assets/css/site.css` | Style website warga |
| CSS admin | `public/assets/css/admin.css` | Style panel admin |
| Upload | `storage/app/public` | Foto, video, surat, dan file publik |
| Deployment | `.github/workflows/main_balesari.yml` | Build dan deploy GitHub Actions |
| Startup Azure | `startup.sh` | Runtime directory, asset root, storage link |

## Alur Request Production

1. Browser mengakses App Service `balesari` melalui HTTPS.
2. Nginx dan PHP-FPM Azure menerima request.
3. Root `index.php` memanggil `public/index.php`.
4. Laravel memuat `bootstrap/app.php`.
5. Middleware web berjalan.
6. Route di `routes/web.php` memilih controller.
7. Controller membaca model/database dan merender Blade view.
8. Asset CSS dan gambar disajikan dari folder `assets` dan `public`.

## Alur Deployment

1. Push ke `main` memicu workflow.
2. GitHub Actions memasang PHP 8.5, Composer dependency production, dan Node.js.
3. Build memakai SQLite kosong sementara agar Composer Laravel package discovery tidak membutuhkan database production.
4. Vite membuat asset build.
5. Artifact dikirim ke Azure App Service.
6. Azure menjalankan `startup.sh`.
7. Environment variables Azure mengatur production database dan aplikasi.

## Konfigurasi Production

Nilai berikut disimpan di Azure App Service Environment variables:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY`
- `APP_URL`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `FILESYSTEM_DISK=public`
- `SESSION_DRIVER=file`
- `CACHE_STORE=file`
- `QUEUE_CONNECTION=sync` untuk deployment sederhana

Jangan menyalin nilai rahasia ke dokumen atau repository.

## Batasan Penting Azure

- Filesystem App Service dapat bersifat lokal dan tidak ideal untuk upload yang harus bertahan saat scale-out.
- Upload jangka panjang sebaiknya dipindahkan ke Azure Blob Storage.
- Folder runtime seperti cache, session, compiled view, dan log harus dibuat saat startup.
- Jangan menjalankan `php artisan serve`; Azure sudah menjalankan Nginx dan PHP-FPM.
- Jangan mengandalkan symlink untuk asset root tanpa menguji App Service. `startup.sh` menyalin asset ke root web.
- `storage:link` harus berhasil agar file di `storage/app/public` dapat diakses.

## Area Berisiko Tinggi

### Database

Model dan view banyak membaca database saat halaman dirender. Jika database belum tersedia, request dapat menghasilkan HTTP 500. Pastikan migration sudah dijalankan dan environment variable database benar.

### Middleware Admin

Alias middleware didaftarkan di `bootstrap/app.php`. Perubahan pada alias dapat membuka atau mengunci seluruh route admin.

### Environment

Config Laravel dapat tercache. Setelah mengubah environment variable di Azure, restart App Service dan gunakan `php artisan optimize:clear` bila diperlukan.

### Asset

Sebagian besar halaman memakai `asset('assets/...')`, bukan hanya Vite. Perubahan path asset harus diuji melalui URL langsung, misalnya `/assets/css/site.css`.

## Validasi Deployment

Setelah deploy:

```bash
php artisan migrate --force
php artisan storage:link --force
php artisan optimize:clear
```

Lalu cek:

- halaman utama HTTP 200;
- `/assets/css/site.css` HTTP 200;
- login admin;
- halaman publik utama;
- upload dan akses file storage;
- GitHub Actions build dan deploy;
- Azure Log stream tanpa error baru.

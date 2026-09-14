# Panduan AI dan Agent

Dokumen ini wajib dibaca sebelum mengubah kode repository Desa Baleasri.

## Tujuan

Menjaga agar perubahan AI atau developer lain tidak merusak fitur yang sudah berjalan, deployment Azure, database, data upload, atau pekerjaan anggota tim lain.

## Aturan Wajib

1. Baca `README.md`, `CONTRIBUTING.md`, dan `docs/ARCHITECTURE.md` sebelum mengubah kode.
2. Mulai dari file atau error yang disebutkan. Jangan melakukan refactor besar tanpa kebutuhan yang jelas.
3. Jangan menghapus, memindahkan, atau mengganti nama file milik developer lain tanpa alasan teknis dan persetujuan.
4. Jangan menjalankan `git reset --hard`, `git checkout --`, atau perintah destruktif lainnya.
5. Jangan commit `.env`, password database, `APP_KEY`, OAuth secret, API key, publish profile Azure, atau credential lain.
6. Jangan mengubah migration yang sudah pernah dijalankan di production. Tambahkan migration baru untuk perubahan schema.
7. Jangan mengganti nama route atau field database publik tanpa memeriksa semua pemakai dan menyiapkan kompatibilitas.
8. Jangan mengubah `startup.sh`, `bootstrap/app.php`, atau konfigurasi proxy HTTPS tanpa memahami dampaknya pada Azure App Service.
9. Jangan menghapus file upload dari `storage/app/public` atau database production.
10. Jangan mengubah desain publik, panel admin, atau alur surat tanpa memeriksa halaman terkait dan route-nya.

## Sebelum Mengedit

- Periksa `git status --short --branch`.
- Baca implementasi lokal yang mengontrol perilaku.
- Cari pemakaian symbol, route, model, dan field yang akan diubah.
- Formulasikan satu dugaan penyebab yang dapat diuji.
- Pilih perubahan terkecil yang dapat membuktikan dugaan tersebut.

## Setelah Mengedit

Jalankan validasi yang paling dekat dengan perubahan:

```bash
php -l path/to/changed.php
php artisan test
npm run build
php artisan route:list
```

Tidak semua perintah wajib dijalankan setiap saat. Jalankan yang relevan dengan file yang disentuh dan laporkan jika lingkungan belum memiliki PHP, Composer, database, atau Node.js.

## Konvensi Teknis

- Laravel 12 dan PHP 8.2+.
- Route web berada di `routes/web.php`.
- Controller berada di `app/Http/Controllers`.
- Model berada di `app/Models`.
- Schema database berada di `database/migrations`.
- View Blade berada di `resources/views`.
- CSS/JS publik utama berada di `public/assets` dan dipanggil dengan `asset(...)`.
- `resources/css` dan `resources/js` dibangun oleh Vite; jangan menganggap semua CSS halaman berasal dari Vite.
- Dependency PHP dikunci oleh `composer.lock`; dependency Node dikunci oleh `package-lock.json`.
- Asset upload memakai `FILESYSTEM_DISK=public` dan membutuhkan `php artisan storage:link`.

## Azure Deployment

- Push ke branch `main` memicu `.github/workflows/main_balesari.yml`.
- Workflow memasang Composer dependency, membangun asset frontend, lalu deploy ke App Service `balesari`.
- Environment production disimpan di Azure App Service > Environment variables, bukan di Git.
- `startup.sh` menyiapkan folder runtime Laravel, root entrypoint, asset root, dan storage link.
- Azure sudah menjalankan Nginx dan PHP-FPM. Jangan menambahkan `php artisan serve` ke startup script.
- Jangan menambahkan redirect HTTPS aplikasi tanpa menguji proxy Azure. Azure sudah menangani HTTPS Only.
- Setelah deployment, cek GitHub Actions, Log stream, dan status HTTP endpoint.

## Prosedur Perubahan

1. Buat perubahan kecil dalam satu tujuan.
2. Jalankan validasi lokal yang relevan.
3. Tinjau `git diff --check` dan `git diff`.
4. Commit dengan pesan yang menjelaskan tujuan.
5. Push hanya perubahan yang dipahami.
6. Periksa GitHub Actions sampai selesai.
7. Untuk perubahan production, dokumentasikan migration, environment variable, dan langkah rollback.

## Jika Menemukan Error

Jangan menebak dari halaman browser saja. Kumpulkan:

- commit yang sedang berjalan;
- job dan step GitHub Actions yang gagal;
- status HTTP;
- baris `production.ERROR` pertama dari `storage/logs/laravel.log`;
- konfigurasi non-rahasia yang relevan.

Rahasia harus disensor sebelum dibagikan.

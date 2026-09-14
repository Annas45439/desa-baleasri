# Kontribusi Desa Baleasri

Dokumen ini berlaku untuk developer, teman satu tim, dan AI yang mengubah repository.

## Alur Kerja Aman

1. Sinkronkan branch sebelum mulai:

```bash
git fetch origin
git pull --rebase origin main
git status --short --branch
```

2. Baca `AGENTS.md` dan `docs/ARCHITECTURE.md`.
3. Buat branch fitur, misalnya `feature/nama-fitur` atau `fix/nama-masalah`.
4. Ubah hanya file yang diperlukan.
5. Jalankan test atau build yang relevan.
6. Tinjau diff sebelum commit.
7. Buat pull request ke `main`. Hindari push langsung ke `main` untuk perubahan besar.

## File yang Tidak Boleh Di-commit

- `.env`
- `.env.production`
- `vendor/`
- `node_modules/`
- `public/build/`
- `public/storage/`
- log, session, cache, dan backup
- database lokal
- password, token, secret, dan publish profile Azure

Gunakan `.env.example` sebagai template tanpa nilai rahasia.

## Database

- Jangan edit migration yang sudah dijalankan.
- Tambahkan migration baru dengan timestamp baru.
- Uji migration pada database kosong dan database yang sudah memiliki data jika memungkinkan.
- Jangan menjalankan `migrate:fresh` atau `db:wipe` pada production.
- Backup database sebelum perubahan schema berisiko.
- Seeder default tidak boleh dianggap sebagai pengganti backup production.

## Perubahan UI

- Periksa route, controller, view, CSS, gambar, dan responsive layout yang terkait.
- CSS publik utama berada di `public/assets/css/site.css` dan `public/assets/css/admin.css`.
- Jangan menghapus class CSS lama hanya karena tidak terlihat dipakai; cari pemakaian di semua Blade view.
- Setelah perubahan frontend, jalankan:

```bash
npm install
npm run build
```

## Perubahan Azure

Perubahan pada file berikut wajib diuji dan dijelaskan di pull request:

- `.github/workflows/main_balesari.yml`
- `startup.sh`
- `bootstrap/app.php`
- `config/*.php`
- `.env.example`

Environment production harus diubah melalui Azure Environment variables. Jangan memasukkan nilainya ke source code.

## Checklist Pull Request

- [ ] Tujuan perubahan jelas.
- [ ] Tidak ada secret di diff.
- [ ] Tidak menghapus perubahan anggota tim lain.
- [ ] Migration baru dibuat jika schema berubah.
- [ ] Test, lint, atau build relevan berhasil.
- [ ] Route dan permission admin tetap benar.
- [ ] Upload dan storage tidak rusak.
- [ ] Langkah deployment dan rollback ditulis jika diperlukan.
- [ ] Screenshot disertakan untuk perubahan UI.

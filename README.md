# ParkirIN — Sistem Manajemen Parkir

Aplikasi web manajemen parkir berbasis **Laravel 12 + Tailwind CSS** dengan 3 peran: **Admin**, **Petugas**, dan **Owner**.

## Fitur
- **Admin** — kelola user, tarif parkir, area parkir, data kendaraan, dan log aktivitas
- **Petugas** — catat kendaraan masuk/keluar, hitung biaya otomatis, cetak struk
- **Owner** — dashboard pendapatan + rekap transaksi per rentang tanggal

---

## Cara Setup di Laptop Baru (Windows)

> Prasyarat: install [XAMPP](https://www.apachefriends.org/) (untuk PHP + MySQL) dan [Composer](https://getcomposer.org/download/) serta [Node.js](https://nodejs.org/).

1. Salin seluruh folder proyek ke laptop baru
2. **Jalankan `SETUP-APP.bat`** (klik dua kali) — script otomatis:
   - install dependency Composer & NPM
   - buat file `.env` + generate app key
   - buat database `parkirr` di MySQL
   - migrasi tabel + seed data awal
   - build aset CSS/JS
3. Setelah selesai, **jalankan `START-APP.bat`** — server menyala dan browser terbuka di `http://127.0.0.1:8000`

### Akun bawaan (dari seeder)
| Username | Password | Role |
|---|---|---|
| `admin` | `password` | Admin |
| `petugas` | `password` | Petugas |
| `owner` | `password` | Owner |

> ⚠️ Jika laptop baru memakai password MySQL non-kosong, edit `DB_PASSWORD` di file `.env` terlebih dahulu.

---

## Alternatif Setup Manual

```bash
composer install
copy .env.example .env
php artisan key:generate
# buat database "parkirr" via phpMyAdmin, lalu:
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

### Pakai data lama (file `database/parkirr.sql`)
Jika ingin memakai data aplikasi yang sudah berjalan (bukan data kosong):
1. Buat database `parkirr` via phpMyAdmin
2. Import file `database/parkirr.sql`
3. Sesuaikan `.env`, lalu `php artisan serve`

---

## Struktur Penting
| Lokasi | Isi |
|---|---|
| `routes/web.php` | Semua route per role |
| `app/Http/Controllers` | Logika aplikasi |
| `resources/views` | Tampilan Blade |
| `database/migrations` | Skema database |
| `database/seeders` | Akun & data awal |
| `database/parkirr.sql` | Backup database siap import |

## Tips
- Mode pengembangan (hot reload CSS/JS): `npm run dev` + `php artisan serve`
- Reset data ke awal: `php artisan migrate:fresh --seed`
- Ganti nama aplikasi: edit `APP_NAME` di `.env`

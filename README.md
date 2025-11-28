
**Sistem Penggajian**

Perancangan (Design) — fitur inti direncanakan dan model data dasar tersedia. Implementasi penuh masih dalam proses.
Memberikan sistem terpusat untuk menghitung dan mengelola penggajian karyawan, termasuk perhitungan upah dasar, tunjangan, bonus, potongan, dan pajak. Sistem ini dirancang agar mudah disesuaikan dengan kebijakan perusahaan (komponen gaji, frekuensi pembayaran, dan aturan pajak lokal).

**Ringkasan Fungsional**
- **Input karyawan**: data personal, jabatan, departemen, gaji pokok, status pajak (PTKP), komponen tunjangan tetap/variabel.
- **Kehadiran & Jadwal**: data kehadiran harian, izin, cuti, lembur.
- **Perhitungan Gaji**: formula modular untuk menghitung komponen:
	- **Gaji Pokok** (GP): nilai dasar dari data pegawai.
	- **Tunjangan** (T): dapat berupa tunjangan tetap (T_fix) dan variabel (T_var).
	- **Bonus** (B): per kasus/periodik, dapat dihitung berdasarkan KPI atau aturan manual.
	- **Lembur** (L): dihitung per jam lembur sesuai aturan upah per jam.
	- **Potongan** (P): BPJS, pinjaman, potongan absen, dsb.
	- **Pajak (PPH)**: dihitung setelah pengurangan PTKP (lihat `PtkpStatus`).

	Contoh formula ringkas (representasi):
	- Gaji Kotor = $GP + T_{fix} + T_{var} + B + L$
	- Penghasilan Kena Pajak = $Gaji\ Kotor - P - (PTKP)$
	- Pajak = fungsi(Penghasilan Kena Pajak, tarif)
	- Gaji Bersih = $Gaji\ Kotor - P - Pajak$

**Input yang Diperlukan untuk Perhitungan**
- `basic_salary` (numeric): gaji pokok per periode.
- `attendance_days` (int): jumlah hari hadir di periode.
- `overtime_hours` (float): total jam lembur.
- `bonuses` (array): daftar bonus (nama, nilai, tipe: tetap/variabel).
- `allowances` (array): daftar tunjangan (nama, nilai, tipe).
- `deductions` (array): daftar potongan (nama, nilai, tipe).
- `ptkp_status_id` (int): referensi ke `PtkpStatus` untuk perhitungan PPh.

**Model Data (high level)**
- `User` / `Pegawai`: profil pegawai dan relasi ke `Jabatan`/`Departemen`.
- `Absensi`: catatan masuk/keluar, status (hadir, izin, sakit, cuti).
- `Jadwal`: jadwal kerja dan shift.
- `Penggajian`: record per periode berisi breakdown komponen gaji.
- `PtkpStatus`: daftar status PTKP dan nilai yang terkait.

**API / Endpoints (proposal desain)**
- `POST /api/payroll/calculate` : kirim payload pegawai dan periode, kembalikan breakdown perhitungan.
- `GET /api/payroll/{period}` : ambil laporan penggajian periode tertentu.
- `POST /api/employees` : tambah pegawai baru.
- `GET /api/attendance/{employee}` : fetch absensi pegawai.

Implementasi endpoint mengikuti struktur `routes/api.php` dan controller di `app/Http/Controllers/API`.

**Instalasi & Konfigurasi (PowerShell)**
1. Pastikan PHP (8.x), Composer, Node.js, dan NPM tersedia.
2. Jalankan perintah di root project:

```powershell
cd c:\Users\RPL13\Sistem-penggajian
composer install; copy .env.example .env; php artisan key:generate
```

3. Sesuaikan ` .env ` (DB_*, MAIL_*, APP_URL).
4. Pasang asset & migrasi data:

```powershell
npm install; npm run dev
php artisan migrate --seed
php artisan storage:link
php artisan serve --host=127.0.0.1 --port=8000
```

Catatan: Gunakan `php artisan migrate --force` pada deployment otomatis di produksi.

**Testing & Validasi**
- Buat unit test untuk fungsi perhitungan gaji di `tests/Unit` (contoh: hitung pajak, hitung lembur, integrasi penghitungan total).
- Gunakan dataset seeder untuk men-setup skenario penggajian (gaji berbeda, absensi berbeda).

**Roadmap / Rencana Pengembangan**
- Phase 1 (Design): finalisasi model data, definisi komponen gaji, dan aturan pajak.
- Phase 2 (Core): implementasi perhitungan, migrasi, seeder, dan endpoint API kalkulasi.
- Phase 3 (UI): dashboard HR, form input data karyawan, modul slip gaji (PDF) dan export.
- Phase 4 (Ops): backup, monitoring, dan deployment otomatis.

**Keamanan & Kepatuhan**
- Enkripsi data sensitif (password, token) dan batasi akses data personal.
- Simpan log perubahan data payroll untuk audit.
- Pastikan kepatuhan terhadap aturan pajak dan ketenagakerjaan lokal.

**Kontribusi**
- Fork repo, buat branch `feature/xxx`, ajukan PR ke `main`.
- Sertakan deskripsi fitur, skenario testing, dan contoh payload API bila relevan.

**Kontak & Lisensi**
- Maintainer: lihat `composer.json` untuk kontak developer.
- Lisensi: MIT (default), sesuaikan jika organisasi punya lisensi lain.

--
Dokumentasi ini dirancang untuk tim pengembang dan pemangku kepentingan HR agar mempermudah diskusi teknis saat fase perancangan. Jika Anda ingin, saya dapat:
- Menambahkan contoh payload JSON untuk endpoint kalkulasi.
- Menyusun template slip gaji (HTML/PDF) dan contoh output.
- Membuat diagram ER model dan alur perhitungan gaji.

Tolong pilih satu atau lebih item di atas untuk saya tambahkan selanjutnya.
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

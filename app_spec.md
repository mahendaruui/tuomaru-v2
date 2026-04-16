# App Spec — SIPENMARU UUI

**Sistem Penerimaan Mahasiswa Baru — Universitas Ubudiyah Indonesia**
Sistem ujian masuk online untuk penerimaan mahasiswa baru UUI, Banda Aceh.

- **Framework:** CodeIgniter 3.x (PHP)
- **Database:** MySQL (`tuomaru` / production: `u484017554_sipenaci_io`)
- **Base URL:** `http://localhost/tuomaru/`
- **UI Theme:** SB Admin 2 (Bootstrap 4) + FontAwesome
- **Default Controller:** `Login`

---

## 1. Roles & Autentikasi

Ada **dua sistem login terpisah** yang berjalan bersamaan.

### System A — Login Peserta (Student)
- Controller: `Login`
- Route: `/login`
- Tabel: `pendaftar`
- Login menggunakan `no_ujian` + `pass` (plain text, tidak di-hash)
- Session menyimpan: `id` (no_ujian) dan `nama`
- Guard: semua halaman `Dashboard` cek `session->userdata('id')`

### System B — Login Admin/Staff
- Controller: `Auth`
- Route: `/auth`
- Tabel: `user`
- Login menggunakan `email` + `password` (bcrypt via `password_verify()`)
- Cek `is_active = 1` sebelum login disetujui
- Session menyimpan: `email` dan `role_id`
- Guard: `is_logged_in()` di `wpu_helper.php` — cek menu access via `user_access_menu`; jika ditolak redirect ke `/auth/blocked`

### Role Admin
| role_id | Nama Role | Redirect Setelah Login |
|---------|-----------|------------------------|
| 1 | Administrator | `/admin` |
| 2 | Member | `/user` |

### Akun Admin Terdaftar
| Nama | Email | Role |
|------|-------|------|
| adminict | adminict@uui.ac.id | Administrator |
| zulfan | mzulfan@uui.ac.id | Administrator |
| mahendar | mahendar@uui.ac.id | Administrator |

---

## 2. Routes & URL Map

### Student Routes
| URL | Controller → Method | Keterangan |
|-----|---------------------|------------|
| `/` atau `/login` | `Login::index()` | Form login peserta |
| `/login/ceklogin` | `Login::ceklogin()` POST | Validasi login peserta |
| `/login/readlogin/{id}/{pass}` | `Login::readlogin()` | Login via URI (legacy) |
| `/login/logout` | `Login::logout()` | Logout peserta |
| `/dashboard` | `Dashboard::index()` | Dashboard peserta |
| `/dashboard/profil` | `Dashboard::profil()` | Profil mahasiswa |
| `/dashboard/lamanUjian` | `Dashboard::lamanUjian()` | Mulai ujian |
| `/dashboard/redirectujian` | `Dashboard::redirectujian()` | Halaman ujian aktif |
| `/dashboard/livetesans` | `Dashboard::livetesans()` | AJAX simpan jawaban |
| `/dashboard/selesai` | `Dashboard::selesai()` | Selesai ujian + hitung nilai |

### Admin Routes
| URL | Controller → Method | Keterangan |
|-----|---------------------|------------|
| `/auth` | `Auth::index()` | Form login admin |
| `/auth/registration` | `Auth::registration()` | Registrasi user admin baru |
| `/auth/verify` | `Auth::verify()` | Aktivasi akun via email token |
| `/auth/forgotPassword` | `Auth::forgotPassword()` | Kirim reset token |
| `/auth/resetPassword` | `Auth::resetPassword()` | Reset password via token |
| `/auth/blocked` | — | Halaman akses ditolak |
| `/admin` | `Admin::index()` | Dashboard admin (statistik) |
| `/admin/role` | `Admin::role()` | Kelola role |
| `/admin/roleAccess/{role_id}` | `Admin::roleAccess()` | Atur akses menu per role |
| `/admin/changeAccess` | `Admin::changeAccess()` | Toggle akses menu (POST) |
| `/admin/viewpeserta` | `Admin::viewpeserta()` | Daftar peserta gelombang terkini |
| `/admin/detailmember/{id}` | `Admin::detailmember()` | Detail peserta |
| `/admin/aturpeserta/{gel}` | `Admin::aturpeserta()` | Atur peserta per gelombang |
| `/admin/downloadTemplatePeserta` | `Admin::downloadTemplatePeserta()` | Download template Excel (.xlsx) untuk import peserta |
| `/admin/importPeserta` | `Admin::importPeserta()` POST | Upload & import data peserta dari file .xlsx/.xls/.csv |
| `/admin/viewsoal` | `Admin::viewsoal()` | Daftar bank soal |
| `/admin/tambahsoal` | `Admin::tambahsoal()` | Form tambah soal |
| `/admin/editsoal/{id}` | `Admin::editsoal()` | Form edit soal |
| `/admin/detailsoal/{id}` | `Admin::detailsoal()` | Detail soal |
| `/admin/hapussoal/{id}` | `Admin::hapussoal()` | Hapus soal |
| `/admin/jadwal` | `Admin::jadwal()` | Daftar jadwal ujian |
| `/admin/tambahjadwal` | `Admin::tambahjadwal()` | Tambah jadwal gelombang |
| `/admin/editjdw/{id}` | `Admin::editjdw()` | Edit jadwal |
| `/admin/hapusjdw/{id}` | `Admin::hapusjdw()` | Hapus jadwal |
| `/atursoal/simpansoal` | `Atursoal::simpansoal()` POST | Simpan soal baru |
| `/atursoal/updatesoal` | `Atursoal::updatesoal()` POST | Update soal |
| `/atursoal/updatejadwal` | `Atursoal::updatejadwal()` POST | Update jadwal |
| `/user` | `User::index()` | Profil admin |
| `/user/edit` | `User::edit()` | Edit profil + foto |
| `/user/changePassword` | `User::changePassword()` | Ganti password |
| `/menu` | `Menu::index()` | Kelola menu utama |
| `/menu/submenu` | `Menu::submenu()` | Kelola submenu |

---

## 3. Controllers

### `Login.php` — Login Peserta
| Method | Keterangan |
|--------|------------|
| `index()` | Tampilkan `views/auth/member.php` |
| `ceklogin()` | Validasi `no_ujian` + `pass` dari tabel `pendaftar` |
| `readlogin($id, $pass)` | Login via parameter URI (legacy) |
| `logout()` | Hapus session, redirect ke `/login` |

### `Auth.php` — Login & Registrasi Admin
| Method | Keterangan |
|--------|------------|
| `index()` | Form + validasi login admin |
| `_login()` | (private) Cek bcrypt hash, set session, route by role |
| `registration()` | Registrasi user baru + kirim email verifikasi |
| `_sendEmail($token, $type)` | (private) Kirim email via SMTP Gmail |
| `verify()` | Aktivasi akun via token (valid 24 jam) |
| `forgotPassword()` | Kirim token reset password |
| `resetPassword()` | Reset password via token |
| `blocked()` | Tampilkan halaman "Akses Ditolak" |
| `logout()` | Hapus session admin |

### `Admin.php` — Back-Office Admin
| Method | Keterangan |
|--------|------------|
| `index()` | Dashboard: total peserta, selesai, belum, jumlah soal |
| `role()` | List semua role |
| `roleAccess($role_id)` | Tampil/toggle akses menu per role |
| `changeAccess()` | Toggle entry `user_access_menu` |
| `viewpeserta()` | List peserta: filter by `id_jdwl` terkini, fallback tampil semua jika belum ada jadwal |
| `downloadTemplatePeserta()` | Generate & download template `.xlsx` (PhpSpreadsheet): Sheet 1 "Template Data" 16 kolom + Sheet 2 "Referensi Prodi" |
| `importPeserta()` | Upload file `.xlsx/.xls/.csv`, parse dengan PhpSpreadsheet, insert ke `pendaftar`. Skip duplikat. Password acak 5 karakter (A-Z0-9) |
| `viewsoal()` | List semua soal di `m_soal` |
| `tambahsoal()` | Form tambah soal (TinyMCE) |
| `hapussoal($id)` | Hapus soal |
| `editsoal($id)` | Form edit soal |
| `detailsoal($id)` | Detail soal |
| `detailmember($id)` | Detail peserta |
| `jadwal()` | List jadwal ujian (`jadwal`) |
| `tambahjadwal()` | Tambah gelombang ujian baru |
| `hapusjdw($id)` | Hapus jadwal |
| `editjdw($id)` | Edit jadwal |
| `aturpeserta($gel)` | Kelola peserta per gelombang |

### `Dashboard.php` — Portal Ujian Peserta
| Method | Keterangan |
|--------|------------|
| `index()` | Dashboard peserta; cek apakah ujian sudah dimulai |
| `profil()` | Halaman profil peserta |
| `lamanUjian()` | Mulai ujian: assign 100 soal ke `hasil_tes` |
| `redirectujian()` | Tampilkan antarmuka ujian + countdown timer |
| `livetesans()` | AJAX: simpan jawaban per soal ke `hasil_tes` |
| `selesai()` | Selesai ujian: tandai `hadir_tulis=Y`, hitung skor, simpan ke `nilaites` |

### `User.php` — Profil Admin
| Method | Keterangan |
|--------|------------|
| `index()` | Tampilkan profil |
| `edit()` | Edit nama + upload foto profil |
| `changePassword()` | Ganti password dengan verifikasi hash |

### `Menu.php` — Manajemen Menu
| Method | Keterangan |
|--------|------------|
| `index()` | List + tambah menu utama (`user_menu`) |
| `submenu()` | List + tambah submenu (`user_sub_menu`) |

### `Atursoal.php` — POST Handler Soal & Jadwal
| Method | Keterangan |
|--------|------------|
| `simpansoal()` | Insert soal baru ke `m_soal` |
| `updatesoal()` | Update soal yang ada |
| `updatejadwal()` | Update jadwal ujian |

---

## 4. Models

### `My_model.php` — Generic CRUD Model
Digunakan oleh semua controller sebagai model utama.

| Method | Keterangan |
|--------|------------|
| `cek_data($tabel, $where)` | `get_where()` — select fleksibel |
| `tampil($tabel)` | `get()` — ambil semua baris |
| `total($tabel, $where)` | Hitung jumlah baris |
| `tambahdata($table, $data)` | Insert satu row |
| `hapus($table, $where)` | Delete row |
| `update($table, $where, $data)` | Update row |
| `tampil_page($number, $offset)` | Fetch dengan paginasi |
| `fetchUrl($url)` | HTTP fetch via cURL atau `file_get_contents` |

### `Menu_model.php`
| Method | Keterangan |
|--------|------------|
| `getSubMenu()` | JOIN `user_sub_menu` + `user_menu` |

---

## 5. Database Tables

### Tabel Utama Ujian
| Tabel | Kolom Penting | Keterangan |
|-------|---------------|------------|
| `pendaftar` | `no_ujian`, `pass`, `nama`, `tempat`, `tanggal`, `jenkel`, `email`, `hp`, `no_identitas`, `asal_sekolah`, `agama`, `alamat`, `alamat_desa`, `alamat_kec`, `alamat_kota`, `alamat_prov`, `sesi`, `id_jdwl`, `hadir_tulis`, `tes_tulis`, `foto` | Data peserta/mahasiswa pendaftar |
| `m_soal` | `id`, `kat`, `soal`, `opsi_a–e`, `jawaban`, `pembahasan`, `bobot`, `file` | Bank soal (MCQ, 5 opsi) |
| `hasil_tes` | `id`, `no_ujian`, `id_soal`, `jwb` | Jawaban per peserta per soal |
| `nilaites` | `no_ujian`, `jwb_b`, `jwb_s`, `nilai`, `status` | Hasil skor ujian (benar, salah, nilai) |
| `jadwal` | `id`, `gelombang`, `tgl_tes` (unix timestamp), `active`, `created` | Jadwal gelombang ujian |

### Tabel Manajemen User Admin
| Tabel | Keterangan |
|-------|------------|
| `user` | Akun admin; kolom: `id`, `name`, `email`, `image`, `password` (bcrypt), `role_id`, `is_active` |
| `user_role` | Role: `1=Administrator`, `2=Member` |
| `user_menu` | Top-level menu: Admin, User, Menu, Manajemen Tes |
| `user_sub_menu` | Submenu dengan `menu_id`, `title`, `url`, `icon`, `is_active` |
| `user_access_menu` | RBAC: role mana yang bisa akses menu mana |
| `user_token` | Token verifikasi email / reset password |

### Tabel Registrasi & Referensi
| Tabel | Keterangan |
|-------|------------|
| `jalur` | Jalur pendaftaran (Regular, KIP, Beasiswa, RPL, dll.) |
| `fakultas` | 6 Fakultas UUI |
| `prodi` | Program studi |
| `pendidikan` | Jenjang pendidikan |
| `provinsi` | Daftar provinsi |
| `pilihan1–5` | Pilihan program studi per pendaftar |
| `lulus` | Data kelulusan / penerimaan |
| `nilaites` | Nilai ujian tulis |

### Tabel CMS / Website
| Tabel | Keterangan |
|-------|------------|
| `post` | Artikel/berita |
| `category` | Kategori berita |
| `headline` | Banner homepage |
| `galery` | Galeri foto |
| `identitas` | Profil universitas |
| `sipen_log` | Log aktivitas |

---

## 6. Alur Bisnis Utama

### Alur Ujian Peserta
```
1. Peserta login via /login (no_ujian + pass)
2. Dashboard menampilkan jadwal ujian aktif
3. Peserta klik "Mulai Ujian" → /dashboard/lamanUjian
   - Sistem assign 100 soal acak ke tabel hasil_tes
4. Peserta mengerjakan soal di /dashboard/redirectujian
   - Countdown timer aktif
   - Setiap jawaban disimpan via AJAX ke /dashboard/livetesans
5. Peserta selesai → /dashboard/selesai
   - hadir_tulis = 'Y' diupdate di pendaftar
   - Skor dihitung: (benar - salah*0.25) / total * 100
   - Disimpan ke tabel nilaites
```

### Alur Registrasi Admin Baru
```
1. Admin register via /auth/registration (nama, email, password)
2. Email verifikasi dikirim via SMTP Gmail (token valid 24 jam)
3. Admin klik link di email → /auth/verify?token=xxx
4. Akun diaktifkan (is_active = 1)
5. Admin bisa login via /auth
```

### RBAC (Role-Based Access Control)
```
1. Setiap request ke halaman admin dicek oleh is_logged_in() helper
2. URI segment 1 dicocokkan ke tabel user_menu
3. Cek tabel user_access_menu: apakah role_id user memiliki akses
4. Jika tidak ada akses → redirect ke /auth/blocked
```

---

## 7. Struktur Views

```
views/
├── auth/
│   ├── login.php              — Form login admin
│   ├── member.php             — Form login peserta (no_ujian + password)
│   ├── registration.php       — Registrasi admin
│   ├── forgot-password.php
│   ├── change-password.php
│   └── blocked.php            — Halaman akses ditolak
├── admin/
│   ├── index.php              — Dashboard statistik
│   ├── jadwal.php             — Manajemen jadwal ujian
│   ├── editjadwal.php
│   ├── peserta.php            — Daftar peserta
│   ├── detailmember.php
│   ├── aturpeserta.php        — Atur peserta per gelombang
│   ├── soal.php               — Bank soal
│   ├── inputsoal.php          — Input soal (TinyMCE editor)
│   ├── editsoal.php
│   ├── detailsoal.php
│   ├── viewhasil.php          — Lihat hasil ujian
│   ├── role.php               — Manajemen role
│   └── role-access.php        — Toggle akses menu per role
├── peserta/
│   ├── dashboard.php          — Landing page peserta + info jadwal
│   ├── profil.php             — Profil peserta
│   ├── lamanujian.php         — Halaman ujian aktif (MCQ + countdown)
│   └── selesai.php            — Halaman selesai + skor
├── user/
│   ├── index.php              — Profil admin
│   ├── edit.php               — Edit profil & foto
│   └── changepassword.php
├── menu/
│   ├── index.php              — Manajemen menu
│   └── submenu.php
├── templates/                 — Layout admin (header, footer, sidebar, topbar)
└── templates_peserta/         — Layout peserta (header, footer, sidebar, topbar)
```

---

## 8. Helper Functions (`wpu_helper.php`)

| Fungsi | Keterangan |
|--------|------------|
| `is_logged_in()` | Guard halaman admin: cek session email + RBAC menu access |
| `is_peserta_logged_in()` | Guard halaman peserta: cek session `id` |
| `base_url_helper()` | Helper URL tambahan |

---

## 9. Assets & Library Eksternal

| Library | Lokasi | Kegunaan |
|---------|--------|---------|
| SB Admin 2 | `assets/vendor/` | Bootstrap 4 admin theme |
| Bootstrap 4 | `assets/vendor/bootstrap/` | CSS framework |
| FontAwesome | `assets/vendor/fontawesome-free/` | Ikon |
| DataTables | `assets/vendor/datatables/` | Tabel dengan fitur search/sort |
| Chart.js | `assets/vendor/chart.js/` | Grafik dashboard |
| TinyMCE | `tinymce/` | Rich text editor untuk input soal |
| jQuery Countdown | `assets/js/jquery.countdown.min.js` | Timer ujian |
| PhpSpreadsheet 2.4.4 | `vendor/phpoffice/phpspreadsheet/` | Generate & baca file Excel (.xlsx/.xls/.csv) |

---

## 10. Konfigurasi Penting

### `application/config/config.php`
- `base_url` → sesuaikan dengan environment
- `encryption_key` → dibutuhkan untuk session

### `application/config/database.php`
- `hostname`: `localhost`
- `username`: `root`
- `password`: *(kosong di local)*
- `database`: `tuomaru`

### `application/config/routes.php`
- Default route: `$route['default_controller'] = 'login';`

### `composer.json` / `composer.lock`
- Dependency manager: Composer 2.x
- Require: `phpoffice/phpspreadsheet ^2.1`, PHP `>=7.4`
- Autoload: `vendor/autoload.php` di-require manual di controller yang butuh
- `vendor/` dikecualikan dari git (`.gitignore`)

### `php.ini` (di root project)
- Memory limit disesuaikan untuk query besar dari tabel `pendaftar`

---

## 11. Template Import Excel (`downloadTemplatePeserta`)

File `.xlsx` dua sheet yang di-generate oleh PhpSpreadsheet:

### Sheet 1 — Template Data
| Kolom | Label | Field DB (`pendaftar`) |
|-------|-------|------------------------|
| A | Nomor Ujian | `no_ujian` |
| B | Nama Lengkap | `nama` |
| C | Tempat Lahir | `tempat` |
| D | Tanggal Lahir (YYYY-MM-DD) | `tanggal` |
| E | Jenis Kelamin (L/P) | `jenkel` |
| F | Email | `email` |
| G | No. HP | `hp` |
| H | NIK (No. Identitas) | `no_identitas` |
| I | Asal Sekolah | `asal_sekolah` |
| J | Agama | `agama` |
| K | Alamat | `alamat` |
| L | Desa | `alamat_desa` |
| M | Kecamatan | `alamat_kec` |
| N | Kota/Kabupaten | `alamat_kota` |
| O | Provinsi | `alamat_prov` |
| P | Kode Program Studi | *(diabaikan saat import)* |

### Sheet 2 — Referensi Prodi
Berisi data prodi aktif dari tabel `prodi`: Kode, Nama Program Studi, Fakultas.

### Alur Import
```
1. Admin download template via /admin/downloadTemplatePeserta
2. Isi data peserta (kolom A-O wajib untuk no_ujian & nama)
3. Upload via form di halaman Peserta (accept: .xlsx, .xls, .csv)
4. POST ke /admin/importPeserta
   - Validasi: no_ujian + nama tidak boleh kosong
   - Validasi: jenkel harus L, P, atau kosong
   - Skip duplikat no_ujian
   - Password di-generate acak 5 karakter (A-Z + 0-9)
5. Flash message menampilkan jumlah berhasil/dilewati
```

---

## 12. Known Issues & Catatan

| Issue | Lokasi | Status |
|-------|--------|--------|
| Password peserta tidak di-hash (plain text) | `Login::ceklogin()`, tabel `pendaftar` | ⚠️ Perlu diperbaiki |
| Legacy MD5 password di tabel `users` | `users.password` | ⚠️ Tabel lama |
| `random_bytes()` error di PHP < 7 | `Auth.php` line 105, 226 | Sudah tidak relevan (PHP 8.2) |
| Memory exhausted pada query besar | `DB_driver.php` line 654 | Perlu optimasi query / pagination |
| cPanel handler di `.htaccess` | `.htaccess` | ✅ Sudah diperbaiki |
| Tabel `users` vs `user` — dua tabel user berbeda | DB | ⚠️ Perlu konsolidasi |
| Kolom P (Kode Program Studi) di template Excel diabaikan saat import | `Admin::importPeserta()` | ⏳ Belum diimplementasi |
| Password peserta disimpan plain text | `pendaftar.pass` | ⚠️ Perlu di-hash |

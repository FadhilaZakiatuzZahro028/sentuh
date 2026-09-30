# 09 — Project Progress

**Last sync dokumentasi:** 30 September 2026
**Deadline:** 1 November 2026
**Internal target:** 28 Oktober 2026
**Status:** Implementasi aktual sudah melampaui catatan progres sebelumnya. CRUD bisnis/tautan/perangkat, redesign login, Dashboard Overview tahap awal, Universal Business Page, stable device redirect, dan generator QR sudah ada. Sebagian mempunyai bukti manual, sebagian baru terverifikasi melalui audit kode/route dan belum memenuhi Definition of Done. Landing page, deployment, analytics, FAQ, serta prototipe QR/NFC fisik belum selesai.

> **Aturan status:** `Verified` berarti ada bukti terminal/screenshot/pengujian pengguna atau pemeriksaan tool pada audit ini. `Implemented — test pending` berarti file/alur ada di repository aktual tetapi belum mempunyai bukti pengujian yang cukup. Jangan menyamakan keberadaan kode dengan fitur selesai.

## 1. Environment dan baseline

| Area | Status | Catatan |
|---|---|---|
| Laravel + Filament lokal | Verified | Login/logout lokal pernah diuji; audit archive 30 Sep berhasil boot `php artisan route:list` |
| Versi lokal | Verified dari laporan pengguna | PHP `8.3.6`, Laravel `13.33.0`, Filament `5.8.4`, Tailwind `4.3.3`, MySQL `8.4.3` |
| Build frontend sebelumnya | Verified lama | `npm install` + `npm run build` pernah lulus; perlu build ulang pada Windows setelah baseline terbaru |
| Composer validation sebelumnya | Verified lama | `composer validate --strict` pernah lulus |
| Automated test | Belum memadai | Hanya ExampleTest lama; belum ada feature test domain |
| PostgreSQL | Belum diuji | Wajib sebelum keputusan deployment produksi |

Audit container 30 September tidak dapat menjalankan PHPUnit/build frontend secara representatif karena environment Linux audit tidak memiliki beberapa PHP extension/native Node binding yang dibutuhkan. Ini **bukan** bukti aplikasi Windows gagal; ulangi test pada Laragon/Windows setelah TASK 010 diterapkan.

## 2. Git dan dokumentasi

- Branch archive: `main`.
- Commit terakhir yang tersimpan di Git archive: `6b626b1` (`docs: update GitHub setup progress`).
- Banyak implementasi setelah commit tersebut masih berupa modified/untracked files.
- `.env` tidak tracked, tetapi file `.env` ada di archive yang diunggah; jangan membagikan archive tersebut secara publik.
- `storage/framework/views/.gitignore` hilang pada archive sehingga compiled Blade views muncul sebagai untracked. TASK 010 mengembalikan file ignore tersebut; cache view tidak perlu di-commit.
- Dokumentasi 27–28 September sebelumnya tidak lagi konsisten dengan implementasi aktual; TASK 010 menyinkronkan `03`, `04`, `06`, `08`, `09`, dan `docs/README.md`.

**Belum dilakukan pada laptop pengguna:** `git add`, commit, atau push. Jangan klaim GitHub sudah berisi baseline terbaru sebelum pengguna mengonfirmasi.

## 3. Bisnis dan tautan

### Verified

- Migration `businesses` dan `business_links` sebelumnya dilaporkan `Ran` pada MySQL lokal.
- CRUD dasar bisnis, upload logo/cover, edit, slug unik, dan penyimpanan tautan pernah diuji.
- `business_links.business_id` memakai `ON DELETE RESTRICT`.
- URL `javascript:alert(1)` dilaporkan ditolak dan tidak tersimpan pada pengujian 28 September.
- Bisnis dengan tautan atau perangkat dilaporkan tidak dapat dihapus; bisnis sementara tanpa relasi berhasil dihapus.

### Implemented — test pending / gap

- Halaman publik memakai `accent_color`, tetapi form admin belum menyediakan input warna aksen.
- Tabel bisnis belum dikonfirmasi menampilkan jumlah perangkat seperti target PRD.
- Pengujian negative upload, batas field, toggle/reorder/edit/hapus seluruh variasi tautan, dan automated feature tests belum lengkap.

## 4. Perangkat

### Verified dari pengujian 28 September

- Migration `devices` berjalan pada MySQL.
- UUID/public code dibuat otomatis dan tetap stabil setelah perubahan status.
- Status awal `inactive`; relasi Business/Device bekerja.
- Create Device, edit status, tabel device, dan copy UUID diuji.
- Bisnis dengan perangkat mendapat guard penghapusan.

### Implemented — test pending

- Resource perangkat mempunyai aksi QR preview/download.
- Penghapusan perangkat belum diuji secara lengkap.
- Kebijakan final terhadap hard-delete device yang pernah dipakai pada acrylic belum ditetapkan; jangan ubah menjadi cascade tanpa keputusan baru.

## 5. QR, redirect, dan Universal Business Page

### Implemented — test pending

- `App\\Support\\DeviceQrCode` menghasilkan URL stabil `/t/{deviceCode}?via=qr`, image QR, dan SVG.
- QR library yang digunakan adalah `chillerlan/php-qrcode` yang tersedia transitif melalui Filament.
- `/t/{deviceCode}` sudah memeriksa device aktif dan bisnis `published`, lalu redirect ke slug bisnis terkini.
- `/b/{slug}` hanya mengambil bisnis `published` dan link aktif terurut.
- URL link publik difilter ulang agar hanya `http`/`https`.
- Universal Business Page Blade sudah ada dengan logo, cover, identitas, alamat, deskripsi, warna aksen, dan tombol.

### Belum terverifikasi / belum lengkap

- dua perangkat → satu bisnis;
- perubahan slug setelah QR dibuat;
- device inactive / code unknown / business draft;
- QR SVG benar-benar dipindai ponsel;
- NFC ditulis dan diuji pada ponsel kompatibel;
- tiga tipe organisasi menggunakan template yang sama;
- mobile 360px dan ponsel fisik;
- halaman unavailable khusus SENTUH untuk kondisi publik yang tidak tersedia.

## 6. Dashboard Overview

### Implemented — test pending

Custom Dashboard dan widget sudah ada:

- `SentuhHeroShowcase`;
- `SentuhStatsOverview`;
- `SentuhAccessTrend`;
- `SentuhRecentActivity`;
- `SentuhRecentBusinesses`.

KPI Total Bisnis, Halaman Terbit, dan Perangkat Aktif membaca database. Total Akses menampilkan **Belum tersedia**. Chart/aktivitas belum memakai angka palsu dan menunggu sumber data nyata.

### Belum selesai

- filter 7/30/90 hari;
- `scan_events`;
- Total Akses aktual;
- seri QR/NFC aktual;
- activity log aktual;
- verifikasi mobile/accessibility Dashboard.

## 7. Autentikasi admin

### Verified

- Custom login dua panel desktop dan satu kolom emulator mobile sudah memiliki bukti manual.
- Route admin yang diaudit memakai middleware autentikasi Filament.

### Blocker sebelum production

`App\\Models\\User` belum mempunyai aturan akses panel production Filament yang eksplisit. Ini harus diselesaikan dan diuji pada environment non-local sebelum deployment. Login lokal bukan bukti akses production akan berfungsi.

## 8. Landing page, deployment, analytics, FAQ, dan prototipe

| Fitur | Status |
|---|---|
| Landing page SENTUH | Belum; `/` masih Laravel welcome |
| `scan_events` / access analytics | Belum |
| Render/Supabase deployment | Belum |
| PostgreSQL portability test | Belum |
| Persistent object storage | Belum |
| Acrylic fisik | Belum terbukti |
| QR cetak + scan ponsel nyata | Belum terbukti |
| NFC programming + tap ponsel | Belum terbukti |
| Curated FAQ + WhatsApp handoff | Belum |

## 9. Scope tambahan yang belum disahkan

Audit archive menemukan migration/model/resource untuk Penjualan, Rekening Kas, Pembayaran, Pengeluaran Kas, dan Laporan Keuangan. Fitur tersebut tidak tercantum pada PRD MVP SENTUH saat ini.

**Status sementara:** jangan dihapus, tetapi **freeze pengembangan** sampai diputuskan apakah subsystem ini memang dibutuhkan untuk deliverable Entrepreneurship. Keberadaannya tidak boleh menggeser prioritas QR/NFC, halaman publik, deployment, dan prototipe fisik.

## 10. Milestone aktif — TASK 010

**Tujuan:** membuat baseline proyek dapat dipercaya sebelum coding fitur baru.

1. Sinkronkan dokumen dengan implementasi aktual.
2. Kembalikan `storage/framework/views/.gitignore` agar compiled views tidak masuk Git.
3. Audit `git status` dan `git diff --check`.
4. Jangan commit `.env`, `vendor`, `node_modules`, `public/build`, atau cache view.
5. Setelah diterapkan di laptop, pengguna menjalankan verifikasi Git/build/test lalu mengirim hasil sebelum TASK 011.

## 11. Urutan setelah TASK 010

1. **TASK 011 — Stabilization & automated tests:** akses Filament production, auth negatif, business/link/device, redirect dan public visibility.
2. **TASK 012 — Dashboard Phase 1 verification:** data nyata/empty state dan mobile.
3. **TASK 013 — Universal Business Page finalization:** accent color admin, tiga kategori, unavailable state, 360px.
4. **TASK 014 — QR/NFC core end-to-end:** stable redirect, slug change, scan QR, kebijakan device delete, NFC URL.
5. **TASK 015 — Landing Page MVP.**
6. **TASK 016 — Deployment + prototype fisik.**
7. **TASK 017 — `scan_events` + Dashboard analytics.**
8. **TASK 018 — FAQ terkurasi + WhatsApp handoff.**

Jangan gunakan `migrate:fresh` pada database lokal yang berisi akun admin/data demo tanpa backup dan persetujuan eksplisit.

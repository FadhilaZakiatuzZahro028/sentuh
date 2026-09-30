# 06 — Test Plan / Demo Checklist

**Status:** Sinkronisasi audit 30 September 2026. Checklist membedakan bukti pengujian manual sebelumnya dari implementasi yang baru terlihat pada repository. Item `[x]` hanya untuk hasil yang benar-benar pernah dilaporkan/diamati; keberadaan kode saja tidak diberi status lulus.
**Tanggal revisi:** 30 September 2026
**Acuan:** `AGENTS.md`, `01_PROJECT_BRIEF.md`, `02_PRD.md`, `03_ARCHITECTURE.md`, `04_DESIGN_SYSTEM.md`, `08_DECISIONS.md`, `09_PROGRESS.md`.

> `[ ]` berarti belum terverifikasi atau belum selesai, bukan otomatis gagal. Jika audit environment tidak dapat menjalankan suatu test karena dependency platform, ulangi pada Laragon/Windows dan catat hasil aktual sebelum mencentang.

## 1. Environment, dependency, dan Git

- [x] Laravel berjalan lokal pada Windows 11 + Laragon berdasarkan laporan pengguna.
- [x] Versi lingkungan yang dilaporkan: PHP `8.3.6`, Laravel `13.33.0`, Filament `5.8.4`, Tailwind CSS `4.3.3`, MySQL `8.4.3`.
- [x] `npm install` dan `npm run build` pernah berhasil pada baseline awal; warning Fontaine tidak menggagalkan build.
- [x] `composer validate --strict` pernah menghasilkan `./composer.json is valid`.
- [x] `.env` dilaporkan tidak tracked; archive Git terakhir hanya melacak `.env.example`.
- [x] Audit archive 30 September berhasil boot dan menjalankan `php artisan route:list`; route publik dan admin terdaftar.
- [ ] Jalankan ulang `php artisan --version`, `php -v`, `composer validate --strict`, `php artisan test`, dan `npm run build` di laptop setelah TASK 010 diterapkan.
- [ ] Pastikan `storage/framework/views/.gitignore` kembali aktif dan compiled Blade views tidak muncul di `git status`.
- [ ] Audit `git status`/`git diff` lalu buat commit baseline baru; commit terakhir archive masih `6b626b1`.
- [ ] Pastikan `.env`, `vendor`, `node_modules`, `public/build`, dan cache runtime tidak ikut commit.

**Catatan audit container:** PHPUnit/build frontend tidak dapat dijadikan bukti pada container audit karena ada PHP extension/native Node binding yang tidak tersedia. Jangan mencatatnya sebagai kegagalan aplikasi Windows.

## 2. Autentikasi dan akses admin

- [x] Filament terpasang dan halaman login tersedia.
- [x] Login/logout lokal berhasil diuji sebelum dan sesudah redesign menurut pengguna.
- [x] Audit `route:list -v` 30 September menunjukkan route CRUD admin memakai `Filament\\Http\\Middleware\\Authenticate`.
- [ ] Akses `/admin` tanpa sesi harus redirect/ditolak pada browser nyata.
- [ ] Kredensial salah harus ditolak tanpa membocorkan informasi sensitif.
- [ ] Uji keyboard/fokus/kontras dan pesan error login.
- [ ] Uji ponsel fisik, landscape, dan lebar 360px.
- [ ] **Sebelum deployment:** uji environment non-local. `App\\Models\\User` saat audit belum mempunyai aturan akses panel production Filament yang eksplisit; selesaikan dan buktikan sebelum go-live.

## 3. CRUD bisnis dan tautan

### Sudah memiliki bukti manual

- [x] Migration `businesses` berjalan dan struktur utama diverifikasi.
- [x] Bisnis demo dibuat melalui Filament dan terlihat pada tabel.
- [x] Logo/cover tersimpan pada disk `public`; preview lokal bekerja setelah `APP_URL` diperbaiki.
- [x] Edit tagline berhasil tanpa menghilangkan gambar.
- [x] Slug duplikat `kopi-senja` ditolak dan jumlah record tetap satu.
- [x] Edit record tanpa mengubah slug sendiri berhasil.
- [x] Migration `business_links` berjalan dengan FK `ON DELETE RESTRICT`.
- [x] Repeater business links tampil dan satu link berhasil disimpan/diverifikasi.
- [x] `javascript:alert(1)` dilaporkan ditolak dan tidak ditemukan di database pada 28 September.
- [x] Bisnis dengan tautan tidak dapat dihapus melalui Filament.
- [x] Bisnis sementara tanpa tautan/perangkat berhasil dihapus.
- [x] Bisnis tanpa tautan tetapi mempunyai perangkat dilaporkan ditolak saat dihapus dan menampilkan notifikasi.

### Belum lengkap

- [ ] Uji URL ekstrem/panjang, skema lain selain `javascript:`, dan whitespace/manipulasi URL.
- [ ] Uji toggle aktif/nonaktif, reorder, edit, hapus satu link, serta kondisi tanpa link.
- [ ] Uji file bukan gambar, ukuran >2 MB, ganti gambar, hapus gambar.
- [ ] Uji batas panjang `name`, `slug`, `category`, tagline, alamat, dan deskripsi.
- [ ] Tambahkan input/admin test untuk `accent_color` bila fitur dipertahankan pada MVP.
- [ ] Verifikasi tabel bisnis menampilkan jumlah perangkat sesuai PRD.
- [ ] Tambahkan automated feature tests untuk CRUD/validation/delete guard.

## 4. CRUD perangkat

### Sudah memiliki bukti manual 28 September

- [x] Migration `devices` berjalan pada MySQL.
- [x] FK menggunakan `restrictOnDelete()`.
- [x] UUID/public code otomatis dan format/stabilitasnya diuji melalui Tinker.
- [x] Status awal `inactive` dan relasi Business/Device diuji.
- [x] Create Device melalui Filament berhasil dan diverifikasi melalui Tinker.
- [x] Edit status menjadi `active` berhasil tanpa mengubah UUID.
- [x] Tabel device menampilkan informasi utama.
- [x] Copy UUID pernah diuji.
- [x] Bulk delete device dinonaktifkan sementara.

### Belum terverifikasi

- [ ] Hard-delete perangkat dan perilaku setelah perangkat pernah dipakai untuk QR/acrylic.
- [ ] Invalid/missing business relation.
- [ ] Collision/uniqueness public code melalui automated test.
- [ ] Hak akses CRUD tanpa login.
- [ ] Automated feature tests Device.

## 5. Dashboard Overview

Audit kode 30 September menemukan custom Dashboard dan widget, tetapi belum ada bukti UI/test lengkap untuk baseline terbaru.

- [ ] Verifikasi Dashboard SENTUH benar-benar tampil setelah login pada laptop pengguna.
- [ ] KPI **Total Bisnis** sama dengan hitungan database yang diketahui.
- [ ] KPI **Halaman Terbit** hanya menghitung bisnis `published`.
- [ ] KPI **Perangkat Aktif** hanya menghitung device `active`.
- [ ] **Total Akses** menampilkan status belum tersedia sebelum `scan_events`; tidak boleh menampilkan angka palsu.
- [ ] Tren Akses menampilkan empty state sebelum tracking dibuat.
- [ ] Aktivitas Terbaru menampilkan empty state sebelum sumber activity log dibuat.
- [ ] Tabel Bisnis Terbaru benar-benar membaca record terbaru dari database.
- [ ] Tidak ada link navigasi kosong/broken yang seolah fitur siap.
- [ ] Responsif 360px dan desktop; tidak horizontal overflow.
- [ ] Fokus keyboard, kontras, label, dan pesan state diperiksa.
- [ ] Filter 7/30/90 hari belum dianggap selesai sampai data periodik tersedia dan query-nya diuji.

## 6. Universal Business Page

Audit kode menemukan `BusinessPageController`, route `/b/{slug}`, dan `resources/views/business/show.blade.php`.

- [ ] Bisnis `published` yang valid dapat dibuka dari `/b/{slug}`.
- [ ] Bisnis `draft` tidak dapat dibuka publik.
- [ ] Slug tidak dikenal tidak membocorkan data internal.
- [ ] Logo dan cover tampil jika tersedia dan layout tetap baik jika kosong.
- [ ] Tagline/deskripsi/alamat hanya tampil sesuai data.
- [ ] Link inactive tidak tampil.
- [ ] Link invalid/non-http(s) tidak tampil.
- [ ] Urutan link mengikuti `sort_order`.
- [ ] Accent color valid diterapkan; value invalid fallback dengan aman.
- [ ] Kafe, sekolah, dan minimal satu organisasi lain menggunakan template yang sama tanpa kode per kategori.
- [ ] Mobile 360px dan ponsel fisik lolos tanpa overflow.
- [ ] Buat halaman unavailable SENTUH yang informatif jika diputuskan sesuai PRD; saat ini error publik masih mengandalkan 404 framework.

## 7. Stable redirect dan QR

Audit kode menemukan `DeviceRedirectController` dan `DeviceQrCode`; ini **belum** berarti alur telah lulus end-to-end.

- [ ] `/t/{deviceCode}` dengan device aktif + bisnis published redirect ke bisnis yang benar.
- [ ] Kode tidak dikenal menghasilkan respons aman.
- [ ] Device inactive tidak membuka bisnis.
- [ ] Business draft melalui device tidak membuka data publik.
- [ ] Dua device dengan kode berbeda dapat menuju bisnis yang sama.
- [ ] Ubah slug bisnis; URL device lama tetap mengarah ke bisnis yang benar.
- [ ] Generator QR memakai `APP_URL`/konfigurasi dan bukan localhost hard-coded.
- [ ] QR preview admin membuka data QR yang sesuai device.
- [ ] Download SVG valid dan dapat dibuka.
- [ ] QR yang dihasilkan benar-benar dipindai dari ponsel.
- [ ] Parameter `?via=qr` tidak diklaim sebagai analytics sampai `scan_events` dibuat.
- [ ] Putuskan apakah `chillerlan/php-qrcode` dijadikan dependency langsung; saat ini tersedia transitif melalui Filament.

## 8. NFC

- [ ] Tentukan URL NFC menggunakan stable device route, bukan slug langsung.
- [ ] Bila kanal dibedakan, gunakan `?via=nfc` dan uji hasil route.
- [ ] Tulis NFC tag fisik.
- [ ] Tap menggunakan ponsel NFC kompatibel.
- [ ] Setelah analytics dibuat, pastikan kanal NFC berasal dari URL yang diterbitkan, bukan dugaan server.

## 9. Analytics QR/NFC

Belum diimplementasikan.

- [ ] Finalisasi schema `scan_events`.
- [ ] Minimal simpan `device_id`, `channel`, dan waktu kejadian; hindari IP/personal data yang tidak perlu.
- [ ] Catat hanya redirect yang benar-benar terjadi sesuai definisi yang diputuskan.
- [ ] Uji QR vs NFC terpisah.
- [ ] Uji Total Akses per periode.
- [ ] Uji line chart QR/NFC terhadap event yang diketahui.
- [ ] Jangan menyebut metrik sebagai unique visitors, physical NFC verification, review count, atau sales.

## 10. Landing page dan FAQ

- [ ] `/` tidak lagi Laravel welcome.
- [ ] Hero SENTUH menjelaskan produk QR/NFC tanpa klaim berlebihan.
- [ ] CTA WhatsApp bekerja pada mobile.
- [ ] Visual acrylic diberi status konsep/foto nyata secara jujur.
- [ ] FAQ memakai jawaban terkurasi.
- [ ] Pertanyaan di luar FAQ memberi fallback jujur.
- [ ] WhatsApp handoff hanya setelah tindakan pengguna.

FAQ tetap setelah core/deployment/analytics dasar sesuai prioritas proyek.

## 11. Deployment dan storage

- [ ] Migration/query diuji pada PostgreSQL.
- [ ] Tentukan platform deployment final setelah uji teknis dan biaya.
- [ ] Secret hanya di environment host; tidak di Git/screenshot.
- [ ] Production access Filament diuji dengan user authorization yang benar.
- [ ] `APP_URL` HTTPS menghasilkan business/device/QR URL yang benar.
- [ ] Logo/cover persisten setelah restart/redeploy.
- [ ] Smoke test admin, business page, links, device redirect setelah deploy.
- [ ] Cold-start/free-tier behavior diuji.
- [ ] Backup screenshot/video demo disiapkan.

## 12. Prototipe fisik dan demo

- [ ] Minimal satu acrylic dibuat dan difoto.
- [ ] Total biaya dicatat dan tetap di bawah Rp100.000.
- [ ] QR final dicetak dan dipindai pada ponsel nyata.
- [ ] NFC final diprogram dan ditap pada ponsel nyata.
- [ ] Semua demo customer/sales/testimonial fiktif diberi label simulasi.
- [ ] Screenshot dan bukti test disimpan untuk laporan akademik.

## 13. Scope tambahan Penjualan/Kas/Laporan Keuangan

Audit menemukan implementasi subsystem ini, tetapi PRD belum menyatakannya sebagai bagian MVP.

- [ ] Putuskan secara eksplisit: **masuk scope Entrepreneurship** atau **freeze/out-of-focus**.
- [ ] Sebelum keputusan, jangan menambah requirement, UI, atau workflow baru pada subsystem tersebut.
- [ ] Jika dipertahankan, buat requirement, acceptance criteria, architecture note, dan test plan terpisah sebelum menyebutnya selesai.

## 14. Urutan verifikasi berikutnya

1. Terapkan TASK 010 di laptop dan kirim `git status`, `git diff --check`, build/test output.
2. Stabilkan auth production + automated feature tests inti.
3. Verifikasi Dashboard dan Universal Business Page.
4. Jalankan stable redirect + QR end-to-end.
5. Lanjut landing page, deployment/prototype, analytics, lalu FAQ.

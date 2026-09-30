# 08 — Decisions (Living Log)

**Status dokumen:** Living log — keputusan historis dipertahankan; kontradiksi status diperbarui berdasarkan audit repository 30 September 2026.
**Tanggal revisi:** 30 September 2026

Dokumen ini mencatat keputusan produk/teknis. **Decision record bukan bukti fitur lulus pengujian.** Bukti aktual mengikuti `06_TEST_PLAN.md` dan `09_PROGRESS.md`.

## 1. Riwayat keputusan awal — 25 September 2026

| Date | Decision | Why | Status saat ini |
|---|---|---|---|
| 2026-09-25 | Working brand **Sentuh** | Konsep touch/NFC sederhana | Tetap; trademark/domain belum dicek |
| 2026-09-25 | Laravel monolith + Blade/Tailwind/Alpine + Filament | Mengurangi kompleksitas | Final arah teknis |
| 2026-09-25 | Local MySQL, kandidat Supabase PostgreSQL | Reuse Laragon + kandidat cloud demo | PostgreSQL belum diuji |
| 2026-09-25 | Kandidat Render Docker | Menghindari biaya awal | Belum final/diuji |
| 2026-09-25 | Satu template lintas institusi | Perbedaan ada pada data/link, bukan codebase | Final |
| 2026-09-25 | Stable device redirect terpisah dari slug bisnis | QR cetak harus tahan perubahan slug | Final; implementasi sudah ada, test end-to-end pending |
| 2026-09-25 | Curated FAQ + optional WhatsApp | Tanpa API AI berbayar/claim liar | Final scope; belum dibangun |
| 2026-09-25 | Prototype < Rp100.000; simulasi harus berlabel | Constraint mata kuliah | Final |

## 2. Keputusan 26 September 2026

### DEC-009C-01 — Stack

- Pertahankan Laravel monolith, Blade, Tailwind, Alpine sesuai kebutuhan, dan Filament.
- Versi lingkungan berdasarkan laporan: Laravel `13.33.0`, PHP `8.3.6`, Filament `5.8.4`, Tailwind `4.3.3`, MySQL `8.4.3`.
- Jangan menambah React terpisah, API service, queue, Redis, atau teknologi baru hanya untuk menyamai mockup.

### DEC-009C-02 — Identitas visual

- Gunakan **MIDNIGHT BLUE**: `#10233F`, `#F7F8FA`, `#0B1424`, `#2563EB`.
- `docs/assets/SENTUH_UI_REFERENCE.png` adalah referensi gaya/komposisi, bukan desain 1:1.
- Identitas business page boleh memakai logo/foto/accent color masing-masing organisasi.

### DEC-009C-03 — Dashboard Overview dan integritas data

Target Dashboard:

- filter 7/30/90 hari untuk metrik periodik;
- Total Bisnis;
- Halaman Terbit;
- Perangkat Aktif;
- Total Akses;
- Tren Akses QR/NFC;
- Aktivitas Terbaru;
- Bisnis Terbaru.

Semua statistik aplikasi harus berasal dari data nyata. Jika sumber belum ada, gunakan empty state/status belum tersedia. Jangan mengisi angka mockup sebagai data produksi.

### DEC-009C-04 — Universal Business Page dan links

- Satu template Blade berbasis data untuk seluruh kategori.
- Google Review, WhatsApp, Maps, website, Instagram, dan custom link bersifat opsional.
- Tautan dapat diberi label, urutan, status aktif, dan harus aman.
- Jangan membuat page/template khusus per kategori.

### DEC-009C-05 — Stable device URL

- Setiap perangkat memiliki `public_code` unik/stabil.
- Route permanen `/t/{deviceCode}` menjadi entry point QR/NFC.
- Jangan mencetak slug bisnis langsung pada QR.
- `?via=qr` / `?via=nfc` boleh membedakan kanal jika tracking sudah tersedia.

### DEC-009C-06 — Prioritas MVP

Urutan inti tetap: dokumentasi/schema → CRUD → Dashboard foundation → Universal Business Page → stable QR/NFC → deployment/prototipe → access tracking/chart → curated FAQ.

### DEC-009C-07 — Deployment kandidat

Supabase PostgreSQL, Render Docker, dan object storage persisten tetap **kandidat**, bukan production stack yang sudah disahkan. PostgreSQL portability, storage, HTTPS, secrets, dan behavior free-tier harus diuji sebelum keputusan final.

## 3. Keputusan 27 September 2026

### DEC-20260927-01 — Skema bisnis dan tautan

- `businesses`: slug unique, status `draft/published`, konten business umum.
- `business_links`: `business_id`, `label`, `type`, `url`, `sort_order`, `is_active`.
- Relasi `HasMany/BelongsTo`; link dikelola dalam konteks bisnis.
- Tidak membuat field kontak wajib per industri.

### DEC-20260927-02 — Cegah hapus bisnis yang masih mempunyai tautan

- `business_links.business_id` memakai `restrictOnDelete()`.
- Jangan ganti menjadi cascade tanpa keputusan baru.
- UI harus memberi notifikasi yang dapat dipahami.

### DEC-20260927-03 — Login admin dua panel

- Pertahankan autentikasi Filament.
- Desktop: panel visual acrylic Midnight Blue + form terang.
- Mobile: prioritaskan form dan sembunyikan panel visual bila perlu.
- Aset render adalah konsep, bukan foto produk fisik; QR dalam render bukan QR fungsional.

## 4. Keputusan 28 September 2026

### DEC-20260928-01 — Struktur perangkat QR/NFC

- Satu perangkat fisik mendukung QR dan NFC sekaligus.
- `public_code` berupa UUID unik 36 karakter.
- UUID dibuat otomatis dan tidak dapat diubah melalui update model normal.
- Status awal `inactive`.
- Device `BelongsTo Business`; Business `HasMany Devices`.
- FK `devices.business_id` memakai `restrictOnDelete()`.
- MVP tidak memakai field `type` atau `notes`.

Bukti manual yang dilaporkan: migration devices berjalan, UUID/status/relasi diuji, create/edit device bekerja, UUID tetap sama setelah perubahan status.

### DEC-20260928-02 — Administrasi penghapusan

- Bisnis tidak dapat dihapus jika masih mempunyai tautan atau perangkat.
- Filament memberi notifikasi saat penghapusan ditolak.
- Bulk delete bisnis dan perangkat dinonaktifkan sementara.
- `public_code` tidak menjadi input form.
- Tabel device menyediakan salin UUID.

## 5. Sinkronisasi audit — 30 September 2026

Bagian ini mencatat kondisi implementasi yang ditemukan pada repository. Ini **tidak otomatis mengubah target PRD**.

### DEC-AUDIT-20260930-01 — Jangan membuat ulang fitur yang ternyata sudah ada

Audit menemukan implementasi:

- custom Dashboard + widget KPI/empty state;
- Universal Business Page `/b/{slug}`;
- stable redirect `/t/{deviceCode}`;
- generator/preview/download QR;
- CRUD device yang sudah lebih maju dari dokumentasi 27 September.

**Konsekuensi:** milestone berikutnya berfokus pada sinkronisasi, testing, dan gap closure. Jangan membuat migration/resource/controller baru untuk fitur yang sama hanya karena dokumen lama menyebutnya belum ada.

### DEC-AUDIT-20260930-02 — Dependency QR perlu dibuat eksplisit atau diputuskan

`App\\Support\\DeviceQrCode` menggunakan `chillerlan/php-qrcode` `5.0.5`. Package saat audit tersedia sebagai dependency transitif `filament/filament`, bukan requirement langsung root `composer.json`.

**Status:** implementasi ada; keputusan dependency final **pending**. Sebelum deployment, pilih salah satu secara eksplisit:

1. jadikan package direct dependency dan pin kompatibilitas; atau
2. ganti/pertahankan pendekatan lain yang disetujui.

Jangan mengubah package sekarang hanya untuk merapikan audit.

### DEC-AUDIT-20260930-03 — Scope Penjualan/Kas/Laporan Keuangan belum disahkan

Audit menemukan model/migration/resource untuk Penjualan, Rekening Kas, Pembayaran, Pengeluaran Kas, dan Laporan Keuangan. Fitur ini tidak tercantum pada PRD MVP yang berlaku.

**Kontrol sementara:**

- jangan dihapus pada TASK 010;
- jangan dikembangkan lebih jauh;
- jangan menganggapnya deliverable resmi;
- putuskan secara eksplisit apakah ia diperlukan untuk tugas Entrepreneurship sebelum memasukkannya ke PRD/Architecture sebagai scope final.

Tujuannya mencegah scope creep agar alur QR/NFC, halaman publik, deployment, dan prototipe fisik tetap prioritas.

### DEC-AUDIT-20260930-04 — Baseline Git harus diamankan sebelum fitur baru

Audit archive menunjukkan commit terakhir `6b626b1`, sedangkan banyak fitur terkini masih modified/untracked. `storage/framework/views/.gitignore` juga hilang sehingga compiled Blade views muncul sebagai untracked.

**Keputusan milestone:** TASK 010 hanya menyinkronkan dokumentasi dan kebersihan baseline Git. Tidak ada coding fitur baru sampai pengguna memverifikasi status/diff/build/test lokal dan baseline aman untuk di-commit.

## 6. Hal yang masih perlu keputusan

- Apakah package QR akan dijadikan direct dependency atau diganti dengan pendekatan lain.
- Kebijakan hard-delete device setelah kode pernah dipakai/cetak; status `inactive` mungkin lebih aman, tetapi belum diputuskan final.
- Struktur `scan_events`, definisi event sukses, retensi/minimalisasi data, dan sumber activity log admin.
- Aturan akses user Filament production yang final.
- Platform hosting/database/storage produksi dan alamat publik/domain jangka panjang.
- Apakah subsystem Penjualan/Kas/Laporan Keuangan benar-benar bagian scope Entrepreneurship SENTUH.

**Prosedur:** untuk setiap keputusan baru, catat tanggal, konteks, pilihan, keputusan, konsekuensi, dan test yang diperlukan. Jangan mengubah status fitur menjadi selesai hanya karena decision record ditulis.

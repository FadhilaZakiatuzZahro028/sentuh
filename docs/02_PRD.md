# 02 — Product Requirements Document (PRD) SENTUH

**Status:** Requirements utama tetap TASK 009B; catatan keputusan perangkat disinkronkan pada TASK 010
**Tanggal sinkronisasi status:** 30 September 2026
**Referensi:** `AGENTS.md`, `docs/01_PROJECT_BRIEF.md`, `docs/03_ARCHITECTURE.md`, `docs/04_DESIGN_SYSTEM.md`, dan `docs/05_DEVELOPMENT_WORKFLOW.md`.
**Arah UI resmi:** MIDNIGHT BLUE; `docs/assets/SENTUH_UI_REFERENCE.png` adalah acuan gaya dan komposisi, bukan desain yang disalin persis.

> Dokumen ini mendefinisikan **kebutuhan yang dituju**, bukan bukti fitur sudah dibangun. Status implementasi dan bukti pengujian dicatat terpisah di `docs/09_PROGRESS.md` dan `docs/06_TEST_PLAN.md`. Nama bisnis, tampilan, dan angka pada mockup merupakan **ilustrasi**, bukan pelanggan ataupun statistik aktual.

## 1. Tujuan dan batasan

SENTUH adalah produk acrylic berbasis **QR Code dan NFC** yang membuka halaman digital milik bisnis atau organisasi. Satu sistem harus dapat melayani kafe, sekolah, klinik, UMKM, dan organisasi lain menggunakan **satu template halaman publik berbasis data**, tanpa membuat kode khusus untuk tiap kategori.

**Batas proyek:** tenggat 1 November 2026; target internal 28 Oktober 2026; tim 2 orang; anggaran prototipe **di bawah Rp100.000**. Dahulukan alur demonstrasi fisik yang benar-benar bekerja daripada penyempurnaan analitik atau kosmetik.

**Arsitektur yang dipertahankan:** Laravel monolith; Filament untuk admin; Blade, Tailwind, Alpine.js sesuai kebutuhan untuk antarmuka publik; MySQL lokal. Supabase PostgreSQL, Render Docker, dan penyimpanan objek masih **kandidat produksi**, bukan pilihan hosting yang sudah diuji/disahkan. Jangan mengubah stack hanya untuk menyamai mockup.

**Di luar MVP:** akun mandiri pemilik bisnis, billing/subscription, payment gateway, chatbot berbasis API generative AI, integrasi API Google Review, pengambilan ulasan Google, page builder bebas, domain kustom per pelanggan, dan analytics kompleks.

## 2. Pengguna dan alur utama

| Pengguna | Kebutuhan | Alur |
|---|---|---|
| Calon pembeli SENTUH | Memahami produk dan menghubungi tim | Landing page → informasi produk/cara kerja → FAQ terkurasi atau WhatsApp atas pilihan sendiri |
| Admin internal SENTUH | Mengelola bisnis, tautan, dan perangkat | Login Filament → data bisnis dan publikasi → tautan → perangkat → QR/NFC |
| Pengunjung bisnis | Mengakses informasi yang relevan | Scan QR / tap NFC → rute perangkat permanen → halaman organisasi terbit → tombol tujuan yang aktif |

Hanya tim internal yang memiliki akses admin pada MVP. Halaman bisnis publik tidak menyediakan akses tulis.

## 3. Landing page SENTUH

**Kebutuhan fungsional:**
- Menjelaskan produk acrylic dan cara kerja QR/NFC, contoh penerapan untuk berbagai organisasi, dan jalur pemesanan/kontak yang benar-benar berfungsi.
- Menampilkan harga hanya sesudah ditetapkan; tidak membuat klaim penjualan, ulasan, kemitraan, atau hasil bisnis yang tidak terbukti.
- FAQ berbasis **jawaban yang dikurasi**, mencakup pertanyaan yang benar-benar sudah dapat dijawab, misalnya cara kerja, kompatibilitas, pilihan tampilan, pemesanan, dan pengiriman bila informasinya sudah dikonfirmasi.
- Bila pertanyaan tidak terjawab, berikan fallback jujur dan tawarkan tombol WhatsApp; **tidak** boleh melakukan pengalihan otomatis tanpa pilihan pengunjung.

**Arah UI:** hero berisi headline/CTA di kiri dan visual produk di kanan pada desktop, disusul manfaat singkat; mobile menumpuk elemen dengan CTA tetap mudah dijangkau. Gunakan foto acrylic asli jika tersedia; render/mockup tetap diidentifikasi sebagai konsep.

## 4. Autentikasi dan admin

- Gunakan **Filament yang sudah terpasang**, dengan login dan logout internal; seluruh CRUD harus dilindungi autentikasi dan otorisasi yang sesuai.
- Desain login desktop menggunakan panel visual produk di kiri dan formulir di kanan. Pada mobile, formulir menjadi prioritas. Jangan tampilkan fungsi seperti pemulihan kata sandi jika belum benar-benar tersedia.
- Dashboard dan formulir mengikuti prinsip Midnight Blue: sidebar gelap ramping, area kerja terang, kartu modular, pesan validasi jelas, dan akses keyboard/mobile yang layak.

### 4.1 Struktur navigasi yang direncanakan

**Dashboard, Bisnis, Perangkat, Laporan, Pengaturan.** Menu Laporan dan Pengaturan boleh belum ditampilkan hingga halaman/fungsi yang sah siap. Jangan menautkan menu aktif ke halaman kosong demi menyamai mockup.

### 4.2 Dashboard Overview — spesifikasi target

| Area | Kebutuhan | Sumber data / saat belum tersedia |
|---|---|---|
| Header | Judul, ringkasan singkat, filter periode **7/30/90 hari** untuk metrik akses; default rancangan 30 hari | Filter hanya memengaruhi metrik/visualisasi berbasis periode, bukan total bisnis sepanjang waktu |
| KPI 1 | **Total Bisnis** | Jumlah record di `businesses`; sebelum tabel/CRUD tersedia tampilkan status belum tersedia |
| KPI 2 | **Halaman Terbit** | Jumlah bisnis berstatus `published` |
| KPI 3 | **Perangkat Aktif** | Jumlah perangkat berstatus aktif; sebelum modul perangkat tersedia tampilkan status belum tersedia |
| KPI 4 | **Total Akses** | Jumlah request redirect yang **berhasil dicatat** dalam periode terpilih; sebelum pencatatan diimplementasikan tampilkan *belum tersedia*, **bukan 0 palsu** |
| Grafik | **Line chart Tren Akses** menurut tanggal, dengan seri **QR Scan** dan **NFC Tap** setelah sumber tiap kanal tercatat | Jika data/sistem pencatatan belum tersedia, tampilkan *empty state*; jika pencatatan ada tetapi belum ada akses, boleh tampilkan keadaan data kosong/0 sesuai data |
| Aktivitas Terbaru | Aktivitas administratif/operasional yang benar-benar direkam sistem | Jika belum ada sumber activity log, tampilkan *empty state*, bukan contoh seolah nyata |
| Bisnis Terbaru | Tabel record bisnis aktual terbaru | Jika belum ada bisnis, tampilkan *empty state* dan aksi yang sesuai |

**Batas definisi data:** "akses" adalah kejadian kunjungan ke rute redirect yang dicatat, bukan jumlah pengunjung unik, bukti NFC disentuh secara fisik, atau jumlah ulasan Google. Pemisahan QR/NFC memakai URL/parameter kanal yang memang diterbitkan dan diproses sistem, bukan dugaan. Angka pada mockup selalu diberi label ilustrasi.

**Prioritas penerapan dashboard:** rancangan layout dan KPI wajib sebagai hasil akhir yang dituju; widget harus terhubung ke data asli saat tersedia. Pencatatan akses dan aktivitas dilakukan **setelah alur bisnis → perangkat → QR/NFC → halaman publik bekerja**, agar deadline dan prioritas MVP tidak terganggu. Tidak perlu membuat event log hanya untuk mengisi dashboard dengan angka.

## 5. Manajemen bisnis (Filament)

### 5.1 Daftar bisnis

Tampilkan **nama, kategori, slug, status publikasi, jumlah perangkat**, dan aksi yang relevan (lihat/edit) berdasarkan data sistem. Sediakan keadaan daftar kosong yang membantu admin membuat bisnis pertama.

### 5.2 Tambah/edit bisnis

Kebutuhan konten: **nama**, **slug unik**, **kategori deskriptif yang fleksibel**, tagline/deskripsi opsional, logo, cover, warna aksen, alamat, dan status **draft/published**. Pengelompokan form: **Identitas, Tampilan, Kontak, Tombol, Publikasi**, disesuaikan kemampuan Filament.

- Kategori tidak boleh mengunci pilihan tombol atau menghasilkan template terpisah per industri.
- WhatsApp, Maps, review Google, website, Instagram, menu, pendaftaran, dan tujuan lain merupakan **tautan terkonfigurasi** (lihat bagian 6); penempatan di tab Kontak tidak berarti wajib membuat kolom terpisah di `businesses`.
- Unggahan gambar harus divalidasi tipe dan ukurannya. Untuk produksi, penyimpanan harus persisten, bukan mengandalkan filesystem ephemeral hosting.
- Validasi slug, panjang input, serta kelayakan publikasi dilakukan di sisi server. Draf tidak boleh bocor melalui route publik.

## 6. Manajemen tombol/tautan per bisnis

- Satu bisnis memiliki banyak tautan. Setiap tautan dapat diberi **label**, **jenis/ikon**, **URL**, **urutan**, dan status **aktif/nonaktif**.
- Jenis yang didukung sebagai *preset* mencakup Google Review, Maps, WhatsApp, Instagram, website, dan jenis kustom; contoh menu atau pendaftaran dapat menggunakan tautan berlabel khusus.
- Tidak ada tombol yang wajib hanya karena kategori bisnis tertentu. URL yang tidak diisi/tidak valid atau tautan tidak aktif tidak ditampilkan pada halaman publik.
- Validasi URL harus menolak skema tidak aman; URL Google Review adalah tautan yang diberikan pemilik bisnis, tanpa API atau klaim verifikasi ulasan.
- Pengelolaan tombol berada dalam konteks bisnis agar admin tidak salah mengaitkan tautan ke organisasi lain.

## 7. Manajemen perangkat fisik

- Satu bisnis dapat memiliki beberapa perangkat/stand. Masing-masing memiliki **kode publik unik dan stabil** yang tidak berubah saat slug, nama, atau informasi bisnis diperbarui.
- Admin dapat mendaftarkan perangkat, memberi label, memilih bisnis pemilik, mengaktifkan/menonaktifkan, dan memperoleh URL serta QR siap cetak/unduh (format SVG/PNG praktis sesuai implementasi).
- **Satu perangkat fisik dapat mendukung QR dan NFC sekaligus.** Sesuai keputusan 28 September 2026, skema MVP `devices` tidak memakai kolom `type` atau `notes`; keputusan ini tidak mengubah prinsip QR/NFC pada PRD.
- Rute rancangan `/t/{deviceCode}` mencari perangkat yang masih aktif dan organisasi yang sudah terbit, kemudian mengarahkan pengunjung ke halaman bisnis terkini; jangan mencetak QR langsung menuju slug bisnis.
- Apabila dibedakan untuk pencatatan kanal, QR dan NFC dapat mengarah ke kode perangkat yang sama dengan penanda kanal masing-masing, misalnya `?via=qr` dan `?via=nfc`. Format final disahkan pada tahap implementasi route.
- QR produksi menggunakan domain/`APP_URL` yang stabil; cetakan URL hosting sementara hanya untuk prototipe berlabel dan perlu ditinjau sebelum penggunaan komersial.

## 8. Universal Business Page

- Gunakan **satu template Blade mobile-first yang dirender dari data**, bukan halaman berbeda yang di-hard-code untuk setiap kategori.
- Tampilkan identitas organisasi (logo/cover jika tersedia, nama, tagline/deskripsi, alamat jika ada), warna aksen yang aman, dan hanya tautan aktif/valid menurut urutannya.
- Tombol harus nyaman disentuh, memiliki label yang jelas, dan menuju tujuan yang benar pada perangkat seluler.
- Permintaan ke perangkat tak dikenal/nonaktif atau bisnis yang belum diterbitkan harus menghasilkan halaman *unavailable* yang informatif tanpa mengungkap data draf.
- Konten dan tautan bisnis bisa diperbarui tanpa mengganti alamat QR permanen yang telah dicetak pada perangkat.

## 9. Pencatatan akses dan privasi (tahap setelah alur utama)

- Setelah route redirect berfungsi, tambahkan pencatatan minimum jika waktu mencukupi agar Total Akses dan Tren Akses dapat membaca data nyata.
- Jika dicatat, atribut minimal yang direncanakan adalah perangkat, kanal (`qr` atau `nfc`), dan waktu kejadian. Hindari menyimpan IP/alamat perangkat pribadi bila tidak diperlukan; tidak ada cross-site tracking dalam MVP.
- Jangan mengklaim angka scan sebagai orang unik, verifikasi pembacaan NFC fisik, atau keberhasilan mengirim Google Review.
- Sumber Aktivitas Terbaru administratif harus ditentukan tersendiri; jangan menyamakan catatan scan dengan tindakan admin tanpa keputusan eksplisit.

## 10. Persyaratan nonfungsional

- **Responsif:** periksa lebar 360px serta lebar ponsel dan desktop umum; tidak ada horizontal overflow.
- **Aksesibilitas:** kontras teks/tombol memadai, label form, fokus keyboard terlihat, CTA bisa digunakan dengan sentuhan.
- **Keamanan:** autentikasi/otorisasi admin, validasi sisi server, tidak menyimpan rahasia dalam Git, URL tujuan aman, unggahan tervalidasi, dan draf tersembunyi dari publik.
- **Portabilitas DB:** gunakan migration/kueri yang kompatibel MySQL dan PostgreSQL; **uji PostgreSQL sebelum deployment**, bukan menganggapnya sudah lulus.
- **Keandalan demo:** sediakan prosedur warm-up jika hosting gratis tertidur serta video/screenshot cadangan. Jangan menjanjikan uptime produksi gratis permanen.
- **Integritas data:** di aplikasi, tidak ada statistik, aktivitas, atau testimoni rekayasa. Data simulasi hanya muncul pada mockup atau demo yang dilabeli jelas.

## 11. Skenario penerimaan tingkat produk

1. Admin internal bisa login/logout serta mengakses CRUD setelah autentikasi; akses CRUD tanpa login ditolak.
2. Admin membuat **setidaknya tiga contoh jenis organisasi** melalui form/data, tanpa menulis kode baru; contoh *Kopi Senja* dan *SMA Nusantara* hanya data demo.
3. Tiap bisnis dapat memiliki tombol berbeda dan urutan yang bisa diatur; URL tidak valid ditolak dan tautan kosong/nonaktif tidak tampil.
4. Dua perangkat dengan kode berbeda dapat menuju satu organisasi. Sesudah nama, slug, atau konten diubah, URL perangkat lama tetap membuka halaman bisnis yang tepat.
5. Perangkat tidak aktif, kode tak dikenal, dan bisnis draft tidak menampilkan data privat.
6. QR yang dicetak dapat dipindai dari ponsel nyata; NFC yang diprogram dapat dibaca ponsel kompatibel; keduanya membuka tujuan semestinya.
7. Landing page dan business page bisa digunakan pada ponsel sempit; WhatsApp fallback FAQ hanya terbuka setelah pengunjung memilihnya.
8. Dashboard menampilkan empat KPI serta area chart, aktivitas, dan tabel sesuai desain; setiap bagian memakai data nyata atau *empty state* yang akurat saat sumber datanya belum tersedia.
9. Ketika pencatatan akses sudah dibuat, filter periode menghasilkan angka dan grafik yang sesuai dengan event uji aktual, serta seri QR/NFC terpisah menurut kanal yang benar-benar dicatat.
10. Sebelum demo final, URL produksi tidak mengandung localhost, data produksi tersimpan secara persisten, dan pengujian setelah deployment dilaksanakan.

Kasus uji terperinci, hasil, serta bukti pengujian harus masuk `docs/06_TEST_PLAN.md`, **bukan langsung ditandai berhasil di PRD ini**.

## 12. Urutan pengerjaan dan Definition of Done

**Urutan implementasi yang disepakati:**
1. Selesaikan sinkronisasi dokumentasi dan persetujuan struktur database.
2. Migration + CRUD bisnis Filament.
3. Manajemen tombol/tautan.
4. CRUD perangkat.
5. Universal Business Page.
6. Generator QR dan route redirect permanen.
7. Deployment dan prototipe NFC yang diuji pada ponsel.
8. Pencatatan akses, KPI/line chart berbasis data aktual, dan sumber aktivitas jika tersedia.
9. FAQ terkurasi dengan opsi pengalihan WhatsApp.

**Definition of Done tiap fitur:** kode diterapkan; otorisasi/validasi relevan diuji; kasus berhasil dan gagal dibuktikan; tampilan mobile diperiksa jika ada UI; dokumentasi Progress/Test Plan/Decisions terkait diperbarui; tidak ada kredensial yang ter-commit. Dokumen atau mockup yang sudah disetujui **tidak** sama dengan fitur yang selesai diuji.

## 13. Keputusan dan hal yang masih menunggu kajian

- **Sudah diputuskan:** konsep Midnight Blue, struktur Dashboard Overview dan seri QR/NFC sebagai target, satu halaman bisnis universal, kode perangkat stabil, Laravel monolith + Filament, data statistik harus nyata.
- **Sudah diputuskan setelah revisi PRD awal:** skema MVP `devices` memakai public code stabil, relasi ke business, status, dan tanpa `type`/`notes` (lihat `08_DECISIONS.md`).
- **Masih perlu keputusan/validasi:** mekanisme activity log admin, strategi teknis `scan_events`/agregasi dan retensi, status dependency QR secara eksplisit, kebijakan hard-delete device yang pernah dicetak, penyimpanan produksi, finalisasi platform deployment, aturan akses panel production, serta validasi PostgreSQL.
- **Status implementasi tidak ditentukan oleh PRD:** lihat `09_PROGRESS.md` dan `06_TEST_PLAN.md`; jangan membuat ulang migration/resource hanya karena catatan requirement historis lebih lama dari implementasi.

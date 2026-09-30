# 04 — Design System SENTUH

**Status:** Design System Midnight Blue disepakati. Login admin sudah diterapkan dan memiliki bukti manual; Dashboard Overview serta Universal Business Page sudah memiliki implementasi awal tetapi belum mencapai Definition of Done; landing page masih belum dibuat.
**Tanggal sinkronisasi:** 30 September 2026
**Arah visual resmi:** MIDNIGHT BLUE
**Referensi visual utama:** [`assets/SENTUH_UI_REFERENCE.png`](assets/SENTUH_UI_REFERENCE.png) (mockup yang disetujui sebagai referensi gaya/komposisi, bukan desain untuk disalin 1:1).
**Lingkup:** landing page SENTUH, login admin, dashboard Filament, formulir administrasi, dan Universal Business Page.

> **Catatan penempatan gambar:** Saat menyimpan dokumen ini di proyek lokal, letakkan gambar di `docs/assets/SENTUH_UI_REFERENCE.png`. Gambar contoh berisi nama bisnis, aktivitas, dan angka **ilustratif**; itu bukan bukti fitur telah selesai maupun statistik aktual.

## 1. Tujuan dan prinsip desain

SENTUH menghubungkan produk acrylic QR Code/NFC dengan halaman digital untuk berbagai bisnis dan organisasi. Desain harus terasa **clean, modern, profesional, ringan, konsisten, dan memiliki identitas sendiri**, dengan produk acrylic sebagai elemen visual utama.

- Ikuti **arah gaya, komposisi, tipografi visual, kartu, sidebar, form, dan preview mobile** pada gambar referensi; sesuaikan untuk kemampuan dan kebutuhan nyata aplikasi.
- Utamakan alur pengguna yang bekerja dan pengalaman mobile sebelum efek dekoratif.
- Jadikan foto acrylic asli sebagai aset hero ketika tersedia. Mockup render boleh dipakai sebagai *konsep* berlabel, bukan diklaim sebagai foto prototipe fisik yang sudah dibuat.
- Gunakan hierarki informasi yang jelas, ruang kosong yang cukup, CTA yang berfungsi, dan komponen yang memang diperlukan.
- Hindari gradient berlebihan, dashboard dekoratif, testimonial/ulasan fiktif tanpa label, animasi tidak perlu, dan klaim seolah terafiliasi dengan Google.
- Landing page, admin, dan halaman bisnis mempunyai kebutuhan visual berbeda; jangan memaksakan satu layout pada semuanya.

## 2. Design tokens

| Token | Warna | Fungsi utama |
|---|---|---|
| Primary / Midnight Blue | `#10233F` | Identitas merek, sidebar, area utama |
| Background | `#F7F8FA` | Latar area kerja yang terang |
| Deep Navy | `#0B1424` | Hero dan bidang gelap |
| Accent Blue | `#2563EB` | Tombol utama, navigasi aktif, elemen penekanan |

Warna putih atau abu netral, warna teks, border, dan warna status diturunkan saat implementasi untuk memenuhi kebutuhan kontras. **Jangan** menggunakan Accent Blue untuk seluruh elemen dan jangan membuat seluruh workspace gelap.

**Gaya komponen:**
- Workspace terang, panel putih, border tipis, sudut membulat secukupnya, dan bayangan halus jika membantu pemisahan lapisan.
- Sidebar gelap yang ramping, ikon sederhana dan konsisten, navigasi aktif terlihat jelas.
- Form dengan label dan pesan validasi yang mudah dibaca; hindari terlalu banyak field pada satu layar.
- Gunakan font sans-serif yang mudah dibaca. Pemilihan keluarga font final dilakukan saat implementasi berdasarkan lisensi dan performa; tidak ada font baru yang wajib diinstal berdasarkan mockup saja.
- Status aktif/nonaktif tidak hanya dibedakan dengan warna; sertakan teks atau ikon yang dapat dipahami.

**Batas identitas:** palet Midnight Blue berlaku untuk branding SENTUH dan admin. **Universal Business Page** boleh menggunakan logo, foto, dan warna aksen masing-masing bisnis; template tetap menjaga kontras dan keterbacaan.

## 3. Landing page SENTUH

**Acuan gambar:** area hero dengan konten besar di kiri, visual produk acrylic di kanan, latar Deep Navy/Midnight Blue, satu CTA utama yang menonjol, CTA sekunder bila diperlukan, diikuti kartu manfaat kecil dengan ikon yang bermakna.

Struktur konten yang direncanakan:
1. Header: wordmark SENTUH, navigasi yang relevan, CTA pemesanan/WhatsApp.
2. Hero: headline singkat, penjelasan QR/NFC yang tidak berlebihan, visual acrylic, CTA utama dan CTA pendukung.
3. Ringkasan manfaat: praktis, satu halaman fleksibel, QR/NFC, dan dapat dipakai berbagai jenis bisnis/organisasi.
4. Cara kerja, contoh penggunaan, serta informasi produk dan harga **setelah dikonfirmasi**.
5. FAQ terkurasi dan tombol WhatsApp opsional yang hanya aktif jika dipilih pengunjung.

Pada mobile, headline, CTA, dan gambar disusun vertikal tanpa elemen terpotong atau halaman melebar. Seluruh menu dan CTA harus menuju fitur/tujuan nyata; bagian yang belum tersedia tidak boleh ditampilkan sebagai tautan mati.

## 4. Login admin

- **Desktop:** visual branding dan produk acrylic pada panel kiri; panel kanan berisi formulir login yang sederhana dan jelas.
- **Mobile:** prioritaskan formulir login; visual produk boleh disederhanakan atau dipindahkan agar tidak mendorong formulir terlalu jauh ke bawah.
- Pertahankan autentikasi Filament yang sudah terpasang. Penyesuaian tampilan harus melalui mekanisme kustomisasi yang kompatibel dengan Filament 5, bukan mengganti sistem login tanpa keputusan baru.
- Hanya tampilkan kontrol seperti “ingat saya” atau “lupa password” bila perilakunya benar-benar disediakan dan diuji; gambar mockup tidak mewajibkan keduanya.
- Berikan pesan kesalahan login yang jelas tanpa membocorkan informasi keamanan.

### 4.1 Implementasi login admin — hasil uji 27 September 2026

- **Sudah diterapkan (laporan + screenshot pengguna):** layout desktop dua panel; visual produk acrylic di panel kiri, formulir terang kontras di kanan, brand SENTUH, judul besar bawaan `Sign in` dihilangkan, tombol diberi label **Masuk**. Foto produk panel kiri merupakan aset render konsep `public/images/sentuh-login-panel.webp`, bukan foto prototipe fisik.
- **Komposisi:** gunakan ilustrasi panel kiri sebagai satu background utuh yang sudah berisi logo dan tagline; jangan menggandakan teks di atasnya. Gunakan `background-size: contain` untuk melindungi teks dari pemotongan; bidang samping berwarna Deep Navy sengaja dapat terlihat akibat perbedaan rasio.
- **Teknis:** tetap memakai autentikasi Filament melalui `app/Filament/Auth/AdminLogin.php`, panel provider, dan Blade `resources/views/filament/auth/admin-login.blade.php`. Perubahan CSS responsif berada pada Blade login yang dilaporkan pengguna.
- **Uji berhasil:** screenshot desktop menunjukkan seluruh formulir tanpa scroll; login/logout diuji pengguna setelah redesign; screenshot Chrome DevTools resolusi 390×844 menunjukkan satu kolom tanpa panel gambar dan tombol terlihat.
- **Belum diuji:** ponsel fisik, keadaan login salah, akses admin tanpa sesi, kontras dan navigasi keyboard secara menyeluruh. Label email/password pada screenshot masih berbahasa Inggris; lokalisasi belum diselesaikan.
- **Catatan keamanan dan produk:** QR pada gambar hanyalah ilustrasi, bukan QR fungsional. Aset dalam folder `public/` boleh dilayani secara publik; jangan menaruh kredensial di dalam visual.

## 5. Dashboard admin — Overview

**Karakter layout:** sidebar ramping Midnight Blue di kiri, header ringkas, workspace terang, statistik modular, chart bersih, tabel dan aktivitas dengan kepadatan informasi yang nyaman.

### 5.1 Navigasi yang direncanakan

1. Dashboard
2. Bisnis
3. Perangkat
4. Laporan
5. Pengaturan

Menu **Laporan** dan **Pengaturan** pada desain awal bukan alasan untuk menambah fitur di luar MVP. Audit 30 September menemukan menu/fitur Penjualan, Kas, dan Laporan Keuangan pada implementasi aktual; status scope-nya belum disahkan di PRD sehingga fitur tersebut dibekukan dari pengembangan lanjutan sampai ada keputusan produk.

### 5.2 Susunan Overview

| Area | Isi |
|---|---|
| Header | Judul **Dashboard**, deskripsi singkat, filter periode **7/30/90 hari** untuk metrik berbasis waktu bila datanya tersedia |
| Baris 1 | Empat kartu KPI: **Total Bisnis**, **Halaman Terbit**, **Perangkat Aktif**, **Total Akses** (periode terpilih; default rencana 30 hari) |
| Baris 2 kiri (lebih lebar) | **Line chart Tren Akses**, seri **QR Scan** dan **NFC Tap** berdasarkan tanggal |
| Baris 2 kanan | **Aktivitas Terbaru** yang hanya menampilkan aktivitas sistem yang benar-benar tercatat |
| Baris 3 | **Tabel Bisnis Terbaru**; ringkasan perangkat dapat ditambahkan kemudian jika bermanfaat dan data tersedia |

**Definisi tampilan awal** (rincian query disahkan di PRD/Architecture sebelum implementasi):
- Total Bisnis: jumlah record bisnis yang tersimpan.
- Halaman Terbit: jumlah bisnis berstatus *published*.
- Perangkat Aktif: jumlah perangkat berstatus aktif.
- Total Akses: jumlah kejadian akses yang **tercatat** melalui rute redirect selama periode terpilih; **bukan** jumlah orang unik, bukan bukti pembacaan fisik perangkat, dan bukan jumlah ulasan Google.
- Grafik QR/NFC: tampil sebagai dua seri hanya jika mekanisme pencatatan sumber QR/NFC benar-benar telah tersedia. Jika tidak ada sumber data, tampilkan *empty state*; jangan mengarang angka atau menampilkan seri palsu.
- Aktivitas Terbaru: gunakan kejadian operasional yang benar-benar dicatat sistem. Jika belum ada mekanisme activity log, tampilkan *empty state*, bukan riwayat contoh di produksi.
- Bisnis Terbaru: data bisnis aktual diurutkan berdasarkan waktu pembuatan.

**Aturan mutlak integritas data:** semua angka, tabel, chart, dan aktivitas pada aplikasi harus membaca data sebenarnya. Ketika tabel belum ada, fitur pencatatan belum dibuat, atau data belum terkumpul, tampilkan *empty state* yang menjelaskan kondisinya. Data simulasi hanya diperbolehkan pada mockup/demo yang **diberi label jelas**. Tampilan Overview boleh dibangun bertahap tanpa mendahului CRUD, rute QR/NFC, atau pencatatan akses.

**Chart:** jangan menambah library grafik sebelum mengevaluasi komponen yang sudah tersedia dan kompatibel dengan Filament 5. Hindari animasi dan dekorasi yang mengurangi keterbacaan.

## 6. Halaman Bisnis dan formulir administrasi

### 6.1 Daftar bisnis

Tampilkan nama bisnis/organisasi, kategori, slug, status publikasi, jumlah perangkat, dan aksi edit/lihat yang relevan. Utamakan pencarian, status yang terbaca, dan tata letak yang tetap nyaman ketika data masih kosong.

### 6.2 Form tambah/edit bisnis

Pertahankan pengelompokan sesuai kebutuhan nyata, misalnya **Identitas, Tampilan, Kontak, Tombol, Publikasi**, seperti komposisi form pada gambar referensi. Kebutuhan UI meliputi nama, kategori deskriptif, slug, tagline/deskripsi, logo, cover, warna aksen, alamat, dan status publikasi.

WhatsApp, Maps, Google Review, website, Instagram, dan tujuan lain disediakan sebagai **tautan bisnis yang dapat diberi label, diurutkan, dan dinonaktifkan** sesuai arsitektur yang disepakati. Jangan otomatis membuat kolom WhatsApp/Maps terpisah hanya karena pada mockup berada dalam tab Kontak; penentuan field dan relasinya dilakukan pada tahap struktur database.

### 6.3 Kelola tombol

Pengelolaan tombol berada dalam konteks resource bisnis. Link yang tidak diisi atau tidak aktif tidak boleh muncul di halaman publik. Tidak semua kategori membutuhkan tombol Google Review. Validasi URL harus menolak protokol tidak aman.

### 6.4 Kelola perangkat

Implementasi perangkat sudah menggunakan label, bisnis terkait, status, dan kode publik permanen. Satu perangkat fisik mendukung QR dan NFC sekaligus; MVP tidak memakai field `type`/`notes`. Tabel admin sudah memiliki aksi terkait kode publik dan QR, tetapi pengujian end-to-end QR/NFC fisik masih tertunda.

## 7. Universal Business Page (mobile-first)

Satu template Blade berbasis data melayani kafe, sekolah, klinik, UMKM, dan organisasi lain tanpa membuat desain hard-coded untuk tiap kategori.

**Komposisi acuan:** gambar sampul atau visual atas, logo, nama, tagline/deskripsi pendek, tombol aksi utama yang besar dan mudah disentuh, informasi tambahan yang relevan. Susunan konten disesuaikan dengan data dan identitas tiap bisnis, tidak harus menyerupai kafe contoh pada referensi.

- Dukung gambar, alamat, logo, deskripsi, warna identitas, dan tautan yang diurutkan.
- Tampilkan hanya data terisi dan tautan aktif dengan URL yang valid.
- Gunakan target sentuh yang nyaman, teks tombol yang jelas, dan kontras yang diuji.
- Perangkat tidak aktif, kode tidak dikenal, atau bisnis yang belum diterbitkan harus berujung pada halaman *unavailable* yang informatif dan tidak membocorkan draf.

## 8. Responsivitas, aksesibilitas, dan keadaan layar

Periksa setidaknya lebar mobile **360px** dan desktop umum. Tidak boleh ada horizontal overflow; CTA harus dapat disentuh dan digunakan lewat keyboard. Setiap halaman menyediakan umpan balik *loading, empty, error,* dan *success* ketika relevan. Kaji kontras warna pada penerapan nyata, bukan hanya berdasarkan nilai palet.

Buat screenshot implementasi nyata untuk menilai kemiripan komposisi dengan referensi, tetapi jangan menganggap kesamaan visual membuktikan tombol atau fitur sudah berfungsi.

## 9. Urutan penerapan, verifikasi, dan keterkaitan dokumen

1. Pertahankan arah visual resmi dan gambar referensi di `docs/assets/SENTUH_UI_REFERENCE.png` pada repositori lokal.
2. Rekam perubahan yang sudah teruji pada login dan CRUD; jangan menyimpulkan dashboard/halaman publik selesai hanya karena layout login sudah selesai.
3. Berikutnya: jangan membuat ulang fitur yang sudah ada. Verifikasi Dashboard/Universal Business Page/QR redirect yang sudah diimplementasikan, tutup gap akses production dan automated test, lalu lanjut landing/deployment sesuai prioritas MVP.
4. Setelah tiap milestone, perbarui `docs/06_TEST_PLAN.md`, `docs/09_PROGRESS.md`, dan `docs/08_DECISIONS.md` bila ada keputusan penting.

**Status implementasi 30 September 2026:** login admin dan CRUD inti mempunyai bukti manual. Dashboard SENTUH, perangkat, generator QR, stable redirect, serta Universal Business Page sudah ada pada kode, tetapi sebagian besar belum memiliki pengujian end-to-end/otomatis. Landing page, analytics QR/NFC, deployment, dan prototipe fisik belum selesai. Progres rinci mengikuti `docs/09_PROGRESS.md`.

**Catatan gambar:** contoh bisnis, angka statistik, dan entri aktivitas pada mockup adalah **data ilustrasi** dan tidak boleh disalin sebagai data aktual pada aplikasi.

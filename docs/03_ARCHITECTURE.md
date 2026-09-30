# 03 — Architecture

**Status:** Sinkronisasi audit 30 September 2026. Skema `businesses`, `business_links`, dan `devices` sudah ada di implementasi aktual. Rute publik `/b/{slug}` dan `/t/{deviceCode}`, generator QR, Universal Business Page, dan Dashboard Overview tahap awal juga sudah ada di kode. `scan_events`, landing page SENTUH, deployment produksi, dan storage persisten belum selesai.
**Pembaruan:** 30 September 2026

## Architecture choice

SENTUH tetap menggunakan **Laravel monolith** dalam satu repository dan satu aplikasi server-side. Frontend publik memakai Blade + Tailwind CSS + Alpine.js sesuai kebutuhan; admin memakai Filament 5; backend Laravel 13; database lokal Laragon MySQL `sentuh_dev`.

Versi yang sebelumnya dilaporkan dari lingkungan lokal pengguna: Laravel `13.33.0`, PHP `8.3.6`, Filament `5.8.4`, Tailwind CSS `4.3.3`, dan MySQL `8.4.3`. Kandidat produksi masih Supabase PostgreSQL + Render Docker + object storage persisten. Kompatibilitas PostgreSQL belum diuji sehingga kandidat ini belum boleh dianggap keputusan deployment final.

Jangan memperkenalkan React terpisah, API service baru, Redis, queue, billing/subscription, atau perubahan stack lain tanpa keputusan baru di `08_DECISIONS.md`.

## Request flow aktual dan target berikutnya

```text
Ponsel pengunjung -- scan QR atau tap NFC
        |
        v
/t/{deviceCode}?via=qr atau ?via=nfc
        | cek perangkat aktif + bisnis published
        v
/b/{businessSlug}
        | bisnis + tautan aktif terurut
        v
Universal Business Page
        |
        +--> tautan eksternal http/https yang tervalidasi

Admin SENTUH --> /admin --> Bisnis / Perangkat / Dashboard
Calon pembeli --> / --> masih Laravel welcome; landing SENTUH belum dibuat
```

Implementasi saat ini sudah memiliki route `/t/{deviceCode}` dan `/b/{slug}`. Parameter `?via=qr` sudah dipakai oleh generator QR, tetapi **belum dicatat** karena `scan_events` belum ada. NFC dapat menggunakan device URL yang sama dengan kanal `via=nfc` setelah alur pencatatan kanal ditetapkan dan diuji.

Kode perangkat tetap harus stabil meskipun slug bisnis berubah. QR cetak tidak boleh menunjuk langsung ke slug bisnis.

## Model domain inti

### `users`

Autentikasi admin internal tetap memakai tabel bawaan Laravel dan Filament. Login/logout lokal setelah redesign pernah dilaporkan berhasil. Audit route 30 September menunjukkan route admin memakai `Filament\\Http\\Middleware\\Authenticate`.

**Gap sebelum deployment:** `App\\Models\\User` belum mengimplementasikan kontrak/aturan akses panel production Filament. Kondisi ini harus diuji dan diselesaikan sebelum deployment; jangan menganggap login production sudah aman hanya karena environment lokal bekerja.

### `businesses`

Migration: `database/migrations/2026_09_26_134531_create_businesses_table.php`.

| Kolom | Tipe / aturan |
|---|---|
| `id` | bigint unsigned, primary key |
| `name` | varchar(150), wajib |
| `slug` | varchar(160), wajib, unique |
| `category` | varchar(100), wajib dan fleksibel |
| `tagline` | varchar(255), nullable |
| `description` | text, nullable |
| `address` | text, nullable |
| `logo_path` | varchar(255), nullable |
| `cover_path` | varchar(255), nullable |
| `accent_color` | varchar(7), nullable |
| `status` | varchar(20), default `draft`; target `draft` / `published` |
| timestamps | `created_at`, `updated_at` |

Model `Business` memiliki relasi `links()` dan `devices()`. CRUD dasar, upload, slug unik, edit, serta aturan penghapusan bisnis yang masih mempunyai relasi sudah memiliki bukti manual sebelumnya. `accent_color` digunakan pada halaman publik, tetapi input warna pada form admin belum diselesaikan.

### `business_links`

Migration: `database/migrations/2026_09_27_085024_create_business_links_table.php`.

| Kolom | Tipe / aturan |
|---|---|
| `id` | bigint unsigned, primary key |
| `business_id` | FK ke `businesses.id`, `ON DELETE RESTRICT` |
| `label` | varchar(100), wajib |
| `type` | varchar(50), wajib |
| `url` | varchar(2048), wajib |
| `sort_order` | unsigned integer, default `0` |
| `is_active` | boolean, default `true` |
| timestamps | `created_at`, `updated_at` |

Tautan dikelola melalui Repeater dalam konteks bisnis. Pengujian manual 28 September mencatat `javascript:alert(1)` ditolak dan tidak tersimpan. Halaman publik melakukan validasi kedua dengan hanya menerima URL valid berskema `http` atau `https`.

### `devices`

Migration: `database/migrations/2026_09_28_025755_create_devices_table.php`.

Keputusan implementasi yang sudah tercatat dan ada di kode:

- satu bisnis dapat mempunyai banyak perangkat;
- satu perangkat fisik dapat membawa QR dan NFC sekaligus;
- `public_code` berupa UUID unik 36 karakter dan dibuat otomatis oleh model;
- `public_code` tidak menjadi input form dan tidak boleh berubah melalui pembaruan model normal;
- status awal `inactive`, dengan status `active` / `inactive`;
- FK `business_id` menggunakan `restrictOnDelete()`;
- tidak ada kolom `type` atau `notes` pada MVP.

CRUD perangkat, edit status, copy public code, dan stabilitas UUID sudah memiliki bukti manual 28 September. Pengujian hard-delete perangkat dan test otomatis masih belum selesai.

## QR dan redirect permanen

`App\\Support\\DeviceQrCode` membentuk URL dari `config('app.url')` + route `device.redirect` + `?via=qr`. Implementasi dapat menghasilkan Data URI QR dan SVG mentah untuk download.

Kode memakai `chillerlan/php-qrcode` versi `5.0.5` yang saat ini tersedia melalui dependency `filament/filament`, bukan sebagai dependency langsung di root `composer.json`. Sebelum mempertahankannya jangka panjang, keputusan dependency ini perlu dicatat dan diuji agar generator QR tidak bergantung secara tidak sengaja pada dependency transitif.

`DeviceRedirectController`:

1. mencari `public_code` yang cocok;
2. mengharuskan perangkat berstatus aktif;
3. mengharuskan bisnis terkait berstatus `published`;
4. redirect ke route `business.show` memakai slug bisnis terkini.

Belum ada automated feature test untuk kode tidak dikenal, device inactive, bisnis draft, dua device ke satu bisnis, serta perubahan slug setelah QR dibuat.

## Universal Business Page

`BusinessPageController` dan `resources/views/business/show.blade.php` sudah ada sebagai implementasi awal satu template lintas kategori.

Controller saat ini:

- hanya mengambil bisnis `published`;
- memuat tautan aktif terurut;
- memfilter URL publik hanya `http`/`https`;
- menyediakan logo/cover dari disk `public`;
- memvalidasi `accent_color` hex dan fallback ke Midnight Blue.

Template perlu diuji minimal pada kafe, sekolah, dan klinik/organisasi lain, mobile 360px, dan ponsel fisik. Error untuk slug/device yang tidak tersedia saat ini masih mengandalkan respons 404 framework; target PRD adalah halaman unavailable yang informatif dan tidak membocorkan draf.

## Dashboard Overview

Implementasi awal sudah ada melalui custom Dashboard dan widget:

- `SentuhStatsOverview`;
- `SentuhAccessTrend`;
- `SentuhRecentActivity`;
- `SentuhRecentBusinesses`;
- `SentuhHeroShowcase`.

KPI **Total Bisnis**, **Halaman Terbit**, dan **Perangkat Aktif** sudah membaca database. **Total Akses** sengaja menampilkan `Belum tersedia`. Area Tren Akses dan Aktivitas harus tetap empty state sampai ada sumber data nyata.

Belum ada `scan_events`, filter periode 7/30/90 hari, Total Akses aktual, seri QR/NFC aktual, atau activity log admin.

## Storage

- Lokal: logo dan cover menggunakan disk Laravel `public` pada `businesses/logos` dan `businesses/covers`.
- `APP_URL=http://sentuh.test` sebelumnya memperbaiki preview/storage URL lokal.
- Produksi tidak boleh mengandalkan filesystem ephemeral Render untuk aset bisnis.
- Persistent object storage masih kandidat dan belum diuji.

## Modul tambahan yang terdeteksi pada audit 30 September

Repository aktual juga memuat subsystem:

- `sales_orders` dan `sales_order_items`;
- `cash_accounts`;
- `sales_order_payments`;
- `cash_expenses`;
- Filament Penjualan/Kas dan halaman `FinancialReport`.

Subsystem ini **belum tercantum pada PRD MVP maupun decision record sebagai scope resmi SENTUH**. Untuk mencegah scope creep, statusnya saat ini adalah **implemented/partially implemented but scope pending**. Jangan memperluas subsystem tersebut sampai pemilik proyek memutuskan apakah fitur itu diperlukan untuk deliverable Entrepreneurship atau harus dikeluarkan dari fokus MVP.

## Landing page, analytics, deployment, dan NFC fisik

Belum selesai:

- `/` masih mengarah ke Laravel `welcome`;
- `scan_events` dan analytics QR/NFC belum dibuat;
- deployment Render/Supabase belum dilakukan;
- PostgreSQL compatibility belum diuji;
- object storage persisten belum diuji;
- acrylic fisik + QR cetak + NFC pada ponsel nyata belum memiliki bukti pengujian;
- curated FAQ chatbot belum dibuat.

## Security boundaries

- Admin MVP hanya untuk tim SENTUH; halaman publik read-only.
- Draf bisnis dan perangkat nonaktif tidak boleh membuka data bisnis melalui route device.
- URL eksternal harus aman dan tervalidasi.
- Jangan menyimpan kredensial/secret di Git atau dokumentasi.
- Jangan mengklaim QR scan sebagai orang unik, keberhasilan NFC fisik, Google Review, atau penjualan.
- Sebelum production, uji akses panel Filament dengan environment non-local dan hak akses user yang eksplisit.

## Verifikasi berikutnya

1. Sinkronkan dokumentasi dan amankan baseline Git.
2. Tambahkan pengujian otomatis auth/domain/redirect dan selesaikan aturan akses panel production.
3. Verifikasi Dashboard Overview dan Universal Business Page pada data nyata/mobile.
4. Uji QR + stable redirect end-to-end termasuk perubahan slug dan perangkat nonaktif.
5. Baru kemudian lanjut landing page, deployment/prototipe fisik, analytics, dan FAQ sesuai urutan MVP.

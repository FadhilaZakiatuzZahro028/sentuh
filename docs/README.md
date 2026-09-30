# Sentuh — Documentation Index

Folder ini adalah **source of truth** untuk keputusan produk, arsitektur, pengujian, dan progres SENTUH. Jangan mempertahankan spesifikasi yang saling bertentangan antara chat, repo, dan dokumen.

| File | Purpose |
|---|---|
| `01_PROJECT_BRIEF.md` | Tujuan, scope, batas anggaran/tenggat, dan deliverable |
| `02_PRD.md` | Kebutuhan MVP, user journey, acceptance criteria, Definition of Done |
| `03_ARCHITECTURE.md` | Stack, application flow, data model, dan implementasi arsitektur aktual |
| `04_DESIGN_SYSTEM.md` | Arah UI/UX dan status penerapan visual |
| `05_DEVELOPMENT_WORKFLOW.md` | Ritme milestone, Git, quality routine, dan aturan perubahan |
| `06_TEST_PLAN.md` | Checklist functional/security/QR/NFC/deployment dan bukti test |
| `07_DEPLOYMENT_PLAN.md` | Strategi kandidat local-to-online dan risiko deployment |
| `08_DECISIONS.md` | Living log keputusan teknis/produk dan isu keputusan pending |
| `09_PROGRESS.md` | Status aktual, gap, milestone aktif, dan urutan berikutnya |
| `10_AI_COLLABORATION.md` | Kontrak kerja dengan AI assistant |

`../AGENTS.md` tetap berada di **project root** supaya coding tools yang mengenali `AGENTS.md` dapat menemukannya. Detail spesifikasi berada di `docs/`.

## Status sinkronisasi — 30 September 2026

Audit terhadap archive proyek aktual menemukan implementasi lebih maju daripada catatan 27–28 September. Saat ini:

- CRUD bisnis, business links, dan devices sudah ada; sejumlah skenario mempunyai bukti manual;
- redesign login admin sudah ada dan pernah diuji desktop/emulator mobile;
- Dashboard Overview tahap awal sudah ada dengan KPI berbasis data yang tersedia dan empty state untuk analytics;
- Universal Business Page, stable device redirect, serta generator/aksi QR sudah ada di kode tetapi belum mempunyai pengujian end-to-end lengkap;
- landing page SENTUH, `scan_events`, deployment, persistent production storage, physical QR/NFC test, dan curated FAQ belum selesai;
- subsystem Penjualan/Kas/Laporan Keuangan terdeteksi pada implementasi tetapi belum disahkan sebagai scope PRD, sehingga pengembangannya dibekukan sementara;
- baseline Git belum aman karena banyak perubahan setelah commit `6b626b1` belum di-commit/push.

Status paling rinci selalu mengacu ke `09_PROGRESS.md`; bukti dan checklist mengacu ke `06_TEST_PLAN.md`. Target/requirements tetap mengacu ke `02_PRD.md` dan tidak boleh dianggap selesai hanya karena kode tersedia.

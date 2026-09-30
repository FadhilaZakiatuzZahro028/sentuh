# 05 — Development Workflow

## Working style (two-person team)
- Developer/designer: Laravel, UI, deployment and technical test evidence.
- Business/report owner: supplier research, pricing/HPP, proposal, transparently labeled demo-sales exercise, report and PPT.
- Both: physical prototype, phone tests, product photography and presentation rehearsal.

## Build order

A. Verify the existing Laravel environment, Git status,
   and project documentation.

B. Finalize database architecture and migrations.

C. Implement Filament business, link, and device CRUD.

D. Build Dashboard Overview with actual available
   statistics and empty states for unavailable data.

E. Implement the reusable mobile-first business page,
   stable device redirects, and QR generation.

F. Deploy the application, build the physical acrylic
   prototype, and test QR/NFC on real phones.

G. Implement basic QR/NFC access tracking and
   activate the dashboard chart using actual data.

H. Implement the curated FAQ chatbot with optional
   WhatsApp handoff.

I. Finalize the proposal, report, financial
   calculations, and presentation.

## Git workflow
- Start with a `.gitignore` appropriate to Laravel; never stage `.env`, tokens or secret keys.
- Small feature branches recommended (`feature/business-crud`, `feature/device-qr`, etc.), short descriptive commits, merge only after a manual smoke test.
- Before destructive commands or schema changes, back up relevant local data and confirm impact.
- For a two-person assignment, GitHub Issues / a checked progress document is enough; avoid tooling overhead.

## Local quality routine (Windows 11 PowerShell)
Verify command availability before assuming scripts exist:
```powershell
php artisan --version
php artisan route:list
php artisan test
npm run build
```
For PHP style, inspect whether Laravel Pint is present before invoking it (for example `vendor\bin\pint --test`). Run migration checks on a disposable local database when creating/changing schema; do not execute migrations against production without review.

## Change request template
**Goal** | **Files to modify** | **Approach** | **Commands** | **Expected result** | **How to test** | **Actual result** | **Doc updates**.

## Progress rule
Only mark a task complete when the user confirms actual successful output/screenshot or a test result is available. Do not treat a proposed implementation as completed code.

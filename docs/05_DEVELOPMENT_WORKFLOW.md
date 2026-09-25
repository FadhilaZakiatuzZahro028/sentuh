# 05 — Development Workflow

## Working style (two-person team)
- Developer/designer: Laravel, UI, deployment and technical test evidence.
- Business/report owner: supplier research, pricing/HPP, proposal, transparently labeled demo-sales exercise, report and PPT.
- Both: physical prototype, phone tests, product photography and presentation rehearsal.

## Build order
A. Local Laravel running (reported working; capture version and commit state next).
B. Initialize repository and docs; choose confirmed Laravel/Filament dependency versions.
C. Database migrations and Filament auth + CRUD (business + links + device).
D. Reusable mobile business page and stable redirect route.
E. QR generator; scan test; deploy test instance and verify stable URL.
F. Print a single acrylic; write/tag NFC; test on real phone.
G. Landing-page FAQ chat widget; optional metrics if time permits.
H. Finalize proposal, report, financial calculations and PPT.

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

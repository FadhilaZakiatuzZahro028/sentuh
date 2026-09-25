# 03 — Architecture (Draft)

## Architecture choice
**Laravel monolith**, one repository and one server-side app. Frontend: Blade + Tailwind + Alpine.js; admin: Filament; backend: Laravel; local DB: existing Laragon MySQL; candidate production DB: Supabase PostgreSQL; candidate host: Render Docker; production images: persistent object storage (candidate: Supabase Storage).

**Compatibility checkpoints:** inspect `php artisan --version` and `composer.json` before pinning Laravel/Filament versions. Local MySQL is convenient but introduces a database-engine switch; avoid MySQL-specific SQL and explicitly test PostgreSQL before production.

## Request flow
```text
Customer phone -- scan QR or tap NFC
      |
      v
/t/{deviceCode}?via=qr or ?via=nfc
      | validate active device; optional channel metric
      v
/b/{businessSlug} --> database business + enabled ordered links
      |                   --> persistent logo/cover URLs
      v
Business page --> external approved destinations

Sentuh admin --> /admin (auth) --> businesses, links, devices
Sentuh buyer --> / (landing page) --> FAQ guidance --> optional WhatsApp
```

`/t/{deviceCode}?via=qr` and `?via=nfc` are design examples, not yet implemented. Distinct printed QR/NFC URLs allow source breakdown. A deviceCode stays permanent; an organization slug may change and is looked up at redirect time.

## Proposed domain model
- `users`: standard Laravel authentication for internal admins.
- `businesses`: `id`, `name`, `slug` unique, `category` descriptive, `tagline`, `description`, `address`, `logo_path`, `cover_path`, `accent_color`, `status`, timestamps.
- `business_links`: `id`, `business_id`, `label`, `type`, `url`, `sort_order`, `is_active`, timestamps.
- `devices`: `id`, `business_id`, `public_code` unique and stable, `label`, `status`, timestamps.
- `scan_events` (later): `id`, `device_id`, `channel` (`qr` or `nfc`), `created_at`. Protect privacy; consider aggregate counts instead of long-term event logs.

Table names/fields are **proposals**, subject to adjustment before migrations; document changes here before implementation.

## Boundaries & security
- Only the Sentuh team has admin access in MVP. Business owners do not log in.
- Filament resources/policies and server-side validation protect writes; public pages are read-only.
- Do not trust link URLs from admin forms without validation; reject unsafe protocols (`javascript:`, etc.).
- Admin uploads: validate image type/size, use storage abstraction, avoid storing production assets only on ephemeral disk.
- Do not call Google APIs or claim verified review results; only link to an owner-supplied Google Review URL.
- Use `APP_URL` or a configurable stable public base to generate absolute device URLs. Never embed localhost in production downloads.

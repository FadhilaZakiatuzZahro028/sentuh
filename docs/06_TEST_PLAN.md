# 06 — Test Plan / Demo Checklist

Mark boxes only after actual execution. Create sample businesses and label them as demos.

## Environment
- [ ] Record actual Laravel and PHP versions (`php artisan --version`, `php -v`).
- [x] User reported basic Laravel page accessible locally (capture screenshot later).
- [x] `npm install` and `npm run build` succeeded in reported terminal output.
- [ ] GitHub repository created and initial commit confirmed.

## Admin
- [ ] Unauthenticated visitor cannot access admin CRUD.
- [ ] Admin can create/edit a business and set draft/published status.
- [ ] Admin can create/edit/delete/reorder per-business links.
- [ ] Admin can create multiple devices for the same business and download scannable QR.
- [ ] Invalid links/upload types are rejected with helpful messages.

## Public flows
- [ ] Cafe demo page has intended buttons and correct destinations.
- [ ] School demo page has admissions/site/map links without hard-coded Google Review.
- [ ] Changing slug or business details does not break old device QR routes.
- [ ] Disabled, unknown or unpublished devices do not leak draft information.
- [ ] Smartphone view works at 360px, normal Android/iOS widths, no horizontal overflow.
- [ ] FAQ chat handles known question, unknown question and opt-in WhatsApp fallback.

## Physical
- [ ] Scan printed QR from a real acrylic display on at least one phone.
- [ ] Write NFC URL and tap on a compatible NFC-enabled phone.
- [ ] QR and NFC lead to the intended page, even after business content changes.
- [ ] Photograph prototype for report.

## Deployment
- [ ] HTTPS online page opens; correct `APP_URL`; no localhost QR URLs.
- [ ] Repeated page open after free host idle tested and demo fallback documented.
- [ ] Production logo remains after service restart/redeploy.
- [ ] Smoke test after deployment, including admin auth, DB connectivity, redirects and WhatsApp CTA.
- [ ] Academic screenshots and demo-video backup saved offline for presentation.

## Honest reporting
- [ ] Simulated customer/sales and mock analytics visibly identified as such.
- [ ] Click counts never represented as confirmed Google reviews.

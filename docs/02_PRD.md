# 02 — Product Requirements (MVP)

**All sample brands and statistics here are illustrative, not real customers.**

## Users and journeys
- **Visitor / buyer:** visits Sentuh landing page, reads offer, asks common questions in FAQ chat, opens WhatsApp for personalized inquiry.
- **Sentuh admin:** logs in, adds a business/institution, defines its published page, sets links, registers one or more physical devices, downloads print-ready QR.
- **End visitor:** scans QR / taps NFC, sees the business page, follows a chosen destination (review, map, WhatsApp, site, enrollment, menu etc.).

## Public landing page
- Hero featuring real acrylic product photo when available; clear product explanation and how it works.
- Demonstration business page and simple benefit/FAQ section.
- WhatsApp CTA configured centrally; no fake review/testimonial claims.
- Guided FAQ chatbot: curated answers for pricing (once price is confirmed), how QR/NFC works, compatibility, customization, ordering, delivery. Escalate with a **user-selected** WhatsApp button for unanswered or complex queries; never automatically redirect or claim an AI understands all queries.

## Admin
- Single internal admin role for MVP; authenticated routes only.
- Business form: organization name, unique slug, broad category (descriptive only), tagline/description, optional logo/cover, address, status (draft/published), theme accent.
- Editable **ordered** action links: custom label, kind/icon (review/maps/WhatsApp/Instagram/website/custom), URL, active toggle; validate destination. Suggested presets depend on category but are never mandatory.
- Register devices: unique immutable public code, device label/location, owning business, enabled/disabled state; create QR and NFC URLs (separate channel tags if analytics enabled).
- Preview public page and download QR as printable SVG/PNG as practical; prevent accidental publication of incomplete pages.

## Public business page
- Same Blade template for restaurants, schools and any other organization; page content comes from data.
- Mobile-first, accessible color contrast, descriptive link text; no login required to view published pages.
- Display only populated/enabled links; Google Review is just an external link if a valid official URL is provided by the organization.
- Unknown, disabled or unpublished destinations show a branded helpful 404/unavailable page; never leak drafts.

## Tracking (optional after main demo works)
- Separate QR and NFC redirect links per device so channel may be counted without guessing.
- Optional `scan_events`/click counts for aggregate demonstration. Limit or avoid IP retention; no cross-site tracking for MVP. Show counts as visits/clicks, **not** verified unique people or submitted Google reviews.

## Acceptance scenarios
1. Admin adds "Kopi Senja" with reviews/WhatsApp/map, and adds "SMA Nusantara" with admissions/site/map. Both work with the **same page template**.
2. Two separate stands linked to one organization have different device IDs, but open the same updated organization page.
3. Changing business slug or WhatsApp does not change an already generated device QR's public route.
4. A missing Google Review URL does not show a broken review button.
5. A complex chatbot question produces a truthful fallback and offers user-initiated WhatsApp handoff.
6. All public flows work on narrow mobile widths.

## Definition of Done per feature
Behavior implemented; validation and authorization checked; mobile view checked; success/failure case manually tested or automated; current documentation and demo sample updated; no credentials committed.

# Sentuh — Project Instructions for AI Coding Assistants

**Project:** Sentuh, a QR/NFC acrylic display and universal business-page platform.
**Deadline:** 1 November 2026. **Team:** 2 people. **Prototype budget:** under Rp100,000.

Read `docs/README.md` first, then relevant documents before proposing changes. When instructions disagree, ask for clarification rather than silently rewriting product decisions. These instructions guide coding agents that support `AGENTS.md`; they do not give a chat assistant automatic access to local files.

## Non-negotiables
1. Keep this a Laravel monolith: Blade + Tailwind CSS + Alpine.js, PHP/Laravel backend, Filament admin. Do not introduce a separate React frontend, API service, queue, Redis, or subscription system without an approved decision record.
2. One reusable, mobile-first business-page template for *any* business or institution; configurable links rather than hard-coded categories.
3. A business can have multiple physical QR/NFC devices. Printed QR destinations must be stable and point to a redirect route, not a changeable business slug.
4. Landing-page customer-support chatbot MVP is curated FAQ + handoff to WhatsApp, **not** a generative AI chatbot. Never promise answers outside verified FAQ content.
5. Every customer-facing call-to-action must work on mobile. Keep visual quality intentional: no generic gradients, decorative dashboards, stock-style AI copy, inconsistent cards or excessive animation.
6. Never commit `.env`, credentials, tokens, phone numbers obtained privately, or customer-only information. Validate inputs, protect admin routes, and never expose write access to the public.
7. Avoid fabricated business results. Demo/fictitious sales and sample customers must be visibly labeled as simulations in academic deliverables.
8. Prioritize a working demo and physical acrylic prototype over optional analytics. Do not present QR clicks as actual Google reviews.

## Coding rules
- Follow existing Laravel conventions, framework version and repository style. Verify versions before adding dependencies.
- Make small, reviewable changes. Specify files added/changed and why. Do not rewrite unrelated working code.
- Controllers should be thin; put reusable business logic in services/actions as complexity warrants.
- Use migrations, models and validation; do not build business functionality by manual database edits.
- Use PostgreSQL-compatible schema/queries even while local development uses MySQL. Test the database switch before deployment.
- Keep generated public URLs based on configuration (`APP_URL`), never hard-code localhost into QR output.
- File uploads must be validated; production images must use persistent object storage, not Render's ephemeral filesystem.
- Document new environment variable *names* in `.env.example`; never put real secrets in documentation.
- Run relevant formatting and tests, report actual results; do not claim code was tested unless it was.

## Collaboration protocol
- Work **one milestone at a time**. Start with objective, brief rationale, ordered Windows 11/PowerShell steps, then explicit verification and expected output.
- Ask for terminal output/screenshot if a setup step fails. Do not stack additional tasks onto an unresolved error.
- Before commands that delete/overwrite files, explain the impact and request confirmation.
- When proposing a new library, deployment platform or new feature, state reason, cost implications and whether it changes MVP scope.
- Answer in clear Indonesian unless the user asks otherwise. Explain unfamiliar concepts simply; only introduce code when it is time to implement or requested.
- Update `docs/08_DECISIONS.md` for meaningful architectural changes, `docs/09_PROGRESS.md` after milestones, and `docs/06_TEST_PLAN.md` as checks are added.

## Priority order
Working local Laravel → admin + database → generic business page → QR redirects → deployment → physical NFC prototype → FAQ chatbot → optional click analytics.

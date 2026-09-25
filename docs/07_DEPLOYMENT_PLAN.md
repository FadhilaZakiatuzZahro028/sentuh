# 07 — Deployment Plan (not yet executed)

## Candidate free-demo stack
- **Render (Docker)**: Laravel runtime; may sleep after idle. Avoid storing persistent uploads on local Render filesystem.
- **Supabase PostgreSQL**: candidate hosted relational database; free-tier inactivity and quotas must be checked before launch.
- **Supabase Storage**: candidate persistent image hosting; configure via Laravel storage abstraction or a carefully scoped upload service.
- **GitHub**: source control and host integration.

This is a **candidate demo plan**, not a statement that a customer-facing paid service will have free 24/7 uptime. Confirm current provider terms and PHP/Docker build compatibility at deployment time.

## Release prerequisites
1. Verify Laravel version and select compatible Filament release.
2. Ensure app is framework/DB portable; resolve MySQL → PostgreSQL differences in local test or a staging Supabase project.
3. Set production configuration and real secrets only in host environment settings, never in GitHub or screenshots. Generate app key privately.
4. Run DB migrations on target PostgreSQL only after backup/review; create admin account securely and avoid default credentials.
5. Prepare Dockerfile and startup behavior, app cache/view/build artifacts, correct listen address/port, health check route.
6. Configure proper storage for logos, HTTPS, `APP_URL`, and make QR links stable.
7. Test sleep/cold-start behavior and reserve presentation time for pre-demo warm-up.

## Printed QR policy
Use project-owned domain with sustainable renewal for real sales. If budget does not allow that, print only clearly labeled course prototypes on a temporary hosted address; a future domain switch will otherwise invalidate printed QR codes.

## Rollback and safety
Maintain deploy commit hash, `.env.example` without secrets, initial database backup/seed plan and a short offline demo video. Do not promise customer lifetime hosting until real hosting, domain and support costs are modeled.

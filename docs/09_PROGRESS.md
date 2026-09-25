# 09 — Project Progress

**Last sync:** 25 September 2026
**Deadline:** 1 November 2026
**Internal target:** 28 October 2026

## 1. Development Environment

Verified through user's terminal output:

- Operating system: Windows 11
- Development environment: VS Code and Laragon
- PHP: 8.3.6
- Composer: 2.8.5
- Node.js: 24.15.0
- NPM: 11.12.1
- Git: 2.51.0
- Laravel: 13.33.0
- Local database environment: MySQL

Completed:
- [x] Verify PHP, Composer, Node.js, NPM and Git.
- [x] Create Laravel project.
- [x] Run Laravel locally and open the welcome page.
- [x] Run npm install successfully.
- [x] Run npm run build successfully.

Note:
The optional Fontaine warning did not prevent the Vite build.

## 2. Project Documentation

Completed:
- [x] Define the initial product concept.
- [x] Prepare the project documentation package.
- [x] Place AGENTS.md in the Laravel project root.
- [x] Place documentation inside the docs directory.
- [x] Verify AGENTS.md exists using PowerShell.
- [x] Verify docs/README.md exists.
- [x] Verify docs/09_PROGRESS.md exists.

Documentation maintenance:
- Keep local project documentation as the primary source.
- Synchronize updated documentation with ChatGPT Project.
- Record important technical decisions in 08_DECISIONS.md.
- Update this file after verified development milestones.

## 3. Git and GitHub

Completed:
- [x] Initialize local Git repository.
- [x] Use main as the default branch.
- [x] Verify that .env is ignored by Git.
- [x] Add rules to ignore additional .env files.
- [x] Verify that .env.example is not ignored.
- [x] Stage initial Laravel files and project documentation.
- [x] Exclude CLAUDE.md from the initial staging.
- [x] Run git diff --cached --check successfully.
- [x] Create the initial Git commit.
- [x] Create the remote GitHub repository.
- [x] Connect the local repository to GitHub.
- [x] Push the main branch to GitHub.

Pending:
- [ ] Complete the final review of staged files.
- [ ] Confirm .env.example contains no real secrets.

Note:
CLAUDE.md remains untracked until its instructions
are reviewed and aligned with AGENTS.md.

Initial commit: 7c817e7
Branch: main
Remote: GitHub
Status: Successfully pushed

## 4. Backend and Admin

Current status: NOT STARTED

Pending:
- [ ] Inspect composer.json dependencies.
- [ ] Confirm compatible Filament version.
- [ ] Configure the development database.
- [ ] Install and configure Filament.
- [ ] Implement business, link and device management.
- [ ] Test admin authentication and CRUD operations.

## 5. Public Website and Business Pages

Current status: NOT STARTED

Pending:
- [ ] Implement the Sentuh landing page.
- [ ] Implement the reusable business page.
- [ ] Support different business and organization types.
- [ ] Implement stable device redirect URLs.
- [ ] Generate downloadable QR Codes.
- [ ] Test public pages on mobile devices.

## 6. Deployment and Physical Prototype

Current status: NOT STARTED

Pending:
- [ ] Validate the production hosting approach.
- [ ] Test PostgreSQL compatibility.
- [ ] Deploy the Laravel application.
- [ ] Test the production QR redirect.
- [ ] Select the acrylic and NFC supplier.
- [ ] Produce one physical prototype.
- [ ] Test QR and NFC using real devices.

## 7. Additional MVP Features

Pending:
- [ ] Implement the guided FAQ chatbot.
- [ ] Provide optional WhatsApp handoff.
- [ ] Consider basic analytics if time permits.

## 8. Current Milestone

TASK 006 — GitHub Setup

Status: COMPLETED

Next:
TASK 008 — Verify dependencies and install Filament.

- Inspect composer.json.
- Confirm Filament compatibility.
- Prepare local database configuration.

## 9. Open Risks

- Free hosting availability and cold-start delays.
- MySQL to PostgreSQL compatibility not yet tested.
- Physical acrylic supplier not yet selected.
- NFC-compatible testing phone not yet confirmed.
- Final brand/domain availability not yet verified.
- Prototype budget must remain below Rp100,000.

## 10. Project Working Rules

- Follow AGENTS.md and the relevant docs.
- Work on one development milestone at a time.
- Verify results before marking features complete.
- Update progress after completed milestones.
- Prioritize the functional MVP before optional features.
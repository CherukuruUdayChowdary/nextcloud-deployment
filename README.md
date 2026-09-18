# Nextcloud deployment (Qubitbots)

Deployment files and notes for the Qubitbots Nextcloud instance: a local Docker stack for development, and a PHP install on Hostinger shared hosting for the live site.

## Contents

| Path | What it is |
|---|---|
| `compose.yaml` | Local Docker stack: Nextcloud, MariaDB, Redis, ONLYOFFICE |
| `.env.example` | Passwords for the Docker stack (copy to `.env`) |
| `config.sample.php` | Sample `config.php` for the Hostinger install |
| `scripts/backup-docker.bat` | Backs up the Docker stack (database + files) |
| `scripts/hostinger-post-install.sh` | Post-restore steps on Hostinger |
| `docs/migration-hostinger.md` | Full migration walkthrough |
| `docs/phases.md` | What was built, phase by phase |

## Local (Docker)

```bash
cp .env.example .env    # then edit the passwords
docker compose up -d
# http://localhost:8080
```

## Live (Hostinger shared hosting)

Nextcloud 34.0.3 runs as a plain PHP app. See `docs/migration-hostinger.md`.

Works there: files, sharing, users/groups/quotas, Calendar, Contacts, Tasks, Deck, Tables, Forms, Notes, Mail, Appointments, Cloudflare R2 external storage, desktop and mobile clients.

Doesn't work there: ONLYOFFICE/Collabora office editing, Talk calls, Redis, the Nextcloud MCP server. Those need Docker, so a VPS.

## Notes

- Never commit `config.php`, `.env`, database dumps or the `data/` folder.
- The R2 access keys live in the database, encrypted with `secret` and `passwordsalt`; keep those values when migrating.

# Build phases

| Phase | Work | Status |
|---|---|---|
| 1 | Core apps: Mail, Tasks, Tables, Deck, Forms, Talk, Notes, Audioplayer, PDF Viewer | Done |
| 2 | Desktop client and Android app access | Done |
| 3 | Office editing | Done with ONLYOFFICE (Collabora failed on the WOPI callback in Docker) |
| 4 | Appointments app with a live public booking page | Done |
| 5 | Team accounts and roles: group, intern accounts, group admin, quotas, folder permissions | Done |
| 6 | Move off localhost to Hostinger | Done (shared hosting; office editing pending a VPS) |
| 7 | MCP server for Claude/Nextcloud | Not started (needs a VPS) |

## Phase 5 setup

- Group `Qubitbots-Interns`, accounts `prudhvi` (group admin) and `pavansai`, 1 GB quota each.
- `Qubitbots Shared` shared with the group: read, create, edit (no delete, no reshare).
- `Announcements` shared with the group: view only.

## Known issues hit along the way

- Collabora: "Document loading failed" because the WOPI callback pointed at `localhost:8080`, which inside the container is the container itself. Setting `wopi_callback_url` to `http://app` and adding `aliasgroup1` fixed the host errors, but the editor still failed, so we switched to ONLYOFFICE.
- Web UI admin saves failed until the admin password was reset with `occ`; the password-confirmation step was rejecting it.
- Nextcloud's "Can edit" preset includes delete and reshare; use Custom permissions and click Save share.
- On Hostinger, Argon2 hashing is slow enough that MySQL drops the connection; lower `hashingMemoryCost`/`hashingTimeCost` or use `OC_PASS` with `--password-from-env`.

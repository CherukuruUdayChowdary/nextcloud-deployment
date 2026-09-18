#!/bin/sh
# Run over SSH from the Nextcloud public_html folder after restoring the database.
# Usage: sh hostinger-post-install.sh your-site.hostingersite.com
set -e

php occ maintenance:mode --off
php occ config:system:set trusted_domains 0 --value="$1"
php occ app:enable files_external
php occ app:disable richdocuments      || true
php occ app:disable richdocumentscode  || true
php occ db:add-missing-indices
php occ maintenance:repair --include-expensive
php occ config:system:set maintenance_window_start --value=1 --type=integer
php occ background:cron
php occ status

# Migrating from Docker to Hostinger shared hosting

Nextcloud is installed as a plain PHP app. The Docker stack can't be copied across, so the database and data are restored onto a matching fresh install.

## 1. Back up the Docker stack

`scripts/backup-docker.bat` produces:
- `nextcloud-db.sql` — database dump
- `nextcloud-files.tar.gz` — the whole `/var/www/html` volume (app, config, custom_apps, data)

Extract just what's needed on the laptop:

```cmd
tar -xzf nextcloud-files.tar.gz ./data ./config ./custom_apps
del data\nextcloud.log
tar -caf restore.zip data custom_apps
```

## 2. Prepare Hostinger

- PHP 8.2/8.3, with `pdo_mysql zip gd curl mbstring intl bcmath gmp xml fileinfo openssl exif posix`, and APCu if offered.
- Create a MySQL database and user.
- Enable SSH (hPanel → Advanced → SSH Access).

## 3. Install the same version

Matching the backup's version matters; a newer release won't accept the dump.

```bash
cd ~/domains/<site>
rm -rf public_html/*
curl -L -o nc.zip https://download.nextcloud.com/server/releases/nextcloud-34.0.3.zip
unzip -q nc.zip
mv nextcloud/* nextcloud/.htaccess nextcloud/.user.ini public_html/
rmdir nextcloud && rm nc.zip
```

## 4. Upload and restore

```cmd
scp -P 65002 restore.zip USER@HOST:~/domains/<site>/
scp -P 65002 nextcloud-db.sql USER@HOST:~/
```

```bash
cd ~/domains/<site>
unzip -q restore.zip && mv custom_apps public_html/ && rm restore.zip
mysql -u DBUSER -p DBNAME < ~/nextcloud-db.sql
```

`data/` stays outside `public_html`.

## 5. Configure and finish

Write `public_html/config/config.php` from `config.sample.php`, keeping the original `instanceid`, `passwordsalt` and `secret`, then:

```bash
cd public_html
sh hostinger-post-install.sh <site-address>
OC_PASS='NEW_PASSWORD' php occ user:resetpassword --password-from-env ADMINUSER
```

Add a cron job every 5 minutes:

```
/usr/bin/php /home/USER/domains/<site>/public_html/cron.php
```

## 6. Re-add external storage

External storage mounts created after the backup have to be recreated:

```bash
php occ app:enable files_external
php occ files_external:create "/Cloudflare R2" amazons3 amazons3::accesskey \
  -c bucket=BUCKET -c hostname=ACCOUNTID.r2.cloudflarestorage.com \
  -c region=auto -c use_ssl=true -c use_path_style=true \
  -c key=ACCESS_KEY -c secret=SECRET_KEY
php occ files_external:verify 1
php occ files_external:applicable --add-group=admin --add-group=GROUP 1
```

## 7. Clients

Point the desktop and Android apps at the new address. The desktop client keeps no "add account" button in some builds; quitting it and moving `%APPDATA%\Nextcloud` aside resets it to the login screen.

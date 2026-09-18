@echo off
REM Backs up the local Docker stack: database dump + the whole nextcloud volume.
REM Run from the folder that holds compose.yaml.
setlocal
set BACKUP_DIR=%USERPROFILE%\nextcloud-backup
if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

docker compose exec -u www-data app php occ maintenance:mode --on
docker compose exec db sh -c "mariadb-dump --single-transaction -unextcloud -p$MYSQL_PASSWORD nextcloud > /tmp/nextcloud-db.sql"
docker compose cp db:/tmp/nextcloud-db.sql "%BACKUP_DIR%\nextcloud-db.sql"
docker run --rm -v nextcloud-test_nextcloud:/src -v "%BACKUP_DIR%":/backup alpine tar czf /backup/nextcloud-files.tar.gz -C /src .
docker compose exec -u www-data app php occ maintenance:mode --off

dir "%BACKUP_DIR%"
endlocal

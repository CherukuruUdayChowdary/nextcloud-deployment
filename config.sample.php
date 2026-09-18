<?php
// Sample config for the Hostinger (shared hosting) install.
// Copy to public_html/config/config.php and fill in the real values.
// Keep 'instanceid', 'passwordsalt' and 'secret' from the original install,
// otherwise stored credentials (e.g. external storage keys) can't be decrypted.
$CONFIG = array (
  'instanceid' => 'CHANGE_ME',
  'passwordsalt' => 'CHANGE_ME',
  'secret' => 'CHANGE_ME',
  'trusted_domains' =>
  array (
    0 => 'your-site.hostingersite.com',
  ),
  'datadirectory' => '/home/USER/domains/your-site.hostingersite.com/data',
  'dbtype' => 'mysql',
  'version' => '34.0.3.2',
  'overwrite.cli.url' => 'https://your-site.hostingersite.com',
  'overwriteprotocol' => 'https',
  'htaccess.RewriteBase' => '/',
  'dbname' => 'USER_nextcloud',
  'dbhost' => 'localhost',
  'dbtableprefix' => 'oc_',
  'mysql.utf8mb4' => true,
  'dbuser' => 'USER_dbuser',
  'dbpassword' => 'CHANGE_ME',
  'default_phone_region' => 'IN',
  'maintenance_window_start' => 1,
  // APCu caching (enable the extension in hPanel first)
  'memcache.local' => '\\OC\\Memcache\\APCu',
  'memcache.locking' => '\\OC\\Memcache\\APCu',
  'filelocking.enabled' => true,
  'apcu_enabled_cli' => true,
  // Lower Argon2 cost: the shared DB connection times out during slow hashing
  'hashingMemoryCost' => 65536,
  'hashingTimeCost' => 2,
  'hashingThreads' => 1,
  'apps_paths' =>
  array (
    0 =>
    array (
      'path' => '/home/USER/domains/your-site.hostingersite.com/public_html/apps',
      'url' => '/apps',
      'writable' => false,
    ),
    1 =>
    array (
      'path' => '/home/USER/domains/your-site.hostingersite.com/public_html/custom_apps',
      'url' => '/custom_apps',
      'writable' => true,
    ),
  ),
  'installed' => true,
  'maintenance' => false,
);

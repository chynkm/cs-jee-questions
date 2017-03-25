<?php
set_time_limit(0);
require_once('session.php');
require_once('config.php');

exec('/bin/rm /tmp/jee.sql /tmp/jee_backup.zip > /dev/null 2&>1');
exec('/usr/bin/mysqldump --user='.DB_USERNAME.' --password='.DB_PASSWORD.' --databases '.DB_NAME.' > /tmp/jee.sql');
exec('/usr/bin/zip -r -j /tmp/jee_backup.zip '.getcwd().'/uploads'.' /tmp/jee.sql');

$file = '/tmp/jee_backup.zip';
header('Content-Type: application/zip');
header('Content-Transfer-Encoding: Binary');
header('Content-Length: '.filesize($file));
header('Content-Disposition: attachment; filename='.basename($file));
readfile($file);
die;


<?php
require_once('session.php');
require_once('Db.php');

$db = new Db();
echo $db->deleteImage($_GET['id'], $_GET['column']);

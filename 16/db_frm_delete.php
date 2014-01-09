<?php
require 'db.inc.php';
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$sql = 'drop table frm_access_levels';
mysql_query($sql, $db);

$sql = 'drop table frm_admin';
mysql_query($sql, $db);

$sql = 'drop table frm_bbcode';
mysql_query($sql, $db);


$sql = 'drop table frm_forum';
mysql_query($sql, $db);

$sql = 'drop table frm_post_count';
mysql_query($sql, $db);

$sql = 'drop table frm_posts';
mysql_query($sql, $db);

$sql = 'drop table frm_users';
mysql_query($sql, $db);

echo '<br>Hotovo!';
?>

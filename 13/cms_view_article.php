<?php
require 'db.inc.php';
require 'cms_output_functions.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

include 'cms_header.inc.php';
output_story($db, $_GET['article_id']);
show_comments($db, $_GET['article_id'], TRUE);
include 'cms_footer.inc.php';
?>
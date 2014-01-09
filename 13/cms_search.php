<?php
require 'db.inc.php';
require 'cms_output_functions.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

include 'cms_header.inc.php';

$search = (isset($_GET['search'])) ? $_GET['search'] : '';

$sql = 'SELECT
            article_id
        FROM
            cms_articles
        WHERE
            MATCH (title, article_text) AGAINST ("' .
            mysql_real_escape_string($search, $db) . '" IN BOOLEAN MODE)
        ORDER BY
            MATCH (title, article_text) AGAINST ("' .
            mysql_real_escape_string($search, $db) . '" IN BOOLEAN MODE) DESC';
$result = mysql_query($sql, $db) or die(mysql_error($db));

if (mysql_num_rows($result) == 0) {
  echo '<p><strong>Zadaným kritériím neodpovídají žádné èlánky.</strong></p>';
} else {
  while ($row = mysql_fetch_array($result)) {
    output_story($db, $row['article_id'], TRUE);
  }
}
mysql_free_result($result);

include 'cms_footer.inc.php';
?>
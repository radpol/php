<?php
require 'db.inc.php';
require 'cms_output_functions.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

include 'cms_header.inc.php';

$sql = 'SELECT
            article_id
        FROM
            cms_articles
        WHERE
            is_published = TRUE
        ORDER BY
            publish_date DESC';
$result = mysql_query($sql, $db);

if (mysql_num_rows($result) == 0) {
  echo '<p><strong>Nejsou k dispozici žádné èlánky k redakci.</strong></p>';
} else {
  while ($row = mysql_fetch_array($result)) {
    output_story($db, $row['article_id'], TRUE);
  }
}
mysql_free_result($result);

include 'cms_footer.inc.php';
?>
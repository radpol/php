<?php
require 'db.inc.php';
include 'cms_output_functions.inc.php';
include 'cms_header.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

echo '<h2>Dostupnost �l�nk�</h2>';

echo '<h3>�ekaj�c� �l�nky</h3>';
$sql = 'SELECT
            article_id, title, UNIX_TIMESTAMP(submit_date) AS submit_date
        FROM
            cms_articles
        WHERE
            is_published = FALSE
        ORDER BY
            title ASC';
$result = mysql_query($sql, $db) or die(mysql_error($db));

if (mysql_num_rows($result) == 0) {
  echo '<p><strong>Nem�te ��dn� nepublikovan� �l�nky.</strong></p>';
} else {
  echo '<ul>';
  while ($row = mysql_fetch_array($result)) {
    echo '<li><a href="cms_review_article.php?article_id=' .
    $row['article_id'] . '">' . htmlspecialchars($row['title']) .
            '</a> (' . datum("j. F Y", $row['submit_date']) . ')</li>';
  }
  echo '</ul>';
}
mysql_free_result($result);

echo '<h3>Publikovan� �l�nky</h3>';
$sql = 'SELECT
            article_id, title, UNIX_TIMESTAMP(publish_date) AS publish_date
        FROM
            cms_articles
        WHERE
            is_published = TRUE
        ORDER BY
            title ASC';
$result = mysql_query($sql, $db) or die(mysql_error($db));

if (mysql_num_rows($result) == 0) {
  echo '<p><strong>Nem�te ��dn� publikovan� �l�nky.</strong></p>';
} else {
  echo '<ul>';
  while ($row = mysql_fetch_array($result)) {
    echo '<li><a href="cms_review_article.php?article_id=' .
    $row['article_id'] . '">' . htmlspecialchars($row['title']) .
            '</a> (' . datum("j. F Y", $row['publish_date']) . ')</li>';
  }
  echo '</ul>';
}
mysql_free_result($result);

include 'cms_footer.inc.php';
?>
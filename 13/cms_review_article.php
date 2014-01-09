<?php
require 'db.inc.php';
require 'cms_output_functions.inc.php';
include 'cms_header.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$article_id = (isset($_GET['article_id']) && 
  ctype_digit($_GET['article_id'])) ? $_GET['article_id'] : '';

echo '<h2>Redakce èlánku</h2>';
output_story($db, $article_id);

$sql = 'SELECT
            is_published, UNIX_TIMESTAMP(publish_date) AS publish_date,
            access_level
        FROM
            cms_articles a INNER JOIN cms_users u ON a.user_id = u.user_id
        WHERE
            article_id = ' . $article_id;
$result = mysql_query($sql, $db) or die(mysql_error());

$row = mysql_fetch_array($result);
extract($row);
mysql_free_result($result);

if (!empty($date_published) and $is_published) {
  echo '<h4>Publikováno: ' . date('l F j, Y H:i', $date_published) . '</h4>';
}
?>

<form method="post" action="cms_transact_article.php">
  <div>
    <input type="submit" name="action" value="Upravit"/>
    <?php
    if ($access_level > 1 || $_SESSION['access_level'] > 1) {
      if ($is_published) {
        echo '<input type="submit" name="action" value="Stáhnout"/> ';
      } else {
        echo '<input type="submit" name="action" value="Publikovat"/> ';
        echo '<input type="submit" name="action" value="Vymazat"/> ';
      }
    }
    ?>
    <input type="hidden" name="article_id" value="<?php echo $article_id; ?>"/>
  </div>
</form>
<?php
include 'cms_footer.inc.php';
?>
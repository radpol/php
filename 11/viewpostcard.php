<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
$token = (isset($_GET['token'])) ? $_GET['token'] : '';

$query = 'SELECT email_id, token, to_name, to_email, from_name, from_email,
          subject, postcard, message FROM pc_confirmation WHERE
          token = "' . $token . '"';
$result = mysql_query($query, $db) or die(mysql_error());

if (mysql_num_rows($result) == 0) {
  echo '<p>To je ale pøekvapení! Není co prohlížet.</p>';
  mysql_free_result($result);
  exit;
} else {
  $row = mysql_fetch_assoc($result);
  extract($row);
  mysql_free_result($result);
}
?>
<html>
  <head>
    <title><?php echo $subject; ?></title>
  </head>
  <body>
    <?php
    echo '<img src="' . $postcard . '" alt="' . $description . ' "/><br/>';
    echo $message;
    ?>
  </body>
</html>
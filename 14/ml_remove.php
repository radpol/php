<html>
  <head>
    <title>Odhlášení odbìru hromadné pošty</title>
  </head>
  <body>
    <h1>Odhlášení odbìru hromadné pošty</h1>
    <?php
    require 'db.inc.php';

    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
      die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    $user_id = (isset($_GET['user_id']) &&
      ctype_digit($_GET['user_id'])) ? $_GET['user_id'] : -1;

    $ml_id = (isset($_GET['ml_id']) &&
      ctype_digit($_GET['ml_id'])) ? $_GET['ml_id'] : -1;

    if (empty($user_id) || empty($ml_id)) {
      die('Nesprávné parametry.');
    }
    $query = 'DELETE FROM ml_subscriptions WHERE user_id = ' . $user_id .
      ' AND ml_id = ' . $ml_id;
    mysql_query($query, $db) or die(mysql_error());

    $query = 'SELECT listname FROM ml_lists WHERE ml_id = ' . $ml_id;
    $result = mysql_query($query, $db) or die(mysql_error($db));
    if (mysql_num_rows($result) == 0) {
      die('Neznámý seznam.');
    }
    $row = mysql_fetch_array($result);
    $listname = $row['listname'];
    mysql_free_result($result);

    echo '<p>Byli jste odebráni z distribuèního seznamu ' . $listname . '</p>';
    echo '<p><a href="ml_user.php?user_id=' . $user_id . '">Návrat ' .
      'na stránku pro pøihlášení k odbìru hromadné pošty.</a></p>';
    ?>
  </body>
</html>
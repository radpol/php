<html>
  <head>
    <title>Dìkujeme</title>
  </head>
  <body>
    <?php
    require 'db.inc.php';

    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
      die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    $user_id = (isset($_GET['user_id'])) ? $_GET['user_id'] : '';
    $ml_id = (isset($_GET['ml_id'])) ? $_GET['ml_id'] : '';
    $type = (isset($_GET['type'])) ? $_GET['type'] : '';

    if (empty($user_id)) {
      die('Není definován identifikátor uživatele.');
    }
    $query = 'SELECT first_name, last_name, email
              FROM ml_users WHERE user_id = ' . $user_id;
    $result = mysql_query($query, $db) or die(mysql_error());

    if (mysql_num_rows($result) > 0) {
      $row = mysql_fetch_assoc($result);
      $full_name = $row['first_name'] . ' ' . $row['last_name'];
      $email = $row['email'];
    } else {
      die('Identifikátor uživatele nenalezen.');
    }
    mysql_free_result($result);

    if (empty($ml_id)) {
      die('Není definován identifikátor distribuèního seznamu.');
    }
    if (ctype_digit($ml_id)) {
      $query = 'SELECT listname FROM ml_lists WHERE ml_id = ' . $ml_id;
      $result = mysql_query($query, $db) or die(mysql_error());

      if (mysql_num_rows($result)) {
        $row = mysql_fetch_assoc($result);
        $listname = $row['listname'];
      } else {
        die ('Identifikátor distribuèního seznamu nenalezen.');
      }
      mysql_free_result($result);
    }
    if ($type == 'c') {
      echo '<h1>Podìkování uživateli: ' . $full_name . '</h1>';
      if (ctype_digit($ml_id)) {
        echo '<p>Potvrzení o zaøazení do distribuèního seznamu ' . $listname .
          ' bylo odesláno na adresu ' . $email . '.</p>';
      }
      else
      {
        echo '<p>Potvrzení o zaøazení do nìkolika distribuèních seznamù' .
          ' bylo odesláno na adresu ' . $email . '.</p>';
      }
    } else {
      echo '<h1>Podìkování uživateli: ' . $full_name . '</h1>';
      echo '<p>Dìkujeme za pøihlášení do distribuèního seznamu ' .
        $listname . '.</p>';
    }
    ?>
  </body>
</html>
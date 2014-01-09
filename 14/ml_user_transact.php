<?php
require 'db.inc.php';
require 'class.SimpleMail.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';

switch ($action) {
  case 'Pøihlásit':
    $email = (isset($_POST['email'])) ? $_POST['email'] : '';
    $query = 'SELECT
                  user_id
              FROM
                  ml_users
              WHERE
                  email="' . mysql_real_escape_string($email, $db) . '"';
    $result = mysql_query($query, $db) or die(mysql_error($db));

    if (mysql_num_rows($result) > 0) {
      $row = mysql_fetch_assoc($result);
      $user_id = $row['user_id'];
    } else {
      $first_name = (isset($_POST['first_name'])) ? $_POST['first_name'] : '';
      $last_name = (isset($_POST['last_name'])) ? $_POST['last_name'] : '';

      $query = 'INSERT INTO ml_users
                    (first_name, last_name, email)
                VALUES
                    ("' . mysql_real_escape_string($first_name, $db) . '", ' .
                    '"' . mysql_real_escape_string($last_name, $db) . '", ' .
                    '"' . mysql_real_escape_string($email, $db) . '")';
      mysql_query($query, $db);
      $user_id = mysql_insert_id($db);
    }
    mysql_free_result($result);

    $count = 0;
    foreach ($_POST['ml_id'] as $ml_id) {
      if (ctype_digit($ml_id)) {
        $query = 'INSERT INTO ml_subscriptions
                      (user_id, ml_id, pending)
                  VALUES
                      (' . $user_id . ', ' . $ml_id . ', TRUE)';
        mysql_query($query, $db);

        $query = 'SELECT listname FROM ml_lists WHERE ml_id = ' . $ml_id;
        $result = mysql_query($query, $db);

        $row = mysql_fetch_assoc($result);
        $listname = $row['listname'];

        $message = 'Vážený uživateli,' . "\n\n" .
          'Elektronicky s Vámi komunikujeme na základì Vámi ' .
          'udìleného souhlasu k odbìru zpráv pro distribuèní seznam ' .
          $listname . ".\n\n" .
          'Jestliže jste zprávu obdržel(a) omylem, omlouváme se. ' .
          'Chcete-li svùj odbìr potvrdit, pokraèujte na potvrzovací ' .
          'stránku uvedenou níže.' . "\n\n" .
          'Pokud jste odbìr zpráv vyžádali, potvrïte prosím ' .
          'tuto skuteènost klepnutím na tento odkaz: ' . "\n" .
          'http://www.priklad.cz/ml_user_transact.php?user_id=' .
          $user_id . '&ml_id=' . $ml_id . '&action=potvrzeni';

        $mail = new SimpleMail();
        $mail->setToAddress($email);
        $mail->setFromAddress('admin@priklad.cz');
        $mail->setSubject('Žádost o potvrzení odbìru hromadné pošty');
        $mail->setTextBody($message);
        $mail->send();
        unset($mail);
        $count++;
      }
    }
    header('Location: ml_thanks.php?user_id=' . $user_id . '&ml_id=' .
      ($count == 1 ? $ml_id : 'n') . '&type=c');
    break;

  case 'potvrzeni':
    $user_id = (isset($_GET['user_id'])) ? $_GET['user_id'] : '';
    $ml_id = (isset($_GET['ml_id'])) ? $_GET['ml_id'] : '';

    if (!empty($user_id) && !empty($ml_id)) {
      $query = 'UPDATE ml_subscriptions
            SET
                pending = FALSE
            WHERE
                user_id = ' . $user_id . ' AND
                ml_id = ' . $ml_id;
      mysql_query($query, $db) or die(mysql_error($db));

      $query = 'SELECT
                listname
            FROM
                ml_lists
            WHERE
                ml_id = ' . $ml_id;
      $result = mysql_query($query, $db);

      $row = mysql_fetch_assoc($result);
      $listname = $row['listname'];
      mysql_free_result($result);

      $query = 'SELECT
                first_name, email
            FROM
                ml_users
            WHERE
                user_id = ' . $user_id;
      $result = mysql_query($query, $db);

      $row = mysql_fetch_assoc($result);
      $first_name = $row['first_name'];
      $email = $row['email'];
      mysql_free_result($result);

      $message = 'Vážený uživateli,' . "\n\n" .
        'Zaregistrovali jsme Vás k odbìru hromadné pošty ' .
        'pro seznam ' . $listname . ".  Vítejte!\n\n" .
        'Pokud jste tuto zprávu obdrželi omylem, ' .
        'omlouváme se. Zrušit odbìr zpráv mùžete ' .
        'neprodlenì klepnutím na následující odkaz' . "\n" .
        'http://www.priklad.cz/ml_remove.php?user_id=' .
        $user_id . '&ml_id=' . $ml_id;

      $mail = new SimpleMail();
      $mail->setToAddress($email);
      $mail->setFromAddress('admin@priklad.cz');
      $mail->setSubject('Potvrzení odbìru hromadné pošty');
      $mail->setTextBody($message);
      $mail->send();

      header('Location: ml_thanks.php?user_id=' . $user_id . '&ml_id=' .
        $ml_id . '&type=s');
    } else {
      header('Location: ml_user.php');
    }
    break;
}
?>
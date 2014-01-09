<?php
require 'db.inc.php';
require 'class.SimpleMail.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$action = (isset($_POST['action'])) ? $_POST['action'] : '';

switch ($action) {
  case 'Pøidat distribuèní seznam':
    $listname = isset($_POST['listname']) ? $_POST['listname'] : '';
    $query = 'INSERT INTO ml_lists
                  (listname)
              VALUES
                  ("' . mysql_real_escape_string($listname, $db) . '")';
    mysql_query($query, $db) or die(mysql_error($db));
    break;

  case 'Vymazat distribuèní seznam':
    $ml_id = isset($_POST['ml_id']) ? $_POST['ml_id'] : '';
    if (ctype_digit($ml_id)) {
      $query = 'DELETE FROM ml_lists WHERE ml_id=' . $ml_id;
      mysql_query($query, $db) or die(mysql_error($db));

      $query = 'DELETE FROM ml_subscriptions WHERE ml_id=' . $ml_id;
      mysql_query($query, $db) or die(mysql_error($db));
    }
    break;

  case 'Odeslat zprávu':
    $ml_id = isset($_POST['ml_id']) ? $_POST['ml_id'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    if ($ml_id == 'all') {
      $listname = 'Hlavní';
    } else if (ctype_digit($ml_id)) {
      $query = 'SELECT
              listname
          FROM
              ml_lists
          WHERE
              ml_id=' . $ml_id;
      $result = mysql_query($query, $db) or die(mysql_error($db));
      $row = mysql_fetch_assoc($result);
      $listname = $row['listname'];
      mysql_free_result($result);
    } else {
      break;
    }

    $query = 'SELECT DISTINCT
                usr.email, usr.first_name, usr.user_id
              FROM ml_users usr
                INNER JOIN ml_subscriptions mls
                ON usr.user_id = mls.user_id
              WHERE mls.pending = FALSE';
    if ($_POST['ml_id'] != 'all') {
      $query .= " AND mls.ml_id=" . $ml_id;
    }

    $result = mysql_query($query, $db) or die(mysql_error($db));
    if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
        if (is_numeric($_POST['ml_id'])) {
          $footer = "Tuto zprávu jste obdrželi, protože jste èlenem " .
            "distribuèního seznamu " . $listname .
            ". Pokud jste obdrželi tuto zprávu omylem, " .
            "nebo pokud chcete zrušit èlenství v tomto " .
            "distribuèním seznamu, navštivte prosím následující " .
            "adresu URL:\n" .
            "http://www.priklad.cz/ml_remove.php?user_id=" .
            $row['user_id'] . "&ml_id=". $_POST['ml_id'];
        } else {
          $footer = "Tuto zprávu dostáváte, protože jste se k jejímu " .
            "odbìru pøihlásili registrací v jednom nebo v nìkolika " .
            "distribuèních seznamech. Chcete-li odbìr zmìnit, " .
            "navštivte následující adresu URL:\n" .
            "http://www.priklad.cz/ml_user.php?user_id=" . $row['user_id'];
        }
        $message .= "\n\n--------------\n";
        $message .= $footer;

        $mail = new SimpleMail();
        $mail->setToAddress($row['email']);
        $mail->setFromAddress('admin@priklad.cz');
        $mail->setSubject(stripslashes($subject));
        $mail->setTextBody($message);
        $mail->send();
      }
    }
    mysql_free_result($result);
    break;
}
header('Location: ml_admin.php');
?>

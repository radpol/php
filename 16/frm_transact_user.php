<?php
session_start();
require 'db.inc.php';
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
if (isset($_REQUEST['action'])) {
  switch ($_REQUEST['action']) {
    case 'Pøihlásit':
      if (isset($_POST['email']) && isset($_POST['passwd'])) {
        $sql = 'SELECT
                    id, access_lvl, name, last_login
                FROM
                    frm_users
                WHERE
                    email = "' . $_POST['email'] . '" AND
                    password = "' . $_POST['passwd'] . '"';
        $result = mysql_query($sql, $db) or die(mysql_error($db));

        if ($row = mysql_fetch_array($result)) {
          $_SESSION['user_id'] = $row['id'];
          $_SESSION['access_lvl'] = $row['access_lvl'];
          $_SESSION['name'] = $row['name'];
          $_SESSION['last_login'] = $row['last_login'];
          $sql = 'UPDATE frm_users SET
                        last_login = "' . date('Y-m-d H:i:s') . '"
                    WHERE
                        id = ' . $row['id'];
          mysql_query($sql, $db) or die(mysql_error($db));
        }
        else
        {
          header('Location: frm_login.php');
          exit();
        }
      }
      header('Location: frm_index.php');
      exit();
      break;

    case 'Odhlásit':
      session_unset();
      session_destroy();
      header('Location: frm_index.php');
      exit();
      break;

    case 'Vytvoøit úèet':
      if (isset($_POST['name']) && isset($_POST['email']) &&
        isset($_POST['passwd']) && isset($_POST['passwd2']) &&
        $_POST['passwd'] == $_POST['passwd2']) {
        $sql = 'INSERT INTO frm_users
                    (email, name, password, date_joined, last_login)
                VALUES
                    ("' . $_POST['email'] . '", "' . $_POST['name'] . '", 
                    "' . $_POST['passwd'] . '", "' . date('Y-m-d H:i:s') . '",
                    "' . date('Y-m-d H:i:s') . '")';
        mysql_query($sql, $db) or die(mysql_error($db));

        $_SESSION['user_id'] = mysql_insert_id($db);
        $_SESSION['access_lvl'] = 1;
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
      }
      header('Location: frm_index.php');
      exit();
      break;

    case 'Zmìnit úèet':
      if (isset($_POST['name']) && isset($_POST['email']) &&
        isset($_POST['accesslvl']) && isset($_POST['userid'])) {
        $sql = 'UPDATE frm_users SET
                    email = "' . $_POST['email'] . '",
                    name = "' . $_POST['name'] . '",
                    access_lvl = ' . $_POST['accesslvl'] . ',
                    signature = "' . $_POST['signature'] . '"
                WHERE
                    id = ' . $_POST['userid'];
        mysql_query($sql, $db) or die(mysql_error($db));
      }
      header('Location: frm_admin.php?option=uzivatele');
      exit();
      break;

    case 'Upravit úèet':
      if (isset($_POST['name']) && isset($_POST['email']) &&
        isset($_POST['accesslvl']) && isset($_POST['userid'])) {
        $chg_pw = FALSE;
        if (!empty($_POST['oldpasswd'])) {
          $sql = 'SELECT
                        password
                    FROM
                        frm_users
                    WHERE
                        id = ' . $_POST['userid'] . ' AND
                        password = "' . $_POST['oldpasswd'] . '"';
          $result = mysql_query($sql, $db) or die(mysql_error($db));
          if ($row = mysql_fetch_array($result)) {
            if (isset($_POST['passwd']) && isset($_POST['passwd2']) &&
              $_POST['passwd'] == $_POST['passwd2']) {
              $chg_pw = TRUE;
            } else {
              header('Location: frm_useraccount.php?error=heslonelzeupravovat');
              exit();
              break;
            }
          }
        }
        $sql = 'UPDATE frm_users SET
                    email = "' . $_POST['email'] . '",
                    name="' . $_POST['name'] . '",
                    access_lvl = ' . $_POST['accesslvl'] . ',
                    signature = "' . $_POST['signature'] . '"';
        if ($chg_pw) {
          $sql .= ', password = "' . $_POST['passwd'] . '"';
        }
        $sql .= ' WHERE id=' . $_POST['userid'];
        mysql_query($sql, $db) or die(mysql_error($db));
      }
      header('Location: frm_index.php');
      break;

    case 'Pøipomenout heslo':
      if (isset($_POST['email'])) {
        $sql = 'SELECT
                    password
                FROM
                    frm_users
                WHERE
                    email="' . $_POST['email'] . '"';

        $result = mysql_query($sql, $db) or die(mysql_error($db));

        if (mysql_num_rows($result)) {
          $row = mysql_fetch_array($result);
          $headers = array();
          $headers[] = 'From: admin@priklad.cz';
          $headers[] = 'MIME-Version: 1.0';
          $headers[] = 'Content-type: text/plain; charset="windows-1250"';
          $headers[] = 'Content-Transfer-Encoding: 7bit';
          $subject = 'Pøipomenutí zapomenutého hesla';
          $body = 'Jen pro poøádek, vaše heslo pro stránky pøátel komiksù je: ' .
                  $row['password'] ."\n\n";
          $body .= 'Mùžete je použít pro pøihlášení na stránce http://' .
          $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) .
                    '/frm_login.php?e=' . $_POST['email'];

          mail($_POST['email'], $subject, $body, join("\r\n", $headers));
        }
      }
      header('Location: frm_login.php');
      break;
  }
}
?>
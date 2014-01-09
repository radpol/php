<?php
require_once 'db.inc.php';
require_once 'cms_http_functions.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

if (isset($_REQUEST['action'])) {

  switch ($_REQUEST['action']) {
    case 'Pøihlásit':
      $email = (isset($_POST['email'])) ? $_POST['email'] : '';
      $password = (isset($_POST['password'])) ? $_POST['password'] : '';
      $sql = 'SELECT
                  user_id, access_level, name
              FROM
                  cms_users
              WHERE
                  email = "' . mysql_real_escape_string($email, $db) . '" AND
                  password = PASSWORD("' .
                  mysql_real_escape_string($password, $db) . '")';
      $result = mysql_query($sql, $db) or die(mysql_error($db));
      if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        extract($row);
        session_start();
        
        $_SESSION['user_id'] = $user_id;
        $_SESSION['access_level'] = $access_level;
        $_SESSION['name'] = $name;
      }
      mysql_free_result($result);
      redirect('cms_index.php');
      break;

    case 'Odhlásit':
      session_start();
      session_unset();
      session_destroy();
      redirect('cms_index.php');
      break;

    case 'Vytvoøit úèet':
      $name = (isset($_POST['name'])) ? $_POST['name'] : '';
      $email = (isset($_POST['email'])) ? $_POST['email'] : '';
      $password_1 = (isset($_POST['password_1'])) ? $_POST['password_1'] : '';
      $password_2 = (isset($_POST['password_2'])) ? $_POST['password_2'] : '';
      $password = ($password_1 == $password_2) ? $password_1 : '';
      if (!empty($name) && !empty($email) && !empty($password)) {
        $sql = 'INSERT INTO cms_users
                    (email, password, name)
                VALUES
                  ("' . mysql_real_escape_string($email, $db) . '",
                  PASSWORD("' . mysql_real_escape_string($password, $db) . '"),
                  "' . mysql_real_escape_string($name, $db) . '")';
        mysql_query($sql, $db) or die(mysql_error($db));

        session_start();
        $_SESSION['user_id'] = mysql_insert_id($db);
        $_SESSION['access_level'] = 1;
        $_SESSION['name'] = $name;
      }
      redirect('cms_index.php');
      break;

    case 'Upravit úèet':
      $user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : '';
      $email = (isset($_POST['email'])) ? $_POST['email'] : '';
      $name = (isset($_POST['name'])) ? $_POST['name'] : '';
      $access_level = 
        (isset($_POST['access_level'])) ? $_POST['access_level'] : '';
      if (!empty($user_id) && !empty($name) && !empty($email) &&
        !empty($access_level) && !empty($user_id)) {
        $sql = 'UPDATE cms_users SET
                    email = "' . mysql_real_escape_string($email, $db) . '",
                    name = "' . mysql_real_escape_string($name, $db) . '",
                    access_level = "' .
                    mysql_real_escape_string($access_level, $db) . ' "
                WHERE
                    user_id = ' . $user_id;
        mysql_query($sql, $db) or die(mysql_error($db));
      }
      redirect('cms_admin.php');
      break;

    case 'Nové heslo!':
      $email = (isset($_POST['email'])) ? $_POST['email'] : '';
      if (!empty($email)) {
        $sql = 'SELECT email FROM cms_users WHERE email="' .
        mysql_real_escape_string($email, $db) . '"';
        $result = mysql_query($sql, $db) or die(mysql_error($db));
        if (mysql_num_rows($result) > 0) {
          $password = strtoupper(substr(sha1(time()), rand(0, 32), 8));
          $subject = 'Obnovení hesla k webu komiksù';
          $body = 'Vypadá to tak, že jste zapomenuli heslo? Netrapte se. ' .
                    'Vytvoøili jsme vám nové!' . "\n\n";
          $body .= 'Vaše nové heslo: ' . $password;
          mail($email, $subject, $body);
        }
        mysql_free_result($result);
      }
      redirect('cms_login.php');
      break;

    case 'Upravit údaje':
      session_start();
      $email = (isset($_POST['email'])) ? $_POST['email'] : '';
      $name = (isset($_POST['name'])) ? $_POST['name'] : '';
      if (!empty($name) && !empty($email) && !empty($_SESSION['user_id']))
      {
        $sql = 'UPDATE cms_users SET
                    email = "' . mysql_real_escape_string($email, $db) . '",
                    name = "' . mysql_real_escape_string($name, $db) . '",
                WHERE
                    user_id = ' . $_SESSION['user_id'];
        mysql_query($sql, $db) or die(mysql_error($db));
      }
      redirect('cms_cpanel.php');
      break;
    default:
      redirect('cms_index.php');
  }
} else {
  redirect('cms_index.php');
}
?>
<?php
session_start();

include 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

// Odfiltrování pøijatých hodnot.
$username = (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'main.php';

if (isset($_POST['submit'])) {
  $query = 'SELECT admin_level FROM site_user WHERE ' .
    'username = "' . mysql_real_escape_string($username, $db) . '" AND ' .
    'password = PASSWORD("' . mysql_real_escape_string($password, $db) . '")';
  $result = mysql_query($query, $db) or die(mysql_error($db));

  if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_assoc($result);
    $_SESSION['username'] = $username;
    $_SESSION['logged'] = 1;
    $_SESSION['admin_level'] = $row['admin_level'];
    header ('Refresh: 5; URL=' . $redirect);
    echo '<p>Nyní budete pøesmìrováni na pùvodní stránku požadavku.</p>';
    echo '<p>Nebudete-li do 5 sekund pøesmìrováni automaticky, ' .
            '<a href="' . $redirect . '">klepnìte sem</a>.</p>';
    mysql_free_result($result);
    mysql_close($db);
    die();
  } else {
    // Tyto hodnoty je tøeba explicitnì nastavit.
    $_SESSION['username'] = '';
    $_SESSION['logged'] = 0;
    $_SESSION['admin_level'] = 0;

    $error = '<p><strong>Bylo zadáno neplatné uživatelské jméno ' .
            'a heslo!</strong> <a href="register.php">Zaregistrujte se ' .
            'zde</a>, pokud jste tak již neuèinili.</p>';
  }
  mysql_free_result($result);
}
?>
<html>
  <head>
    <title>Pøihlášení</title>
  </head>
  <body>
    <?php
    if (isset($error)) {
      echo $error;
    }
    ?>
    <form action="login.php" method="post">
      <table>
        <tr>
          <td>Uživatelské jméno:</td>
          <td><input type="text" name="username" maxlength="20" size="20"
                     value="<?php echo $username; ?>"/></td>
        </tr><tr>
          <td>Heslo:</td>
          <td><input type="password" name="password" maxlength="20" size="20"
                     value="<?php echo $password; ?>"/></td>
        </tr><tr>
          <td> </td>
          <td>
          <input type="hidden" name="redirect" value="<?php echo $redirect ?>"/>
          <input type="submit" name="submit" value="Pøihlásit"/>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php
mysql_close($db);
?>
<?php
session_start();

// Odfiltrování pøijatých hodnot.
$username = (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'main.php';

if (isset($_POST['submit'])) {

  if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {

    if (!empty($_POST['username']) && $_POST['username'] == 'tatokniha' &&
      !empty($_POST['password']) && $_POST['password'] == 'jeskvìlá') {


      $_SESSION['username'] = $username;
      $_SESSION['logged'] = 1;
      header ('Refresh: 5; URL=' . $redirect);
      echo '<p>Nyní budete pøesmìrováni na pùvodní stránku požadavku.</p>';
      echo '<p>Nebudete-li do 5 sekund pøesmìrováni automaticky, ' .
            '<a href="' . $redirect . '">klepnìte sem</a>.</p>';
      die();
    } else {
      // Tyto hodnoty je tøeba explicitnì nastavit.
      $_SESSION['username'] = '';
      $_SESSION['logged'] = 0;

      $error = '<p><strong>Bylo zadáno neplatné uživatelské jméno ' .
            'a heslo!</strong> <a href="register.php">Zaregistrujte se ' .
            'zde</a>, pokud jste tak již neuèinili.</p>';
    }
  }
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

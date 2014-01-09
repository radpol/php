<?php
include 'auth.inc.php';
include 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$hobbies_list = array('Poèítaèe', 'Tanec', 'Cvièení', 'Létání', 'Golf',
    'Lov', 'Internet', 'Ètení', 'Cestování', 'Jiné');

if (isset($_POST['submit']) && $_POST['submit'] == 'Upravit') {
  // Filtr pøijatých hodnot.
  $username = (isset($_POST['username'])) ? trim($_POST['username']) : '';
  $user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : '';
  $first_name = (isset($_POST['first_name'])) ? trim($_POST['first_name']) : '';
  $last_name = (isset($_POST['last_name'])) ? trim($_POST['last_name']) : '';
  $email = (isset($_POST['email'])) ? trim($_POST['email']) : '';
  $city = (isset($_POST['city'])) ? trim($_POST['city']) : '';
  $state = (isset($_POST['state'])) ? trim($_POST['state']) : '';
  $hobbies = (isset($_POST['hobbies']) && is_array($_POST['hobbies'])) ?
  $_POST['hobbies'] : array();

  $errors = array();

  // Kontrola, zda uživatelské jméno souhlasí s identifikátorem uživatele
  // (aby hackeøi nemohli manipulovat s údaji jiných uživatelù).
  $query = 'SELECT username FROM site_user WHERE user_id = ' . (int)$user_id .
    ' AND username = "' . mysql_real_escape_string($_SESSION['username'], $db) .
    '"';
  $result = mysql_query($query, $db) or die(mysql_error());

  if (mysql_num_rows($result) == 0) {
    ?>
    <html>
      <head>
        <title>Aktualizace uživatelského úètu</title>
      </head>
      <body>
        <p><strong>Nepokoušejte se podvést formuláø!</strong></p>
      </body>
    </html>
    <?php
    mysql_free_result($result);
    mysql_close_db($db);
    die();
  }
  mysql_free_result($result);


  if (empty($first_name)) {
    $errors[] = 'Musíte uvést jméno.';
  }
  if (empty($last_name)) {
    $errors[] = 'Musíte uvést pøíjmení.';
  }
  if (empty($email)) {
    $errors[] = 'Musíte uvést adresu elektronické pošty.';
  }

  if (count($errors) > 0) {
    echo '<p><strong style="color:#FF000;">Nelze dokonèit aktualizaci úètu.' .
      '</strong></p>';
    echo '<p>Opravte následující chyby:</p>';
    echo '<ul>';
    foreach ($errors as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
  } else {
    // Vše je v poøádku, proto mùžeme pøijaté informace uložit do databáze.

    $query = 'UPDATE site_user_info SET
      first_name = "' . mysql_real_escape_string($first_name, $db) . '",
      last_name = "' . mysql_real_escape_string($last_name, $db) . '",
      email = "' . mysql_real_escape_string($email, $db) . '",
      city = "' . mysql_real_escape_string($city, $db) . '",
      state = "' . mysql_real_escape_string($state, $db) . '",
      hobbies = "' . mysql_real_escape_string(join(', ', $hobbies), $db) . '"
      WHERE
      user_id = ' . $user_id;
    mysql_query($query, $db) or die(mysql_error());
    mysql_close($db);
    ?>
    <html>
    <head>
      <title>Aktualizace uživatelského úètu</title>
    </head>
    <body>
      <p><strong>Vaše osobní údaje byly aktualizovány.</strong></p>
      <p><a href="user_personal.php">Klepnìte sem</a> pro návrat.</p>
    </body>
    </html>
    <?php
    die();
  }
} else {
  $query = 'SELECT
              u.user_id, first_name, last_name, email, city,
              state, hobbies AS my_hobbies
            FROM
              site_user u JOIN site_user_info i ON u.user_id = i.user_id
            WHERE
              username = "' .
              mysql_real_escape_string($_SESSION['username'], $db) . '"';
  $result = mysql_query($query, $db) or die(mysql_error());
  $row = mysql_fetch_assoc($result);

  extract($row);
  $hobbies = explode(', ', $my_hobbies);

  mysql_free_result($result);
  mysql_close($db);
}
?>
<html>
  <head>
    <title>Aktualizace uživatelského úètu</title>
    <style type="text/css">
      td { vertical-align: top; }
    </style>
    <script type="text/javascript">
      window.onload = function() {
        document.getElementById('cancel').onclick = goBack;
      }
      function goBack() {
        history.go(-1);
      }
    </script>
  </head>
  <body>
    <h1>Aktualizace uživatelského úètu</h1>
    <form action="update_account.php" method="post">
      <table>
        <tr>
          <td>Uživatelské jméno:</td>
          <td><input type="text" value="<?php echo $_SESSION['username']; ?>"
                     disabled="disabled"/></td>
        </tr><tr>
          <td><label for="email">E-mail:</label></td>
          <td><input type="text" name="email" id="email" size="20"
                     maxlength="50" value="<?php echo $email; ?>"/></td>
        </tr><tr>
          <td><label for="first_name">Jméno:</label></td>
          <td><input type="text" name="first_name" id="first_name" size="20"
                     maxlength="20" value="<?php echo $first_name; ?>"/></td>
        </tr><tr>
          <td><label for="last_name">Pøíjmení:</label></td>
          <td><input type="text" name="last_name" id="last_name" size="20"
                     maxlength="20" value="<?php echo $last_name; ?>"/></td>
        </tr><tr>
          <td><label for="city">Mìsto:</label></td>
          <td><input type="text" name="city" id="city" size="20" maxlength="20"
                     value="<?php echo $city; ?>"/></td>
        </tr><tr>
          <td><label for="state">Zemì:</label></td>
          <td><input type="text" name="state" id="state" size="2" maxlength="2"
                     value="<?php echo $state; ?>"/></td>
        </tr><tr>
          <td><label for="hobbies">Zájmy:</label></td>
          <td><select name="hobbies[]" id="hobbies" multiple="multiple">
              <?php
              foreach ($hobbies_list as $hobby)
              {
                if (in_array($hobby, $hobbies)) {
                  echo '<option value="' . $hobby . '" selected="selected">' .
                    $hobby . '</option>';
                } else {
                  echo '<option value="' . $hobby . '">' . $hobby . '</option>';
                }
              }
              ?>
          </select></td>
        </tr><tr>
          <td> </td>
          <td>
          <input type="hidden" name="user_id" value="<?php echo $user_id;?>"/>
          <input type="submit" name="submit" value="Upravit"/>
          <input type="button" id="cancel" value="Storno"/>
        </tr>
      </table>
    </form>
  </body>
</html>
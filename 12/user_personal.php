<?php
include 'auth.inc.php';
include 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
?>
<html>
  <head>
    <title>Osobní údaje</title>
  </head>
  <body>
    <h1>Vítejte na svých osobních stránkách.</h1>
    <p>Zde mùžete upravit své osobní údaje nebo vymazat svùj úèet.</p>
    <p>Na této stránce si mùžete prohlédnout, co jste o sobì uvedli.</p>
    <p><a href="main.php">Klepnìte sem</a> pro návrat na hlavní stránku.</p>
    <?php
    $query = 'SELECT
                  username, first_name, last_name, city, state, email, hobbies
              FROM
                  site_user u JOIN
                  site_user_info i ON u.user_id = i.user_id
              WHERE
                  username = "' .
                  mysql_real_escape_string($_SESSION['username'], $db) . '"';
    $result = mysql_query($query, $db) or die(mysql_error($db));

    $row = mysql_fetch_array($result);
    extract($row);
    mysql_free_result($result);
    mysql_close($db);
    ?>
    <ul>
      <li>Jméno: <?php echo $first_name; ?></li>
      <li>Pøíjmení: <?php echo $last_name; ?></li>
      <li>Mìsto: <?php echo $city; ?></li>
      <li>Zemì: <?php echo $state; ?></li>
      <li>E-mail: <?php echo $email; ?></li>
      <li>Zájmy: <?php echo $hobbies; ?></li>
    </ul>
    <p><a href="update_account.php">Upravit</a> |
    <a href="delete_account.php">Zrušit úèet</a></p>
  </body>
</html>
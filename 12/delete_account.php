<?php
include 'auth.inc.php';
include 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

if (isset($_POST['submit']) && $_POST['submit'] == 'Yes') {
  $query = 'DELETE i FROM
              site_user u JOIN site_user_info i ON u.user_id = i.user_id
            WHERE u.username="' .
  mysql_real_escape_string($_SESSION['username'], $db) . '"';
  mysql_query($query, $db) or die(mysql_error($db));

  $query = 'DELETE FROM site_user WHERE username="' .
  mysql_real_escape_string($_SESSION['username'], $db) . '"';
  mysql_query($query, $db) or die(mysql_error($db));

  $_SESSION['logged'] = null;
  $_SESSION['username'] = null;
  ?>
<html>
<head>
  <title>Odstranit uivatelskı úèet</title>
</head>
<body>
<p><strong>Vybranı uivatelskı úèet byl vymazán.</strong></p>
<p><a href="main.php">Klepnìte sem</a> a vrate se na hlavní stránku.</p>
</body>
</html>
<?php
mysql_close($db);
die();
} else {
?>
<html>
  <head>
    <title>Odstranit uivatelskı úèet</title>
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
    <p>Opravdu chcete odstranit vybranı uivatelskı úèet?</p>
    <p><strong>Potvrdíte-li operaci, nebude moné úèet obnovit!</strong></p>
    <form action="delete_account.php" method="post">
      <div>
        <input type="submit" name="submit" value="Ano"/>
        <input type="button" id="cancel" value="Ne" onclick="history.go(-1);"/>
      </div>
    </form>
  </body>
</html>
<?php
}
?>
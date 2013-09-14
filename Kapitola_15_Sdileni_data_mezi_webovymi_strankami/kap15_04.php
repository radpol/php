<?php
  session_start();
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  // Jestliže přijde jméno uživatele z formuláře, použij ho.
  if (isset($_POST['jmeno']))
    $_SESSION['jmeno'] = $_POST['jmeno'];

  // Jestliže není jméno uživatele v session, zobraz formulář.
  if (!isset($_SESSION['jmeno']))
  {
    echo '<form action="" method="post">';
    echo '<b>Napiš svoje jméno, prosím:</b>';
    echo '<input type="text" name="jmeno" size="20"><br />';
    echo '<input type="submit" value="Odešli jméno">';
    echo '</form>';
  }

  // Jestliže je jméno uživatele v session, zobraz ho.
  if (isset($_SESSION['jmeno']))
    echo '<b>Jmenuješ se ', $_SESSION['jmeno'], '</b>';
?>
</form>
</body>
</html>


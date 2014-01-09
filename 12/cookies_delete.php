<?php
// Platnost souborù cookie vypršela v minulosti.
$expire = time() - 1000;

setcookie('username', null, $expire);
setcookie('remember_me', null, $expire);

header('Refresh: 5; URL=cookies_test.php');
?>
<html>
  <head>
    <title>Test odstranìní souborù cookie</title>
  </head>
  <body>
    <h1>Mazání souborù cookie</h1>
    <p>Za 5 sekund budete pøesmìrováni na hlavní stránku.</p>
    <p>Nebudete-li pøesmìrováni automaticky,
    <a href="cookies_test.php">klepnìte sem</a>.</p>
  </body>
</html>
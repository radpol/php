<?php
// Platnost souborù cookie vyprší za 30 dní(vyjádøeno v sekundách)
$expire = time() + (60 * 60 * 24 * 30);

setcookie('username', 'testovaci_uzivatel', $expire);
setcookie('remember_me', 'ano', $expire);

header('Refresh: 5; URL=cookies_test.php');
?>
<html>
  <head>
    <title>Test nastavení souborù cookie</title>
  </head>
  <body>
    <h1>Nastavení souborù cookie</h1>
    <p>Za 5 sekund budete pøesmìrováni na hlavní stránku.</p>
    <p>Nebudete-li pøesmìrováni automaticky,
    <a href="cookies_test.php">klepnìte sem</a>.</p>
  </body>
</html>
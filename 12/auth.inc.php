<?php
// Zahájení nebo pokraèování relace.
session_start();

if (!isset($_SESSION['logged'])) {
    header('Refresh: 5; URL=login.php?redirect=' . $_SERVER['PHP_SELF']);
  echo '<p>Za 5 sekund budete pøesmìrováni na pøihlašovací stránku.</p>' .
    '<p>Nebudete-li pøesmìrováni automaticky, ' .
    '<a href="login.php?redirect=' . $_SERVER['PHP_SELF'] .
    '">klepnìte sem</a>.</p>';
    die();
}
?>
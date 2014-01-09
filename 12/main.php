<?php
session_start();
?>
<html>
  <head>
    <title>Stránka registrovaného uživatele</title>
  </head>
  <body>
    <h1>Vítejte na domovské stránce!</h1>
    <?php
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1) {
      ?>
      <p>Pøihlášený uživatel: <b><?php
      echo $_SESSION['username'];?>.</b></p>
      <p>Nyní mùžete <a href="user_personal.php">klepnout sem</a> a upravit své
      osobní pøedvolby podle vlastního uvážení.</p>
      <?php
      if (isset($_SESSION['admin_level']) && $_SESSION['admin_level'] > 0) {
        echo '<p><a href="admin_area.php">Zde</a> najdete ' .
          'nástoje pro správu.</p>';
      }
    } else {
      ?>
      <p>Momentálnì nejste pøihlášeni do systému. Po pøihlášeni budete
      mít pøístup k osobnímu nastavení a ke stránkám pro správu.</p>
      <p>Pokud jste již registrováni, pøihlaste se <a href="login.php">zde</a>.
        Chcete-li vytvoøit nový uživatelský úèet, registrujte se
        <a href="register.php">zde</a>.</p>
      <?php
    }
  ?>
  </body>
</html>
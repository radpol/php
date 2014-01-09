<html>
  <head>
    <title>Testovací stránka pro náhled souborù cookie</title>
  </head>
  <body>
    <h1>Tyto soubory cookie byly nastaveny</h1>
    <?php
    if (!empty($_COOKIE)) {
      echo '<pre>';
      print_r($_COOKIE);
      echo '</pre>';
    } else {
      echo '<p>Nejsou nastaveny žádné soubory cookie.</p>';
    }
    ?>
    <p><a href="cookies_test.php">Zpìt na hlavní stránku</a></p>
  </body>
</html>
<?php
  session_start();

  // ovìø, zda je uživatel pøihlášen pomocí platného hesla.
  if ($_SESSION['authuser'] != 1) {
    echo "Bohužel nemáte dostateèná oprávnìní k prohlížení této stránky!";
    exit();
  }
?>
<html>
  <head>
    <title>Filmový web – <?php echo $_REQUEST[ 'oblfilm' ]; ?></title>
  </head>
  <body>
    <?php
      echo 'Vítejte na našem webu. ';
      echo 'Pøihlášený uživatel: '. $_SESSION[ 'username' ];
      echo '<br />';
      echo 'Mým oblíbeným filmem je ';
      echo $_REQUEST[ 'oblfilm' ];
      echo ' .<br />';
      $hodnocení = 5;
      echo 'Tento film hodnotím známkou: ';
      echo $hodnocení;
    ?>
  </body>
</html>

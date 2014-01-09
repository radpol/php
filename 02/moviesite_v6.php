<?php
session_start();

// ovìø, zda je uživatel pøihlášen pomocí platného hesla.
if ( $_SESSION['authuser'] != 1 ) {
  echo "Bohužel nemáte dostateèná oprávnìní k prohlížení této stránky!";
  exit();
}
?>

<html>
  <head>
    <title>
      <?php
      if (isset($_GET['oblfilm'])) {
        echo ' - ';
        echo $_GET['oblfilm'];
      }
      ?>
    </title>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <?php
    $oblfilmy = array( 'Život Briana',
                       'Pianista',
                       'Král rybáø',
                       'Svatý grál',
                       'Matrix',
                       'Terminátor 2',
                       'Hvìzdné války',
                       'Blízká setkání tøetího druhu',
                       'Šestnáct svícnù',
                       'Pán Prstenù: Spoleèenstvo prstenu');

    if (isset( $_GET['oblfilm'])) {
      echo 'Vítejte na našem webu . ';
      echo 'Pøihlášený uživatel: ' . $_SESSION[ 'username' ];
      echo '<br/>';
      echo 'Mým oblíbeným filmem je ';
      echo $_REQUESTGET[ 'oblfilm' ];
      echo ' .<br/>';
      $hodnocení = 5;
      echo 'Tento film hodnotím známkou: ';
      echo $hodnocení;
    } else {
      echo 'Mých ' . $_POST['pocet'] . ' nejoblíbenìjších filmù';

      if (isset( $_POST['seradit'])) {
        sort($oblfilmy);
        echo ' (seøazených podle abecedy) ';
      }
      echo ': <br />';

      $cfilmu = 0;
      echo '<ol>';
      while ($cfilmu < $_POST['pocet']) {
        echo '<li>';
        echo $oblfilmy[$cfilmu];
        echo '</li>';
        $cfilmu = $cfilmu + 1;
      }
      echo '</ol>';
    }
    ?>
  </body>
</html>

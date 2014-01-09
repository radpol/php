<html>
  <head>
    <title>Máme pøestupný rok?</title>
  </head>
  <body>
    <?php
    date_default_timezone_set('Europe/Prague');
    $pøestupnýrok = date('L');
    if ($pøestupnýrok == 1) {
      echo 'Hurá! Letos je pøestupný rok!';
    }
    else {
      echo 'Litujeme, letos není pøestupný rok.';
    }
    ?>
  </body>
</html>

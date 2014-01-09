<html>
  <head>
    <title>Najít oblíbený film!</title>
  </head>
  <body>
    <?php
      // pøidejte následující øádek
      $oblíbenýfilm = urlencode('Život Briana');

      // upravte následující øádek
      echo "<a href=\"moviesite.php?oblfilm=$oblíbenýfilm\">";
      echo 'Další informace o mém oblíbeném filmu!';
      echo '</a>';
    ?>
  </body>
</html>

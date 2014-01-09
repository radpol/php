<?php
  session_start();
  $_SESSION['username'] = "Petr12345";
  $_SESSION['authuser'] = 1;
?>
<html>
  <head>
    <title>Najít oblíbený film!</title>
  </head>
  <body>
    <?php
      $oblíbenýfilm = urlencode( 'Život Briana' );
      echo "<a href=\"moviesite.php?oblfilm=$oblíbenýfilm\">";
      echo 'Další informace o mém oblíbeném filmu!';
      echo '</a>';
    ?>
  </body>
</html>

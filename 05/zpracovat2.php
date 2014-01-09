<html>
  <head>
    <title>Pozemské pozdravy</title>
  </head>
  <body>
    <?php
    echo '<h1>' . $_POST['pozdrav'] . ', ' . $_POST['jmeno'] . '!</h1>';

    if (isset($_POST['debug'])) {
      echo '<pre><strong>DEBUG:</strong>' . "\n";
      print_r($_POST);
      echo '</pre>';
    }
    ?>
  </body>
</html>
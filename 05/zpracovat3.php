<?php
if ($_POST['type'] == 'movie' && $_POST['movie_type'] == '') {
  header('Location: form3.php');
}
?>
<html>
  <head>
    <title><?php 
      echo $_POST['submit'] . ' ';
      if ($_POST['type'] == "movie")
      {
        echo "film";
      }
      else
      {
        echo ($_POST['type'] == 'actor') ? 'herce' : 'režiséra';
      }
      echo ': ' . $_POST['name']; ?></title>
  </head>
  <body>
    <?php
    if (isset($_POST['debug'])) {
      echo '<pre>';
      print_r($_POST);
      echo '</pre>';
    }

    $name = ucfirst($_POST['name']);
    if ($_POST['type'] == 'movie')
    {
      $foo = $_POST['movie_type'] . ' film';
    } else {
      $foo = ($_POST['type'] == "actor") ? "herce" : "režiséra";
    }

    echo '<p>Pokoušíte se ';
    echo ($_POST['submit'] == 'Vyhledat') ? 'vyhledat ' : 'pøidat ';
    echo $foo . " " . $name . '</p>';
    ?>
  </body>
</html>
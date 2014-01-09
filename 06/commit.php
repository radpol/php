<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));
?>
<html>
  <head>
    <title>Potvrzení transakce</title>
  </head>
  <body>
    <?php
    switch ($_GET['action']) {
      case 'pøidat':
        switch ($_GET['type']) {
          case 'movie':
            $query = 'INSERT INTO
                movie
                    (movie_name, movie_year, movie_type, movie_leadactor,
                    movie_director)
                VALUES
                    ("' . $_POST['movie_name'] . '",
                     ' . $_POST['movie_year'] . ',
                     ' . $_POST['movie_type'] . ',
                     ' . $_POST['movie_leadactor'] . ',
                     ' . $_POST['movie_director'] . ')';
            break;
      }
      break;
    case 'upravit':
    switch ($_GET['type']) {
      case 'movie':
        $query = 'UPDATE movie SET
                    movie_name = "' . $_POST['movie_name'] . '",
                    movie_year = ' . $_POST['movie_year'] . ',
                    movie_type = ' . $_POST['movie_type'] . ',
                    movie_leadactor = ' . $_POST['movie_leadactor'] . ',
                    movie_director = ' . $_POST['movie_director'] . '
                WHERE
                    movie_id = ' . $_POST['movie_id'];
        break;
    }
    break;
    }

    if (isset($query)) {
    $result = mysql_query($query, $db) or die(mysql_error($db));
    }
    ?>
    <p>Hotovo!</p>
  </body>
</html>
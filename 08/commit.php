<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se p¯ipojit. Zkontrolujte prosÌm p¯ipojenÌ k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));
// Odstranit n·sledujÌcÌ ¯·dky.
?>
<html>
<head>
  <title>PotvrzenÌ transakce</title>
</head>
<body>
<?php
// Konec odstranÏnÌ ¯·dk˘.
switch ($_GET['action']) {
  case 'p¯idat':
    switch ($_GET['type']) {
      case 'movie':
        $error = array();
        $movie_name = isset($_POST['movie_name']) ?
          trim($_POST['movie_name']) : '';
        if (empty($movie_name)) {
          $error[] = urlencode('UveÔte prosÌm n·zev filmu.');
        }
        $movie_type = isset($_POST['movie_type']) ?
          trim($_POST['movie_type']) : '';
        if (empty($movie_type)) {
          $error[] = urlencode('UveÔte prosÌm filmov˝ û·nr.');
        }
        $movie_year = isset($_POST['movie_year']) ?
          trim($_POST['movie_year']) : '';
        if (empty($movie_year)) {
          $error[] = urlencode('UveÔte prosÌm rok uvedenÌ filmu do kin.');
        }
        $movie_leadactor = isset($_POST['movie_leadactor']) ?
          trim($_POST['movie_leadactor']) : '';
        if (empty($movie_leadactor)) {
          $error[] = urlencode('UveÔte prosÌm jmÈno herce v hlavnÌ roli.');
        }
        $movie_director = isset($_POST['movie_director']) ?
          trim($_POST['movie_director']) : '';
        if (empty($movie_director)) {
          $error[] = urlencode('UveÔte prosÌm jmÈno reûisÈra.');
        }
        $movie_release = isset($_POST['movie_release']) ?
          trim($_POST['movie_release']) : '';
        if (!preg_match('|^\d{2}-\d{2}-\d{4}$|', $movie_release)) {
          $error[] = urlencode('Datum musÌ b˝t ve form·tu dd-mm-yyyy.');
        } else {
          list($day, $month, $year) = explode('-', $movie_release);
          if (!checkdate($month, $day, $year)) {
            $error[] = urlencode('Zadejte prosÌm platnÈ datum.');
          } else {
            $movie_release = mktime(0, 0, 0, $month, $day, $year);
          }
        }
        if (empty($error)) {
          $query = 'INSERT INTO
                    movie
                      (movie_name, movie_year, movie_type, movie_leadactor,
                      movie_director, movie_release, movie_rating)
                    VALUES
                      ("' . $movie_name . '",
                       ' . $movie_year . ',
                       ' . $movie_type . ',
                       ' . $movie_leadactor . ',
                       ' . $movie_director . ')';
        } else {
          header('Location:movie.php?action=p¯idat' .
              '&error=' . join($error, urlencode('<br/>')));
        }
        // OdstraÚte n·sledujÌcÌ ¯·dky.
        $query = 'INSERT INTO
                  movie (movie_name, movie_year, movie_type, movie_leadactor,
                    movie_director)
                  VALUES
                    ("' . $_POST['movie_name'] . '",
                    ' . $_POST['movie_year'] . ',
                    ' . $_POST['movie_type'] . ',
                    ' . $_POST['movie_leadactor'] . ',
                    ' . $_POST['movie_director'] . ')';
        // Konec odstranÏnÌ ¯·dk˘.
        break;
    }
    break;
  case 'upravit':
    switch ($_GET['type']) {
      case 'movie':
        $error = array();
        $movie_name = isset($_POST['movie_name']) ?
          trim($_POST['movie_name']) : '';
        if (empty($movie_name)) {
          $error[] = urlencode('UveÔte prosÌm n·zev filmu.');
        }
        $movie_type = isset($_POST['movie_type']) ?
          trim($_POST['movie_type']) : '';
        if (empty($movie_type)) {
          $error[] = urlencode('UveÔte prosÌm filmov˝ û·nr.');
        }
        $movie_year = isset($_POST['movie_year']) ?
          trim($_POST['movie_year']) : '';
        if (empty($movie_year)) {
          $error[] = urlencode('UveÔte prosÌm rok uvedenÌ filmu do kin.');
        }
        $movie_leadactor = isset($_POST['movie_leadactor']) ?
          trim($_POST['movie_leadactor']) : '';
        if (empty($movie_leadactor)) {
          $error[] = urlencode('UveÔte prosÌm jmÈno herce v hlavnÌ roli.');
        }
        $movie_director = isset($_POST['movie_director']) ?
          trim($_POST['movie_director']) : '';
        if (empty($movie_director)) {
          $error[] = urlencode('UveÔte prosÌm jmÈno reûisÈra.');
        }
        $movie_release = isset($_POST['movie_release']) ?
          trim($_POST['movie_release']) : '';
        if (!preg_match('|^\d{2}-\d{2}-\d{4}$|', $movie_release)) {
          $error[] = urlencode('Datum musÌ b˝t ve form·tu dd-mm-yyyy.');
        } else {
          list($day, $month, $year) = explode('-', $movie_release);
          if (!checkdate($month, $day, $year)) {
            $error[] = urlencode('Zadejte prosÌm platnÈ datum.');
          } else {
            $movie_release = mktime(0, 0, 0, $month, $day, $year);
          }
        }
        $movie_rating = isset($_POST['movie_rating']) ?
          trim($_POST['movie_rating']) : '';
        if (!is_numeric($movie_rating)) {
          $error[] = urlencode('Ohodnoùte film ËÌselnou hodnotou.');
        } else if ($movie_rating < 0 || $movie_rating > 10) {
          $error[] = urlencode('Zadejte ËÌslo od 0 do 10.');
        }
        if (empty($error)) {
          $query = 'UPDATE
                      movie
                    SET
                      movie_name = "' . $movie_name . '",
                      movie_year = ' . $movie_year . ',
                      movie_type = ' . $movie_type . ',
                      movie_leadactor = ' . $movie_leadactor . ',
                      movie_director = ' . $movie_director . ',
                    WHERE
                      movie_id = ' . $_POST['movie_id'];
        } else {
          header('Location:movie.php?action=upravit&id=' . $_POST['movie_id'] .
              '&error=' . join($error, urlencode('<br/>')));
        }
        // OdstraÚte n·sledujÌcÌ ¯·dky.
        $query = 'UPDATE
                    movie
                  SET
                    movie_name = "' . $_POST['movie_name'] . '",
                    movie_year = ' . $_POST['movie_year'] . ',
                    movie_type = ' . $_POST['movie_type'] . ',
                    movie_leadactor = ' . $_POST['movie_leadactor'] . ',
                    movie_director = ' . $_POST['movie_director'] . '
                  WHERE
                    movie_id = ' . $_POST['movie_id'];
        // Konec odstranÏnÌ ¯·dk˘.

        break;
    }
    break;
}

if (isset($query)) {
  $result = mysql_query($query, $db) or die(mysql_error($db));
}
?>
<html>
  <head>
    <title>PotvrzenÌ transakce</title>
  </head>
  <body>
    <p>Hotovo!</p>
  </body>
</html>
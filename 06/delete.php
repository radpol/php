<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

if (!isset($_GET['do']) || $_GET['do'] != 1) {
  switch ($_GET['type']) {
    case 'movie':
      echo 'Skuteènì chcete odstranit tento film?<br/>';
      break;
    case 'people':
      echo 'Skuteènì chcete vymazat tuto osobu?<br/>';
      break;
  }
  echo '<a href="' . $_SERVER['REQUEST_URI'] . '&do=1">ano</a> ';
  echo 'nebo <a href="admin.php">ne</a>';
} else {
  switch ($_GET['type']) {
    case 'people':
      $query = 'UPDATE movie SET
                    movie_leadactor = 0
                WHERE
                    movie_leadactor = ' . $_GET['id'];
      $result = mysql_query($query, $db) or die(mysql_error($db));

      $query = 'DELETE FROM people
                WHERE
                    people_id = ' . $_GET['id'];
      $result = mysql_query($query, $db) or die(mysql_error($db));
      ?>
      <p style="text-align: center;">Vybraná osoba byla vymazána.
      <a href="admin.php">Návrat na seznam</a></p>
      <?php
      break;
    case 'movie':
      $query = 'DELETE FROM movie
                WHERE
                  movie_id = ' . $_GET['id'];
      $result = mysql_query($query, $db) or die(mysql_error($db));
      ?>
      <p style="text-align: center;">Vybraný film byl vymazán.
      <a href="admin.php">Návrat na seznam</a></p>
      <?php
      break;
  }
}
?>
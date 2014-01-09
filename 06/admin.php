<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));
?>
<html>
  <head>
    <title>Databáze filmového klubu</title>
    <style type="text/css">
      th { background-color: #999;}
      .odd_row { background-color: #EEE; }
      .even_row { background-color: #FFF; }
    </style>
  </head>
  <body>
    <table style="width:100%;">
      <tr>
        <th colspan="2">Filmy <a href="movie.php?action=pøidat">[PØIDAT]</a></th>
      </tr>
      <?php
      $query = 'SELECT * FROM movie';
      $result = mysql_query($query, $db) or die (mysql_error($db));

      $odd = true;
      while ($row = mysql_fetch_assoc($result)) {
        echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
        $odd = !$odd;
        echo '<td style="width:75%;">';
        echo $row['movie_name'];
        echo '</td><td>';
        echo ' <a href="movie.php?action=upravit&id=' . $row['movie_id'] .
             '"> [UPRAVIT]</a>';
        echo ' <a href="delete.php?type=movie&id=' . $row['movie_id'] .
             '"> [ODSTRANIT]</a>';
        echo '</td></tr>';
      }
      ?>
      <tr>
        <th colspan="2">Osoby <a href="people.php?action=pøidat">
          [PØIDAT]</a></th>
      </tr>
      <?php
      $query = 'SELECT * FROM people';
      $result = mysql_query($query, $db) or die (mysql_error($db));

      $odd = true;
      while ($row = mysql_fetch_assoc($result)) {
        echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
        $odd = !$odd;
        echo '<td style="width: 25%;">';
        echo $row['people_fullname'];
        echo '</td><td>';
        echo ' <a href="people.php?action=upravit&id=' . $row['people_id'] .
             '"> [UPRAVIT]</a>';
        echo ' <a href="delete.php?type=people&id=' . $row['people_id'] .
             '"> [ODSTRANIT]</a>';
        echo '</td></tr>';
      }
      ?>
    </table>
  </body>
</html>
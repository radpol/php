<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo')
   or die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// vyber název a žánr filmù vyrobených od roku 1990
$dotaz = 'SELECT movie_name, movietype_label 
          FROM movie 
            LEFT JOIN movietype ON movie_type = movietype_id
          WHERE movie.movie_year > 1990 
          ORDER BY movie_type';
$výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));

// zobraz výsledky
echo '<table border="1">';
while ($øádek = mysql_fetch_assoc($výsledky)) {
  echo '<tr>';
  foreach($øádek as $hodnota) {
    echo ' <td> ' . $hodnota . ' </td> ';
  }
  echo '</tr>';
}
echo '</table>';
?>

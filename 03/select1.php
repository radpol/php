<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo')
   or die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// vyber název a žánr filmù vyrobených od roku 1990
$dotaz = 'SELECT movie_name, movie_type 
         FROM movie 
         WHERE movie_year > 1990 
         ORDER BY movie_type';
$výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));

// zobraz výsledky
while ($øádek = mysql_fetch_array($výsledky)) {
  foreach ($øádek as $hodnota) {
    echo $hodnota . ' ';
  }
  echo '<br/>';
}
?>

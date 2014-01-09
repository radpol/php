<?php
// Pøipojte se k MySQL.
$db = mysql_connect('localhost', 'uzivatel', 'heslo')
   or die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

// Nastavte novou databázi jako pracovní databázi
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Nyní vložte data do tabulky "movie" .
$dotaz = 'INSERT INTO movie (movie_id, movie_name, movie_type, 
          movie_year, movie_leadactor, movie_director) 
          VALUES 
            (1, "Božský Bruce", 5, 2003, 1, 2 ), 
            (2, "Maléry pana Šikuly", 5, 1999, 5, 6 ), 
            (3, "Grand Canyon", 2, 1991, 4, 3 )';
$výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));

// Nová data do tabulky "movietype" .
$dotaz = 'INSERT INTO movietype (movietype_id, movietype_label) 
        VALUES 
          (1, "Sci Fi"), 
          (2, "Drama"), 
          (3, "Dobrodružný"), 
          (4, "Váleèný"), 
          (5, "Komedie"), 
          (6, "Horror"), 
          (7, "Akèní"), 
          (8, "Dìtský")';
$výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));

// Nová data do tabulky "people" .
$dotaz = 'INSERT INTO people (people_id, people_fullname, 
          people_isactor, people_isdirector) 
          VALUES 
           (1, "Jim Carrey", 1, 0 ), 
           (2, "Tom Shadyac", 0, 1 ), 
           (3, "Lawrence Kasdan", 0, 1 ), 
           (4, "Kevin Kline", 1, 0 ), 
           (5, "Ron Livingston", 1, 0 ), 
           (6, "Mike Judge", 0, 1 )';
$výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));

echo 'Vložení dat probìhlo úspìšnì!';
?>

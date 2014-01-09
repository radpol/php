<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));
                   
// uprav tabulku movie tak, aby obsahovala navíc délku, 
// náklady a výnosy filmu
$dotaz = 'ALTER TABLE movie ADD COLUMN (
  movie_running_time TINYINT UNSIGNED NULL,
  movie_cost         DECIMAL(4,1)     NULL,
  movie_takings      DECIMAL(4,1)     NULL)';
mysql_query($dotaz, $db) or die (mysql_error($db));
                   
// vlož nová data pro každý film do tabulky movie
$dotaz = 'UPDATE movie 
           SET movie_running_time = 101,
               movie_cost = 81,
               movie_takings = 242.6
           WHERE
               movie_id = 1';
mysql_query($dotaz, $db) or die(mysql_error($db));
                   
$dotaz = 'UPDATE movie 
           SET movie_running_time = 89,
               movie_cost = 10,
               movie_takings = 10.8
           WHERE
               movie_id = 2';
mysql_query($dotaz, $db) or die(mysql_error($db));
                   
$dotaz = 'UPDATE movie 
           SET movie_running_time = 134,
               movie_cost = NULL,
               movie_takings = 33.2
           WHERE
               movie_id = 3';
mysql_query($dotaz, $db) or die(mysql_error($db));
                   
echo 'Databáze filmù byla úspìšnì aktualizována!';
?>

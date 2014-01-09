<?php
// Pøipojte se k MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

//Pokud hlavní databáze neexistuje, vytvoøte ji.
$dotaz = 'CREATE DATABASE IF NOT EXISTS moviesite';
mysql_query($dotaz, $db) or die(mysql_error($db));

//Nastavte novou databázi jako pracovní databázi
mysql_select_db('moviesite', $db) or die(mysql_error($db));

//Vytvoøte tabulku "movie" .
$dotaz = 'CREATE TABLE movie (
    movie_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    movie_name VARCHAR(255) NOT NULL,
    movie_type TINYINT NOT NULL DEFAULT 0,
    movie_year SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    movie_leadactor INTEGER UNSIGNED NOT NULL DEFAULT 0,
    movie_director INTEGER UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (movie_id),
    KEY movie_type (movie_type, movie_year)
  )
  ENGINE=MyISAM';
mysql_query($dotaz, $db) or die (mysql_error($db));

//Vytvoøte tabulku "movietype" 
$dotaz = 'CREATE TABLE movietype (
    movietype_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    movietype_label VARCHAR(100) NOT NULL,
    PRIMARY KEY (movietype_id)
  )
  ENGINE=MyISAM';
mysql_query($dotaz, $db) or die(mysql_error($db));

//Vytvoøte tabulku "people" 
$dotaz = 'CREATE TABLE people (
    people_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    people_fullname VARCHAR(255) NOT NULL,
    people_isactor TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
    people_isdirector TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (people_id)
  )
  ENGINE=MyISAM';
mysql_query($dotaz, $db) or die(mysql_error($db));

echo 'Databáze filmù byla úspìšnì vytvoøena!!';
?>
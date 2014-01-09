<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Upravte tabulku movie, abyste do ní mohli ukládat hodnocení
// a datum uvedení do kin.
$query = 'ALTER TABLE movie ADD COLUMN (
    movie_release INTEGER UNSIGNED DEFAULT 0,
    movie_rating  TINYINT UNSIGNED DEFAULT 5)';
mysql_query($query, $db) or die(mysql_error($db));

echo 'Tabulka filmù byla úspìšnì aktualizována!';
?>
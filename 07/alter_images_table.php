<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Úprava struktury tabulky "images".
$query = 'ALTER TABLE images DROP COLUMN image_filename';

mysql_query($query, $db) or die (mysql_error($db));

echo 'Tabulka obrázkù byla úspìšnì aktualizována.';
?>
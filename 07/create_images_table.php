<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Vytvoøte tabulku obrázkù
$query = 'CREATE TABLE images (
        image_id       INTEGER      NOT NULL AUTO_INCREMENT,
        image_caption  VARCHAR(255) NOT NULL,
        image_username VARCHAR(255) NOT NULL,
        image_filename VARCHAR(255) NOT NULL DEFAULT "",
        image_date     DATE         NOT NULL,
        PRIMARY KEY (image_id)
    )
    ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

echo 'Tabulka obrázkù byla úspìšnì vytvoøena.';
?>
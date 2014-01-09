<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se pшipojit. Zkontrolujte prosнm pшipojenн k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

// Vytvoшte tabulku uћivatelщ.
$query = 'CREATE TABLE IF NOT EXISTS site_user (
            user_id     INTEGER     NOT NULL AUTO_INCREMENT,
            username    VARCHAR(20) NOT NULL,
            password    CHAR(41)    NOT NULL,

            PRIMARY KEY (user_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// Vytvoшte tabulku informacн o uћivatelнch.
$query = 'CREATE TABLE IF NOT EXISTS site_user_info (
            user_id     INTEGER     NOT NULL,
            first_name  VARCHAR(20) NOT NULL,
            last_name   VARCHAR(20) NOT NULL,
            email       VARCHAR(50) NOT NULL,
            city        VARCHAR(20),
            state       CHAR(2),
            hobbies     VARCHAR(255),

            FOREIGN KEY (user_id) REFERENCES site_user(user_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// Naplтte tabulku uћivatelщ.
$query = 'INSERT IGNORE INTO site_user
            (user_id, username, password)
          VALUES
            (1, "jan", PASSWORD("tajnй")),
            (2, "jana", PASSWORD("heslo"))';
mysql_query($query, $db) or die (mysql_error($db));

// Naplтte tabulku doplтujнcнch informacн o uћivatelнch.
$query = 'INSERT IGNORE INTO site_user_info
            (user_id, first_name, last_name, email, city, state, hobbies)
          VALUES
            (1, "Jan", "Novбk", "jan@priklad.cz", NULL, NULL, NULL),
            (2, "Jana", "Novбkovб", "jana@priklad.cz", NULL, NULL, NULL)';
mysql_query($query, $db) or die (mysql_error($db));

echo 'Pшнkaz ъspмљnм vykonбn!';
?>
<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$query = 'CREATE TABLE IF NOT EXISTS ml_lists (
              ml_id    INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
              listname VARCHAR(100)     NOT NULL,

              PRIMARY KEY (ml_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));

$query = 'CREATE TABLE IF NOT EXISTS ml_users (
              user_id    INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
              first_name VARCHAR(20)      NOT NULL,
              last_name  VARCHAR(20)      NOT NULL,
              email      VARCHAR(100)     NOT NULL,

              PRIMARY KEY (user_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));

$query = 'CREATE TABLE IF NOT EXISTS ml_subscriptions (
              ml_id   INTEGER UNSIGNED NOT NULL,
              user_id INTEGER UNSIGNED NOT NULL,
              pending BOOLEAN          NOT NULL DEFAULT TRUE,

              PRIMARY KEY (ml_id, user_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die(mysql_error($db));

echo 'Hotovo';
?> 
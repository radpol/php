<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

// Vytvoøte tabulku potvrzení.
$query = 'CREATE TABLE IF NOT EXISTS pc_confirmation (
            email_id    INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            token       CHAR(32)         NOT NULL,
            to_email    VARCHAR(100)     NOT NULL,
            to_name     VARCHAR(50)      NOT NULL,
            from_name   VARCHAR(100)     NOT NULL,
            from_email  VARCHAR(50)      NOT NULL,
            subject     VARCHAR(255)     NOT NULL,
            postcard    VARCHAR(255)     NOT NULL,
            message     TEXT,

            PRIMARY KEY (email_id)
          )
          ENGINE=MyISAM';
      mysql_query($query, $db) or die (mysql_error($db));

echo 'Operace probìhla úspìšnì!';
?>
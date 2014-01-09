<?php
require 'db.inc.php';

date_default_timezone_set('Europe/Prague');

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$sql = 'CREATE TABLE IF NOT EXISTS frm_access_levels (
            access_lvl   TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
            access_name  VARCHAR(50)      NOT NULL,

            PRIMARY KEY (access_lvl)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT IGNORE INTO frm_access_levels
            (access_lvl, access_name)
        VALUES
            (1, "Uživatel"),
            (2, "Moderátor"),
            (3, "Správce")';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'CREATE TABLE IF NOT EXISTS frm_admin (
            id       INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            title    VARCHAR(100)     NOT NULL DEFAULT "",
            value    VARCHAR(255)     NOT NULL DEFAULT "",
            constant VARCHAR(100)     NOT NULL DEFAULT "",

            PRIMARY KEY (id)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT IGNORE INTO frm_admin
            (id, title, value, constant)
        VALUES
            (NULL, "Nadpis stránek", "Fóra pro fanoušky komiksù", "title"),
            (NULL, "Popis serveru", "Místo, kde mùžete diskutovat o svých ' .
            'oblíbených komiksech, filmech apod.", "description"),
            (NULL, "Napište správci", "admin@priklad.cz", "admin_email"),
            (NULL, "Autorská práva", "&copy; Web pro fanoušky komiksù. ' .
            'Všechna práva vyhrazena.", "copyright"),
            (NULL, "Záhlaví stránek", "Fóra pro fanoušky komiksù", "titlebar"),
            (NULL, "Limit stránkování", "10", "pageLimit"),
            (NULL, "Rozsah stránek", "7", "pageRange")';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'CREATE TABLE IF NOT EXISTS frm_bbcode (
            id          INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            template    VARCHAR(255)     NOT NULL DEFAULT "",
            replacement VARCHAR(255)     NOT NULL DEFAULT "",

            PRIMARY KEY (id)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));


$sql = 'CREATE TABLE IF NOT EXISTS frm_forum (
            id              INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            forum_name      VARCHAR(100)     NOT NULL DEFAULT "",
            forum_desc      VARCHAR(255)     NOT NULL DEFAULT "",
            forum_moderator INTEGER UNSIGNED NOT NULL DEFAULT 0,

            PRIMARY KEY (id)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT IGNORE INTO frm_forum
            (id, forum_name, forum_desc, forum_moderator)
        VALUES
            (NULL, "Nové fórum", "To je výchozí fórum vytvoøené pøi ' .
            'instalaci databáze. Po dokonèení instalace zmìòte ' .
            'jeho název a popis.", 1)';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'CREATE TABLE IF NOT EXISTS frm_post_count (
            user_id    INTEGER UNSIGNED NOT NULL DEFAULT 0,
            post_count INTEGER UNSIGNED NOT NULL DEFAULT 0,

            PRIMARY KEY (user_id)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT INTO frm_post_count VALUES (1, 1)';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'CREATE TABLE IF NOT EXISTS frm_posts (
            id           INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            topic_id     INTEGER UNSIGNED NOT NULL DEFAULT 0,
            forum_id     INTEGER UNSIGNED NOT NULL DEFAULT 0,
            author_id    INTEGER UNSIGNED NOT NULL DEFAULT 0,
            update_id    INTEGER UNSIGNED NOT NULL DEFAULT 0,
            date_posted  DATETIME         NOT NULL DEFAULT "0000-00-00 00:00:00",
            date_updated DATETIME,
            subject     VARCHAR(100)     NOT NULL DEFAULT "",
            body        MEDIUMTEXT,

            PRIMARY KEY (id),
            INDEX (forum_id, topic_id, author_id, date_posted),
            FULLTEXT INDEX (subject, body)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT IGNORE INTO frm_posts
            (id, topic_id, forum_id, author_id, update_id, date_posted,
            date_updated, subject, body)
        VALUES
            (1, 0, 1, 1, 0, "' . date('Y-m-d H:i:s') . '", 0, "Vítejte",
            "Vítejte na svém novém diskusním serveru. Po dokonèení instalace ' .
            'nezapomeòte zmìnit heslo správce. Bavte se dobøe!")';
mysql_query($sql, $db) or die(mysql_error($db));


$sql = 'CREATE TABLE IF NOT EXISTS frm_users (
            id          INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            email       VARCHAR(100)     NOT NULL UNIQUE,
            password    CHAR(41)         NOT NULL,
            name        VARCHAR(100)     NOT NULL,
            access_lvl  TINYINT UNSIGNED NOT NULL DEFAULT 1,
            signature   VARCHAR(255),
            date_joined DATETIME         NOT NULL,
            last_login  DATETIME,

            PRIMARY KEY (id)
        )
        ENGINE=MyISAM';
mysql_query($sql, $db) or die(mysql_error($db));

$sql = 'INSERT IGNORE INTO frm_users
            (id, name, email, password, access_lvl, signature,
            date_joined, last_login)
        VALUES
            (1, "Správce", "admin@priklad.cz", "heslo",
            3, "", "' . date('Y-m-d H:i:s') . '", NULL)';
mysql_query($sql, $db) or die(mysql_error($db));
?>

<html>
  <head>
    <title>Tabulky diskusního serveru byly vytvoøeny</title>
  </head>
  <body>
    <h1>Diskusní fóra pro fanoušky komiksù</h1>
    <p>Byly vytvoøeny následující tabulky:</p>
    <ul>
      <li>frm_admin</li>
      <li>frm_access_levels</li>
      <li>frm_admin</li>
      <li>frm_bbcode</li>
      <li>frm_form</li>
      <li>frm_post_count</li>
      <li>frm_posts</li>
      <li>frm_users</li>
    </ul>
    <p><a href="frm_login.php">Pøihlásit se</a> do systému.</p>
  </body>
</html>

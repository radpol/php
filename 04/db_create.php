<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
    die('Nemohu se pøipojit. Zkontrolujte pøipojovací parametry.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));
                   
// vytvoø tabulku reviews
$dotaz = 'CREATE TABLE reviews (
        review_movie_id INTEGER UNSIGNED NOT NULL, 
        review_date     DATE             NOT NULL, 
        reviewer_name   VARCHAR(255)     NOT NULL,
        review_comment  VARCHAR(8000)     NOT NULL,
        review_rating   TINYINT UNSIGNED NOT NULL  DEFAULT 0, 
                   
        KEY (review_movie_id)
    )
    ENGINE=MyISAM';
mysql_query($dotaz, $db) or die (mysql_error($db));
                   
// vlož nová data do tabulky reviews
$dotaz = <<<ENDSQL
  INSERT INTO reviews (review_movie_id, review_date, 
                       reviewer_name, review_comment,   
                       review_rating)
  VALUES 
    (1, "2008-09-23", "Marek Skála", 
        "Vìdìl jsem, že to bude dobrý. I když moje pøítelkynì 
         mì donutila, abych se na nìj podíval.", 4),
    (1, "2008-09-23", "Jakub Slonek", 
        "No nevím, Popelka se mi líbila víc.", 2),
    (1, "2008-09-28", "Páa", "Naprostá bomba!", 5),
    (2, "2008-09-23", "Marvin", 
        "Tak tohle je mùj oblíbený film. Moc jsem tomu nedával,
         ale nakonec jsme tenhle kousek zamyloval.", 5),
    (3, "2008-09-23", "Václav K.", 
        "Film se mi docela líbil, i když to nejdøíve vypadalo jako
         nepovedené video od agenta nìjaké cestovky.", 3)
ENDSQL;
mysql_query($dotaz, $db) or die(mysql_error($db));
                   
echo 'Databáze filmù byla úspìšnì aktualizována!';
?>

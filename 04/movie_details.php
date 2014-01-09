<?php
// funkce pro vygenerování hodnocení
function vygeneruj_hodnocení($rating) {
    $hodnocení_filmu = '';
    for ($i = 0; $i < $rating; $i++) {
        $hodnocení_filmu .= '<img src="star.gif" alt="star"/>';
    }
    return $hodnocení_filmu;
}

// vezme identifikátor režiséra a vrátí jeho celé jméno
function naèti_režiséra($id_režiséra) {                  
    global $db;
                   
    $dotaz = 'SELECT people_fullname 
               FROM people
               WHERE people_id = ' . $id_režiséra;
    $výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
    $øádek = mysql_fetch_assoc($výsledky);
    extract($øádek);
                   
    return $people_fullname;
}
                   
// vezme identifikátor hlavního aktéra a vrátí jeho celé jméno
function naèti_hlaktéra($id_hlaktéra) {                   
    global $db;
                   
    $dotaz = 'SELECT people_fullname
               FROM people 
               WHERE people_id = ' . $id_hlaktéra;
    $výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
    $øádek = mysql_fetch_assoc($výsledky);
    extract($øádek);
                   
    return $people_fullname;
}
                   
// vezme identifikátor žánru a vrátí jeho smysluplný textový popis
function naèti_žánr($id_žánru) {                  
    global $db;
                   
    $dotaz = 'SELECT movietype_label
               FROM movietype
               WHERE movietype_id = ' . $id_žánru;
    $výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
    $øádek = mysql_fetch_assoc($výsledky);
    extract($øádek);
                   
    return $movietype_label;
}
                  
// funkce pro výpoèet, zda film byl film ziskový, 
// ztrátový nebo zda zùstal na nule
function spoèítej_rozdíl($výnosy, $náklady) {                   
    $rozdíl = $výnosy - $náklady;
                   
    if ($rozdíl < 0) {     
        $barva = 'red';
        $rozdíl = abs($rozdíl) . ' mil. dolarù';
    } elseif ($rozdíl > 0) {
        $barva = 'green';
        $rozdíl = $rozdíl . ' mil. dolarù';
    } else {
        $barva = 'blue';
        $rozdíl = 'ùstal na nule';
    }
                   
    return '<span style="color:'.$barva.';">'.$rozdíl.'</span>';
}
                   
// pøipoj se k MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
    die('Nemohu se pøipojit. Zkontrolujte pøipojovací parametry.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));
                   
// naèti údaje
$dotaz = '
 SELECT movie_name, movie_year, movie_director, movie_leadactor,
        movie_type, movie_running_time, movie_cost, movie_takings
 FROM movie
 WHERE movie_id = ' . $_GET['movie_id'];
$výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
$øádek = mysql_fetch_assoc($výsledky);
$film_název         = $øádek['movie_name'];
$film_režisér       = naèti_režiséra($øádek['movie_director']);
$film_hlaketér      = naèti_hlaktéra($øádek['movie_leadactor']);
$film_rok           = $øádek['movie_year'];
$movie_running_time = $øádek['movie_running_time'] . ' minut';
$film_výnosy        = $øádek['movie_takings'] . ' mil. dolarù';
$film_náklady       = $øádek['movie_cost'] . ' mil. dolarù';
$film_bilance       = spoèítej_rozdíl($øádek['movie_takings'],
                          $øádek['movie_cost']);
                   
// zobraz informace
echo <<<ENDHTML
<html>
 <head>
  <title>Podrobné údaje o filmu: $film_název</title>
 </head>
 <body>
  <div style="text-align: center;">
   <h2>$film_název</h2>
   <h3><em>Podrobnosti</em></h3>
   <table cellpadding="2" cellspacing="2"
    style="width: 70%; margin-left: auto; margin-right: auto;">
    <tr>
     <td><strong>Název</strong></strong></td>
     <td>$film_název</td>
     <td><strong>Rok uvedení</strong></strong></td>
     <td>$film_rok</td>
    </tr><tr>
     <td><strong>Režie</strong></td>
     <td>$film_režisér</td>
     <td><strong>Náklady</strong></td>
     <td>$$film_náklady<td/>
    </tr><tr>
     <td><strong>V hlavní roli</strong></td>
     <td>$film_hlaketér</td>
     <td><strong>Výnosy</strong></td>
     <td>$$film_výnosy<td/>
    </tr><tr>
     <td><strong>Délka</strong></td>
     <td>$movie_running_time</td>
     <td><strong>Bilance</strong></td>
     <td>$film_bilance<td/>
    </tr>
   </table>
ENDHTML;

// naèti recenze pro tento film
$dotaz = '
  SELECT review_movie_id, review_date, reviewer_name, 
         review_comment,review_rating
   FROM reviews
   WHERE review_movie_id = ' . $_GET['movie_id'] . '
   ORDER BY review_date DESC';
                   
$výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
// zobraz recenze
echo <<< ENDHTML
   <h3><em>Recenze</em></h3>
   <table cellpadding="2" cellspacing="2"
    style="width: 90%; margin-left: auto; margin-right: auto;">
    <tr>
     <th style="width: 7em;">Datum</th>
     <th style="width: 10em;">Recenzent</th>
     <th>Komentáøe</th>
     <th style="width: 5em;">Hodnocení</th>
    </tr>
ENDHTML;
                   
while ($øádek = mysql_fetch_assoc($výsledky)) {
    $datum = $øádek['review_date'];
    $jméno = $øádek['reviewer_name'];
    $komentáø = $øádek['review_comment'];
    $hodnocení = vygeneruj_hodnocení($øádek['review_rating']);                  

    echo <<<ENDHTML
    <tr>
      <td style="vertical-align:top; text-align: center;">$datum</td>
      <td style="vertical-align:top;">$jméno</td>
      <td style="vertical-align:top;">$komentáø</td>
      <td style="vertical-align:top;">$hodnocení</td>
    </tr>
ENDHTML;
}
                   
echo <<<ENDHTML
  </div>
 </body>
</html>     
ENDHTML;
?>

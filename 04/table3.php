<?php
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

// pøipoj se k MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
    die('Nemohu se pøipojit. Zkontrolujte pøipojovací parametry.');
                   
// zajisti, abychom používali správnou databázi
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// naèti informace
$dotaz = 'SELECT movie_id, movie_name, movie_year, movie_director, 
                 movie_leadactor, movie_type
          FROM movie
          ORDER BY movie_name ASC,
                   movie_year DESC';
$výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
// zjisti poèet øádkù ve výsledku
$poèet_filmù = mysql_num_rows($výsledky);

$tabulka = <<<ENDHTML
<div style="text-align: center;">
  <h2>Databáze s recenzemi filmù</h2>
  <table border="1" cellpadding="2" cellspacing="2"
         style="width: 70%; margin-left: auto; margin-right: auto;">
    <tr>
      <th>Název filmu</th>
      <th>Rok uvedení na plátna kin</th>
      <th>Režisér</th>
      <th>V hlavní roli</th>
      <th>Kategorie</th>
    </tr>
ENDHTML;

// projdi výsledky
while ($øádek = mysql_fetch_assoc($výsledky)) {
  extract($øádek);
  $režisér = naèti_režiséra($movie_director);
  $hlaktér = naèti_hlaktéra($movie_leadactor);
  $žánr = naèti_žánr($movie_type);

  $tabulka .= <<<ENDHTML
  <tr>
    <td>
      <a href="movie_details.php?movie_id=$movie_id"
           title="Více informací o filmu $movie_name">
          $movie_name
      </a>
    </td>
    <td>$movie_year</td>
    <td>$režisér</td>
    <td>$hlaktér</td>
    <td>$žánr</td>
  </tr>
ENDHTML;
}     

$tabulka .= <<<ENDHTML
  </table>
  <p>Poèet filmù: $poèet_filmù</p>
</div>
ENDHTML;

echo $tabulka;
?>

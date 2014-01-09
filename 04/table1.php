<?php
// pøipoj se k MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
    die('Nemohu se pøipojit. Zkontrolujte pøipojovací parametry.');
                   
// zajisti, abychom používali správnou databázi
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// naèti informace
$dotaz = 'SELECT movie_name, movie_year, movie_director, 
                 movie_leadactor, movie_type
          FROM movie
          ORDER BY movie_name ASC,
                   movie_year DESC';
$výsledky = mysql_query($dotaz, $db) or die(mysql_error($db));
                   
// zjisti poèet øádkù ve výsledku
$poèet_filmù = mysql_num_rows($výsledky);
?>
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
    <?php
    // projdi výsledky
    while ($row = mysql_fetch_assoc($výsledky)) {
      extract($row);
      echo '<tr>';
      echo '<td>' . $movie_name . '</td>';
      echo '<td>' . $movie_year . '</td>';
      echo '<td>' . $movie_director . '</td>';
      echo '<td>' . $movie_leadactor . '</td>';
      echo '<td>' . $movie_type . '</td>';
      echo '</tr>';
    }     
    ?>
  </table>
  <p>Poèet filmù: <?php echo $poèet_filmù; ?></p>
</div>	

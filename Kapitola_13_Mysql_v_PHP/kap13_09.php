<?php 
 
// Pøipojení k databázi.
$db_spojeni = mysqli_connect
  ('localhost', 'root', 'lokomotiva', 'test', 3306);
 
// Otestování, zda se pøipojení podaøilo.
if (!$db_spojeni)
{
  echo 'Pøipojení se nepodaøilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_connect_error();
  exit();
}

// Správné nastavení èeštiny.
$objekt_vysledku = mysqli_query($db_spojeni, "SET NAMES 'cp1250'");
if (!$objekt_vysledku)
{
  echo 'Poslání SQL pøíkazu se nepodaøilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_error($db_spojeni);
  exit();
}

// Test, jestli pøišla data z formuláøe.
if (isset($_POST['zprava']))
{
  // Vytvoøení SQL pøíkazu typu INSERT.
  $sql_prikaz = 
    "INSERT INTO kniha_navstev(datum,jmeno,email,zapis) "
    ."VALUES(NOW(),'"
    .mysqli_real_escape_string($db_spojeni,$_POST['jmeno'])
    ."','"
    .mysqli_real_escape_string($db_spojeni,$_POST['email'])
    ."','"
    .mysqli_real_escape_string($db_spojeni,$_POST['zprava'])
    ."')"
    ;

  // Zaslání SQL pøíkazu do databáze.
  $objekt_vysledku = mysqli_query($db_spojeni, $sql_prikaz);
 
  if (!$objekt_vysledku)
  {
    echo 'Poslání SQL pøíkazu se nepodaøilo, sorry';
    echo '<br />';
    echo 'Popis chyby: ', mysqli_error($db_spojeni);
    exit();
  }
}

// Odpojení od databáze.
if ($db_spojeni)
  mysqli_close($db_spojeni);
?>
</body>
</html>


<html>
<head>
<title>Zaslání SQL příkazu do databáze</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php 
 
// Připojení k databázi.
$db_spojeni = mysqli_connect
  ('localhost', 'root', 'lokomotiva', 'test', 3306);
 
// Otestování, zda se připojení podařilo.
if ($db_spojeni)
  echo 'Připojení se podařilo';
else
{
  echo 'Připojení se nepodařilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_connect_error();
  exit();
}
 
// Zaslání SQL příkazu do databáze.
$objekt_vysledku = mysqli_query($db_spojeni, 'SELECT * FROM osoby');
 
if (!$objekt_vysledku)
{
  echo 'Poslání SQL příkazu se nepodařilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_error($db_spojeni);
  exit();
}
 
// Zobrazení všech vrácených dat.
echo '<pre>';
while ($radek = mysqli_fetch_array($objekt_vysledku))
  var_dump($radek);
echo '</pre>';
 
// Zavření objektu výsledku, protože už ho nebudeme používat.
mysqli_free_result($objekt_vysledku);
 
// Odpojení od databáze.
if ($db_spojeni)
  mysqli_close($db_spojeni);
 
?>
</body>
</html>


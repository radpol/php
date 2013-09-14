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
mysqli_query($db_spojeni, 'SELECT * FROM osoby');
echo 'Právě byl zaslán SQL příkaz do databáze';
 
// Odpojení od databáze.
if ($db_spojeni)
  mysqli_close($db_spojeni);
 
?>
</body>
</html>


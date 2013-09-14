<html>
<head>
<title>Kniha návštěv</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php 


// -- Připojení k databázi a správné nastavení češtiny --

// Připojení k databázi.
$db_spojeni = mysqli_connect
  ('localhost', 'root', 'lokomotiva', 'test', 3306);
 
// Otestování, zda se připojení podařilo.
if (!$db_spojeni)
{
  echo 'Připojení se nepodařilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_connect_error();
  exit();
}

// Správné nastavení češtiny.
$objekt_vysledku = mysqli_query($db_spojeni, "SET NAMES 'cp1250'");
if (!$objekt_vysledku)
{
  echo 'Poslání SQL příkazu se nepodařilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_error($db_spojeni);
  exit();
}


// -- Vlož nový zápis, pokud byl odeslán formulářem --

// Test, jestli přišla data z formuláře.
if (isset($_POST['zprava']))
{
  // Vytvoření SQL příkazu typu INSERT.
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

  // Zaslání SQL příkazu do databáze.
  $objekt_vysledku = mysqli_query($db_spojeni, $sql_prikaz);
 
  if (!$objekt_vysledku)
  {
    echo 'Poslání SQL příkazu se nepodařilo, sorry';
    echo '<br />';
    echo 'Popis chyby: ', mysqli_error($db_spojeni);
    exit();
  }
  echo 'Nový zápis do knihy návštěv přidán.<br />';
}


// -- Vypiš všechny zápisy v knize návštěv --

// Zaslání SQL příkazu do databáze.
$objekt_vysledku = mysqli_query($db_spojeni,
  'SELECT * FROM kniha_navstev ORDER BY datum DESC');
if (!$objekt_vysledku)
{
  echo 'Poslání SQL příkazu se nepodařilo, sorry';
  echo '<br />';
  echo 'Popis chyby: ', mysqli_error($db_spojeni);
  exit();
}

// Zobrazení všech vrácených dat.
while ($radek = mysqli_fetch_array($objekt_vysledku))
{
  echo '<hr />';
  echo 'Datum a čas: ',$radek['datum'],'<br />';
  echo 'Napsal: ',$radek['jmeno'],' (',$radek['email'],')<br />';
  echo 'Zápis: ',$radek['zapis'],'<br />';
  echo '<br />';
}
echo '<hr />';


// -- Odpojení od databáze --

// Zavření objektu výsledku, protože už ho nebudeme používat.
mysqli_free_result($objekt_vysledku);
 
// Odpojení od databáze.
if ($db_spojeni)
  mysqli_close($db_spojeni);


// -- Formulář pro vkládání nových zápisů --
?>
<form name="kniha" action="" method="post">
<b>Jméno:</b><br />
<input name="jmeno" size="40"><br />
<br />
<b>Mail:</b><br />
<input name="email" size="40"><br />
<br />
<b>Zpráva:</b><br />
<textarea name="zprava" rows="5" cols="30"></textarea><br />
<br />
<input type="submit" value="Odeslat zprávu">
</form>

</body>
</html>


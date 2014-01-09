<html>
 <head>
<title>Zaèínáme s vıvojem v PHP6, Apache a MySQL - Chybová stránka</title>
 </head>
 <body>
<?php
switch ($_SERVER['QUERY_STRING']) {
  case 400:
    echo '<h1>Chybnı poadavek</h1>';
    echo '<h2>Kód chyby 400</h2>';
    echo '<p>Hledaná stránka mohla bıt odebrána, pøejmenována ' .
         'nebo je doèasnì nedostupná.</p>';
    break;
     
  case 401:
    echo '<h1>Pøihlášení selhalo</h1>';
    echo '<h2>Kód chyby 401</h2>';
    echo '<p>Zadaná povìøení neopravòují k prohlíení tohoto ' .
         'adresáøe nebo stránky.</p>';
    break;
  
  case 403:
    echo '<h1>Pøístup zakázán</h1>';
    echo '<h2>Kód chyby 403</h2>';
    echo '<p>Zadaná povìøení neopravòují k prohlíení tohoto ' .
         'adresáøe nebo stránky.</p>';
    break;
     
  case 404:
    echo '<h1>Soubor nebyl nalezen</h1>';
    echo '<h2>Kód chyby 404</h2>';
    echo '<p>Hledaná stránka mohla bıt odebrána, pøejmenována ' .
         'nebo je doèasnì nedostupná.</p>';
    break;

  case 500:
    echo '<h1>Vnitøní chyba serveru</h1>';
    echo '<h2>Kód chyby 500</h2>';
    echo '<p>Na stránce, ke které se pokoušíte pøipojit, došlo ' .
         'k problémùm a nelze ji zobrazit.</p>';
    break;
     
  default:
    echo '<h1>Informace o chybì</h1>';
    echo '<p>To je vlastní chybová stránka...</p>';
}

echo '<p>Pokud pøedpokládáte, e byste mìli mít monost' .
     'zobrazit danı adresáø nebo stránku, obrate se na ' .
     '<a href="mailto:sysadmin@priklad.cz">správce webového serveru</a>.</p>';

$now = (isset($_SERVER['REQUEST_TIME'])) ? $_SERVER['REQUEST_TIME'] : time();
$page = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : 'neznámá';

$msg = wordwrap('Kdy se návštìvník pokusil zobrazit stránku ' . $page .
  ' dne ' . date('F d, Y', $now) . ' v ' . date('H:i:sa T', $now) . 
  ' došlo k chybì ' . $_SERVER['QUERY_STRING'] . '.');

mail('admin@priklad.cz', 'Chyba webové stránky', $msg);
?>
 </body>
</html>
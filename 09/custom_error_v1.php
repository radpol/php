<?php
// Nejprve vytvoøíme vlastní rutinu pro ošetøení chyb.
function handler( $typ, $zpráva, $soubor, $øádek ) {
  echo "<h1>Informace o chybì</h1>";
  echo "Bìhem zpracování této stránky došlo k chybì. Informujte ";
  echo "<a href=\"mailto:admin@doména.cz\">správce</a>.<br><br>";
  echo "<b>Zjištìné informace</b><br><br>";
  echo "<b>Typ chyby:</b> $typ<br>";
  echo "<b>Chybové hlášení:</b> $zpráva<br>";
  echo "<b>Soubor s chybou:</b> $soubor<br>";
  echo "<b>K chybì došlo na øádku:</b> $øádek";
}

// Aktivace rutiny pro ošetøení chyb.
set_error_handler( "handler" );
// Øetìzec bude obsahovat chybnì napsané slovo "Press" .
$øetìzec = "Knihy nakladatelství Computer Perss jsou skvìlé!";

/*
 * Pokuste se k nahrazení chybného podøetìzce použít funkci
 * str_replace(). Tento pokus vyústí v chybu typu E_WARNING.
 * Dùvodem je užití nesprávného poètu argumentù funkce.
 */
str_replace( "Perss", "Press" );

?>

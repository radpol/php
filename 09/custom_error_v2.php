<?php
function handler($typ, $zpráva, $soubor, $øádek) {
  switch ($typ) {
    case E_ERROR:
        echo '<h1>Závažná chyba</h1>';
        echo '<p>V souboru ' . $soubor . ' na øádku ' .
             $øádek . ' došlo ke kritické chybì.<br/>' . $zpráva . '.</p>';
        die();
        break;

    case E_WARNING:
        echo '<h1>Varování</h1>';
        echo '<p>V souboru ' . $soubor . ' na øádku ' . $øádek .
             ' došlo k ménì závažné chybì.<br/>' . $zpráva . '.';
        break;

    case E_NOTICE:
        // Chyby tohoto typu nebudeme zobrazovat.
        break;
  }
}

// Nastavte obsluhu chyby.
set_error_handler('handler');

// Øetìzec bude obsahovat chybnì napsané slovo "Press" .
$øetìzec = "Knihy nakladatelství Computer Perss jsou skvìlé!";

/*
 * Pokuste se k nahrazení chybného podøetìzce použít funkci
 * str_replace(). Tento pokus vyústí v chybu typu E_WARNING.
 * Dùvodem je užití nesprávného poètu argumentù funkce.
 */
str_replace( "Perss", "Press" );
?>
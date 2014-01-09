<?php
// Nejprve vytvoøíme vlastní rutinu pro ošetøení chyb.
function handler($typ, $zpráva, $soubor, $øádek) {

    $msg = 'Pøi zpracování stránky došlo k chybám.' . "\n\n";
    $msg .= 'Typ chyby: ' . $typ . "\n";
    $msg .= 'Chybová zpráva: ' . $zpráva . "\n";
    $msg .= 'Název souboru: ' . $soubor . "\n";
    $msg .= 'Èíslo øádku: ' . $øádek . "\n";
    $msg = wordwrap($msg, 75);

    switch($typ) {
    case E_ERROR:
        mail('admin@priklad.cz', 'Závažná chyba webové prezentace', $msg);
        die();
        break;
          
    case E_WARNING:
        mail('admin@priklad.cz', 'Ménì závažná chyba webové prezentace', $msg);
        break;
    }
}

/*
 * Po nastavení oznamování chyb na nulu bude o varováních a chybách
 * informován pouze správce.
 */
error_reporting(0);

// Nastavte funkci pro ošetøení chyb.
set_error_handler('handler');

/*
 * Sem vložte zbytek kódu stránky. Tento kód zde nebudeme uvádìt.
 * Spokojíme se s odesláním e-mailu správci. Nezapomeòte, že závažné chyby
 * zastaví bìh skriptu i nyní, ovšem informace o nich se zobrazí jen správci.
 */
?>
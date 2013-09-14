<?php
  $x = 4;
  // Globální promìnná $x nastavena na 4.
 
  function vypis_x()
  {
    echo $x;
    // Tohle je pokus o výpis lokální prommìnné $x.
  }
 
  echo vypis_x();
?>

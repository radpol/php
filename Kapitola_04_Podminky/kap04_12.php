<?php
  var_dump(10 > 20);
  // Tato podmínka je nepravdivá.
  // Vypíše: bool(false)
 
  echo '<br>';
  // Zajistí, aby se další výpis vypsal
  // na další øádku.
 
  var_dump(!(10 > 20));
  // Tato podmínka je pravdivá, protože je
  // je použita operace negace, která otoèila
  // pravdivost podmínky.
  // Vypíše: bool(true)
?>

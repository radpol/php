<?php
  var_dump('30' == '+30');
  // Podmínka je pravdivá, protože PHP porovná
  // øetìzce jako èísla, vypíše se tedy bool(true)
 
  echo '<br>';
  // Zajistí, aby se další výpis vypsal
  // na další øádku.
 
  var_dump('30x' == '+30x');
  // Podmínka není pravdivá, protože PHP porovná
  // øetìzce jako texty, vypíše se tedy bool(false)
?>

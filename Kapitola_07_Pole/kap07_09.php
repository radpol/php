<?php
  $pole = array(1 => 20);
  // Vytvoøení pole, které obsahuje jedno èíslo, a to dvacítka.
  // Dvacítka má index 1.
 
  $pole[10] = 100;
  // Protože v poli neexistuje prvek s indexem 10, tak se vytvoøí
  // a uloží se do nìj èíslo 100.
 
  // Teï už jsou v poli dva prvky.
  // Index 1 obsahuje 20 a index 10 obsahuje 100.
 
  var_dump($pole);
  // Vypíše pole.
?>

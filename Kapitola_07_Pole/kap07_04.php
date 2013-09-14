<?php
  $pole = array(1,2,3,4,5);
  // Vytvoøení pole, ve kterém budou uloženo pìt èísel.
  // Jednièka má index nula, dvojka má index jedna, trojka má index 
  // dva, ètyøka mí index tøi a pìtka má index ètyøi.
 
  $pole[3] = 10;
  // Zmìna prvku v poli, který má index tøi. Na tomto indexu byla
  // pùvodnì ètyøka, teï jsme tam uložili namísto ní desítku.
 
  // Pole teï obsahuje èísla: 1,2,3,10,5.
 
  var_dump($pole);
  // Vypíše: ???
  // Vypsání celého pole.
?>

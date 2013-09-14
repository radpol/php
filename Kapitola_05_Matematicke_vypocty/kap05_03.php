<?php
  $x = 3;
 
  $y = $x++;
  // Dojde ke zvìtšení $x o jednièku (tedy v $x bude 4), ale
  // výsledkem výrazu $x++ je stará hodnota $x, takže do
  // promìnné $y se pøiøadí hodnota promìnné $x ještì pøed
  // pøiètením jednièky (tedy v $y bude 3).
 
  echo '$x = ', $x, '<br>';
  // Vypíše: $x = 4
  echo '$y = ', $y, '<br>';
  // Vypíše: $y = 3
?>

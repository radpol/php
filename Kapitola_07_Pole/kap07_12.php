<?php
  $pole = array(1 => 100, 2 => 150);
  // Vytvoøení pole, které obsahuje dvì èísla: sto a dvìstì.
  // Index 1 má uloženou stovku a index 2 má uloženou dvoustovku.
 
  foreach ($pole as $index => $prvek)
    echo 'Nalezen index: ',$index,', prvek: ',$prvek,'<br>';
  // Toto je konstrukce foreach, která prochází pole $pole a každý prvek
  // vypíše jeho index a vlastní prvek.
?>

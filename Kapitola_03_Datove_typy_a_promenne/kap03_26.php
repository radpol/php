<?php
  $a = 1;
  // Promìnná $a teï obsahuje jako hodnotu èíslo 1
 
  echo $a;
  // Vypíše hodnotu promìnné $a 
  // Vypíše: 1
 
  unset($a);
  // Pomocí konstrukce unset zrušíme promìnnou $a.
  // Od této chvíle tedy promìnná $a už neexistuje.
 
  echo $a;
  // Teï bychom mìli vypsat hodnotu promìnné $a. Protože však
  // promìnná $a už neexistuje, pokoušíme se použít neexistující
  // promìnnou.
  // Pokud je PHP nastaveno tak, aby nepolykalo chyby, vypíše
  // chybu:
  // Notice: Undefined variable: a in c:\inet_srv\http\doc_root\a.php
  // on line 13
?>

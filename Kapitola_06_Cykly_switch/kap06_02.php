<?php
  $i = 1;
  // Zaèneme vypisovat èísla od jedné.
 
  while ($i <= 10)
  {
    if ($i > 2)
      break;
    // Jestliže promìnná $i obsahuje èíslo vìtší, než 2, pak
    // se vykoná pøíkaz break a cyklus se pøedèasnì ukonèí.
 
    echo $i,' ';
    // Vypiš èíslo uložené v promìnné $i a pak vypiš mezeru,
    // aby èísla nebyla nalepená hned na sobì.
 
    ++$i;
    // Inkrementace promìnné $i, tedy zvìtšení èísla o jednièku.
  }
?>

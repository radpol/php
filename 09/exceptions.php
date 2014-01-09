<?php
// $x = null;
// $x = 500;
$x = 1000;

try {
  if (is_null($x)) {
    throw new Exception( 'Promìnná nemùže být prázdná!' );
  }
  if ($x < 1000) {
    throw new Exception( 'Hodnota promìnné nesmí být menší než 1000!' );
  }

  echo 'Hodnota prošla procesem ovìøování!';
}
catch (Exception $e) {
  echo 'Ovìøení selhalo. ' . $e->getMessage();
}
?>
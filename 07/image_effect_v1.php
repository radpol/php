<?php
// Upravte cestu tak, aby odpovídala vašemu umístìní.
$dir ='C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/obrazky';

// Ovìøte, že obrázek je platný.
if (isset($_GET['id']) && ctype_digit($_GET['id']) && file_exists($dir . '/'.
    $_GET['id'] . '.jpg')) {
  $image = imagecreatefromjpeg($dir . '/' . $_GET['id'] . '.jpg');
} else {
  die('Zadán neplatný obrázek.');
}

// Použijte filtr.
$effect = (isset($_GET['e'])) ? $_GET['e'] : -1;
switch ($effect) {
  case IMG_FILTER_NEGATE:
    imagefilter($image, IMG_FILTER_NEGATE);
    break;
  case IMG_FILTER_GRAYSCALE:
    imagefilter($image, IMG_FILTER_GRAYSCALE);
    break;
  case IMG_FILTER_EMBOSS:
    imagefilter($image, IMG_FILTER_EMBOSS);
    break;
  case IMG_FILTER_GAUSSIAN_BLUR:
    imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
    break;
}

// Zobrazení obrázku.
header('Content-Type: image/jpeg');
imagejpeg($image, '', 100);
?>

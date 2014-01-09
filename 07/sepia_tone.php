<?php
// Upravte cestu tak, aby odpovídala vašemu umístìní.
$dir ='C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/images';

$image = imagecreatefromjpeg($dir . '/1.jpg');

// Odeberte informace o barvì: vytvoøte èernobílý obrázek.
imagefilter($image, IMG_FILTER_GRAYSCALE);

// Použijte nahnìdlý odstín.
imagefilter($image, IMG_FILTER_COLORIZE, 0xFF, 0xB9, 0x80, 30);

// Zobrazte obrázek.
header('Content-Type: image/jpeg');
imagejpeg($image, '', 100);
?>

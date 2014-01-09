<?php
// Upravte cestu tak, aby odpovídala vašemu umístìní.
$dir ='C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/obrazky';

// Zmìòte cestu tak, aby odpovídala umístìní souborù písem ve vašem systému.
// Pøípadnì vyberte jiné písmo.
putenv('GDFONTPATH=C:/Windows/Fonts');
$font = 'C:/Windows/Fonts/arial.ttf';

// Ovìøte, že obrázek je platný.
if (isset($_GET['id']) && ctype_digit($_GET['id']) && file_exists($dir . '/' .
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

// Na vyžádání pøidejte popisek.
if (isset($_GET['capt'])) {
    imagettftext($image, 12, 0, 20, 20, 0, $font, $_GET['capt']);
}

// Na požádání pøidejte také vodoznak.
if (isset($_GET['logo'])) {
    // Urèete souøadnice x a y k vystøedìní vodoznaku.
    list($width, $height) = getimagesize($dir . '/' . $_GET['id'] . '.jpg');
    list($wmk_width, $wmk_height) = getimagesize('obrazky/logo.png');
    $x = ($width - $wmk_width) / 2;
    $y = ($height - $wmk_height) / 2;
    
    $wmk = imagecreatefrompng('obrazky/logo.png');
    imagecopymerge($image, $wmk, $x, $y, 0, 0, $wmk_width, $wmk_height, 20);
    imagedestroy($wmk);
}

// Zobrazení obrázku.
header('Content-Type: image/jpeg');
imagejpeg($image, '', 100);
?>
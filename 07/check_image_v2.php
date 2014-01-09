<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Upravte cestu tak, aby odpovídala vašemu umístìní.
$dir ='C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/obrazky';

// Nejprve se ujistìte, že pøenos probìhl v poøádku.
if ($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK) {
  switch ($_FILES['uploadfile']['error']) {
    case UPLOAD_ERR_INI_SIZE:
      die('Velikost pøenášeného souboru pøesáhla hodnotu ' .
                'upload_max_filesize definovanou v souboru php.ini.');
      break;
    case UPLOAD_ERR_FORM_SIZE:
      die('Velikost pøenášeného souboru pøesáhla hodnotu MAX_FILE_SIZE ' .
                'urèenou ve formuláøi HTML.');
      break;
    case UPLOAD_ERR_PARTIAL:
      die('Soubor byl pøenesen jen èásteènì.');
      break;
    case UPLOAD_ERR_NO_FILE:
      die('Nebyl pøenesen žádný soubor.');
      break;
    case UPLOAD_ERR_NO_TMP_DIR:
      die('Server nemá k dispozici doèasný adresáø.');
      break;

    case UPLOAD_ERR_CANT_WRITE:
      die('Serveru se nepodaøilo uložit pøenesený soubor na disk.');
      break;
    case UPLOAD_ERR_EXTENSION:
      die('Pøenos souboru zastaven doplòkem PHP.');
      break;
  }
}

// Zjištìní informací o pøeneseném souboru.
$image_caption = $_POST['caption'];
$image_username = $_POST['username'];
$image_date = date('Y-m-d');
list($width, $height, $type, $attr) =
  getimagesize($_FILES['uploadfile']['tmp_name']);

// Zkontrolujte, zda podporujete formát pøeneseného souboru.

// Odstraòte následující øádky
switch ($type) {
  case IMAGETYPE_GIF:
    $image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']) or
    die('Formát pøeneseného souboru není podporován.');
    $ext = '.gif';
    break;
  case IMAGETYPE_JPEG:
    $image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']) or
    die('Formát pøeneseného souboru není podporován.');
    $ext = '.jpg';
    break;
  case IMAGETYPE_PNG:
    $image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']) or
    die('Formát pøeneseného souboru není podporován.');
    $ext = '.png';
    break;
  default:
    die('Formát pøeneseného souboru není podporován.');
  }
  // Konec odstranìných øádkù.

  $error = 'Formát pøeneseného souboru není podporován.';
  switch ($type) {
    case IMAGETYPE_GIF:
      $image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']) or
      die($error);
      break;
    case IMAGETYPE_JPEG:
      $image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']) or
      die($error);
      break;
    case IMAGETYPE_PNG:
      $image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']) or
      die($error);
      break;
    default:
      die($error);
    }

    // Uložte informace do tabulky.
    $query = 'INSERT INTO images (image_caption, image_username, image_date)
              VALUES ("' . $image_caption . '", "' . $image_username . '", "'
             . $image_date . '")';
    $result = mysql_query($query, $db) or die (mysql_error($db));

    // Naètení identifikátoru obrázkù generovaného databází MySQL automaticky
    // pøi vložení nového záznamu.
    $last_id = mysql_insert_id();

    // Odstraòte následující øádky

    // Jelikož je tento ID jedineèný, lze jej použít jako název souboru.
    // Budete pak mít jistotu, že existující obrázek nebude pøepsán.
    $imagename = $last_id . $ext;


    // Název cílového souboru známe až nyní,
    // proto je tøeba tabulku aktualizovat.
    $query = 'UPDATE images
              SET image_filename = "' . $imagename . '"
              WHERE image_id = ' . $last_id;
    $result = mysql_query($query, $db) or die (mysql_error($db));

    switch ($type) {
      case IMAGETYPE_GIF:
        imagegif($image, $dir . '/' . $imagename);
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($image, $dir . '/' . $imagename, 100);
        break;
      case IMAGETYPE_PNG:
        imagepng($image, $dir . '/' . $imagename);
        break;
    }
    // Konec odstranìných øádkù.

    // Uložte obrázek na cílové místo.
    $imagename = $last_id . '.jpg';
    imagejpeg($image, $dir . '/' . $imagename);
    imagedestroy($image);
    ?>
<html>
  <head>
    <title>Zde je váš obrázek!</title>
  </head>
  <body>
    <h1>Takže, jaké to je, být slavný?</h1>
    <p>Zde je obrázek, který jste právì odeslali na náš server:</p>
    <img src="obrazky/<?php echo $imagename; ?>" style="float:left;">
    <table>
      <tr><td>Obrázek je uložen jako: </td>
      <!-- Odstraòte tento øádek:
    <tr><td>Typ obrázku: </td><td><?php echo $ext; ?></td></tr>
    -->
      <tr><td>Výška: </td><td><?php echo $height; ?></td></tr>
      <tr><td>Šíøka: </td><td><?php echo $width; ?></td></tr>
      <tr><td>Datum uložení: </td><td><?php echo $image_date; ?></td></tr>
    </table>
  </body>
</html>

<?php
// pøipojení k databázi MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Upravte cestu tak, aby odpovídala vašemu umístìní.
$dir ='C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/obrazky';

// Upravte cestu tak, aby odpovídala vašemu umístìní.
$thumbdir = $dir . '/miniatury';

// Upravte cestu tak, aby odpovídala vašemu umístìní.
putenv('GDFONTPATH=C:/Windows/Fonts');
$font = 'C:/Windows/Fonts/arial.ttf';

// Obsluha pøenášených souborù.
if ($_POST['submit'] == 'Odeslat') {

  // Nejprve se ujistìte, že pøenos probìhl v poøádku.
  if ($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK)
  {
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
  $image_date = @date('Y-m-d');
  list($width, $height, $type, $attr) =
  getimagesize($_FILES['uploadfile']['tmp_name']);

  // Zkontrolujte, zda podporujete formát pøeneseného souboru.
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

    // Uložení obrázku na koneèné místo.
    $image_id = $last_id;
    imagejpeg($image, $dir . '/' . $image_id  . '.jpg');
    imagedestroy($image);

  } else {
    // Zjištìní informací o obrázku.
    $query = 'SELECT
                  image_id, image_caption, image_username, image_date
              FROM
                  images
              WHERE
                  image_id = ' . $_POST['id'];
    $result = mysql_query($query, $db) or die (mysql_error($db));
    extract(mysql_fetch_assoc($result));

    list($width, $height, $type, $attr) = getimagesize($dir . '/' . $image_id .
        '.jpg');
  }

  if ($_POST['submit'] == 'Uložit') {
    // Ovìøte platnost obrázku.
    if (isset($_POST['id']) && ctype_digit($_POST['id']) &&
      file_exists($dir . '/' . $_POST['id'] . '.jpg')) {
      $image = imagecreatefromjpeg($dir . '/' . $_POST['id'] . '.jpg');
    } else {
      die('Zadán neplatný obrázek.');
    }

    // Aplikace filtru.
    $effect = (isset($_POST['effect'])) ? $_POST['effect'] : -1;
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

    // Požaduje-li to uživatel, pøidejte popisek.
    if (isset($_POST['emb_caption'])) {
      imagettftext($image, 12, 0, 20, 20, 0, $font, $image_caption);
    }

    // Požaduje-li to uživatel, pøidejte vodoznak s logem.
    if (isset($_POST['emb_logo'])) {
      // Zjistìte souøadnice x a y k vystøedìní vodoznaku.
      list($wmk_width, $wmk_height) = getimagesize('obrazky/logo.png');
      $x = ($width - $wmk_width) / 2;
      $y = ($height - $wmk_height) / 2;

      $wmk = imagecreatefrompng('obrazky/logo.png');
      imagecopymerge($image, $wmk, $x, $y, 0, 0, $wmk_width, $wmk_height, 20);
      imagedestroy($wmk);
    }

    // Uložte obrázek po aplikaci filtru.
    imagejpeg($image, $dir . '/' . $_POST['id'] . '.jpg', 100);

    // Nastavte rozmìry miniatury.
    $thumb_width = $width * 0.10;
    $thumb_height = $height * 0.10;

    // Vytvoøte miniaturu.
    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
    imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumb_width, $thumb_height,
      $width, $height);
    imagejpeg($thumb, $dir . '/' . $_POST['id'] . '.jpg', 100);
    imagedestroy($thumb);
    ?>
<html>
  <head>
    <title>Zde je váš obrázek!</title>
  </head>
  <body>
    <h1>Obrázek byl úspìšnì uložen!</h1>
    <img src="obrazky/<?php echo $_POST['id']; ?>.jpg" />
  </body>
</html>
<?php
} else {
?>
<html>
  <head>
    <title>Zde je váš obrázek!</title>
  </head>
  <body>
    <h1>Takže, jaké to je, být slavný?</h1>
    <p>Zde je obrázek, který jste právì odeslali na náš server:</p>
    <?php
    if ($_POST['submit'] == 'Odeslat') {
      $imagename = 'obrazky/' . $image_id  . '.jpg';
    } else {
      $imagename = 'image_effect.php?id=' . $image_id  . '&e=' .
      $_POST['effect'];

      if (isset($_POST['emb_caption'])) {
        $imagename .= '&capt=' . urlencode($image_caption);
      }

      if (isset($_POST['emb_logo'])) {
        $imagename .= '&logo=1';
      }
    }
    ?>
    <img src="<?php echo $imagename; ?>" style="float:left;">
    <table>
      <tr><td>Obrázek je uložen jako: </td>
        <td><?php echo $image_id  . '.jpg'; ?></td></tr>
      <tr><td>Výška: </td><td><?php echo $height; ?></td></tr>
      <tr><td>Šíøka: </td><td><?php echo $width; ?></td></tr>
      <tr><td>Datum uložení: </td><td><?php echo $image_date; ?></td></tr>
    </table>
    <p>Obrázek mùžete upravit nìkolika zpùsoby. Poznámka: Po uložení se zmìny
    <em>stanou nevratné</em>.</p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div>
        <input type="hidden" name="id" value="<?php echo $image_id;?>"/>
        Filtr: <select name="effect">
          <option value="-1">Žádný</option>
          <?php
          echo '<option value="' . IMG_FILTER_GRAYSCALE . '"';
          if (isset($_POST['effect']) && $_POST['effect'] ==
            IMG_FILTER_GRAYSCALE) {
            echo ' selected="selected"';
          }
          echo '>Èernobílý</option>';

          echo '<option value="' . IMG_FILTER_GAUSSIAN_BLUR . '"';
          if (isset($_POST['effect']) && $_POST['effect'] ==
            IMG_FILTER_GAUSSIAN_BLUR) {
            echo ' selected="selected"';
          }
          echo '>Rozmazat</option>';

          echo '<option value="' . IMG_FILTER_EMBOSS . '"';
          if (isset($_POST['effect']) && $_POST['effect'] ==
            IMG_FILTER_EMBOSS) {
            echo ' selected="selected"';
          }
          echo '>Reliéf</option>';

          echo '<option value="' . IMG_FILTER_NEGATE . '"';
          if (isset($_POST['effect']) && $_POST['effect'] ==
            IMG_FILTER_NEGATE) {
            echo ' selected="selected"';
          }
          echo '>Negativ</option>';
          ?>
        </select>
        <br/><br/>
        <?php
        echo '<input type="checkbox" name="emb_caption"';
        if (isset($_POST['emb_caption'])) {
          echo ' checked="checked"';
        }
        echo '>Vložit do obrázku popisek?';
        echo '<br/><br/><input type="checkbox" name="emb_logo"';
        if (isset($_POST['emb_logo'])) {
          echo ' checked="checked"';
        }
        echo '>Vložit do obrázku vodoznak loga?';
        ?>
        <br/><br/>
        <input type="submit" value="Náhled" name="submit" />
        <input type="submit" value="Uložit" name="submit" />
      </div>
    </form>
  </body>
</html>
<?php
}
?>
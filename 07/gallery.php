<?php
// pøipojení k databázi MySQL
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));

// Upravte cestu tak, aby odpovídala umístìní obrázkù.
$dir ='obrazky';

// Upravte cestu tak, aby odpovídala umístìní miniatur.
$thumbdir = $dir . '/miniatury';
?>
<html>
  <head>
    <title>Vítejte v naší fotogalérii</title>
    <style type="text/css">
      th { background-color: #999;}
      .odd_row { background-color: #EEE; }
      .even_row { background-color: #FFF; }
    </style>
  </head>
  <body>
    <p>Chcete-li vidìt obrázek v plné velikosti, klepnìte na miniaturu.</p>
    <table style="width:100%;">
      <tr>
        <th>Obrázek</th>
        <th>Popisek</th>
        <th>Uložil</th>
        <th>Datum uložení</th>
      </tr>
      <?php
      // Naètení miniatur
      $result = mysql_query('SELECT * FROM images') or die(mysql_error());

      $odd = true;
      while ($rows = mysql_fetch_array($result)) {
        echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
        $odd = !$odd;
        extract($rows);
        echo '<td><a href="' . $dir . '/' . $image_id . '.jpg">';
        echo '<img src="' . $thumbdir . '/' . $image_id . '.jpg">';
        echo '</a></td>';
        echo '<td>' . $image_caption . '</td>';
        echo '<td>' . $image_username . '</td>';
        echo '<td>' . $image_date . '</td>';
        echo '</tr>';
      }
      ?>
    </table>
  </body>
</html>
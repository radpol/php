<html>
  <head>
    <title>Editace schopnosti</title>
    <style type="text/css">
      td { vertical-align: top; }
    </style>
  </head>
  <body>
    <img src="logo.jpg" alt="Web pro fanoušky komiksù" style="float: left;" />
    <h1>Web<br/>pro fanoušky komiksù</h1>
    <h2>Editace schopností postavy</h2>
    <hr style="clear: both;"/>
    <form action="char_transaction.php" method="post">
      <div>
        <input type="text" name="new_power" size="20" maxlength="40" value="" />
        <input type="submit" name="action" value="Pøidat novou schopnost" />
      </div>
      <?php
      require 'db.inc.php';

      $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
      die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
      mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

      $query = 'SELECT power_id, power FROM comic_power ORDER BY power ASC';
      $result = mysql_query($query, $db) or die (mysql_error($db));

      if (mysql_num_rows($result) > 0) {
        echo '<p><em>Odstranìní schopnosti zpùsobí vymazání všech ' .
             'souvisejících postav -- vybírejte tedy obezøetnì!</em></p>';

        $num_powers = mysql_num_rows($result);
        $threshold = 5;
        $max_columns = 2;

        $num_columns = min($max_columns, ceil($num_powers/$threshold));
        $count_per_column = ceil($num_powers/$num_columns);

        $i = 0;
        echo '<table><tr><td>';
        while ($row = mysql_fetch_assoc($result)) {
          if (($i > 0) && ($i % $count_per_column == 0)) {
            echo '</td><td>';
          }
          echo '<input type="checkbox" name="powers[]" "value="' .
          $row['power_id'] . '" /> ';
          echo $row['power'] . '<br/>';
          $i++;
        }
        echo '</td></tr></table>';

        echo '<br/><input type="submit" name="action" ' .
                    'value="Vymazat vybrané schopnosti" />';
      } else {
        echo '<p><strong>Nejsou dostupné žádné schopnosti...</strong></p>';
      }
      ?>
    </form>
    <p><a href="list_characters.php">Návrat na hlavní stránku</a></p>
  </body>
</html>
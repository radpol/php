<html>
  <head>
    <title>Nabídka produktù pro fanoušky komiksù</title>
    <style type="text/css">
      th { background-color: #999;}
      td { vertical-align: top; }
      .odd_row { background-color: #EEE; }
      .even_row { background-color: #FFF; }
    </style>
  </head>
  <body>
    <h1>Obchod pro fanoušky komiksù</h1>
    <p><a href="ecomm_view_cart.php">Zobrazit obsah nákupního košíku</a></p>
    <p>Dìkujeme, že jste navštívili náš web!
      Prohlédnìte si seznam našich skvìlých produktù. Chcete-li se dovìdìt
    nìco bližšího, klepnìte na pøíslušný odkaz:</p>
    <table style="width:75%;">
      <?php
      require 'db.inc.php';

      $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
        die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

      mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

      $query = 'SELECT
                    product_code, name, price
                FROM
                    ecomm_products
                ORDER BY
                    product_code ASC';
      $result = mysql_query($query, $db)or die(mysql_error($db));

      $odd = true;
      while ($row = mysql_fetch_array($result)) {
        echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
        $odd = !$odd;
        extract($row);
        echo '<td style="text-align: center; width:100px;"><a href="' .
              'ecomm_view_product.php?product_code=' . $product_code .
              '"><img src="images/' . $product_code .'_t.jpg" alt="' . $name .
              '"/></a></td>';
        echo '<td><a href="ecomm_view_product.php?product_code=' . 
              $product_code . '">' . $name . '</a></td>';
        echo '<td style="text-align: right;"><a href="ecomm_view_product.php?' .
              'product_code=' . $product_code . '">' . $price . ' Kè</a></td>';
        echo '</tr>';
      }
      ?>
    </table>
  </body>
</html>
<?php
session_start();
require 'db.inc.php';
?>
<html>
  <head>
    <title>Toto je obsah vašeho košíku!</title>
    <style type="text/css">
      th { background-color: #999;}
      td { vertical-align: top; }
      .odd_row { background-color: #EEE; }
      .even_row { background-color: #FFF; }
    </style>
  </head>
  <body>
    <h1>Obchod pro fanoušky komiksù</h1>
    <?php
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
    die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    $session = session_id();

    $query = 'SELECT
                  t.product_code, qty,
                  name, description, price
              FROM
                  ecomm_temp_cart t JOIN ecomm_products p ON
                      t.product_code = p.product_code
              WHERE
                  session = "' . $session . '"
              ORDER BY
                  t.product_code ASC';
    $result = mysql_query($query, $db) or die (mysql_error($db));

    $rows = mysql_num_rows($result);
    if ($rows == 0) {
      echo '<p>Máte prázdný košík.</p>';
    } else if ($rows == 1) {
      echo '<p>V košíku máte vybrán jeden produkt.</p>';
    } else if ($rows > 1 and $rows < 5) {
      echo '<p>V košíku máte ' . $rows . ' produkty.</p>';
    } else {
      echo '<p>V košíku máte ' . $rows . ' produktù.</p>';
    }

    if ($rows > 0) {
      ?>
    <table style="width: 75%;">
      <tr>
        <th style="width: 100px;"> </th><th>Název zboží</th><th>Množství</th>
        <th>Jednotková cena</th><th>Celková cena</th>
      </tr><tr>
        <?php
        $total = 0;
        $odd = true;
        while ($row = mysql_fetch_array($result)) {
          echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
          $odd = !$odd;
          extract($row);
          ?>
        <td style="text-align:center;">
          <a href="ecomm_view_product.php?product_code=<?php
             echo $product_code; ?>">
            <img src="images/<?php echo $product_code; ?>_t.jpg"
               alt="<?php echo $name; ?>"/></a>
        </td>
        <td><a href="ecomm_view_product.php?product_code=
                 <?php echo $product_code; ?>"><?php echo $name; ?></a>
        </td>
        <td>
          <form method="post" action="ecomm_update_cart.php">
            <div>
              <input type="text" name="qty" maxlength="2" size="2"
                     value="<?php echo $qty; ?>"/>
              <input type="hidden" name="product_code"
                     value="<?php echo $product_code; ?>"/>
              <input type="hidden" name="redirect" value="ecomm_view_cart.php"/>
              <input type="submit" name="submit" value="Zmìnit množství"/>
            </div>
          </form>
        </td>
        <td style="text-align: right;">
          <?php echo number_format($price, 2, ',', ' '); ?> Kè</td>
        <td style="text-align: right;">
          <?php echo number_format($price * $qty, 2, ',', ' '); ?> Kè </td>
      </tr>
      <?php
      $total = $total + $price * $qty;
    }
    ?>
    </table>
    <p>Celková cena nákupu bez poštovného:
    <strong><?php echo number_format($total, 2, ',', ' '); ?></strong> Kè</p>
    <form method="post" action="ecomm_checkout.php">
      <div>
        <input type="submit" name="submit" value="Objednat"
               style="font-weight: bold;"/>
      </div>
    </form>
    <form method="post" action="ecomm_update_cart.php">
      <div>
        <input type="hidden" name="redirect" value="ecomm_shop.php"/>
        <input type="submit" name="submit" value="Vyprázdnit košík"/>
      </div>
    </form>
    <?php
  }
  ?>
    <hr/>
    <p><a href="ecomm_shop.php">&lt;&lt; Zpìt na hlavní stránku</a></p>
  </body>
</html>
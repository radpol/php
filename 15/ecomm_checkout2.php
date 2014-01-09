<?php
session_start();
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$session = session_id();

if (isset($_POST['same_info'])) {
  $_POST['shipping_first_name'] = $_POST['first_name'];
  $_POST['shipping_last_name'] = $_POST['last_name'];
  $_POST['shipping_address_1'] = $_POST['address_1'];
  $_POST['shipping_address_2'] = $_POST['address_2'];
  $_POST['shipping_city'] = $_POST['city'];
  $_POST['shipping_state'] = $_POST['state'];
  $_POST['shipping_zip_code'] = $_POST['zip_code'];
  $_POST['shipping_phone'] = $_POST['phone'];
  $_POST['shipping_email'] = $_POST['email'];
}
?>
<html>
  <body>
  <title>Pokladna - krok 2 ze 3</title>
  <style type="text/css">
    th { background-color: #999;}
    td { vertical-align: top; }
    .odd_row { background-color: #EEE; }
    .even_row { background-color: #FFF; }
  </style>
  </head>
  <body>
    <h1>Obchod pro fanoušky komiksù</h1>
    <h2>Vystavení objednávky</h2>
    <ol>
      <li>Zadejte fakturaèní a doruèovací adresu</li>
      <li><strong>Ovìøte správnost údajù a odešlete objednávku</strong></li>
      <li>Potvrzení objednávky a úètenka</li>
    </ol>
    <table style="width: 75%;">
      <tr>
        <th style="width: 100px;"> </th><th>Název položky</th><th>Množství</th>
        <th>Jednotková cena</th><th>Celková cena</th>
      </tr>
      <tr>
        <?php
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
        $results = mysql_query($query, $db) or die (mysql_error($db));

        $rows = mysql_num_rows($results);

        $total = 0;
        $odd = true;
        while ($row = mysql_fetch_array($results)) {
          echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
          $odd = !$odd;
          extract($row);
          ?>
        <td style="text-align:center;">
          <img src="images/<?php echo $product_code; ?>_t.jpg"
               alt="<?php echo $name; ?>"/>
        </td>
        <td><?php echo $name; ?></td>
        <td><?php echo $qty; ?></td>
        <td style="text-align: right;">
          <?php echo number_format($price, 2, ',', ' '); ?> Kè</td>
        <td style="text-align: right;">
          <?php echo number_format($price * $qty, 2, ',', ' ');?> Kè
        </td>
      </tr>
      <?php
      $total = $total + $price * $qty;
    }
    ?>
    </table>
    <p>Celková cena bez DPH a poštovného èiní:
    <strong><?php echo number_format($total, 2, ',', ' '); ?> Kè</strong></p>
    <table>
      <tr>
        <td>
          <table>
            <tr>
              <th colspan="2">Fakturaèní adresa</th>
            </tr><tr>
              <td>Jméno:</td>
              <td><?php echo htmlspecialchars($_POST['first_name']);?></td>
            </tr><tr>
              <td>Pøíjmení:</td>
              <td><?php echo htmlspecialchars($_POST['last_name']);?></td>
            </tr><tr>
              <td>Fakturaèní adresa:</td>
              <td><?php echo htmlspecialchars($_POST['address_1']);?></td>
            </tr><tr>
              <td> </td>
              <td><?php echo htmlspecialchars($_POST['address_2']);?></td>
            </tr><tr>
              <td>Mìsto:</td>
              <td><?php echo htmlspecialchars($_POST['city']);?></td>
            </tr><tr>
              <td>Zemì:</td>
              <td><?php echo htmlspecialchars($_POST['state']);?></td>
            </tr><tr>
              <td>PSÈ:</td>
              <td><?php echo htmlspecialchars($_POST['zip_code']);?></td>
            </tr><tr>
              <td>Telefon:</td>
              <td><?php echo htmlspecialchars($_POST['phone']);?></td>
            </tr><tr>
              <td>Elektronická adresa:</td>
              <td><?php echo htmlspecialchars($_POST['email']);?></td>
            </tr><tr>
              <td colspan="2" style="text-align: center;">
                <?php
                if (isset($_POST['same_info'])) {
                  echo 'Fakturaèní adresa je stejná jako adresa doruèovací.';
                }
                ?>
              </td>
            </tr>
          </table>
        </td>
        <td>
          <?php
          if (!isset($_POST['same_info'])) {
            ?>
          <table>
            <tr>
              <th colspan="2">Doruèovací adresa</th>
            </tr><tr>
              <td>Jméno:</td>
              <td><?php echo htmlspecialchars($_POST['shipping_first_name']);?>
              </td>
            </tr><tr>
              <td>Pøíjmení:</td>
              <td><?php echo htmlspecialchars($_POST['shipping_last_name']);?>
              </td>
            </tr><tr>
              <td>Doruèovací adresa:</td>
              <td><?php echo htmlspecialchars($_POST['shipping_address_1']);?>
              </td>
            </tr><tr>
              <td> </td>
              <td><?php echo htmlspecialchars($_POST['shipping_address_2']);?>
              </td>
            </tr><tr>
              <td>Mìsto:</td>
              <td><?php echo htmlspecialchars($_POST['shipping_city']);?></td>
            </tr><tr>
              <td>Zemì:</td>
              <td><?php echo htmlspecialchars($_POST['shipping_state']);?></td>
            </tr><tr>
              <td>PSÈ:</td>
              <td><?php echo htmlspecialchars($_POST['shipping_zip_code']);?>
              </td>
            </tr><tr>
              <td>Telefon:</td>
              <td><?php echo htmlspecialchars($_POST['shipping_phone']);?></td>
            </tr><tr>
              <td>Elektronická adresa:</td>
              <td><?php echo htmlspecialchars($_POST['shipping_email']);?></td>
            </tr>
          </table>
          <?php
        }
        ?>
        </td>
      </tr>
    </table>
    <form method="post" action="ecomm_checkout3.php">
      <div>
        <input type="submit" name="submit" value="Zpracovat objednávku"/>
        <input type="hidden" name="first_name"
          value="<?php echo htmlspecialchars($_POST['first_name']);?>"/>
        <input type="hidden" name="last_name"
          value="<?php echo htmlspecialchars($_POST['last_name']);?>"/>
        <input type="hidden" name="address_1"
          value="<?php echo htmlspecialchars($_POST['address_1']);?>"/>
        <input type="hidden" name="address_2"
          value="<?php echo htmlspecialchars($_POST['address_2']);?>"/>
        <input type="hidden" name="city"
          value="<?php echo htmlspecialchars($_POST['city']);?>"/>
        <input type="hidden" name="state"
          value="<?php echo htmlspecialchars($_POST['state']);?>"/>
        <input type="hidden" name="zip_code"
          value="<?php echo htmlspecialchars($_POST['zip_code']);?>"/>
        <input type="hidden" name="phone"
          value="<?php echo htmlspecialchars($_POST['phone']);?>"/>
        <input type="hidden" name="email"
          value="<?php echo htmlspecialchars($_POST['email']);?>"/>
        <input type="hidden" name="shipping_first_name" value=
          "<?php echo htmlspecialchars($_POST['shipping_first_name']);?>"/>
        <input type="hidden" name="shipping_last_name" value=
          "<?php echo htmlspecialchars($_POST['shipping_last_name']);?>"/>
        <input type="hidden" name="shipping_address_1" value=
          "<?php echo htmlspecialchars($_POST['shipping_address_1']);?>"/>
        <input type="hidden" name="shipping_address_2" value=
          "<?php echo htmlspecialchars($_POST['shipping_address_2']);?>"/>
        <input type="hidden" name="shipping_city" value=
          "<?php echo htmlspecialchars($_POST['shipping_city']);?>"/>
        <input type="hidden" name="shipping_state" value=
          "<?php echo htmlspecialchars($_POST['shipping_state']);?>"/>
        <input type="hidden" name="shipping_zip_code" value=
          "<?php echo htmlspecialchars($_POST['shipping_zip_code']);?>"/>
        <input type="hidden" name="shipping_phone" value=
          "<?php echo htmlspecialchars($_POST['shipping_phone']);?>"/>
        <input type="hidden" name="shipping_email" value=
          "<?php echo htmlspecialchars($_POST['shipping_email']);?>"/>
      </div>
    </form>
  </body>
</html>
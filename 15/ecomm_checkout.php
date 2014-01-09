<?php
session_start();
?>
<html>
  <body>
  <title>Pokladna - krok 1 ze 3</title>
  <style type="text/css">
    th { background-color: #999;}
    td { vertical-align: top; }
    .odd_row { background-color: #EEE; }
    .even_row { background-color: #FFF; }
  </style>
  <script type="text/javascript">

    window.onload = function() {
      // Nastavení schopnosti zaškrtávacímu políèku zmìnit viditelnost tabulky.
      var c = document.getElementById('same_info');
      c.onclick = toggle_shipping_visibility;
    }

    function toggle_shipping_visibility() {
      var c = document.getElementById('same_info');
      var t = document.getElementById('shipping_table');

      // Aktualizace zobrazení tabulky o dopravì.
      t.style.display = (c.checked) ? 'none' : '';
    }
  </script>
  </head>
  <body>
    <h1>Obchod pro fanoušky komiksù</h1>
    <h2>Vystavení objednávky</h2>
    <ol>
      <li><strong>Zadejte fakturaèní a doruèovací adresu</strong></li>
      <li>Ovìøte správnost údajù a odešlete objednávku</li>
      <li>Potvrzení objednávky a úètenka</li>
    </ol>
    <form method="post" action="ecomm_checkout2.php">
      <table>
        <tr>
          <td>
            <table>
              <tr>
                <th colspan="2">Fakturaèní adresa</th>
              </tr><tr>
                <td><label for="first_name">Jméno:</label></td>
                <td><input type="text" id="first_name" name="first_name"
                           size="20" maxlength="20"/></td>
              </tr><tr>
                <td><label for="last_name">Pøíjmení:</label></td>
                <td><input type="text" id="last_name" name="last_name"
                           size="20" maxlength="20"/></td>
              </tr><tr>
                <td><label for="address_1">Fakturaèní adresa:</label></td>
                <td><input type="text" id="address_1" name="address_1"
                           size="30" maxlength="50"/></td>
              </tr><tr>
                <td> </td>
                <td><input type="text" id="address_2" name="address_2"
                           size="30" maxlength="50"/></td>
              </tr><tr>
                <td><label for="city">Mìsto:</label></td>
                <td><input type="text" id="city" name="city" size="20"
                           maxlength="20"/></td>
              </tr><tr>
                <td><label for="state">Zemì:</label></td>
                <td><input type="text" id="state" name="state" size="2"
                           maxlength="2"/></td>
              </tr><tr>
                <td><label for="zip_code">PSÈ:</label></td>
                <td><input type="text" id="zip_code" name="zip_code" size="5"
                           maxlength="5"/></td>
              </tr><tr>
                <td><label for="phone">Telefon:</label></td>
                <td><input type="text" id="phone" name="phone" size="10"
                           maxlength="10"/></td>
              </tr><tr>
                <td><label for="email">Elektronická adresa:</label></td>
                <td><input type="text" id="email" name="email" size="30"
                             maxlength="100"/>
                </td>
              </tr><tr>
                <td colspan="2" style="text-align: center;">
                  <input type="checkbox" id="same_info" name="same_info"
                         checked="checked"/>
                  <label for="same_info">
                    Fakturaèní adresa je stejná jako adresa doruèovací
                  </label>
                </td>
              </tr>
            </table>
          </td>
          <td>
            <table id="shipping_table" style="display:none;">
              <tr>
                <th colspan="2">Doruèovací adresa</th>
              </tr><tr>
                <td><label for="shipping_first_name">Jméno:</label></td>
                <td><input type="text" id="shipping_first_name"
                           name="shipping_first_name" size="20"
                           maxlength="20"/></td>
              </tr><tr>
                <td><label for="shipping_last_name">Pøíjmení:</label></td>
                <td><input type="text" id="shipping_last_name"
                           name="shipping_last_name" size="20" maxlength="20"/>
                </td>
              </tr><tr>
                <td><label for="shipping_address_1">Doruèovací adresa:</label>
                </td>
                <td><input type="text" id="shipping_address_1" 
                           name="shipping_address_1" size="30" maxlength="50"/>
                </td>
              </tr><tr>
                <td> </td>
                <td><input type="text" id="shipping_address_2"
                           name="shipping_address_2"
                           size="30" maxlength="50"/></td>
              </tr><tr>
                <td><label for="shipping_city">Mìsto:</label></td>
                <td><input type="text" id="shipping_city" name="shipping_city" 
                           size="20" maxlength="20"/></td>
              </tr><tr>
                <td><label for="shipping_state">Zemì:</label></td>
                <td><input type="text" id="shipping_state" name="shipping_state" 
                           size="2" maxlength="2"/></td>
              </tr><tr>
                <td><label for="shipping_zip_code">PSÈ:</label></td>
                <td><input type="text" id="shipping_zip_code" 
                           name="shipping_zip_code" size="5" maxlength="5"/>
                </td>
              </tr><tr>
                <td><label for="shipping_phone">Telefon:</label></td>
                <td><input type="text" id="shipping_phone" name="shipping_phone"
                           size="10" maxlength="10"/></td>
              </tr><tr>
                <td><label for="shipping_email">Elektronická adresa:</label>
                </td>
                <td><input type="text" id="shipping_email"
                           name="shipping_email" size="30" maxlength="100"/>
                </td>
              </tr>
            </table>
          </td>
        </tr><tr>
        <td colspan="2">
          <input type="submit" value="Pokraèovat"/>
        </td>
        <tr>
      </table>
    </form>
  </body>
</html>
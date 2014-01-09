<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
?>
<html>
  <head>
    <title>Odeslání pohlednice</title>
    <script type="text/javascript">

      window.onload = function() {
        // Nastavení metody assign change_postcard_image() pro výbìr.
        var s = document.getElementById('postcard_select');
        s.onchange = change_postcard_image;
      }

      function change_postcard_image() {
        var s = document.getElementById('postcard_select');
        var i = document.getElementById('postcard');
        var x = s.options.selectedIndex;

        // Aktualizace atributù src a alt prvku img.
        i.src = s.options[x].value;
        i.alt = s.options[x].text;
      }
    </script>
  </head>
  <body>
    <h1>Odeslání pohlednice</h1>
    <form method="post" action="sendconfirm.php">
      <table>
        <tr>
          <td>Jméno odesílatele:</td>
          <td><input type="text" name="from_name" size="40" /></td>
        </tr><tr>
          <td>Adresa odesílatele:</td>
          <td><input type="text" name="from_email" size="40" /></td>
        </tr><tr>
          <td>Jméno pøíjemce:</td>
          <td><input type="text" name="to_name" size="40" /></td>
        </tr><tr>
          <td>Adresa pøíjemce:</td>
          <td><input type="text" name="to_email" size="40" /></td>
        </tr><tr>
          <td>Vyberte pohlednici:</td>
          <td><select id="postcard_select" name="postcard_select">
              <?php
              $query = 'SELECT image_url, description
                        FROM pc_image ORDER BY description';
              $result = mysql_query($query, $db) or die(mysql_error());

              $row = mysql_fetch_assoc($result);
              extract($row);

              mysql_data_seek($result, 0);
              while ($row = mysql_fetch_assoc($result)) {
                echo '<option value="' . $row['image_url'] . '">' . 
                  $row['description'] . '</option>';
              }
              mysql_free_result($result);
              ?>
            </select>
          </td>
        </tr><tr>
          <td colspan="2">
            <img name="postcard" id="postcard" src="<?php echo $image_url; ?>"
                 alt="<?php echo $description; ?>" />
          </td>
        </tr><tr>
          <td>Pøedmìt:</td>
          <td><input type="text" name="subject" size="80" /></td>
        </tr><tr>
          <td colspan="2">
            <textarea cols="76" rows="12"
                      name="message">Sem vložte text zprávy</textarea>
          </td>
        </tr><tr>
          <td colspan="2">
            <input type="submit" value="Odeslat" />
            <input type="reset" value="Obnovit formuláø" />
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
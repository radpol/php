<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se připojit. Zkontrolujte prosím připojení k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
?>
<html>
  <head>
    <title>Správa distribučních seznamů</title>
    <style type="text/css">
      td { vertical-align: top; }
    </style>
  </head>
  <body>
    <h1>Správa distribučních seznamů</h1>
    <form method="post" action="ml_admin_transact.php">
      <p><label for="listname">Přidat distribuční seznam:</label><br />
        <input type="text" id="listname" name="listname" maxlength="100" />
        <input type="submit" name="action" value="Přidat distribuční seznam" />
      </p>
      <?php
      $query = 'SELECT
                    ml_id, listname
                FROM
                    ml_lists
                ORDER BY
                    listname ASC';
      $result = mysql_query($query, $db) or die(mysql_error($db));

      if (mysql_num_rows($result) > 0) {
        echo '<p><label for="ml_id">Vymazat distribuční seznam:</label><br />';
        echo '<select name="ml_id" id="ml_id">';
        while ($row = mysql_fetch_array($result)) {
          echo '<option value="' . $row['ml_id'] . '">' . $row['listname'] .
            '</option>';
        }
        echo '</select>';
        echo '<input type="submit" name="action" value="Vymazat ' .
          'distribuční seznam" />';
        echo '</p>';
      }
      mysql_free_result($result);
      ?>
    </form>
    <p><a href="ml_quick_msg.php">Odeslat uživatelům rychlou zprávu.</a></p>
  </body>
</html>
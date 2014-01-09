<?php
require_once 'frm_header.inc.php';
?>
<script type="text/javascript">
  function delBBCode(id) {
    window.location = 'frm_transact_admin.php?action=odstranitZnacku&b=' + id;
  }
  function delForum(id) {
    window.location = 'frm_transact_affirm.php?action=odstranitForum&f=' + id;
  }
</script>
<?php
$sql = 'SELECT
            access_lvl, access_name
        FROM
            frm_access_levels
        ORDER BY
            access_lvl DESC';
$result = mysql_query($sql, $db) or die(mysql_error($db));

while ($row = mysql_fetch_array($result)) {
  $a_users[$row['access_lvl']] = $row['access_name'];
}

$menuoption = 'server';
if (isset($_GET['option'])) $menuoption = $_GET['option'];

$menuItems = array(
    'server' => 'Diskusní server',
    'uzivatele' => 'Uživatelé',
    'fora' => 'Diskusní fóra',
    'kody' => 'Formátovací kódy');
echo '<p>|';
foreach ($menuItems as $key => $value) {
  if ($menuoption != $key) {
    echo '<a href="' . $_SERVER['PHP_SELF'] . '?option=' . $key. '">';
  }
  echo ' ' . $value . ' ';
  if ($menuoption != $key) {
    echo '</a>';
  }
  echo '|';
}
echo '</p>';

switch ($menuoption) {
  case 'server':
    ?>
<h2>Správa diskusního serveru</h2>
<form method="post" action="frm_transact_admin.php">
  <table>
    <tr>
      <th>Popis</th>
      <th>Hodnota</th>
      <th>Parametr</th>
    </tr>
    <?php
    foreach ($admin as $key => $value) {
      echo '<tr>';
      echo '<td>' . $value['title'] . '</td>';
      echo '<td><input type="text" name="' . $key . '" value="' .
      $value['value'] . '" size="60" /></td>';
      echo '<td>' . $key . '</td>';
      echo '</tr>';
    }
    ?>
  </table>
  <p>
    <input type="submit" name="action" id="Aktualizovat" value="Aktualizovat" />
  </p>
</form>
<?php
break;

  case 'uzivatele':
    ?>
<h2>Správa uživatelù</h2>
<form action="frm_transact_admin.php" method="post">
  <div>
    <label for="userlist">Vyberte úèet, který chcete upravovat:</label>
    <select id="userlist" name="userlist[]">
      <?php
      foreach ($a_users as $key => $value) {
        echo '<optgroup label="' . $value . '">' . user_option_list($db, $key) .
             '</optgroup>';
      }
      ?>
    </select>
    <input type="submit" name="action" value="Upravit úèet"/>
  </div>
</form>
<?php
break;

  case 'fora':
    ?>
<h2>Správa diskusních fór</h2>
<table>
  <tr><th colspan="3">Fórum</th></tr>
  <?php
  $sql = 'SELECT
              id, forum_name, forum_desc
          FROM
              frm_forum';
  $result = mysql_query($sql, $db) or die(mysql_error($db));
  while ($row = mysql_fetch_array($result)) {
    echo '<tr>';
    echo '<td>' . $row['forum_name'] . '<br/>' . $row['forum_desc'] . '</td>';
    echo '<td><a href="frm_edit_forum.php?forum=' .$row['id'] .
         '">Upravit</a></td>';
    echo '<td><a href="#" onclick="delForum('. $row['id'] .
         '); return false;">Odstranit</a></td>';
    echo '</tr>';
  }
  ?>
</table>
<p><a href="frm_edit_forum.php">Vytvoøit nové fórum</a></p>
<?php
break;

  case 'kody':
    ?>
<h2>Správa formátovacích kódù</h2>
<form method="post" action="frm_transact_admin.php">
  <table>
    <tr>
      <th>Vzor</th>
      <th>Náhrada</th>
      <th>Akce</th>
    </tr>
    <?php
    if (isset($bbcode)) {
      foreach ($bbcode as $key => $value) {
        echo '<tr>';
        echo '<td><input type="text" name="bbcode_t' . $key . '" value="' .
             $value['template'] . '" size="32"/></td>';
        echo '<td><input type="text" name="bbcode_r' . $key . '" value="' .
             $value['replacement'] . '" size="32"/></td>';
        echo '<td><input type="button" name="action" id="DelBBCode" ' .
             'value="Odstranit" onclick="delBBCode(' . $key .
             '); return false;"/></td>';
        echo '</tr>';
      }
    }
    ?>
    <tr>
      <td><input type="text" name="bbcode-tnew" size="32"/></td>
      <td><input type="text" name="bbcode-rnew" size="32"/></td>
      <td><input type="submit" name="action" value="Pøidat kód"/></td>
    </tr>
  </table>
  <p><input type="submit" name="action"
            value="Aktualizovat formátovací kódy"/></p>
</form>
<?php
break;
}

require_once 'frm_footer.inc.php';
?>
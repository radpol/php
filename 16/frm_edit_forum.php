<?php
if (isset($_GET['forum'])) {
  $action = 'Upravit';
} else {
  $action = 'Pøidat';
}
$pageTitle = $action . ' fórum';
require_once 'frm_header.inc.php';

$forum = 0;
$fname = '';
$fdesc = '';
$fmod = '';
$userid = 0;

if (isset($_GET['forum'])) {
  $forum = $_GET['forum'];
  $sql = 'SELECT
              forum_name, forum_desc, u.name, u.id
          FROM
              frm_forum f LEFT JOIN frm_users u ON f.forum_moderator = u.id
          WHERE
              f.id = ' . $forum;
  $result = mysql_query($sql, $db) or die(mysql_error($db));
  if ($row = mysql_fetch_array($result)) {
    $fname = $row['forum_name'];
    $fdesc = $row['forum_desc'];
    $fmod = $row['name'];
    $userid = $row['id'];
  }
}
echo '<h2>' . $action . ' fórum</h2>';
?>
<form action="frm_transact_admin.php" method="post">
  <table>
    <tr>
      <th colspan="2">Nastavení diskusního fóra</th>
    </tr><tr>
      <td>Název</td>
      <td><input type="text" name="forumname" value="<?php echo $fname; ?>"/></td>
    </tr><tr>
      <td>Popis</td>
      <td><input type="text" name="forumdesc" size="75" value="<?php
                 echo $fdesc; ?>"/></td>
    </tr><tr>
      <td>Moderátor</td>
      <td><select id="moderator" name="forummod[]">
          <option value="0">...bez moderátora</option>
          <?php
          $sql = 'SELECT
                      id, name
                  FROM
                      frm_users
                  WHERE
                      access_lvl > 1';
          $result = mysql_query($sql, $db) or die(mysql_error($db));
          while ($row = mysql_fetch_array($result)) {
            echo '<option value="' . $row['id'] . '"';
            if ($userid == $row['id']) {
              echo ' selected="selected"';
            }
            echo '>' . $row['name'] . '</option>';
          }
          ?>
        </select>
      </td>
    </tr><tr>
      <td colspan="2">
        <input type="hidden" name="forum_id" value="<?php echo $forum; ?>" />
        <input type="submit" name="action"
               value="<?php echo $action; ?> fórum" />
      </td>
    </tr>
  </table>
</form>
<?php require_once 'frm_footer.inc.php'; ?>
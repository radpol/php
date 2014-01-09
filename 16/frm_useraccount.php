<?php
require_once 'frm_header.inc.php';

$userid = $username = $useremail = $password = $accesslvl = '';
$mode = 'Vytvoøit';
if (isset($_SESSION['user_id'])) {
  $userid = $_SESSION['user_id'];
  $mode = 'Upravit';
  if (isset($_GET['user'])) {
    if ($_SESSION['user_id'] == $_GET['user'] || $_SESSION['access_lvl'] > 2) {
      $userid = $_GET['user'];
      $mode = 'Zmìnit';
    }
  }
  $sql = 'SELECT
              name, email, access_lvl, signature
          FROM
              frm_users
          WHERE
              id = ' . $userid;
  $result = mysql_query($sql, $db) or die(mysql_error($db));

  $row = mysql_fetch_array($result);
  $username = $row['name'];
  $useremail = $row['email'];
  $accesslvl = $row['access_lvl'];
  $signature = $row['signature'];
}

echo '<h2>' . $mode  . ' úèet</h2>';
?>
<form method="post" action="frm_transact_user.php">
  <p>Jméno a pøíjmení:<br />
    <input type="text" name="name" maxlength="100"
         value="<?php echo htmlspecialchars($username); ?>"/></p>
  <p>Kontaktní adresa:<br />
    <input type="text" name="email" maxlength="255"
         value="<?php echo htmlspecialchars($useremail); ?>"/></p>
  <?php

  if ($mode == 'Zmìnit') {
    echo '<div><fieldset>';
    echo '  <legend>Úroveò oprávnìní</legend>';

    $sql = 'SELECT
                  access_lvl, access_name
              FROM
                  frm_access_levels
              ORDER BY
                  access_lvl DESC';
    $result = mysql_query($sql, $db) or die(mysql_error($db));

    while ($row = mysql_fetch_array($result)) {
      echo '<input type="radio" id="acl_' . $row['access_lvl'] .
           '" name="accesslvl" value="' . $row['access_lvl'] . '" ';
      if ($row['access_lvl'] == $accesslvl) {
        echo 'checked="checked"';
      }
      echo '/>' . $row['access_name'] . '<br/>';
    }
    echo '</fieldset></div>';
  }
  if ($mode != 'Zmìnit') {
    echo '<div id="passwords">';
  }
  if ($mode == 'Upravit') {
    if (isset($_GET['error']) && $_GET['error'] == 'heslonelzeupravovat') {
      echo '<strong>Heslo nelze zmìnit. Zkuste to znovu.</strong><br/>';
    }
    ?>
  <p>Pùvodní heslo:<br/>
  <input type="password" id="oldpasswd" name="oldpasswd" maxlength="50" /></p>
  <?php
}
if ($mode != 'Zmìnit') {
  ?>
  <p>Nové heslo:<br/>
  <input type="password" id="passwd" name="passwd" maxlength="50" /></p>
  <p>Ovìøení hesla:<br/>
  <input type="password" id="passwd2" name="passwd2" maxlength="50"/></p>
  <?php
}
if ($mode != 'Zmìnit') {
  echo '</div>';
}
if ($mode != 'Vytvoøit') {
  ?>
  <p>Podpis:<br/>
    <textarea name="signature" id="signature" cols="60" rows="5"><?php
      echo $signature; ?></textarea></p>
  <?php
}
?>
  <p><input type="submit" name="action" value="<?php echo $mode; ?> úèet"></p>
  <?php
  if ($mode == 'Upravit') {
    ?>
  <input type="hidden" name="accesslvl" value="<?php echo $accesslvl; ?>" />
  <?php
}
?>
  <input type="hidden" name="userid" value="<?php echo $userid; ?>"/>
</form>
<?php
require_once 'frm_footer.inc.php';
?>
<?php
require_once 'frm_header.inc.php';

$subject = '';
if (isset($_GET['topicid'])) {
  $topicid = $_GET['topicid'];
} else {
  $topicid = '';
}
if (isset($_GET['forumid'])) {
  $forumid = $_GET['forumid'];
} else {
  $forumid = '';
}
if (isset($_GET['reid'])) {
  $reid = $_GET['reid'];
}
$body = '';
$post = '';
$authorid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$edit_mode = FALSE;

if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['post']) && 
  $_GET['post']) {
  $edit_mode = TRUE;
}

if (!isset($_SESSION['user_id'])) {
  echo '<p><strong>Abyste mohli odesílat pøíspìvky, musíte být pøihlášeni. ' .
       '<a href=\"prihlasit.php\">Pøihlaste se</a> a teprve pak odešlete.' .
       ' zprávu</strong></p>';
} else if ($edit_mode && $_SESSION['user_id'] != $authorid) {
  echo '<p><strong>Nemáte oprávnìní k úpravám tohoto pøíspìvku. ' .
        'Kontaktujte prosím správce.</strong></p>';
} else {
  if ($edit_mode) {
    $sql = 'SELECT
                topic_id, forum_id, author_id, subject, body
            FROM
                frm_posts p JOIN frm_forum f ON p.forum_id = f.id
            WHERE p.id = ' . $_GET['post'];
    $result = mysql_query($sql, $db) or die(mysql_error($db));

    $row = mysql_fetch_array($result);

    $post = $_GET['post'];
    $topicid = $row['topic_id'];
    $forumid = $row['forum_id'];
    $authorid = $row['author_id'];
    $subject = $row['subject'];
    $body = $row['body'];
  } else {

    if ($topicid == '') {
      $topicid = 0;
      $topicname = 'Nová konverzace';
    } else {
      if ($reid != '') {
        $sql = 'SELECT
                    subject
                FROM
                    frm_posts
                WHERE
                    id = ' . $reid;
        $result = mysql_query($sql, $db) or die(mysql_error($db));
        if (mysql_num_rows($result) > 0) {
          $row = mysql_fetch_array($result);
          $re = preg_replace('/(re: )/i', '', $row['subject']);
        }
      }
      $sql = 'SELECT
                  subject
              FROM
                  frm_posts
              WHERE
                  id = ' . $topicid . ' AND topic_id = 0 AND
                  forum_id = ' . $forumid;
      $result = mysql_query($sql, $db) or die(mysql_error($db));
      if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $topicname = 'Odpovìdìt na <em>' . $row['subject'] . '</em>';
        $subject = ($re == '') ? '' : 'Re: ' . $re;
      } else {
        $topicname = 'Odpovìï';
        $topicid = 0;
      }
    }
  }

  if ($forumid == '' || $forumid == 0) {
    $forumid = 1;
  }
  $sql = 'SELECT
              forum_name
          FROM
              frm_forum
          WHERE id = ' . $forumid;
  $result = mysql_query($sql, $db) or die(mysql_error($db));
  $row = mysql_fetch_array($result);
  $forumname = $row['forum_name'];
  ?>

<h2><?php echo ($edit_mode) ? 'Upravit pøíspìvek' : $forumname . ': ' .
  $topicname; ?></h2>
<form method="post" action="frm_transact_post.php">
  <p>Pøedmìt:<br/>
    <input type="text" name="subject" maxlength="255"
         value="<?php echo $subject; ?>"/></p>
  <p>Zpráva:<br/>
  <textarea name="body" rows="10" cols="60"><?php echo $body; ?></textarea></p>
  <p><input type="submit" name="action" value="<?php
              echo ($edit_mode) ? 'Uložit zmìny' : 'Odeslat pøíspìvek'; ?>" />
    <input type="hidden" name="post" value="<?php echo $post; ?>">
    <input type="hidden" name="topic_id" value="<?php echo $topicid; ?>">
    <input type="hidden" name="forum_id" value="<?php echo $forumid; ?>">
  <input type="hidden" name="author_id" value="<?php echo $authorid; ?>"></p>
</form>
<?php
}
require_once 'frm_footer.inc.php';
?>
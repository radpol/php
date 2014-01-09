<?php
require 'frm_header.inc.php';
?>
<script type="text/javascript">
  function deletePost(id, redir) {
    if (id > 0) {
      window.location = 'frm_transact_post.php?action=odstranit&post=' +
        id + '&r=' + redir;
    } else {
      history.back();
    }
  }

  function deleteForum(id) {
    if (id > 0) {
      window.location = 'frm_transact_admin.php?action=odstranitForum&f=' + id;
    } else {
      history.back();
    }
  }
</script>
<?php
switch (strtoupper($_REQUEST['action'])) {
  case 'ODSTRANITPRISPEVEK':
    $sql = 'SELECT
                id, topic_id, forum_id, subject
            FROM
                frm_posts
            WHERE
                id = ' . $_REQUEST['id'];
    $result = mysql_query($sql, $db) or die(mysql_error($db));
    $row = mysql_fetch_array($result);
    if ($row['topic_id'] > 0) {
      $msg = 'Chcete opravdu vymazat pøíspìvek<br/>' .
        '<em>' . $row['subject'] . '</em>?';
      $redir = htmlspecialchars('frm_view_topic.php?t=' . $row['topic_id']);
    } else {
      $msg = 'Pokud vymažete tento pøíspìvek, budou vymazány rovnìž ' .
        'všechny odpovìdi. Chcete skuteènì vymazat celou konverzaci<br/>' .
        '<em>' . $row['subject'] . '</em>?';
      $redir = htmlspecialchars('frm_view_forum.php?f=' . $row['forum_id']);
    }
    echo '<div>';
    echo '<h2>Odstranit pøíspìvek?</h2>';
    echo '<p>' . $msg . '</p>';
    echo '<p><a href="#" onclick="deletePost(' . $row['id'] . ', \'' .
         $redir . '\'); return false;">Ano</a> ' .
         '<a href="#" onclick="history.back(); return false;">Ne</a></p>';
    echo '</div>';
    break;

  case 'ODSTRANITFORUM':
    $sql = 'SELECT
                forum_name
            FROM
                frm_forum
            WHERE
                id=' . $_REQUEST['f'];
    $result = mysql_query($sql, $db) or die(mysql_error($db));
    $row = mysql_fetch_array($result);
    echo '<div>';
    echo '<h2>Odstranit fórum?</h2>';
    echo '<p>Pokud odstraníte toto fórum, budou vymazány rovnìž všechny ' .
         'konverzace a pøíspìvky. Skuteènì chcete vymazat celé diskusní ' .
         'fórum<br/><em>' . $row['forum_name'] . '</em>?</p>';
    echo '<p><a href="#" onclick="deleteForum(' . $_REQUEST['f'] .
         '); return false;">Ano</a> <a href="#" ' .
         'onclick="history.back(); return false;">Ne</a></p>';
    echo '</div>';
  }
  require_once 'frm_footer.inc.php';
  ?>
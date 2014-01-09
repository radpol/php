<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
$token = (isset($_GET['token'])) ? $_GET['token'] : '';

$query = 'SELECT email_id, token, to_name, to_email, from_name, from_email,
    subject, postcard, message FROM pc_confirmation WHERE
    token = "' . $token . '"';
$result = mysql_query($query, $db) or die(mysql_error());

if (mysql_num_rows($result) == 0) {
  echo '<p>To je ale pøekvapení! Není co potvrzovat.</p>';
  mysql_free_result($result);
  exit;
} else {
  $row = mysql_fetch_assoc($result);
  extract($row);
  mysql_free_result($result);
}

$boundary = '==MP_Bound_xyccr948x==';

$headers = array();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: multipart/alternative; boundary="' . $boundary . '"';
$headers[] = 'From: ' . $from_email;

$postcard_message = '<html>';
$postcard_message .= '<p>Pozdravy pro uživatele ' . $to_name . '! ';
$postcard_message .= $from_name . ' vám dnes poslal pohlednici.</p>';
$postcard_message .= '<p>Mìjte se!</p>';
$postcard_message .= '<hr />';
$postcard_message .= '<img src="' . $postcard . '" alt="' . $description .
  ' "/><br/>';
$postcard_message .= $message;
$postcard_message .= '<hr/><p>Mùžete navštívit také ' .
  '<a href="http://localhost/php/11/viewpostcard.php?id=' . $email_id .
  '&token=' . $token .'">http://localhost/php/11/viewpostcard.php?id=' .
  $email_id . '&token=' . $token .
  '</a> a prohlédnout si pohlednici online.</p></html>';

$mail_message = 'To je vícedílná zpráva ve formátu MIME' . "\n";
$mail_message .= '--' . $boundary . "\n";
$mail_message .= 'Content-type: text/html; charset="windows-1250"' . "\n";
$mail_message .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
$mail_message .= $postcard_message . "\n";
$mail_message .= '--' . $boundary . "\n";
$mail_message .= 'Content-Type: text/plain; charset="windows-1250"' . "\n";
$mail_message .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
$mail_message .= strip_tags($postcard_message) . "\n";
$mail_message .= '--' . $boundary . '--' . "\n";
?>
<html>
  <head>
    <title>Pohlednice byla odeslána!</title>
  </head>
  <body>
    <?php
    $success = mail($to_email, $subject, $mail_message, join("\r\n", $headers));
    if ($success) {
      echo '<h1>Gratulujeme!</h1>';
      echo '<p>Uživateli ' . $to_name .
       ' jste odeslali následující pohlednici: <br/></p>';
      echo $postcard_message;
    } else {
      echo '<p><strong>Pøi pokusu o odeslání zprávy' .
        ' došlo k chybì.</strong></p>';
    }
    ?>
  </body>
</html>

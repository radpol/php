<?php
$to_address = $_POST['to_address'];
$from_address = $_POST['from_address'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$boundary = '==MP_Bound_xyccr948x==';

$headers = array();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: multipart/alternative; boundary="' . $boundary . '"';
$headers[] = 'From: ' . $from_address;

$msg_body = 'Toto je vícedílná zpráva ve formátu MIME.' . "\n";
$msg_body .= '--' . $boundary . "\n";
$msg_body .= 'Content-type: text/html; charset="windows-1250"' . "\n";
$msg_body .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
$msg_body .= $message . "\n";
$msg_body .= '--' . $boundary . "\n";
$msg_body .= 'Content-type: text/plain; charset="windows-1250"' . "\n";
$msg_body .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
$msg_body .= strip_tags($message) . "\n";
$msg_body .= '--' . $boundary . '--' . "\n";
?>
<html>
  <head>
    <title>Zpráva byla odeslána!</title>
  </head>
  <body>
    <?php
    $success = mail($to_address, $subject, $msg_body, join("\r\n", $headers));
    if ($success) {
      echo '<h1>Gratulujeme!</h1>';
      echo '<p>Byla odeslána následující zpráva: <br/><br/>';
      echo '<b>Komu:</b> ' . $to_address . '<br/>';
      echo '<b>Od:</b> ' . $from_address . '<br/>';
      echo '<b>Pøedmìt:</b> ' . $subject . '<br/>';
      echo '<b>Zpráva:</b></p>';
      echo nl2br($message);
    } else {
      echo '<p><strong>Pøi odesílání zprávy došlo k chybì.</strong></p>';
    }
    ?>
  </body>
</html>

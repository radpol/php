<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$to_name = $_POST['to_name'];
$to_email = $_POST['to_email'];
$from_name = $_POST['from_name'];
$from_email = $_POST['from_email'];
$postcard = $_POST['postcard'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$query = 'SELECT description FROM pc_image WHERE image_url = "' .
  $postcard . '"';
$result = mysql_query($query, $db) or die(mysql_error());

$description = '';
if (mysql_num_rows($result))
{
  $row = mysql_fetch_assoc($result);
  $description = $row['description'];
}
mysql_free_result($result);

$token = md5(time());

$query = 'INSERT INTO pc_confirmation 
           (email_id, token, to_name, to_email, from_name, from_email,
            subject, postcard, message)
          VALUES
           (NULL, "' . $token . '",  "' . $to_name . '",  "' . $to_email . '",
            "' . $from_name . '",  "' . $from_email . '",   "' . $subject . '",
            "' . $postcard . '",  "' . $message . '")';
mysql_query($query, $db) or die(mysql_error());

$email_id = mysql_insert_id($db);

$headers = array();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset="windows-1250"';
$headers[] = 'Content-Transfer-Encoding: 7bit';
$headers[] = 'From: no-reply@localhost';

$confirm_subject = 'Potvrïte prosím pohlednici [' . $subject .']';

$confirm_message = '<html>';
$confirm_message .= '<p>Pozdravy uživateli ' . $from_name . '. Pomocí ' .
  'následujícího odkazu potvrïte odeslání pohlednice.</p>';
$confirm_message .= '<p><a href="http://localhost/php/11/confirm.php?id=' .
  $email_id . '&token=' . $token .'">Klepnìte sem pro potvrzení</a></p>';
$confirm_message .= '<hr />';
$confirm_message .= '<img src="' . $postcard . '" alt="' . $description . 
    ' "/><br/>';
$confirm_message .= $message . '</html>';
?>
<html>
  <head>
    <title>Zpráva byla odeslána!</title>
  </head>
  <body>
    <?php
    $success = mail($from_email, $confirm_subject, $confirm_message,
      join("\r\n", $headers));

    if ($success) {
      echo '<h1>Nevyøízené potvrzení!</h1>';
      echo '<p>Uživateli ' . $from_email . ' byla odeslána žádost ' .
       'o potvrzení. Otevøete zprávu a klepnutím na pøíslušný odkaz ' .
       'potvrïte úmysl odeslat pohlednici uživateli ' . $to_name . '.</p>';
    } else {
      echo '<p><strong>Pøi odeslání potvrzení došlo k chybì.</strong></p>';
    }
    ?>
  </body>
</html>
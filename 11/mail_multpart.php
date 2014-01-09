<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

$message->setToAddress('p¯Ìjemce@priklad.cz');
$message->setFromAddress('odesÌlatel@priklad.cz');
$message->setCCAddress('p¯Ìtel@priklad.cz');
$message->setBCCAddress('tajnÈ@priklad.cz');
$message->setSubject('Test vÌcedÌlnÈ zpr·vy');
$message->setTextBody('Toto je Ë·st zpr·vy jako prost˝ text!');
$message->setHTMLBody('<html><p>To je Ë·st zpr·vy ve form·tu <b>HTML</b>!
  </p></html>');

if ($message->send()) {
  echo 'Zpr·va byla ˙spÏönÏ odesl·na!';
} else {
  echo 'Odesl·nÌ zpr·vy se nezda¯ilo!';
}
?>
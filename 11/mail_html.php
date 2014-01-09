<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

$message->setSendText(false);
$message->setToAddress('pøíjemce@priklad.cz');
$message->setSubject('Testování zpráv ve formátu HTML');
$message->setHTMLBody('<html><p>Toto je test pomocí <b>jazyka HTML</b>!
  </p></html>');

if ($message->send()) {
  echo 'Zpráva byla úspìšnì odeslána!';
} else {
  echo 'Odeslání zprávy se nezdaøilo!';
}
?>
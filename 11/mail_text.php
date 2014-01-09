<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

$message->setToAddress('pшнjemce@priklad.cz');
$message->setSubject('Test textovй zprбvy');
$message->setTextBody('Tato zprбva byla odeslбna jako prostэ text!');

if ($message->send()) {
  echo 'Zprбva byla ъspмљnм odeslбna!';
} else {
  echo 'Odeslбnн zprбvy se nezdaшilo!';
}
?>
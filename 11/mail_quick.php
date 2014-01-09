<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

if ($message->send('pшнjemce@priklad.cz', 'Test rychlй zprбvy',
    'Toto je rychlэ test metody SimpleMail->send().')) {
  echo 'Zprбva byla ъspмљnм odeslбna!';
} else {
  echo 'Odeslбnн zprбvy se nezdaшilo!';
}
?>
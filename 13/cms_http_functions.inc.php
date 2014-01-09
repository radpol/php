<?php
function redirect($url) {
  if (!headers_sent()) {
    header('Location: ' . $url);
  } else {
    die('Pøesmìrování nelze dokonèit; Výstup již byl odeslán.');
  }
}
?>
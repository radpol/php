<html>
<head>
<title>Kontrola e-mailové adresy</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
</head>
<body>
<?php
$mail = $_POST['mail'];
if (ereg('^[^@]@[^@]+[.][a-zA-Z]+$', $mail))
  echo 'E-mailová adresa je zadána správně';
else
  echo 'E-mailová adresa není zadána správně';
?>
<br /><br />
<a href="3.php">Zkontrolovat další mail</a>
</body>

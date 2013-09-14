<html>
<head>
<title>Odeslání zprávy</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  $zprava = $_POST['zprava'];
  $email = 'vase.adresa@neco.cz';
  $vysledek = mail($email, 'Mail z WWW', $zprava);
  if ($vysledek)
    echo 'Zpráva byla úspěšně odeslána';
  else
    echo 'Zpráva nebyla odeslána, nastala chyba';
?>
</body>
</html>

<html>
<head>
<title>Odeslání mailů</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  $email = 'vase.adresa@neco.cz';
  $vysledek = mail($email, 'Předmět mailu', 'Text mailu');
  if ($vysledek)
    echo 'Mail úspěšně odeslán';
  else
    echo 'Mail nebyl odeslán, nastala chyba';
?>
</body>
</html>
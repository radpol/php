<html>
<head>
<title>Odeslání více příjemcům</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  $email = 'prvni.adresa@neco.cz,druha.adresa@neco.cz';
  $vysledek = mail($email, 'Předmět mailu',  
    "Řádek 1\nŘádek 2\nŘádek 3");
  if ($vysledek)
    echo 'Mail úspěšně odeslán';
  else
    echo 'Mail nebyl odeslán, nastala chyba';
?>
</body>
</html>

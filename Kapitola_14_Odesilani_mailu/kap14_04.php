<html>
<head>
<title>Nastavení odesílatele mailu</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  $email = 'vase.adresa@neco.cz';
  $hlavicky  = "From:janosik@neco.cz\n";
  $vysledek = mail($email, 'Předmět mailu',  "Text mailu", $hlavicky);
  if ($vysledek)
    echo 'Mail úspěšně odeslán';
  else
    echo 'Mail nebyl odeslán, nastala chyba';
?>
</body>
</html>

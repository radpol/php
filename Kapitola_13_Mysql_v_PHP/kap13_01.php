<html>
<head>
<title>Připojení k databázi</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php 
 
$db_spojeni = mysqli_connect
  ('localhost', 'root', 'lokomotiva', 'test', 3306);
// Tady jsme se pokusili připojit k MySQL.
// Pro připojení se použije:
//    databázový server MySQL sídlí na adrese localhost
//    přihlašovací jméno je root
//    heslo je lokomotiva
//    budeme pracovat s databází nazvanou test
//    databázový server sídlí na portu číslo 3306
 
if ($db_spojeni)
  echo 'Připojení se podařilo';
else
  echo 'Připojení se nepodařilo, sorry';
 
?>
</body>
</html>


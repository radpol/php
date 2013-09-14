<?php
  session_start();
?>
<html>
<head>
<title>Ukázka práce se session</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
  if (isset($_SESSION['cislo']))
    echo 'Session už obsahuje proměnnou cislo = ', $_SESSION['cislo'];
  else
  {
    $_SESSION['cislo'] = 333;
    echo 'Do session byla uložena nová proměnná cislo';
  }
?>
</body>
</html>

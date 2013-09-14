<html>
<head>
<title>Informace o figuře</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
</head>
<body>
<?php
 
$vaha = $_POST['vaha'];
$vyska = $_POST['vyska'];
 
$vyska_v_metrech = $vyska / 100.0;

$BMI = $vaha / ($vyska_v_metrech * $vyska_v_metrech);
 
echo 'Vaše BMI = ', $BMI;
echo '<br /><br />';
 
if ($BMI < 15)
  echo 'Jste podvyživený/á';
else if ($BMI < 18.5)
  echo 'Máte podváhu';
else if ($BMI < 25)
  echo 'Máte ideální postavu';
else if ($BMI < 30)
  echo 'Máte nadáhu';
else if ($BMI < 40)
  echo 'Jste obézní';
else
  echo 'Jste nadměrně obézní';
 
?>
</body>
</html>

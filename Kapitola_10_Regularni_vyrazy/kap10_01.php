<html>
<head>
<title>Tester regulárních výrazù</title>
<meta http-equiv="Content-Type"
  content="text/html; charset=windows-1250" />
<style type="text/css"><!--
  .zaver { font-size:120%; color:#000080; }
  .vyhovuje { background-color:#E0E0E0; color:#FF4040; }
--></style>
</head>
<body>
<h1>Tester regulárních výrazù</h1>
<?php
$reg_vyraz = '';
$text = '';
if (isset($_POST['reg_vyraz']))
  $reg_vyraz = $_POST['reg_vyraz'];
if (isset($_POST['text']))
  $text = $_POST['text'];
?>
<form action="" method="post">
<b>Regulární výraz:</b>
<input type="text" name="reg_vyraz" 
  value="<?php echo htmlspecialchars($reg_vyraz); ?>" />
<br /><br />
<b>Text:</b>
<input type="text" name="text"
  value="<?php echo htmlspecialchars($text); ?>" />
<br /><br />
<input type="submit" 
  value="Porovnat text vùèi regulárnímu výrazu" />
<br /><br />
</form>
<b class="zaver">
<?php
if (@ereg($reg_vyraz, $text, $pole_vysledku))
  echo 'Regulárnímu výrazu vyhovuje: <span class="vyhovuje">',
    htmlspecialchars($pole_vysledku[0]),
    '</span>.';
else
  echo 'Text nevyhovuje regulárnímu výrazu.';
?>
</b>
</body>
</html>


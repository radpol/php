<?php
session_start();
$_SESSION['username'] = $_POST['user'];
$_SESSION['userpass'] = $_POST['pass'];
$_SESSION['authuser'] = 0;

// ovìø uživatelské jméno a heslo 
if ( ( $_SESSION['username'] == 'Petr' ) and
  ($_SESSION['userpass'] == '12345' ) )  {
  $_SESSION['authuser'] = 1;
} else {
  echo "Bohužel nemáte dostateèná oprávnìní k prohlížení této stránky!";
  exit();
}
?>
<html>
  <head>
    <title>Najít oblíbený film!</title>
  </head>
  <body>
    <?php include "header.php"; ?>
    <?php
    $oblíbenýfilm = urlencode('Život Briana');
    echo "<a href=\"moviesite.php?oblfilm=$oblíbenýfilm\">";
    echo 'Další informace o mém oblíbeném filmu!';
    echo '</a>';
    ?>
    <br />
    <br />
    Nebo vyberte, kolik filmù byste chtìli vidìt:
    <br />
    <form method="post" action="moviesite.php">
      <p>Zadejte poèet filmù (maximálnì 10):
        <input type="text" name="pocet" maxlength="2" size="2">
        <br/>
        Toto políèko zakrtnìte, chcete-li zobrazit setøídìný seznam:
        <input type="checkbox" name="seradit">
      </p>
      <input type="submit" name="Submit" value="Odeslat">
    </form>
  </body>
</html>

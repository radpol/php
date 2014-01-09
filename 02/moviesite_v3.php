<html>
  <head>
    <title>Filmový web – <?php echo $_GET['oblfilm']; ?></title>
  </head>
  <body>
    <?php
      // odstraòte tento øádek: define('OBLFILM','Život Briana');
      echo 'Mým oblíbeným filmem je ';
      echo $_GET['oblfilm'];
      echo '<br />';
      $hodnocení = 5;
      echo 'Tento film hodnotím známkou: ';
      echo $hodnocení;
    ?>
  </body>
</html>

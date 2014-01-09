<html>
  <head>
    <title>Uveïte jméno</title>
  </head>
  <body>
    <?php
    echo '<h1>Zdravíme uživatele ' . $_POST['jmeno'] . '!</h1>';
    ?>
    <pre>
<strong>DEBUG:</strong>
<?php
print_r($_POST);
?>
    </pre>
  </body>
</html>

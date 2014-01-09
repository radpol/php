<?php
// Nezapomeòte se pøesvìdèit, že pøi pøidávání filmù je vybrán také žánr.
// Není-li, pøesmìrujte uživatele zpìt na stránku s formuláøem.
if ($_POST['submit'] == 'Pøidat') {
  if ($_POST['type'] == 'movie' && $_POST['movie_type'] == '') {
    header('Location: form4.php');
  }
}
?>
<html>
  <head>
    <title>Víceúèelový formuláø</title>
    <style type="text/css">
      <!--
      td {vertical-align: top;}
      -->
    </style>
  </head>
  <body>
    <?php
    // Zobrazit formuláø k získání dalších informací,
    // pokud uživatel vkládá nový záznam
    if ($_POST['submit'] == 'Pøidat') {
      echo '<h1>Pøidat ';
      if ($_POST['type'] == "movie")
      {
        echo ucfirst("film");
      }
      else
      {
        echo ucfirst(($_POST['type'] == 'actor') ? 'herce' : 'režiséra');
      }
      echo '</h1>';
      ?>
    <form action="form4b.php" method="post">
      <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>"/>
      <table>
        <tr>
          <td><?php
            echo ucfirst(($_POST['type'] == 'movie') ? 'Název' : 'Jméno');?>
          </td>

          <td>
            <?php echo $_POST['name']; ?>
            <input type="hidden" name="name"
             value="<?php echo $_POST['name']; ?>"/>
          </td>
        </tr>
        <?php
        if ($_POST['type'] == 'movie') {
          ?>
        <tr>
          <td>Žánr</td>
          <td>
            <?php echo $_POST['movie_type']; ?>
            <input type="hidden" name="movie_type"
                   value="<?php echo $_POST['movie_type']; ?>"/>
          </td>
        </tr><tr>
          <td>Rok</td>
          <td><input type="text" name="year" /></td>
        </tr><tr>
          <td>Popis filmu</td>
          <?php
        } else {
          echo '<tr><td>Životopis</td>';
        }
        ?>
          <td><textarea name="extra" rows="5" cols="60"></textarea></td>
        </tr><tr>
          <td colspan="2" style="text-align: center;">
            <?php
            if (isset($_POST['debug'])) {
              echo '<input type="hidden" name="debug" value="on" />';
            }
            ?>
            <input type="submit" name="submit" value="Pøidat" />
          </td>
        </tr>
      </table>
    </form>
    <?php
    // Uživatel pouze hledá informace...
  } else if ($_POST['submit'] == 'Vyhledat') {
    echo '<h1>Vyhledat ';
    if ($_POST['type'] == "movie")
    {
      echo ucfirst("film");
    }
    else
    {
      echo ucfirst(($_POST['type'] == 'actor') ? 'herce' : 'režiséra');
    }
    echo '</h1>';
    echo '<p>Vyhledává se ' . $_POST['name'] . '...</p>';
  }

  if (isset($_POST['debug'])) {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
  }
  ?>
  </body>
</html>
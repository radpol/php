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
    if ($_POST['type'] == 'movie') {
      echo '<h1>Nový film v žánru ' . ucfirst($_POST['movie_type']) . ': ';
    } else {
      echo '<h1>Nový ';
      echo ($_POST['type'] == 'actor') ? 'herec' : 'film';
      echo ': ';
    }
    echo $_POST['name'] . '</h1>';

    echo '<table>';
    if ($_POST['type'] == 'movie') {
      echo '<tr>';
      echo '<td>Rok</td>';
      echo '<td>' . $_POST['year'] . '</td>';
      echo '</tr><tr>';
      echo '<td>Popis filmu</td>';
    } else {
      echo '<tr><td>Životopis</td>';
    }
    echo '<td>' . nl2br($_POST['extra']) . '</td>';
    echo '</tr>';
    echo '</table>';

    if (isset($_POST['debug'])) {
      echo '<pre>';
      print_r($_POST);
      echo '</pre>';
    }
    ?>
  </body>
</html>
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
    <form action="form4a.php" method="post">
      <table>
        <tr>
          <td>Název nebo jméno</td>
          <td><input type="text" name="name" /></td>
        </tr><tr>
          <td>Typ záznamu</td>
          <td>
            <input type="radio" name="type" value="movie" checked="checked" />
             Film<br/>
            <input type="radio" name="type" value="actor" /> Herec<br/>
            <input type="radio" name="type" value="director"/> Režisér<br/>
          </td>
        </tr><tr>
          <td>Filmový žánr<br/><small>(hodí-li se)</small></td>
          <td>
            <select name="movie_type">
              <option value="">Vyberte žánr...</option>
              <option value="Action">Akèní</option>
              <option value="Drama">Drama</option>
              <option value="Comedy">Komedie</option>
              <option value="Sci-Fi">Sci-Fi</option>
              <option value="War">Váleèný</option>
              <option value="Other">Jiný...</option>
            </select>
          </td>
        </tr><tr>
          <td> </td>
          <td><input type="checkbox" name="debug" checked="checked" />
            Zobrazit ladicí informace
          </td>
        </tr><tr>
          <td colspan="2" style="text-align: center;">
            <input type="submit" name="submit" value="Vyhledat" />
            <input type="submit" name="submit" value="Pøidat" />
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
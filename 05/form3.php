<html>
  <head>
    <title>Pøidávání a vyhledávání</title>
    <style type="text/css">
      <!--
      td {vertical-align: top;}
      -->
    </style>
  </head>
  <body>
    <form action="zpracovat3.php" method="post">
      <table>
        <tr>
          <td>Název nebo jméno</td>
          <td><input type="text" name="name"/></td>
        </tr><tr>
          <td>Žánr</td>
          <td>
            <select name="movie_type">
              <option value="">Vyberte žánr...</option>
              <option value="akèní">Akèní</option>
              <option value="dramatický">Drama</option>
              <option value="komediální">Komedie</option>
              <option value="Sci-Fi">Sci-Fi</option>
              <option value="váleèný">Váleèný</option>
              <option value="nezaøazený">Jiný...</option>
            </select>
          </td>
        </tr><tr>
          <td>Typ záznamu</td>
          <td>
            <input type="radio" name="type" value="movie" checked="checked" />
              Film<br/>
            <input type="radio" name="type" value="actor" /> Herec<br/>
            <input type="radio" name="type" value="director"/> Režisér<br/>
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
<html>
  <head>
    <title>Odeslání pohlednice</title>
    <style type="text/css">
     td { vertical-align: top; }
    </style>
  </head>
  <body>
    <form method="post" action="sendmail.php">
      <table>
        <tr>
          <td>Komu:</td>
          <td><input type="text" name="to_address" size="40"/></td>
        </tr><tr>
          <td>Od:</td>
          <td><input type="text" name="from_address" size="40"/></td>
        </tr><tr>
          <td>Pøedmìt:</td>
          <td><input type="text" name="subject" size="40"/></td>
        </tr><tr>
          <td valign="top">Zpráva:</td>
          <td>
            <textarea cols="60" rows="10"
              name="message">Sem vložte text zprávy.</textarea>
          </td>
        </tr><tr>
          <td></td>
          <td>
            <input type="submit" value="Odeslat"/>
            <input type="reset" value="Vyprázdnit"/>
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>

<?php include 'frm_header.inc.php'; ?>
<h1>Pøihlášení registrovaného uživatele</h1>
<form method="post" action="frm_transact_user.php">
  <table>
    <tr>
      <td><label for="email">Elektronická adresa:</label></td>
      <td><input type="text" id="email" name="email" maxlength="100"/></td>
    </tr><tr>
      <td><label for="passwd">Heslo:</label></td>
      <td><input type="password" id="passwd" name="passwd" maxlength="20"/></td>
    </tr><tr>
      <td> </td>
      <td><input type="submit" class="submit" name="action" value="Pøihlásit"/>
      </td>
    </tr>
  </table>
</form>
<p>Nemáte úèet na našem serveru?
<a href="frm_useraccount.php">Založte si ho!</a></p>
<p><a href="frm_forgot_pass.php">Získat zapomenuté heslo</a></p>
<?php include 'frm_footer.inc.php'; ?>
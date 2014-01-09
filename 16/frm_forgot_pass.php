<?php include 'frm_header.inc.php'; ?>
<h2>Pøipomenutí zapomenutého hesla</h2>
<p>Pokud jste zapomnìli heslo nebo je systém odmítá, zadejte prosím
svou elektronickou adresu, na kterou vám je budeme moci zaslat!</p>
<form method="post" action="frm_transact_user.php">
  <div>
    <label for="email">Kontaktní email:</label>
    <input type="text" id="email" name="email" maxlength="100"/>
    <input type="submit" name="action" value="Pøipomenout heslo"/>
  </div>
</form>
<?php include 'frm_footer.inc.php'; ?>
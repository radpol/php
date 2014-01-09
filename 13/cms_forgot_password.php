<?php include 'cms_header.inc.php'; ?>
<h1>Pøipomenutí zapomenutého hesla</h1>
<p>Zapomnìli jste heslo? Zadejte adresu a my vám zašleme nové!</p>
<form method="post" action="cms_transact_user.php">
 <div>
  <label for="email">Elektronická adresa:</label>
  <input type="text" id="email" name="email" maxlength="100"/>
  <input type="submit" name="action" value="Nové heslo!"/>
 </div>
</form>
<?php include 'cms_footer.inc.php'; ?>
<?php session_start(); ?>
<html>
  <head>
    <title>Redakèní systém</title>
    <style type="text/css">
      td { vertical-align: top; }
    </style>
  </head>
  <body>
    <h1>Web pro fanoušky komiksù</h1>
    <?php
    if (isset($_SESSION['name'])) {
      echo '<p>Jste pøihlášeni jako: ' . $_SESSION['name'] . ' </p>';
    }
    ?>
    <div id="navright">
      <form method="get" action="cms_search.php">
        <div>
          <label for="search">Hledat</label>
          <?php
          echo '<input type="text" id="search" name="search" ';
          if (isset($_GET['keywords'])) {
            echo ' value="' . htmlspecialchars($_GET['keywords']) . '" ';
          }
          echo '/>';
          ?>
          <input type="submit" value="Hledat" />
        </div>
      </form>
    </div>
    <div id='navigation'>
      <a href="cms_index.php">Èlánky</a>
      <?php
      if (isset($_SESSION['user_id'])) {
        echo ' | <a href="cms_compose.php">Napsat</a>';
        if ($_SESSION['access_level'] > 1) {
          echo ' | <a href="cms_pending.php">Redakce</a>';
        }
        if ($_SESSION['access_level'] > 2) {
          echo ' | <a href="cms_admin.php">Správa</a>';
        }
        echo ' | <a href="cms_cpanel.php">Ovládací panel</a>';
        echo ' | <a href="cms_transact_user.php?action=Odhlásit">Odhlásit</a>';
      } else {
        echo ' | <a href="cms_login.php">Pøihlásit</a>';
      }
      ?>
    </div>
    <div id="articles">

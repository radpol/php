<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se pøipojit. Zkontrolujte prosím pøipojení k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

switch ($_POST['action']) {

  case 'Pøidat postavu':

    // Ošetøení pøijatých hodnot v zájmu ochrany databáze.
    $alias = mysql_real_escape_string($_POST['alias'], $db);
    $real_name = mysql_real_escape_string($_POST['real_name'], $db);
    $address = mysql_real_escape_string($_POST['address'], $db);
    $city = mysql_real_escape_string($_POST['city'], $db);
    $state = mysql_real_escape_string($_POST['state'], $db);
    $zipcode_id = mysql_real_escape_string($_POST['zipcode_id'], $db);
    $alignment = ($_POST['alignment'] == 'dobro') ? 'dobro' : 'zlo';

    // Nyní mùžeme pøidat postavu do databáze.
    $query = 'INSERT IGNORE INTO comic_zipcode
                (zipcode_id, city, state)
              VALUES
                ("' . $zipcode_id . '", "' . $city . '", "' . $state . '")';
    mysql_query($query, $db) or die (mysql_error($db));

    $query = 'INSERT INTO comic_lair
                (lair_id, zipcode_id, address)
              VALUES
                (NULL, "' . $zipcode_id . '", "' . $address . '")';
    mysql_query($query, $db) or die (mysql_error($db));

    // Naètení automaticky generovaného ID doupìte.
    $lair_id = mysql_insert_id($db);
    $query = 'INSERT INTO comic_character
                (character_id, alias, real_name, lair_id, alignment)
              VALUES
                (NULL, "' . $alias . '", "' . $real_name . '", ' .
    $lair_id . ', "' . $alignment . '")';
    mysql_query($query, $db) or die (mysql_error($db));

    // Naètení automaticky generovaného ID postavy.
    $character_id = mysql_insert_id($db);
    if (!empty($_POST['powers'])) {
      $values = array();
      foreach ($_POST['powers'] as $power_id) {
        $values[] = sprintf('(%d, %d)', $character_id, $power_id);
      }
      $query = 'INSERT IGNORE INTO comic_character_power
                  (character_id, power_id)
                VALUES ' . implode(',', $values);
      mysql_query($query, $db) or die (mysql_error($db));
    }

    if (!empty($_POST['rivalries'])) {
      $values = array();
      foreach ($_POST['rivalries'] as $rival_id) {
        $values[] = sprintf('(%d, %d)', $character_id, $rival_id);
      }

      // Pøíslušnost k stranì dobra nebo zla ovlivní poøadí sloupcù.
      $columns = ($alignment = 'dobro') ? '(hero_id, villain_id)' :
        '(villain_id, hero_id)';

      $query = 'INSERT IGNORE INTO comic_rivalry
                  ' . $columns . '
                VALUES
                  ' . implode(',', $values);
      mysql_query($query, $db) or die (mysql_error($db));
    }

    $redirect = 'list_characters.php';
    break;

  case 'Vymazat postavu':

    // Pro jistotu ovìøíme, zda ID postavy je èíslo.
    $character_id = (int)$_POST['character_id'];

    // Odstranìní všech informací o postavì z databáze.
    $query = 'DELETE FROM c, l
              USING
                comic_character c, comic_lair l
              WHERE
                c.lair_id = l.lair_id AND
                c.character_id = ' . $character_id;
    mysql_query($query, $db) or die (mysql_error($db));

    $query = 'DELETE FROM comic_character_power
              WHERE
                character_id = ' .  $character_id;
    mysql_query($query, $db) or die (mysql_error($db));

    $query = 'DELETE FROM comic_rivalry
              WHERE
                hero_id = ' . $character_id .
               ' OR villain_id = ' . $character_id;
    mysql_query($query, $db) or die (mysql_error($db));

    $redirect = 'list_characters.php';
    break;

  case 'Upravit postavu':

    // Ošetøení pøijatých hodnot v zájmu ochrany databáze.
    $character_id = (int)$_POST['character_id'];
    $alias = mysql_real_escape_string($_POST['alias'], $db);
    $real_name = mysql_real_escape_string($_POST['real_name'], $db);
    $address = mysql_real_escape_string($_POST['address'], $db);
    $city = mysql_real_escape_string($_POST['city'], $db);
    $state = mysql_real_escape_string($_POST['state'], $db);
    $zipcode_id = mysql_real_escape_string($_POST['zipcode_id'], $db);
    $alignment = ($_POST['alignment'] == 'dobro') ? 'dobro' : 'zlo';

    // Nyní mùžeme upravit informace o postavì v databázi.
    $query = 'INSERT IGNORE INTO comic_zipcode
                (zipcode_id, city, state)
              VALUES
                ("' . $zipcode_id . '", "' . $city . '", "' . $state . '")';
    mysql_query($query, $db) or die (mysql_error($db));

    $query = 'UPDATE comic_lair l, comic_character c
              SET
                l.zipcode_id = ' . $zipcode_id . ',
                l.address = "' . $address . '",
                c.real_name = "' . $real_name . '",
                c.alias = "' . $alias . '",
                c.alignment = "' . $alignment . '"
              WHERE
                c.character_id = ' . $character_id . ' AND
                c.lair_id = l.lair_id';
    mysql_query($query, $db) or die (mysql_error($db));

    $query = 'DELETE FROM comic_character_power
              WHERE
                character_id = ' . $character_id;
    mysql_query($query, $db) or die (mysql_error($db));

    if (!empty($_POST['powers'])) {
      $values = array();
      foreach ($_POST['powers'] as $power_id) {
        $values[] = sprintf('(%d, %d)', $character_id, $power_id);
      }
      $query = 'INSERT IGNORE INTO comic_character_power
                  (character_id, power_id)
                VALUES
                  ' . implode(',', $values);
      mysql_query($query, $db) or die (mysql_error($db));
    }

    $query = 'DELETE FROM comic_rivalry
              WHERE
                hero_id = ' . $character_id .
                ' OR villain_id = ' . $character_id;
    mysql_query($query, $db) or die (mysql_error($db));

    if (!empty($_POST['rivalries'])) {
      $values = array();
      foreach ($_POST['rivalries'] as $rival_id) {
        $values[] = sprintf('(%d, %d)', $character_id, $rival_id);
      }

      // Pøíslušnost k stranì dobra nebo zla ovlivní poøadí sloupcù.
      $columns = ($alignment = 'dobro') ? '(hero_id, villain_id)' :
        '(villain_id, hero_id)';

      $query = 'INSERT IGNORE INTO comic_rivalry
                  ' . $columns . '
                VALUES
                  ' . implode(',', $values);

      mysql_query($query, $db) or die (mysql_error($db));
    }

    $redirect = 'list_characters.php';
    break;

  case 'Odstranit vybrané schopnosti':

    if (!empty($_POST['powers'])) {
      // Ošetøení pøijatých hodnot v zájmu ochrany databáze.
      // Mìla by to být pouze èísla.
      $powers = implode(',', $_POST['powers']);
      $powers = mysql_real_escape_string($powers, $db);

      // Odstranìní schopností.
      $query = 'DELETE FROM comic_power
                WHERE
                  power_id IN (' . $powers . ')';
      mysql_query($query, $db) or die (mysql_error($db));

      $query = 'DELETE FROM comic_character_power
                WHERE
                  power_id IN (' . $powers . ')';
      mysql_query($query, $db) or die (mysql_error($db));
    }

    $redirect = 'edit_power.php';
    break;

  case 'Pøidat novou schopnost':

    // Odstranit vedoucí a koncové mezery, abychom mìli jistotu,
    // že uživatel nechce pøidat prázdné honoty.
    $power = trim($_POST['new_power']);
    if ($power != '')
    {
      // Ošetøení pøijatých hodnot v zájmu ochrany databáze.
      $power = mysql_real_escape_string($power, $db);

      // Vytvoøení nové schopnosti.
      $query = 'INSERT IGNORE INTO comic_power
                  (power_id, power)
                VALUES
                  (NULL, "' . $power . '")';
      mysql_query($query, $db) or die (mysql_error($db));
    }

    $redirect = 'edit_power.php';
    break;

  default:
    $redirect = 'list_characters.php';
  }

header('Location: ' . $redirect);
?>
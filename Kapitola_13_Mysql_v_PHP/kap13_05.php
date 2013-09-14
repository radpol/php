<?php 
 
// Pøipojení k databázi.
$db_spojeni = mysqli_connect
  ('localhost', 'root', 'lokomotiva', 'test', 3306);
 
// Otestování, zda se pøipojení podaøilo.
if (!$db_spojeni)
  die('Pøipojení se nepodaøilo');
 
// Zaslání SQL pøíkazu do databáze.
$objekt_vysledku = mysqli_query($db_spojeni, 'SELECT * FROM osoby');
 
// Otestování, zda se zaslání SQL pøíkazu podaøilo.
if (!$objekt_vysledku)
  die('Chyba zaslání SQL pøíkazu')
 
// Získání prvního øádku, tedy osoby.
$prvni_radek = mysqli_fetch_array($objekt_vysledku);
 
// Zobrazení prvního øádku dat.
var_dump($prvni_radek);
 
?>


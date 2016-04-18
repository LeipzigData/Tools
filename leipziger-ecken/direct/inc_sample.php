<?php

  /* Kopiere diese Datei nach inc.php und adjustiere die Zugangsdaten zu den
     Datenbanken. */

function getConnection() {
  $verbindung=mysqli_connect("localhost","dbuser","dbpass","dbname") or 
    die ("Keine Verbindung m&ouml;glich. Benutzername oder Passwort sind falsch.");
  mysql_set_charset('utf8',$verbindung); 
  return $verbindung;
}


?>

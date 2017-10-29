<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getAdressen() {
  $out='';
  $out.="# -------- Users --------- #\n\n";
  $query='SELECT * FROM users';
  $res = db_query($query);
  foreach ($res as $row) {
    $out.=createAdresse($row);
  }
  $out.="# -------- Actions --------- #\n\n";
  $query='SELECT * FROM actions';
  $res = db_query($query);
  foreach ($res as $row) {
    $out.=createAdresse($row);
  }
  $out.="# -------- Events --------- #\n\n";
  $query='SELECT * FROM events';
  $res = db_query($query);
  foreach ($res as $row) {
    $out.=createAdresse($row);
  }
  $out.="# -------- Projects --------- #\n\n";
  $query='SELECT * FROM projects';
  $res = db_query($query);
  foreach ($res as $row) {
    $out.=createAdresse($row);
  }
  $out.="# -------- Services --------- #\n\n";
  $query='SELECT * FROM services';
  $res = db_query($query);
  foreach ($res as $row) {
    $out.=createAdresse($row);
  }
  $out.="# -------- Stores --------- #\n\n";
  $query='SELECT * FROM stores';
  $res = db_query($query);
  foreach ($res as $row) {
    $out.=createAdresse($row);
  }
  return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Adressen/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Adressen" .

'.$out;
}

// zum Testen
// echo getAdressen();

?>

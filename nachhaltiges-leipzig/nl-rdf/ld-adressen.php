<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function createAdresse($row) {
    $uri=getAddressURI($row);
    $strasse=$row["address"];
    if(empty($strasse)) { return ""; }
    $plz=$row["zip"];
    $stadt=$row["location"];
    $gps_long=$row["longitude"];
    $gps_lat=$row["latitude"];
    $a=array();
    if ($stadt=="Leipzig") { $a[]=' a ld:LeipzigerAdresse '; }
    else { $a[]=' a ld:Adresse '; }
    $a=addLiteral($a,'rdfs:label', "$stadt, $strasse");
    $a=addLiteral($a,'ld:hasCity', $stadt);
    $a=addLiteral($a,'ld:hasStreet', getStreet($strasse));
    $a=addLiteral($a,'ld:hasPostCode', $plz);
    $a=addLiteral($a,'ld:hasHouseNumber', getHouseNumber($strasse));
    $a=addLiteral($a,'gsp:asWKT', "Point($gps_long $gps_lat)");
    return '<http://leipzig-data.de/Data/'.$uri.'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

function getAddressURI($row) {
    $strasse=$row["address"];
    if(empty($strasse)) { return ""; }
    $strasse=getStreet($strasse).".".getHouseNumber($strasse);
    $plz=$row["zip"];
    $stadt=$row["location"];
    $out=fixURI("$plz.$stadt.$strasse");
    $out=str_replace("Trebsen/Mulde", "Trebsen", $out);  
    $out=str_replace("LuetznerStreet", "LuetznerStrasse", $out);  
    $out=str_replace("Katharinenstrasse.21-23", "Katharinenstrasse.21", $out);  
    $out=str_replace("R.-Becher", "R-Becher", $out);  
    $out=str_replace("Stockartstrasse.111", "Stockartstrasse.11", $out);  
    return $out;
}

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

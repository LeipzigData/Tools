<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getSparten() {
  $mysqli=getConnection(); 
  $mysqli->real_query("SELECT * FROM aae_data_sparte");
  $res = $mysqli->use_result();
  $out='';
  while ($row = $res->fetch_assoc()) {
    $out.=createSparte($row);
  }
  $mysqli->real_query("SELECT * FROM aae_data_akteur_hat_sparte");
  $res = $mysqli->store_result();
  while ($row = $res->fetch_assoc()) {
    $out.=createAkteurSparte($row);
  }
  $mysqli->real_query("SELECT * FROM aae_data_event_hat_sparte");
  $res = $mysqli->store_result();
  while ($row = $res->fetch_assoc()) {
    $out.=createEventSparte($row);
  }

  return TurtlePrefix().'
<http://leipziger-ecken.de/Data/Sparten/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Leipziger Ecken - Sparten" .

'.$out;
}

function createSparte($row) {
  $id=$row['KID'];
  $a=array();
  $a[]=' a le:Sparte ';
  $a=addLiteral($a,'le:hasKID', $id);
  $a=addLiteral($a,'rdfs:label', $row['kategorie']);
  return '<http://leipziger-ecken.de/Data/Sparte/S'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

function createAkteurSparte($row) {
  $aid=$row['hat_AID'];
  $kid=$row['hat_KID'];  
  return '<http://leipziger-ecken.de/Data/Akteur/A'. $aid .'> le:zurSparte <http://leipziger-ecken.de/Data/Sparte/S'.$kid.'> .
';
}

function createEventSparte($row) {
  $aid=$row['hat_EID'];
  $kid=$row['hat_KID'];  
  return '<http://leipziger-ecken.de/Data/Event/E'. $aid .'> le:zurSparte <http://leipziger-ecken.de/Data/Sparte/S'.$kid.'> .
';
}

// zum Testen
// echo getSparten();

?>

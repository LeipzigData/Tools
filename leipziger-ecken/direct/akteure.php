<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getAkteure() {
  $mysqli=getConnection(); 
  $mysqli->real_query("SELECT * FROM aae_data_akteur");
  $res = $mysqli->use_result();
  $out='';
  while ($row = $res->fetch_assoc()) {
    $out.=createAkteur($row);
  }
  return TurtlePrefix().'
<http://leipziger-ecken.de/Data/Akteure/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Leipziger Ecken - Akteure" .

'.$out;

}

function createAkteur($row) {
  $id=$row['AID'];
  $a=array();
  $a[]=' a ld:Akteur, org:Organization ';
  $a=addLiteral($a,'le:hasAID', $row['AID']);
  $a=addLiteral($a,'foaf:name', $row['name']);
  $a=addLiteral($a,'foaf:mbox', $row['email']);
  $a=addLiteral($a,'foaf:phone', fixPhone($row['telefon']));
  $a=addResource($a,'foaf:homepage', "", fixURL($row['url']));
  $a=addLiteral($a,'foaf:Image', str_replace("/sites/default/files/", "",$row['bild']));
  $a=addLiteral($a,'foaf:description', $row['beschreibung']);
  $a=addLiteral($a,'le:hatAnsprechpartner', $row['ansprechpartner']);
  $a=addLiteral($a,'le:hatFunktion', $row['funktion']);
  $a=addLiteral($a,'le:hatOeffungszeiten', $row['oeffnungszeiten']);
  $a=addResource($a,'le:hatAdresse', "http://leipziger-ecken.de/Data/Adresse/A",$row['adresse']);
  $a=addResource($a,'le:hatErsteller',"http://leipziger-ecken.de/Data/Person/P", $row['ersteller']);
  $a=addLiteral($a,'dcterms:created', str_replace(" ", "T", $row['created']));
  $a=addLiteral($a,'dcterms:lastModified', str_replace(" ", "T", $row['modified']));
  return '<http://leipziger-ecken.de/Data/Akteur/A'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
// echo getAkteure();

?>

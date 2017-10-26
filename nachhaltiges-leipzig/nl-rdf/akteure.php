<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getAkteure() {
  $query='SELECT * FROM users';
  $res = db_query($query);
  $out='';
  foreach ($res as $row) {
    $out.=createAkteur($row);
  }
  
  return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Akteure/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Akteure" .

'.$out;

}

function createAkteur($row) {
  $id=$row['id'];
  $a=array();
  $a[]=' a foaf:Person ';
  $a=addLiteral($a,'nl:hasID', $id);
  $a=addLiteral($a,'dct:created', str_replace(" ", "T", $row['created_at']));
  $a=addLiteral($a,'dct:updated', str_replace(" ", "T", $row['updated_at']));
  $a=addLiteral($a,'org:memberOf', $row['organization']);
  $a=addLiteral($a,'foaf:firstName', $row['first_name']);
  $a=addLiteral($a,'foaf:lastName', $row['last_name']);
  // Adresse, Geokoordinaten
  $a=addLiteral($a,'foaf:mbox', $row['email']);
  $a=addLiteral($a,'foaf:phone', fixPhone($row['phone_primary']));
  $a=addLiteral($a,'foaf:phone', fixPhone($row['phone_secondary']));
  $a=addResource($a,'foaf:homepage', "", $row['url']);
  return '<http://nachhaltiges-leipzig.de/Data/Akteur/A'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
echo getAkteure();

?>

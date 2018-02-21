<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getLDAkteure() {
  $query='SELECT * FROM users';
  $res = db_query($query);
  $out='';
  foreach ($res as $row) {
    $out.=createLDAkteur($row);
  }
  
  return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/LD-Akteure/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Akteure" .

'.$out;

}

function createLDAkteur($row) {
  $id=$row['id'];
  $a=array(); 
  $a[]=' a org:Organization '; 
  $a=addResource($a,'owl:sameAs', 'http://nachhaltiges-leipzig.de/Data/Akteur.', $id);
  $a=addLiteral($a,'ld:contactPerson', $row['first_name']." ".$row['last_name']);
  $a=addResource($a,'ld:hasAddress', "http://leipzig-data.de/Data/", getAddressURI($row));
  $a=addLiteral($a,'foaf:mbox', $row['email']);
  $a=addLiteral($a,'foaf:phone', fixPhone($row['phone_primary']));
  $a=addLiteral($a,'foaf:phone', fixPhone($row['phone_secondary']));
  $a=addLiteral($a,'rdfs:label', $row['organization']);
  $a=addResource($a,'foaf:homepage', "", $row['organization_url']);
  $name=fixURI($row['organization']);
  return
      '<http://leipzig-data.de/Data/Akteur/'. $name .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
// echo getLDAkteure();

?>

<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getAktionen() {
  $query='SELECT * FROM actions';
  $res = db_query($query);
  $out='';
  foreach ($res as $row) {
    $out.=createAktion($row);
  }
  
  return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Akteure/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Aktionen" .

'.$out;

}

function createAktion($row) {
  $id=$row['id'];
  $a=array();
  $a[]=' a nl:Aktion ';
  $a=addLiteral($a,'nl:hasID', $id);
  $a=addMLiteral($a,'nl:hasDescription', $row['description']);
  $a=addLiteral($a,'nl:hasImage', $row['image']);
  $a=addResource($a,'nl:hasVideoURL', "", $row['video_url']);
  $a=addResource($a,'nl:hasInfoURL', "", $row['info_url']);
  $a=addResource($a,'ld:proposedAddress', "http://leipzig-data.de/Data/", getAddressURI($row));
  $a=addLiteral($a,'nl:hasDistrict', $row['district']);
  $a=addLiteral($a,'nl:isPublished', $row['published']);
  $a=addLiteral($a,'dct:created', str_replace(" ", "T", $row['created_at']));
  $a=addLiteral($a,'dct:updated', str_replace(" ", "T", $row['updated_at']));
  return '<http://nachhaltiges-leipzig.de/Data/Aktion/A'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
// echo getAktionen();

?>

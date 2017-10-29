<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getProjekte() {
  $query='SELECT * FROM projects';
  $res = db_query($query);
  $out='';
  foreach ($res as $row) {
    $out.=createProjekt($row);
  }
  
  return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Projekte/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Projekte" .

'.$out;

}

function createProjekt($row) {
  $id=$row['id'];
  $a=array();
  $a[]=' a nl:Projekt ';
  $a=addLiteral($a,'nl:hasID', $id);
  $a=addMLiteral($a,'nl:hasDescription', $row['description']);
  $a=addMLiteral($a,'nl:hasSummary', $row['short_description']);
  $a=addMLiteral($a,'nl:hasPropertyList', $row['property_list']);
  $a=addLiteral($a,'nl:hasImage', $row['image']);
  $a=addResource($a,'nl:hasVideoURL', "", $row['video_url']);
  $a=addResource($a,'nl:hasInfoURL', "", $row['info_url']);
  $a=addResource($a,'ld:proposedAddress', "http://leipzig-data.de/Data/", getAddressURI($row));
  $a=addLiteral($a,'nl:hasDistrict', $row['district']);
  $a=addLiteral($a,'nl:isPublished', $row['published']);
  $a=addLiteral($a,'dct:created', str_replace(" ", "T", $row['created_at']));
  $a=addLiteral($a,'dct:updated', str_replace(" ", "T", $row['updated_at']));
  return '<http://nachhaltiges-leipzig.de/Data/Projekt/P'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
// echo getProjekte();

?>

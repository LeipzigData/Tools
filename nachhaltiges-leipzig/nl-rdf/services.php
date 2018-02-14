<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getServices() {
  $query='SELECT * FROM services';
  $res = db_query($query);
  $out='';
  foreach ($res as $row) {
    $out.=createService($row);
  }
  
  return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Services/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Services" .

'.$out;

}

function createService($row) {
  $id=$row['id'];
  $a=array();
  $a[]=' a nl:Service ';
  $a=addLiteral($a,'nl:hasID', $id);
  $a=addMLiteral($a,'nl:hasDescription', $row['description']);
  $a=addMLiteral($a,'nl:hasSummary', $row['short_description']);
  $a=addLiteral($a,"nl:hasTargetGroup",$row["target_group"]);
  $a=addLiteral($a,"nl:hasTargetGroupSelection",$row["target_group_selection"]);
  $a=addLiteral($a,"nl:hasDuration",$row["duration"]);
  $a=addLiteral($a,'nl:hasCosts', $row["costs"]);
  $a=addMLiteral($a,'nl:hasRequirements', $row["requirements"]);
  $a=addLiteral($a,'nl:hasServiceType', $row["service_type"]);
  $a=addLiteral($a,'nl:hasImage', $row['image']);
  $a=addResource($a,'nl:hasVideoURL', "", $row['video_url']);
  $a=addResource($a,'nl:hasInfoURL', "", $row['info_url']);
  $a=addResource($a,'ld:proposedAddress', "http://leipzig-data.de/Data/", getAddressURI($row));
  $a=addLiteral($a,'nl:hasDistrict', $row['district']);
  $a=addLiteral($a,'nl:isPublished', $row['published']);
  $a=addLiteral($a,'dct:created', str_replace(" ", "T", $row['created_at']));
  $a=addLiteral($a,'dct:updated', str_replace(" ", "T", $row['updated_at']));
  $res = db_query("SELECT * FROM activities where item_id=$id and item_type='Service'");
  foreach ($res as $u) {
      $a=addResource($a,'nl:hasProvider', "http://leipzig-data.de/Data/Akteur/A", $u["user_id"]);
      $a=addLiteral($a,'nl:hasEventType', $u["item_type_i18n"]);
  }  
  return '<http://nachhaltiges-leipzig.de/Data/Service/S'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
// echo getServices();

?>

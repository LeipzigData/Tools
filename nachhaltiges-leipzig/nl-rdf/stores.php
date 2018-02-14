<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getStores() {
  $query='SELECT * FROM stores';
  $res = db_query($query);
  $out='';
  foreach ($res as $row) {
    $out.=createStore($row);
  }
  
  return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Stores/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Stores" .

'.$out;

}

function createStore($row) {
  $id=$row['id'];
  $a=array();
  $a[]=' a nl:Store ';
  $a=addLiteral($a,'nl:hasID', $id);
  $a=addMLiteral($a,'nl:hasDescription', $row['description']);
  $a=addMLiteral($a,'nl:hasSummary', $row['short_description']);
  $a=addMLiteral($a,'nl:hasPropertyList', $row["property_list"]);
  $a=addLiteral($a,'nl:hasImage', $row['image']);
  $a=addResource($a,'nl:hasVideoURL', "", $row['video_url']);
  $a=addResource($a,'nl:hasInfoURL', "", $row['info_url']);
  $a=addResource($a,'ld:proposedAddress', "http://leipzig-data.de/Data/", getAddressURI($row));
  $a=addLiteral($a,'nl:hasDistrict', $row['district']);
  $a=addLiteral($a,'nl:isPublished', $row['published']);
  $a=addLiteral($a,'dct:created', str_replace(" ", "T", $row['created_at']));
  $a=addLiteral($a,'dct:updated', str_replace(" ", "T", $row['updated_at']));
  $res = db_query("SELECT * FROM activities where item_id=$id and item_type='Store'");
  foreach ($res as $u) {
      $a=addResource($a,'nl:hasProvider', "http://leipzig-data.de/Data/Akteur/A", $u["user_id"]);
      $a=addLiteral($a,'nl:hasEventType', $u["item_type_i18n"]);
  }  
  return '<http://nachhaltiges-leipzig.de/Data/Store/S'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
// echo getStores();

?>

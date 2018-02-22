<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getEvents() { 
  $res = db_query("SELECT * FROM events");
  $out='';
  foreach ($res as $row) {
    $out.=createEvent($row);
  }

  return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Events/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Events" .

'.$out;
}

function createEvent($row) {
  $id=$row['id'];
  $a=array();
  $a[]=' a nl:Event ';
  $a=addLiteral($a,"nl:hasId",$id);
  $a=addLiteral($a,"rdfs:label",$row["name"]);
  $a=addMLiteral($a,"ical:description",$row["description"]);
  $a=addResource($a,'ld:proposedAddress', "http://leipzig-data.de/Data/", getAddressURI($row));
  $a=addLiteral($a,"nl:Zielgruppe",$row["target_group"]);
  $a=addLiteral($a,'ical:dtstart', str_replace(" ", "T", $row['start_at']));
  $a=addLiteral($a,'ical:dtend', str_replace(" ", "T", $row['end_at']));
  $a=addLiteral($a,'nl:Kosten', $row["costs"]);
  $a=addResource($a,'ical:url', "", fixURL($row['info_url']));
  $a=addLiteral($a,'dct:created', fixDate($row['created_at']));
  $a=addLiteral($a,'dct:modified', fixDate($row['updated_at']));
  $a=addLiteral($a,'nl:imPodium', $row["speaker"]);
//  $a=addLiteral($a,'nl:isPublished', $row["published"]);
  $res = db_query("SELECT * FROM activities where item_id=$id and item_type='Event'");
  foreach ($res as $u) {
      $a=addResource($a,'nl:relatedActivity', "http://nachhaltiges-leipzig.de/Data/Aktivitaet.", $u["id"]);
      $a=addResource($a,'nl:hasProvider', "http://nachhaltiges-leipzig.de/Data/Akteur.", $u["user_id"]);
      $a=addLiteral($a,'nl:hasEventType', $u["item_type_i18n"]);
  }  
  return '<http://nachhaltiges-leipzig.de/Data/Event.'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
// echo getEvents();

?>

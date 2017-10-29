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
  $a[]=' a ld:Event ';
  $a=addLiteral($a,"nl:hasId",$id);
  $a=addLiteral($a,"rdfs:label",$row["name"]);
  $a=addMLiteral($a,"ical:description",$row["description"]);
  $a=addResource($a,'ld:proposedAddress', "http://leipzig-data.de/Data/", getAddressURI($row));
  $a=addLiteral($a,"nl:hasTargetGroup",$row["target_group"]);
  $a=addLiteral($a,'ical:dtstart', str_replace(" ", "T", $row['start_at']));
  $a=addLiteral($a,'ical:dtend', str_replace(" ", "T", $row['end_at']));
  $a=addLiteral($a,'nl:hasCosts', $row["costs"]);
  $a=addResource($a,'ical:url', "", fixURL($row['info_url']));
  $a=addLiteral($a,'dct:created', str_replace(" ", "T", $row['created_at']));
  $a=addLiteral($a,'dct:updated', str_replace(" ", "T", $row['updated_at']));
  $a=addLiteral($a,'nl:hasSpeaker', $row["speaker"]);
  $a=addLiteral($a,'nl:isPublished', $row["published"]);
  return '<http://nachhaltiges-leipzig.de/Data/Event/E'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
// echo getEvents();

?>

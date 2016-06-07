<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getEvents() {
  $mysqli=getConnection(); 
  $mysqli->real_query("SELECT * FROM aae_data_event WHERE recurring_event_type IS NULL");
  $res = $mysqli->use_result();
  $out='';
  while ($row = $res->fetch_assoc()) {
    $out.=createEvent($row);
  }
  return TurtlePrefix().'
<http://leipziger-ecken.de/Data/Events/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Leipziger Ecken - Events" .

'.$out;
}

function createEvent($row) {
  $id=$row['EID'];
  $a=array();
  $a[]=' a ld:Event ';
  $a=addLiteral($a,'le:hasEID', $id);
  $a=addLiteral($a,'rdfs:label', $row['name']);
  $a=addMLiteral($a,'ical:summary', $row['kurzbeschreibung']);
  $a=addLiteral($a,'foaf:Image', fixImageString($row['bild']));
  $a=addResource($a,'ical:location', "http://leipziger-ecken.de/Data/Ort/O",$row['ort']);
  $a=addResource($a,'ical:url', "", fixURL($row['url']));
  $a=addResource($a,'ical:creator', "http://leipziger-ecken.de/Data/Person/P",$row['ersteller']);
  $a=addLiteral($a,'ical:dtstart', str_replace(" ", "T", $row['start_ts']));
  $a=addLiteral($a,'ical:dtend', str_replace(" ", "T", $row['ende_ts']));
  $a=addLiteral($a,'dcterms:created', str_replace(" ", "T", $row['created']));
  $a=addLiteral($a,'dcterms:lastModified', str_replace(" ", "T", $row['modified']));
  return '<http://leipziger-ecken.de/Data/Event/E'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
// echo getEvents();

?>

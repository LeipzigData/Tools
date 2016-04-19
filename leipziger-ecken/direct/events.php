<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getEvents() {
  $mysqli=getConnection(); 
  $mysqli->real_query("SELECT * FROM aae_data_event");
  $res = $mysqli->use_result();
  $out='';
  while ($row = $res->fetch_assoc()) {
    $out.=createEvent($row);
  }
  return $out;
}

function fixPhone($u) {
  $u=str_replace(" ", "", $u);
  $u=str_replace("---", "", $u);
  $u=str_replace("/", "-", $u);
  return $u;
}

function fixURL($u) {
  if (strpos($u,'http')===false) { $u='http://'.$u; }
  return $u;
}

function createEvent($row) {
  $id=$row['EID'];
  $a=array();
  $a[]=' a ld:Event ';
  $a=addLiteral($a,'le:hasEID', $id);
  $a=addLiteral($a,'rdfs:label', $row['name']);
  $a=addMLiteral($a,'ical:summary', $row['kurzbeschreibung']);
  $a=addLiteral($a,'foaf:Image', str_replace("/sites/default/files/", "",$row['bild']));
  $a=addResource($a,'ical:location', "http://leipziger-ecken.de/Data/Ort/O",$row['ort']);
  $a=addResource($a,'ical:url', "", fixURL($row['url']));
  $a=addResource($a,'ical:creator', "http://leipziger-ecken.de/Data/Person/P",$row['ersteller']);
  $a=addLiteral($a,'ical:dtstart', str_replace(" ", "T", $row['start_ts']));
  $a=addLiteral($a,'ical:dtend', str_replace(" ", "T", $row['ende_ts']));
  $a=addLiteral($a,'dcterms:created', str_replace(" ", "T", $row['created']));
  $a=addLiteral($a,'dcterms:lastModified', str_replace(" ", "T", $row['modified']));
  return '<http://leipziger-ecken.de/Data/Event/E'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

function TurtlePrefix() {
return '
@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
@prefix owl: <http://www.w3.org/2002/07/owl#> .
@prefix cc: <http://creativecommons.org/ns#> .
@prefix foaf: <http://xmlns.com/foaf/0.1/> .
@prefix org: <http://www.w3.org/ns/org#> .
@prefix skos: <http://www.w3.org/2004/02/skos/core#> .
@prefix ld: <http://leipzig-data.de/Data/Model/> .
@prefix le: <http://leipziger-ecken.de/Data/Model#> .
@prefix ical: <http://www.w3.org/2002/12/cal/ical#> .
@prefix lep: <http://leipziger-ecken.de/Data/Akteur/Profil/> .
@prefix dcterms: <http://purl.org/dc/terms/> .

<http://leipziger-ecken.de/Data/Events/>
    a owl:Ontology ;
    rdfs:label "Dump aus der Datenbank" .

';
}

echo TurtlePrefix().getEvents();

?>

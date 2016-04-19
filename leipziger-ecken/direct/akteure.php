<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");

function addLiteral($a,$key,$value) {
  if (!empty($value)) { $a[]=" $key ".'"'.$value.'"'; }
  return $a;
}

function addResource($a,$key,$prefix,$value) {
  if (!empty($value)) { $a[]=" $key <".$prefix.$value.'>'; }
  return $a;
}

function getAkteure() {
  $mysqli=getConnection(); 
  $mysqli->real_query("SELECT * FROM aae_data_akteur");
  $res = $mysqli->use_result();
  $out='';
  while ($row = $res->fetch_assoc()) {
    $out.=createAkteur($row);
  }
  return $out;
}

function getAdressen() {
  $mysqli=getConnection(); 
  $mysqli->real_query("SELECT * FROM aae_data_adresse");
  $res = $mysqli->use_result();
  $out='';
  while ($row = $res->fetch_assoc()) {
    $out.=createAdresse($row);
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

function createAkteur($row) {
  $id=$row['AID'];
  $a=array();
  $a[]=' a ld:Akteur, org:Organization ';
  $a=addLiteral($a,'le:hasAID', $row['AID']);
  $a=addLiteral($a,'foaf:name', $row['name']);
  $a=addLiteral($a,'foaf:mbox', $row['email']);
  $a=addLiteral($a,'foaf:phone', fixPhone($row['telefon']));
  $a=addResource($a,'foaf:homepage', "", fixURL($row['url']));
  $a=addLiteral($a,'foaf:Image', str_replace("/sites/default/files/", "",$row['bild']));
  $a=addLiteral($a,'foaf:description', $row['beschreibung']);
  $a=addLiteral($a,'le:hatAnsprechpartner', $row['ansprechpartner']);
  $a=addLiteral($a,'le:hatFunktion', $row['funktion']);
  $a=addLiteral($a,'le:hatOeffungszeiten', $row['oeffnungszeiten']);
  $a=addResource($a,'le:hatAdresse', "http://leipziger-ecken.de/Data/Adresse/A",$row['adresse']);
  $a=addResource($a,'le:hatErsteller',"http://leipziger-ecken.de/Data/Person/P", $row['ersteller']);
  $a=addLiteral($a,'dcterms:created', str_replace(" ", "T", $row['created']));
  $a=addLiteral($a,'dcterms:lastModified', str_replace(" ", "T", $row['modified']));
  return '<http://leipziger-ecken.de/Data/Akteur/A'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

function createAdresse($row) {
  $id=$row['ADID'];
  $a=array();
  $a[]=' a ld:Adresse ';
  $a=addLiteral($a,'ld:strasse', $row['strasse']);
  $a=addLiteral($a,'ld:nr', $row['nr']);
  $a=addLiteral($a,'ld:zusatz', $row['adresszusatz']);
  $a=addLiteral($a,'ld:plz', $row['plz']);
  $a=addLiteral($a,'ld:gps', $row['gps']);
  return '<http://leipziger-ecken.de/Data/Adresse/A'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
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
@prefix lep: <http://leipziger-ecken.de/Data/Akteur/Profil/> .
@prefix dcterms: <http://purl.org/dc/terms/> .

<http://leipziger-ecken.de/Data/Akteure/>
    a owl:Ontology ;
    rdfs:label "Dump aus der Datenbank" .

';
}

echo TurtlePrefix().getAkteure().getAdressen();

?>

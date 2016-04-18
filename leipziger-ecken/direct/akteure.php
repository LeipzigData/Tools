<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");

function testdb() {
  $mysqli=getConnection(); 
  $mysqli->real_query("SELECT * FROM aae_data_akteur");
  $res = $mysqli->use_result();
  $out='';
  while ($row = $res->fetch_assoc()) {
    $out.=getAkteur($row);
  }
  return TurtlePrefix().$out;
}


function getAkteur($row) {
  $id=$row['AID'];
  $a=array();
  $a[]=' a ld:Akteur, org:Organization ';
  $a[]=' le:hasAID "'.$row['AID'].'"';
  $a[]=' foaf:name "'.$row['name'].'"';
  $a[]=' foaf:mbox "'.$row['email'].'"';
  $a[]=' foaf:phone "'.$row['telefon'].'"';
  $a[]=' foaf:Image "'.$row['bild'].'"';
  $a[]=' foaf:description "'.$row['beschreibung'].'"';
  $a[]=' dcterms:created "'.str_replace(" ", "T", $row['created']).'"';
  $a[]=' dcterms:lastModified "'.str_replace(" ", "T", $row['modified']).'"';
  return 'lea:A'. $id . join(" ;\n  ",$a) . " . \n\n" ;
}

echo testdb();

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
@prefix lea: <http://leipziger-ecken.de/Data/Akteur/> .
@prefix lep: <http://leipziger-ecken.de/Data/Akteur/Profil/> .
@prefix dcterms: <http://purl.org/dc/terms/> .

<http://leipziger-ecken.de/Data/Akteure/>
    a owl:Ontology ;
    rdfs:label "Dump aus der Datenbank" .

';
}

?>

<?php

function addLiteral($a,$key,$value) {
  if (!empty($value)) { $a[]=" $key ".'"'.$value.'"'; }
  return $a;
}

function addMLiteral($a,$key,$value) {
  if (!empty($value)) { $a[]=" $key ".'"""'.$value.'"""'; }
  return $a;
}

function addResource($a,$key,$prefix,$value) {
  if (!empty($value)) { $a[]=" $key <".$prefix.$value.'>'; }
  return $a;
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
@prefix ical: <http://www.w3.org/2002/12/cal/ical#> .
@prefix dcterms: <http://purl.org/dc/terms/> .
@prefix geo: <http://www.w3.org/2003/01/geo/wgs84_pos#> .

';
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

function fixURI($u) { // Umlaute und so'n Zeugs transformieren
  return $u;
}

function asPlainText($u) {
  return $u;
}

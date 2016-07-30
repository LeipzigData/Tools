<?php

require 'vendor/autoload.php';

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
@prefix foaf: <http://xmlns.com/foaf/0.1/> .
@prefix org: <http://www.w3.org/ns/org#> .
@prefix ld: <http://leipzig-data.de/Data/Model/> .
@prefix le: <http://leipziger-ecken.de/Data/Model#> .
@prefix les: <http://leipziger-ecken.de/Data/Sparte/> .
@prefix ical: <http://www.w3.org/2002/12/cal/ical#> .
@prefix dct: <http://purl.org/dc/terms/> .
@prefix gsp: <http://www.opengis.net/ont/geosparql#> .


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

function fixImageString($u) {
  $u=str_replace("/~swp15-aae/drupal", "", $u);
  $u=str_replace("/sites/default/files/", "", $u);
  return $u;
}

function fixURI($u) { // Umlaute und so'n Zeugs transformieren
  $u=str_replace("str.", "strasse", $u);
  $u=str_replace(" ", "", $u);
  $u=str_replace("ä", "ae", $u);
  $u=str_replace("ö", "oe", $u);
  $u=str_replace("ü", "ue", $u);
  $u=str_replace("Ä", "Ae", $u);
  $u=str_replace("Ö", "Oe", $u);
  $u=str_replace("Ü", "Ue", $u);
  $u=str_replace("ß", "ss", $u);  
  return $u;
}

function asPlainText($u) {
  return '<pre>'.htmlspecialchars(toRDFString($u)).'</pre>';
}

function setNamespace() {
  EasyRdf_Namespace::set('ld', 'http://leipzig-data.de/Data/Model/');
  EasyRdf_Namespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
  EasyRdf_Namespace::set('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
  EasyRdf_Namespace::set('owl', 'http://www.w3.org/2002/07/owl#');
  EasyRdf_Namespace::set('foaf', 'http://xmlns.com/foaf/0.1/');
  EasyRdf_Namespace::set('org', 'http://www.w3.org/ns/org#');
  EasyRdf_Namespace::set('ld', 'http://leipzig-data.de/Data/Model/');
  EasyRdf_Namespace::set('le', 'http://leipziger-ecken.de/Data/Model#');
  EasyRdf_Namespace::set('les', 'http://leipziger-ecken.de/Data/Sparte/');
  EasyRdf_Namespace::set('ical', 'http://www.w3.org/2002/12/cal/ical#');
  EasyRdf_Namespace::set('dct', 'http://purl.org/dc/terms/');
  EasyRdf_Namespace::set('gsp', 'http://www.opengis.net/ont/geosparql#');
}

function toRDFString($s) {
  setNamespace(); 
  $graph = new EasyRdf_Graph("http://leipziger-ecken.de/rdf/");
  $graph->parse($s);
  return $graph->serialise("turtle");
}

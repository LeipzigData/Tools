<?php

require 'vendor/autoload.php';

function addLiteral($a,$key,$value) {
    if (!empty($value)) { $a[]=" $key ".'"'.fixQuotes($value).'"'; }
  return $a;
}

function addMLiteral($a,$key,$value) {
    if (!empty($value)) { $a[]=" $key ".'""" '.fixBackslash($value).' """'; }
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
@prefix nl: <http://nachhaltiges-leipzig.de/Data/Model#> .
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

function fixQuotes($u) {
  $u=str_replace("\"", "\\\"", $u);
  // $u=str_replace("\n", " <br/> ", $u);
  return $u;
}

function fixBackslash($u) {
  $u=str_replace("\\", "\\\\", $u);
  return $u;
}

function fixImageString($u) {
  $u=str_replace("/~swp15-aae/drupal", "", $u);
  $u=str_replace("/sites/default/files/", "", $u);
  return $u;
}

function fixURI($u) { // Umlaute und so'n Zeugs transformieren
  $u=str_replace("str.", "strasse", $u);
  $u=str_replace("Str.", "Strasse", $u);
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
  return '<pre>'.htmlspecialchars($u).'</pre>';
}

function toRDFString($s) {
    return $s;
}

function createAdresse($row) {
    $uri=getAddressURI($row);
    $strasse=$row["address"];
    if(empty($strasse)) { return ""; }
    $plz=$row["zip"];
    $stadt=$row["location"];
    $gps_long=$row["longitude"];
    $gps_lat=$row["latitude"];
    $a=array();
    $a[]=' a ld:WeitereAdresse ';
    $a=addLiteral($a,'rdfs:label', "$stadt, $strasse");
    $a=addLiteral($a,'ld:hasCity', $stadt);
    $a=addLiteral($a,'ld:hasStreet', getStreet($strasse));
    $a=addLiteral($a,'ld:hasPostCode', $plz);
    $a=addLiteral($a,'ld:hasHouseNumber', getHouseNumber($strasse));
    $a=addLiteral($a,'gsp:asWKT', "Point($gps_long $gps_lat)");
    return '<http://leipzig-data.de/Data/'.$uri.'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

function getStreet($s) {
    if(preg_match('/\d+/',$s)) { 
        return substr($s, 0, strrpos($s, " "));
    }
    else { return $s; }
}

function getHouseNumber($s) {
    if(preg_match('/\d+/',$s)) { 
        return substr($s, strrpos ($s, " ")+1);
    }
    else { return "XX"; }
}

function getAddressURI($row) {
    $strasse=$row["address"];
    if(empty($strasse)) { return ""; }
    $strasse=getStreet($strasse).".".getHouseNumber($strasse);
    $plz=$row["zip"];
    $stadt=$row["location"];
    $out=fixuRI("$plz.$stadt.$strasse");
    return $out;
}
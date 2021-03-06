<?php

// require 'vendor/autoload.php';

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

function addLiteralGroup($a,$key,$value) {
    if (!empty($value)) {
        $a[]=" $key ".'"'.join('", "', fixQuotes($value)).'"'; }
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
@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .
@prefix cc: <http://creativecommons.org/ns#> .
@prefix dct: <http://purl.org/dc/terms/> .
@prefix gsp: <http://www.opengis.net/ont/geosparql#> .
@prefix ical: <http://www.w3.org/2002/12/cal/ical#> .


';
}

function fixPhone($u) {
  $u=str_replace(" ", "-", $u);
  $u=str_replace("---", "", $u);
  $u=str_replace("/", "-", $u);
  return $u;
}

function fixURL($u) {
    if (empty($u)) { return; }
    if (strpos($u,'http')===false) { $u='http://'.$u; }
    $u=str_replace("http//","http://",$u);
    $u=str_replace("https//","https://",$u);
    return $u;
}

function fixImageString($u) {
  $u=str_replace("/~swp15-aae/drupal", "", $u);
  $u=str_replace("/sites/default/files/", "", $u);
  return $u;
  
}function fixQuotes($u) {
  $u=str_replace("\"", "\\\"", $u);
  // $u=str_replace("\n", " <br/> ", $u);
  return $u;
}

function fixBackslash($u) {
  $u=str_replace("\\", "\\\\", $u);
  return $u;
}

function fixURI($u) { // Umlaute und so'n Zeugs transformieren
  $u=str_replace("str.", "strasse", $u);
  $u=str_replace("\"", "", $u);
  $u=str_replace("\\", "", $u);
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

/* 
   Geokordinaten sind in den meisten Darstellunge kommaseparierte Paare, was
   mit der Semantik des Kommas in RDF konfligiert, wenn es mehrere
   Geokoordinatenangaben zu einem Subjekt gibt.  Deshalb wird die Darstellung
   von Geokoordinaten als asWKT-String Point(long lat) verwendet. 
*/

function asWKT($string) { 
  $string=trim($string);
  if (empty($string)) return;
  $a=preg_split("/\s*,\s*/",$string); // lat, long
  return "Point($a[1] $a[0])";
}

/* Versuche, eine plausible Adress-URI aus den gegebenen Bestandteilen zu
   erzeugen */

function getStreet($s) {
    if(preg_match('/\d+/',$s)) {
        return substr($s, 0, strrpos($s, " "));
    }
    else { return $s; }
}

function getHouseNumber($s) {
    if(preg_match('/\d+/',$s)) {
        return strtoupper(substr($s, strrpos ($s, " ")+1));
    }
    else { return "XX"; }
}

function createAddress($strasse,$nr,$plz,$ort) {
  if (empty($ort)) return;
  $strasse=str_replace("str.","strasse",$strasse);
  $strasse=str_replace("Str.","Strasse",$strasse);
  $uri=$plz.".".$ort.".".$strasse.".".$nr;
  // mache eine Reihe sinnvoller Ersetzungen
  $uri=preg_replace(array("/\s+/"),array(""),$uri);
  $uri=fixURI($uri);
  return "http://leipzig-data.de/Data/".$uri;
}

function proposeAddressURI($s) {
    if (empty($s)) { return ; }
    if ($s=="Marienweg, Leipzig") { return "04105.Leipzig.Marienweg.56"; }
    preg_match("/(.*)\s*,\s*(\d+)\s*(.*)/",$s,$a);
    $strasse=$a[1]; $plz=$a[2]; $stadt=$a[3];
    $strasse=getStreet($strasse).".".getHouseNumber($strasse);
    $out=fixURI("$plz.$stadt.$strasse");
    $out=str_replace("01455","04155",$out);
    return $out;
}
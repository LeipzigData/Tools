<?php
/**
 * User: Hans-Gert Gräbe
 * Datum: 07.06.2015

 * Generisches Werkzeug, um RDF aus einer CSV-Datei zu erzeugen.

 * Gibt RDF in Turtlenotation zurück zur Nachbearbeitung mit einem
 * Textprozessor der eigenen Wahl.

 */

// require 'vendor/autoload.php';

// output settings
//=========================
ini_set('default_charset', 'utf-8');

/* Generischer Treiber, dem eine Funktion als Parameter übergeben wird, mit der
   ein einzelner Datensatz der CSV-Datei verarbeitet wird. */

function readCSV($filename,$processing,$prefix) {
  if (($handle = fopen("$filename", "r")) !== FALSE) {
    $out=''; $row=1000;
    while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
      $out.=$processing($prefix.$row++,$data);
    }
    fclose($handle);
    return TurtlePrefix().$out;
  }
}

// Generische Transformationsfunktion

function createGenericRDF($subject,$data) {
  $a=array(); $cnt=100;
  foreach ($data as $key => $value) {
    $fix=trim($value);
    if (!empty($fix)) $a=addKeyValue($a,"ihr:predicate".$cnt,$fix);
    $cnt++;
  }
  return 
    '<http://haushaltsrechner.leipzig.de/Data/CSVValue/'.$subject.">\n\t"
    .join(";\n\t",$a).".\n\n";
}

/* Ersetze die generischen durch eigene Feldnamen, die in Array $feldnamen zu
   übergeben sind. */

function postProcess($string,$feldnamen) {
  $genericPredicates=
    array_map(create_function('$i','return "ihr:predicate".$i;'), range(100,count($feldnamen)+99));
  // print_r($genericPredicates);
  // print_r($feldnamen);
  $string=str_replace($genericPredicates,$feldnamen,$string);
  return $string;
}

/* Spezifische Transformationsfunktion für die Bezugliste. Die Label sind schon
   vorhanden, hier wird nur der Baum extrahiert.  */

function createBezugsbaum($subject,$data) {
  $out='ihr:'.fixString($data[2]).' ihr:hasChild ihr:'.fixString($data[0])." .\n";
  $out.='ihr:'.fixString($data[3]).' ihr:hasChild ihr:'.fixString($data[2])." .\n";
  $out.='ihr:'.fixString($data[4]).' ihr:hasChild ihr:'.fixString($data[3])." .\n";
  return $out;
}

// ------ helper functions -------

function addKeyValue($a,$key,$value) {
  $value=fixString($value);
  if (empty($value)) return $a;
  if (strpos($value,"http://") !== FALSE ) { // an URI
    $a[]=$key." <$value>"; 
  } else if (strpos($value,"ihr:") !== FALSE ){ // a ihr
    $a[]=$key." $value"; 
  } else { // a literal
    $a[]=$key." \"$value\""; 
  }
  return $a;
}

function fixString($string) {
  $string=trim($string);
  $string=str_replace("\"","\\\"",$string);
  return $string;
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

function createAddress($strasse,$nr,$plz,$ort) {
  if (empty($ort)) return;
  $uri=$plz.".".$ort.".".$strasse.".".$nr;
  // mache eine Reihe sinnvoller Ersetzungen
  $uri=preg_replace(array("/\s+/"),array(""),$uri);
  $uri=str_replace(
    array("ä", "ö", "ü", "ß"),
    array("ae","oe","ue","ss"),
    $uri);
  return "http://haushaltsrechner.leipzig.de/Data/".$uri;
}

function TurtlePrefix() {
  return '
@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
@prefix owl: <http://www.w3.org/2002/07/owl#> .
@prefix cc: <http://creativecommons.org/ns#> .
@prefix dct: <http://purl.org/dc/terms/> .
@prefix foaf: <http://xmlns.com/foaf/0.1/> .
@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .
@prefix ld: <http://leipzig-data.de/Data/Model/> .

';
}

// ---- Transformationen ----

function processHorte() {
  $out=readCSV("horte-leipzig.csv","createGenericRDF","A"); 
  $feldnamen=array('rdfs:label','ld:hasAddress','ld:Leiter','foaf:mbox','ld:Ansprechpartner','foaf:phone');
  return postProcess($out,$feldnamen);
}

// echo readCSV("horte-leipzig.csv","createGenericRDF",""); 
echo processHorte();

?>


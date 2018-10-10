<?php
/**
 * User: Hans-Gert Gräbe
 * Datum: 07.06.2015
 * Last Update: 11.08.2018

 * Generisches Werkzeug, um RDF aus einer CSV-Datei zu erzeugen.

 * Gibt RDF in Turtlenotation zurück zur Nachbearbeitung mit einem
 * Textprozessor der eigenen Wahl.

 */

// require 'vendor/autoload.php';
require 'helper.php';

// output settings
//=========================
ini_set('default_charset', 'utf-8');

/* Generischer Treiber, dem eine Funktion als Parameter übergeben wird, mit der
   ein einzelner Datensatz der CSV-Datei verarbeitet wird. */

function readCSV($filename,$processing,$prefix,$separator) {
  if (($handle = fopen("$filename", "r")) !== FALSE) {
    $out=''; $row=1000;
    while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
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
    if (!empty($fix)) $a=addLiteral($a,"ihr:predicate".$cnt,$fix);
    $cnt++;
  }
  return 
    '<http://leipzig-data.de/Data/CSVValue/'.$subject.">\n\t"
    .join(";\n\t",$a).".\n\n";
}

/* Ersetze die generischen durch eigene Feldnamen, die in Array $feldnamen zu
   übergeben sind. */

function postProcess($string,$feldnamen) {
  $genericPredicates=
    array_map(create_function('$i','return "ihr:predicate".$i;'),
    range(100,count($feldnamen)+99));
  // print_r($genericPredicates);
  // print_r($feldnamen);
  $string=str_replace($genericPredicates,$feldnamen,$string);
  return $string;
}

/* Spezifische Transformationsfunktionen */

function fixHortURI($s) {
    $s=fixURI($s);
    $s=str_replace("Hortander", "", $s);
    $s=str_replace("Hortinder", "", $s);
    $s=str_replace("Hortder", "", $s);
    $s=str_replace("Hort", "", $s);
    return $s;
}

function createHorte($subject,$data) { // subject is not used
    $a=array(); // Name|Adresse|PLZ|Ort|Anrede|Leitung|Email|Telefon
    $name=$data[0];
    $adresse=createAddress($data[1],"",$data[2],$data[3]);
    $adresse=preg_replace("/(\d+).$/",".$1",$adresse);
    $id=fixHortURI($name);
    $a=addLiteral($a,"rdfs:label",$name);
    $a=addResource($a,"ld:hasAddress","",$adresse);
    $a=addLiteral($a,"foaf:mbox",trim($data[6]));
    $a=addLiteral($a,"foaf:phone",fixPhone($data[7]));
    $a=addLiteral($a,"dct:modified","2018-08-04");
    return 
        "<http://leipzig-data.de/Data/Hort/$id> a ld:Hort;\n\t"
        .join(";\n\t",$a).".\n\n";
}

function fixSchulURI($s) {
    $s=fixURI($s);
    return $s;
}

function createGrundschulen($subject,$data) { // subject is not used
    $a=array(); // Name|Adresse|Ansprechpartner|Email|Webseite|Ortsteil
    $name=str_replace(" - Grundschule der Stadt Leipzig","",$data[0]);
    $name=str_replace("Freier Träger - ","",$name);
    $b=preg_split("/,\s*/",$data[1]);
    $adresse=createAddress($b[0],"",$b[1],$b[2]);
    $adresse=preg_replace("/(\d+).$/",".$1",$adresse);
    $url=trim(str_replace("n/a","",$data[4]));
    $id=fixSchulURI($name);
    $a=addLiteral($a,"rdfs:label",$name);
    $a=addResource($a,"ld:hasAddress","",$adresse);
    $a=addLiteral($a,"foaf:mbox",trim($data[3]));
    $a=addResource($a,"foaf:homepage","",fixURL($url));
    $a=addLiteral($a,"dct:modified","2018-08-04");
    return 
        "<http://leipzig-data.de/Data/Schule/$id> a ld:Grundschule;\n\t"
        .join(";\n\t",$a)." .\n\n";
}

function createBerufsschulen($subject,$data) { // subject is not used
    $a=array(); // Name|Adresse|Ansprechpartner|Email|Webseite|Ortsteil
    $name=str_replace(" - Berufliches Schulzentrum der Stadt Leipzig","",$data[0]);
    $name=str_replace("Berufliches Schulzentrum","BSZ",$name);
    $name=str_replace("Beruflich - ","",$name);
    $name=str_replace("der Stadt Leipzig","",$name);
    $name=str_replace("Freier Träger - ","",$name);
    $b=preg_split("/,\s*/",$data[1]);
    $adresse=createAddress($b[0],"",$b[1],$b[2]);
    $adresse=preg_replace("/(\d+).$/",".$1",$adresse);
    $url=trim(str_replace("n/a","",$data[4]));
    $id=fixSchulURI($name);
    $a=addLiteral($a,"rdfs:label",$name);
    $a=addResource($a,"ld:hasAddress","",$adresse);
    $a=addLiteral($a,"foaf:mbox",trim($data[3]));
    $a=addResource($a,"foaf:homepage","",fixURL($url));
    return 
        "<http://leipzig-data.de/Data/Schule/$id> a ld:Berufsschule;\n\t"
        .join(";\n\t",$a)." .\n\n";
}

function createHaltestellen($subject,$data) { // subject is not used
    $a=array(); // stop_id,stop_name,stop_lat,stop_lon
    $id=$data[0];
    $name=$data[1];
    $name=str_replace("Leipzig, ","",$name);
    $name=str_replace("str.","straße",$name);
    $name=str_replace("Str.","Straße",$name);
    $a=addLiteral($a,"rdfs:label",$name);
    $a=addLiteral($a,'gsp:asWKT', asWKT($data[2].", ".$data[3]));
    $a=addLiteral($a,"dct:modified","2018-08-12");
    return 
        "<http://leipzig-data.de/Data/Haltestelle/H.$id> a ld:Haltestelle, ld:Treffpunkt;\n\t"
        .join(";\n\t",$a).".\n\n";
}

// ---- Transformationen ----

function processHorte() {
  $datadir="/home/graebe/git/LD/Tools/Transform/Data";
  $out=readCSV("$datadir/horte-leipzig.csv","createHorte","","|");
  return $out;
}

function processGrundschulen() {
  $datadir="/home/graebe/git/LD/Tools/Transform/Data";
  $out=readCSV("$datadir/grundschulen.csv","createGrundschulen","",";");
  return $out;
}

function processBerufsschulen() {
  $datadir="/home/graebe/git/LD/Tools/Transform/Data";
  $out=readCSV("$datadir/berufsschulen.csv","createBerufsschulen","",";");
  return $out;
}

function processHaltestellen() {
  $datadir="/home/graebe/git/LD/Tools/Transform/Data";
  $out=readCSV("$datadir/stops.txt","createHaltestellen","",",");
  return $out;
}

// echo processHorte();
// echo processGrundschulen();
// echo processBerufsschulen();
echo processHaltestellen();

?>


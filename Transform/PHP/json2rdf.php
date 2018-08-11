<?php
/**
 * User: Hans-Gert Gräbe
 * Created: 2018-08-10
 * Last Update: 

 * Generisches Werkzeug, um RDF aus einer json-Datei zu erzeugen.

 * Gibt RDF in Turtlenotation zurück zur Nachbearbeitung mit einem
 * Textprozessor der eigenen Wahl.

 */

include_once("helper.php");

function readJSON($filename,$processing,$praeambel) {
    $string = file_get_contents($filename);
    $res = json_decode($string, true);
    $out=''; // print_r($res);
    foreach ($res as $row) {
        $out.=$processing($row);
    }
    return TurtlePrefix().$out;
}

/* Spezifische Transformationsfunktionen */

function fixSpielplatz($u) { 
    $u=preg_replace("/Spielplatz\s*/", "", $u);
    $u=str_replace("''", "", $u);
    return $u;
}

function createSpielplatz($row) {
  $uri=fixSpielplatz(fixURI($row['title']));
  $b=array(); 
  $b[]=' a ld:Spielplatz, ld:Treffpunkt '; 
  $b=addLiteral($b,'rdfs:label', fixQuotes($row['title']));
  $b=addLiteral($b,'ld:Lage', fixQuotes($row['address']));
  $b=addLiteral($b,'gsp:asWKT', asWKT($row['lat'].", ".$row['lng']));
  //$b=addLiteral($b,'ld:hasDistrict', $row['district']);
  $b=addLiteralGroup($b,'ld:erreichbar', $row['local_traffic']);
  $b=addLiteralGroup($b,'ld:hatAusstattung', $row['gaming_devices']);
  $b=addLiteralGroup($b,'ld:hatAusstattung', $row['equipment']);
  $b=addLiteral($b,"dct:modified","2018-08-10");
  return
      '<http://Leipzig-data.de/Data/Spielplatz/'. $uri .'>'. join(" ;\n  ",$b) . " . \n\n" ;
}

function getAfeefaAkteur($row) {
  $id=$row['id'];
  $b=array(); 
  $b[]=' a ld:AfeefaAkteur '; 
  $b=addLiteral($b,'ld:AfeefaEntryType', $row['entryType']);
  $b=addLiteral($b,'ld:AfeefaEntryId', $row['entryId']);
  $b=addLiteral($b,'rdfs:label', fixQuotes($row['name']));
  $b=addMLiteral($b,'ical:description', $row['description']);
  $b=addMLiteral($b,'ical:summary', $row['descriptionShort']);
  $b=addLiteral($b,'foaf:mbox', $row['mail']);
  $b=addLiteral($b,'foaf:phone', $row['phone']);
  $b=addResource($b,'foaf:homepage', "", $row['facebook']);
  $b=addResource($b,'foaf:homepage', "", $row['web']);
  $b=addLiteral($b,"dct:created", $row['created_at']);
  $b=addLiteral($b,"dct:modified", $row['updated_at']);
  $b=addLiteral($b,"ld:AfeefaSpeaker", $row['speakerPublic']);
  foreach ($row['location'] as $a) {
      $s=$a['street']; $plz=$a['zip']; $ort=$a['city'];
      $strasse=getStreet($s); $nr=getHouseNumber($s);
      $b=addResource($b,"ld:hasAddress","",createAddress($strasse,$nr,$plz,$ort));
      $b=addLiteral($b,'gsp:asWKT', asWKT($a['lat'].", ".$a['lon']));
      $b=addLiteral($b,"ld:hasPlaceName", fixQuotes($a['placename']));
  }
  return
      '<http://Leipzig-data.de/Data/AfeefaAkteur.'. $id .'>'. join(" ;\n  ",$b) . " . \n\n" ;
}

// ---- Transformationen ----

function processSpielplaetze() {
  $datadir="/home/graebe/git/LD/Tools/Transform/Data";
  $prefix='<http://leipzig-data.de/Data/Spielplaetze/>
    cc:attributionName "The Leipzig Open Data Project" ;
    cc:attributionURL <http://leipzig-data.de> ;
    cc:license <http://creativecommons.org/publicdomain/zero/1.0/> ;
    dct:source "Seiten der Stadt Leipzig" ;
    a owl:Ontology ;
    rdfs:comment "extrahiert aus kidsle (Stand August 2014)";
    dct:created "2018-08-10" ; 
    rdfs:label "Spielplätze in der Stadt Leipzig" .
';
  return readJSON("$datadir/playgrounds.json","createSpielplatz",$prefix);
}

function processAfeefa() {
    // $filename="https://afeefa.de/api/marketentries?area=leipzig";
    $filename="../Data/leipzig-de.json";
    $string = file_get_contents($filename);
    $res = json_decode($string, true);
    $out=''; // print_r($res);
    // print_r($res);
    foreach ($res['marketentries'] as $row) {
        $out.=getAfeefaAkteur($row);
    }
    return TurtlePrefix().$out;
}

// zum Testen
// echo processSpielplaetze();
echo processAfeefa();

?>

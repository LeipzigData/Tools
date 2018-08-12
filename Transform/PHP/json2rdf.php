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
  $b[]=' a ld:AfeefaEntry '; 
  $b=addLiteral($b,'rdfs:label', fixQuotes($row['name']));
  $b=addLiteral($b,'ld:AfeefaEntryType', $row['entryType']);
  $b=addLiteral($b,'ld:AfeefaEntryId', $row['entryId']);
  $b=addLiteral($b,'ld:AfeefaCertified', $row['certified']);
  $b=addMLiteral($b,'ical:description', $row['description']);
  $b=addMLiteral($b,'ical:summary', $row['descriptionShort']);
  $b=addLiteral($b,'foaf:mbox', $row['mail']);
  $b=addLiteral($b,'foaf:phone', $row['phone']);
  $b=addLiteral($b,"ld:AfeefaSpeaker", $row['speakerPublic']);
  $b=addLiteral($b,"ld:SpokenLanguages", $row['spokenLanguages']);
  $b=addMLiteral($b,"ld:supportWantedDetail", $row['supportWantedDetail']);
  $b=addMLiteral($b,"ld:AfeefaTags", $row['tags']);
  $b=addMLiteral($b,"ld:AfeefaType", $row['type']);
  $b=addResource($b,'foaf:homepage', "", $row['facebook']);
  $b=addResource($b,'foaf:homepage', "", $row['web']);
  $b=addLiteral($b,"dct:created", $row['created_at']);
  $b=addLiteral($b,"dct:modified", $row['updated_at']);
  $b=addLiteral($b,"ld:AfeefaParentOrgaId", $row['parentOrgaId']);
  if (array_key_exists('dateFrom',$row)) {
          $b=addLiteral($b,"ical:dtstart", $row['dateFrom']."T".$row['timeFrom']);
      }
  if (array_key_exists('dateTo',$row)) {
          $b=addLiteral($b,"ical:dtend", $row['dateTo']."T".$row['timeTo']);
      }
  foreach ($row['location'] as $a) {
      $s=$a['street']; $plz=$a['zip']; $ort=$a['city'];
      $strasse=getStreet($s); $nr=getHouseNumber($s);
      $b=addResource($b,"ld:hasAddress","",fixAddress(createAddress($strasse,$nr,$plz,$ort)));
      $b=addLiteral($b,'gsp:asWKT', asWKT($a['lat'].", ".$a['lon']));
      $b=addLiteral($b,"ld:hasPlaceName", fixQuotes($a['placename']));
  }
  return
      '<http://Leipzig-data.de/Data/AfeefaAkteur.'. $id .'>'. join(" ;\n  ",$b) . " . \n\n" ;
}

function fixAddress($s) {
    $s=str_replace("Data/.Leipzig.Arndtstrasse.63","Data/04275.Leipzig.Arndtstrasse.63",$s);
    $s=str_replace("Pommernstrasse10.(GARTENADRESSE)","Pommernstrasse.10",$s);
    $s=str_replace("04105Leipzig.Leipzig","04105.Leipzig",$s);
    $s=str_replace("Loehrstrasse3/.7","Loehrstrasse.3",$s);
    $s=str_replace("04347Leipzig.Leipzig","04347.Leipzig",$s);
    $s=str_replace("PragerStrasse.118-136","PragerStrasse.118",$s);
    $s=str_replace("Georg-Schumann-Strasse.171-175","Georg-Schumann-Strasse.171",$s);
    $s=str_replace("Data/.Leipzig.Lessingstrasse.7","Data/04109.Leipzig.Lessingstrasse.7",$s);
    $s=str_replace("DresdnerStrasse.11-13","DresdnerStrasse.11",$s);
    $s=str_replace("DresdnerStrasse.11/13","DresdnerStrasse.11",$s);
    $s=str_replace("Data/.Leipzig.MockauerStrasse.120","Data/04357.Leipzig.MockauerStrasse.120",$s);
    $s=str_replace("18.Oktober","18Oktober",$s);
    $s=str_replace("Wilhelm-Leuschner-Platz10-.11","Wilhelm-Leuschner-Platz.10",$s);
    $s=str_replace("17.Juni","17Juni",$s);
    $s=str_replace("SchoenefelderAllee23a.","SchoenefelderAllee.23A",$s);
    $s=str_replace("Rosa-Luxemburg-Strasse45,.","Rosa-Luxemburg-Strasse.45",$s);
    $s=str_replace("04177Leipzig.Leipzig","04177.Leipzig",$s);
    $s=str_replace("04109Leipzig.Leipzig","04109.Leipzig",$s);
    $s=str_replace("KiewerStrasse.1–3","KiewerStrasse.1",$s);
    $s=str_replace("Martin-Luther-Ring4-.6","Martin-Luther-Ring.4",$s);
    $s=str_replace("04329Leipzig.Leipzig","04329.Leipzig",$s);
    $s=str_replace("04229Leipzig.Leipzig","04229.Leipzig",$s);
    $s=str_replace("04317.Leipzig..ueHLSTR.14","04317.Leipzig.Muehlstrasse.14",$s);
    $s=str_replace("ZurSchule10.A","ZurSchule.10A",$s);
    $s=str_replace("DresdnerStrasse78-.80","DresdnerStrasse.78",$s);
    $s=str_replace("AnderKotsche11-.13","AnderKotsche.11",$s);
    $s=str_replace("Rossplatz.5/6","Rossplatz.5",$s);
    $s=str_replace("Emilienstrasse17.","Emilienstrasse.17",$s);
    $s=str_replace("Braunstrasse.26-28","Braunstrasse.26",$s);
    $s=str_replace("Zschochersche.STR.2A","ZschocherscheStrasse.2A",$s);
    $s=str_replace("Karl-HeineStrasse","Karl-Heine-Strasse",$s);
    $s=str_replace("BornaischeStrasse179b.","BornaischeStrasse.179B",$s);
    $s=str_replace("TorgauerPlatz.1-2","TorgauerPlatz.1",$s);
    $s=str_replace("NaumburgerStrasse23.","NaumburgerStrasse.23",$s);
    $s=str_replace("Paul-Gruner-Strasse62.(HINTERHAUS)","Paul-Gruner-Strasse.62",$s);
    $s=str_replace("WeissenfelserStrasse65.H","WeissenfelserStrasse.65H",$s);
    $s=str_replace("aul-Gruner-Strasse62.","aul-Gruner-Strasse.62",$s);
    $s=str_replace("","",$s);
    $s=str_replace("","",$s);
    return $s;
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

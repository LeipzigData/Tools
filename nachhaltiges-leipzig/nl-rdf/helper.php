<?php

/* == REST-API ==

Basis-URL: daten.nachhaltiges-leipzig.de

API:
    /api/v1/activities.json
    /api/v1/activities/[id].json
    /api/v1/categories.json
    /api/v1/categories/[id].json
    /api/v1/products.json
    /api/v1/products/[id].json
    /api/v1/trade_types.json
    /api/v1/trade_categories.json
    /api/v1/users.json
    /api/v1/users/[id].json
*/

// ==== Weitere Hilfsfunktionen

function addLiteral($a,$key,$value) {
    if (!empty($value)) { $a[]=" $key ".'"'.fixQuotes(trim($value)).'"'; }
  return $a;
}

function addMLiteral($a,$key,$value) {
    if (!empty($value)) { $a[]=" $key ".'"""'.fixBackslash(trim($value)).'"""'; }
  return $a;
}

function addResource($a,$key,$prefix,$value) {
    if (!empty($value)) { $a[]=" $key <".$prefix.trim($value).'>'; }
  return $a;
}

function addLiteralGroup($a,$key,$value) {
    if (!empty($value)) {
        $a[]=" $key ".'"'.join('", "', $value).'"'; }
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

function fixDate($u) {
    $u=preg_replace('/\s.*/', '', $u);
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
  $u=str_replace("é", "e", $u);  
  $u=str_replace("&", "und", $u);
  $u=str_replace("\"", "", $u);
  return $u;
}

function getWKT($a) {
    if (empty($a)) { return ; }
    return "Point($a[1] $a[0])";
}

function fixNameURI($u) { // Weitere Transformation für Namen
  $u=fixURI($u);
  $u=str_replace("-", "", $u);
  $u=str_replace("Dr.", "", $u);
  return $u;
}

function fixOrgURI($u) { // Weitere Transformation für Organisationen
  $u=fixURI($u);
  $u=str_replace("-", "", $u);
  $u=str_replace("!", "", $u);
  $u=str_replace("e.V.", "", $u);
  $u=str_replace("e.V", "", $u);
  $u=str_replace("GmbH", "", $u);
  $u=str_replace("undCo.oHG", "", $u);
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
    if ($stadt=="Leipzig") { $a[]=' a ld:LeipzigerAdresse '; }
    else { $a[]=' a ld:Adresse '; }
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
        return strtoupper(substr($s, strrpos ($s, " ")+1));
    }
    else { return "XX"; }
}

function proposeAddressURI($s) {
    if (empty($s)) { return ; }
    if ($s=="Marienweg, Leipzig") { return "04105.Leipzig.Marienweg.56"; }
    preg_match("/(.*)\s*,\s*(\d+)\s*(.*)/",$s,$a);
    $strasse=$a[1]; $plz=$a[2]; $stadt=$a[3];
    $strasse=getStreet($strasse).".".getHouseNumber($strasse);
    $out=fixURI("$plz.$stadt.$strasse");
    $out=str_replace("01455","04155",$out);
    $out=str_replace("Strassedes17.Juni","Strassedes17Juni",$out);
    $out=str_replace("Karl-Tauchnitz-Strasse.9-11","Karl-Tauchnitz-Strasse.9",$out);
    $out=str_replace("Angerstrasse.40-42","Angerstrasse.40",$out);
    $out=str_replace("04277.Leipzig.BornaischeStrasse.XX","04277.Leipzig.BornaischeStrasse.18",$out);
    $out=str_replace("04277.Leipzig.Stockartstrasse.111","04277.Leipzig.Stockartstrasse.11",$out);
    $out=str_replace("Dorotheenplatz.2-4","Dorotheenplatz.2",$out);
    $out=str_replace("Johannes-R.-Becher-Strasse","Johannes-R-Becher-Strasse",$out);
    $out=str_replace("Katharinenstrasse.21-23","Katharinenstrasse.21",$out);
    $out=str_replace(".LuetznerStreet.75",".LuetznerStrasse.75",$out);
    $out=str_replace("GrimmaischeStrasse.6-16","GrimmaischeStrasse.6",$out);
    $out=str_replace("04155.Leipzig.GrillplatzMarienweg.XX","04105.Leipzig.Marienweg.56",$out);
    $out=str_replace("04105.Leipzig.GrillplatzMarienweg.XX","04105.Leipzig.Marienweg.56",$out);
    $out=str_replace("04668.Grimma.Taeubchenweg2,GutKoetz,inder.„RANGERSTATIONundQUOT;","04668.Grimma.Taeubchenweg.2",$out);
    $out=str_replace("04107.Leipzig.StadtbibliothekamWilhelm-Leuschner-Platz.10/11","04107.Leipzig.Wilhelm-Leuschner-Platz.10",$out);
    $out=str_replace("Wilhelm-Leuschner-Platz.10-11","Wilhelm-Leuschner-Platz.10",$out);
    $out=str_replace("Martin-Luther-Ring.4-6","Martin-Luther-Ring.4",$out);
    $out=str_replace("Richard-Wagner-Platz.XX","Richard-Wagner-Platz.1",$out);
    $out=str_replace("04179.Leipzig.Rathenaustrasse.XX","04179.Leipzig.Rathenaustrasse.50",$out);
    $out=str_replace("MarkranstaedterStrasse29.B","MarkranstaedterStrasse.29B",$out);
    $out=str_replace("Wolfgang-Heinze-Strasse.XX","Wolfgang-Heinze-Strasse.34",$out);
    $out=str_replace("Nikolaikirchhof.XX","Nikolaikirchhof.1",$out);
    $out=str_replace("Markt.XX","Markt.1",$out);
    $out=str_replace("Kolonnadenstrasse.XX","Kolonnadenstrasse.19",$out);
    $out=str_replace("Basedowstrasse.XX","Wolfgang-Heinze-Strasse.34",$out);
    $out=str_replace("Anton-Bruckner-Allee.XX","Anton-Bruckner-Allee.1",$out);
    $out=str_replace("Naschmarkt.XX","Naschmarkt.1",$out);
    $out=str_replace("Wilhelm-Leuschner-Platz.XX","Wilhelm-Leuschner-Platz.10",$out);
    $out=str_replace("09648.MittweidaOTRingethal.Hauptstrasse.18","09648.Ringethal.Hauptstrasse.18",$out);
    $out=str_replace("","",$out);
    $out=str_replace("","",$out);
    $out=str_replace("","",$out);
    $out=str_replace("","",$out);
    $out=str_replace("","",$out);

    return $out;
}

/* Weitere Probleme:

   04177.Leipzig.Helmholtzstrasse.XX
   Karl-Heine-Strasse.XX
   04668.Grimma,OrtsteilKoessern.Treffpunkt:WaldparkplatzanderStrasseGrimma/OTKoessern–Boehlen.XX
   04683.Belgershain,OrtteilRohrbach.anderKircheinRohrbach.XX
   http://leipzig-data.de/Data/...XX
   04668.Otterwisch.OtterwischamMuehlteich,linksderStrassevonOtterwischnachRohrbachanderScheune.XX
   04821.Polenz.PlanitzwaldanderAltenFoersterei,Zufahrt:WegueberPolenzamPferdehof.XX
   04668.Grimma.Flossplatz,ParkplatzanderHaengebrueckeinGrimma.XX
   04177.Leipzig.GrillplatzFriesenstrasse.XX
   04277.Leipzig.NeueLinie,Wildschweingehege.XX
   04178.Leipzig.ZumBahnhof.XX
   04277.Leipzig.Mathildenstrasse.XX
   04317.Leipzig.EilenburgerStrasse.XX
   04277.Leipzig.KohrenerStrasse.XX
   06237.Leuna.SchwarzerWeg.XX
   LeipzigCentralStation.XX

Nachzutragen: 
04105.Leipzig.Marienweg.56
04277.Leipzig.Wolfgang-Heinze-Strasse.34

*/

function getAddressURI($row) {
    $strasse=$row["address"];
    if(empty($strasse)) { return ""; }
    $strasse=getStreet($strasse).".".getHouseNumber($strasse);
    $plz=$row["zip"];
    $stadt=$row["location"];
    $out=fixURI("$plz.$stadt.$strasse");
    $out=str_replace("Trebsen/Mulde", "Trebsen", $out);  
    $out=str_replace("LuetznerStreet", "LuetznerStrasse", $out);  
    $out=str_replace("Katharinenstrasse.21-23", "Katharinenstrasse.21", $out);  
    $out=str_replace("R.-Becher", "R-Becher", $out);  
    $out=str_replace("Stockartstrasse.111", "Stockartstrasse.11", $out);  
    return $out;
}
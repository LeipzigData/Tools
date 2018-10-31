<?php
/**
 * User: Hans-Gert Gräbe
 * Created: 2018-08-04
 * Last Update: 2018-08-05

 * Extrahiere Akteursinformationen aus der REST-Schnittstelle users.json

 * Es werden Instanzen der Klasse nl:Akteur erzeugt. Jede Instanz hat die
 * NL-URI http://nachhaltiges-leipzig.de/Data/Akteur.<id> sowie eine aus dem
 * Namen abgeleitete LD-URI. Aus der Adresse wird weiter eine LD-Adress-URI
 * berechnet, die in einem weiteren Arbeitsgang zu konsolidieren sind.  

 * Es gibt zwei Ausgaberoutinen. getAkteure() ist ausführlicher und sortiert
 * die Instanzen nach der NL-URI.  getLDAkteure() ist kompakter und sortiert
 * die Instanzen nach der LD-URI.  Letztere Daten dienen dem Abgleich mit den
 * Einträgen in leipzig-data.de, wobei die Akteure nach Adressen und Namen
 * sortiert werden.

 * Alle personenbezogenen Daten sind in personen.php ausgelagert und werden von
 * dort referenziert.  Hier werden keine personenbezogenen Daten gespeichert.

 * Prädikate sind in der README.md genauer beschrieben. 

 */

include_once("helper.php");

function getAkteure() {
    $src="http://daten.nachhaltiges-leipzig.de/api/v1/users.json";
    //$src="/home/graebe/git/LD/ld-workbench/ZAK-Datenprojekt/Daten/users.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $out=''; // print_r($res);
    foreach ($res as $row) {
        $out.=createAkteur($row);
    }
  
    return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Akteure/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    dct:created "2018-08-04" ; 
    rdfs:label "Nachhaltiges Leipzig - Akteure" .

'.$out;

}

function createAkteur($row) {
  $id=$row['id'];
  $b=array(); 
  $b[]=' a nl:Akteur '; 
  $b=addLiteral($b,'nl:hasFullAddress', $row['full_address']);
  $b=addResource($b,'ld:proposedAddress', "http://leipzig-data.de/Data/",
     proposeAddressURI($row['full_address']));
  $b=addLiteral($b,'foaf:mbox', $row['email']);
  $b=addLiteral($b,'rdfs:label', $row['name']);
  //$b=addResource($b,'nl:proposedURI', "http://leipzig-data.de/Data/Akteur/", fixOrgURI($row['name']));
  $b=addResource($b,'foaf:homepage', "", $row['organization_url']);
  $b=addResource($b,'a', "http://nachhaltiges-leipzig.de/Data/Model#", $row['organization_type']);
  //$b=addResource($b,'foaf:image', "", $row['organization_logo_url']);
  $b=addLiteral($b,'gsp:asWKT', getWKT($row['latlng']));
  // $b=addLiteral($b,'nl:hasDistrict', $row['district']);
  // $b=addLiteral($b,"dct:modified","2018-08-04");
  return
      '<http://nachhaltiges-leipzig.de/Data/Akteur.'. $id .'>'. join(" ;\n  ",$b) . " . \n\n" ;
}

function getLDAkteure() {
    $src="http://daten.nachhaltiges-leipzig.de/api/v1/users.json";
    // $src="/home/graebe/git/LD/ld-workbench/ZAK-Datenprojekt/Daten/users.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $out=''; // print_r($res);
    foreach ($res as $row) {
        $out.=createLDAkteur($row);
    }
  
    return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/NL-Akteure/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    dct:created "2018-08-05" ; 
    rdfs:label "Nachhaltiges Leipzig - Akteure zum Abgleich mit leipzig-data.de" .

'.$out;

}

function createLDAkteur($row) {
    $id=$row['id'];
    $uri=fixOrgURI($row['name']);
    $b=array(); 
    $b[]=' a nl:Akteur '; 
    $b=addLiteral($b,'nl:hasFullAddress', $row['full_address']);
    $b=addResource($b,'ld:proposedAddress', "http://leipzig-data.de/Data/",
    proposeAddressURI($row['full_address']));
    $b=addResource($b,'owl:sameAs', "http://nachhaltiges-leipzig.de/Data/Akteur.",$id);
    $b=addLiteral($b,'rdfs:label', $row['name']);
    $b=addLiteral($b,'foaf:mbox', $row['email']);
    $b=addResource($b,'foaf:homepage', "", $row['organization_url']);
    $b=addResource($b,'a', "http://nachhaltiges-leipzig.de/Data/Model#", $row['organization_type']);
    $b=addLiteral($b,'gsp:asWKT', getWKT($row['latlng']));
    $b=addLiteral($b,"dct:modified","2018-08-10");
    return
        '<http://leipzig-data.de/Data/Akteur/'.$uri.'>'. join(" ;\n  ",$b) . " . \n\n" ;
}

function getAkteursOrte() {
    $src="http://daten.nachhaltiges-leipzig.de/api/v1/users.json";
    // $src="/home/graebe/git/LD/ld-workbench/ZAK-Datenprojekt/Daten/users.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $out=''; // print_r($res);
    foreach ($res as $row) {
        $out.=createAkteursOrt($row);
    }
  
    return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/NL-Akteure/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    dct:created "2018-10-30" ; 
    rdfs:label "Nachhaltiges Leipzig - Akteursorte zum Abgleich mit leipzig-data.de" .

'.$out;

}

function createAkteursOrt($row) {
    $id=$row['id'];
    $uri=fixOrgURI($row['name']);
    $b=array(); 
    $b[]=' a nl:Ort '; 
    $b=addLiteral($b,'nl:hasFullAddress', $row['full_address']);
    $b=addResource($b,'ld:proposedAddress', "http://leipzig-data.de/Data/",
    proposeAddressURI($row['full_address']));
    $b=addResource($b,'ld:hasSupplier', "http://nachhaltiges-leipzig.de/Data/Akteur.",$id);
    $b=addLiteral($b,'rdfs:label', $row['name']);
    $b=addLiteral($b,'gsp:asWKT', getWKT($row['latlng']));
    $b=addLiteral($b,"dct:modified","2018-10-30");
    return
        '<http://leipzig-data.de/Data/Ort/'.$uri.'>'. join(" ;\n  ",$b) . " . \n\n" ;
}

// zum Testen
echo getAkteursOrte();
// echo getAkteure();
// echo getLDAkteure();

?>

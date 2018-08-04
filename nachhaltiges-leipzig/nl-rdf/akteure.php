<?php
/**
 * User: Hans-Gert Gräbe
 * Datum: 04.08.2018
 * Last Update: 

 * Extrahiere Akteursinformationen aus der REST-Schnittstelle users.json

 * Es werden Instanzen der Klasse nl:Akteur erzeugt. Alle personenbezogenen
 * Daten sind in personen.php ausgelagert und werden von dort referenziert.
 * Hier werden keine personenbezogenen Daten gespeichert.

 * Prädikate in users.json: id, name, organization_type, organization_url,
 * organization_logo_url, full_address, district, latlng, first_name,
 * last_name, organization_position, email, phone_primary, phone_secondary

 */

include_once("helper.php");

function getAkteure() {
    //$src="http://daten.nachhaltiges-leipzig.de/api/v1/users.json";
    $src="/home/graebe/git/LD/ld-workbench/ZAK-Datenprojekt/Daten/users.json";
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
  $b=addResource($b,'ld:proposedAddress', "http://leipzig-data.de/Data/",
     proposeAddressURI($row['full_address']));
  $b=addLiteral($b,'foaf:mbox', $row['email']);
  $b=addLiteral($b,'rdfs:label', $row['name']);
  $b=addResource($b,'nl:proposedURI', "http://leipzig-data.de/Data/Akteur/", fixOrgURI($row['name']));
  $b=addResource($b,'foaf:homepage', "", $row['organization_url']);
  $b=addResource($b,'a', "http://nachhaltiges-leipzig.de/Data/Model#", $row['organization_type']);
  //$b=addResource($b,'foaf:image', "", $row['organization_logo_url']);
  $b=addLiteral($b,'gsp:asWKT', getWKT($row['latlng']));
  // $b=addLiteral($b,'nl:hasDistrict', $row['district']);
  $b=addLiteral($b,"dct:modified","2018-08-04");
  return
      '<http://nachhaltiges-leipzig.de/Data/Akteur.'. $id .'>'. join(" ;\n  ",$b) . " . \n\n" ;
}

// zum Testen
echo getAkteure();

?>

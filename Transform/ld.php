<?php
/**
 * User: Hans-Gert Gräbe
 * Last Update: 2021-08-09

 * Extrahiere Informationen aus "Leipzig Data"

 */

include_once("helper.php");

function getLDAkteure($startId) {
    $src="../Daten/users.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        if ($row['id']>$startId) { $a[]=createLDAkteur($row); }
    }
    return $a;
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
        '<http://leipzig-data.de/Data/Akteur/'.$uri.'>'. join(" ;\n  ",$b) . " ." ;
}

function getAkteursOrte() {
    $src="../Daten/users.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $a[]=createAkteursOrt($row);
    }
    return $a;
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
echo TurtlePrefix()
    .join("\n\n", getLDAkteure())
    ;

?>

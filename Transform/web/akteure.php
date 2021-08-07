<?php
/**
 * User: Hans-Gert Gräbe
 * Last Update: 2021-08-07

 * Extrahiere Akteursinformationen aus den verschiedenen Dumps

 */

include_once("helper.php");

function getNLAkteure() {
    $src="../Dumps/nachhaltiges-sachsen/Users.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id=$row['id'];
        $b=array();
        $b[]=' a org:Organization';
        $b=addLiteral($b,'ld:hasSource','Nachhaltiges Leipzig');
        $b=addLiteral($b,'skos:prefLabel',$row['name']);
        $b=addLiteral($b,'ld:hasType',$row['organization_type']);
        $b=addResource($b,'foaf:homepage','',$row['organization_url']);
        $a[]='<http://nachhaltiges-sachsen.de/rdf/Akteur_'.$id.'>'.
            join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

function getLEAkteure() {
    $src="../Dumps/leipziger-ecken/Akteure.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res['data'] as $row) {
        $id=$row['id'];
        $att=$row['attributes'];
        $b=array();
        $b[]=' a org:Organization';
        $b=addLiteral($b,'ld:hasSource','Leipziger Ecken');
        $b=addLiteral($b,'skos:prefLabel',$att['title']);
        $b=addLiteral($b,'ld:hasType',$row['type']);
        if (!empty($att['external_url'])) { 
            $b=addResource($b,'foaf:homepage',"",$att['external_url']['uri']);
        }
        $a[]='<http://leipziger-ecken.de/rdf/Akteur_'.$id.'>'.
            join(" ;\n  ",$b) . " ." ;
    }
    return $a;
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
  $b=addLiteral($b,"dct:modified","2019-02-24");
  return
      '<http://nachhaltiges-leipzig.de/Data/Akteur.'. $id .'>'. join(" ;\n  ",$b) . " . \n\n" ;
}

function getLDAkteure($startId) {
    $src="../Daten/users.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $out=''; // print_r($res);
    foreach ($res as $row) {
        if ($row['id']>$startId) { $out.=createLDAkteur($row); }
    }
  
    return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/NL-Akteure/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    dct:created "2019-02-24" ; 
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
    $src="../Daten/users.json";
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
//echo TurtlePrefix().join("\n\n", getNLAkteure());
echo TurtlePrefix().join("\n\n", getLEAkteure());

?>

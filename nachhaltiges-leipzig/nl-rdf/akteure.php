<?php

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
    rdfs:label "Nachhaltiges Leipzig - Akteure" .

'.$out;

}

function createAkteur($row) {
  $id=$row['id'];
  $a=array(); $b=array(); $c=array(); 
  $a[]=' a foaf:Person '; $b[]=' a nl:Akteur '; $c[]=' a org:Membership ';
  $a=addLiteral($a,'nl:hasID', $id);
//  $a=addLiteral($a,'dct:created', fixDate($row['created_at']));
//  $b=addLiteral($b,'dct:modified', fixDate($row['updated_at']));
//  $a=addLiteral($a,'nl:lastLoginAt', fixDate($row['last_login_at']));
//  $a=addLiteral($a,'nl:lastActivityCheckAt', fixDate($row['activity_check_at']));
//  $a=addLiteral($a,'nl:ActivityCheckState', $row['activity_check_state']);
  $a=addLiteral($a,'foaf:firstName', $row['first_name']);
  $a=addLiteral($a,'foaf:lastName', $row['last_name']);
  $a=addResource($a,'nl:proposedURI',  "http://leipzig-data.de/Data/Person/",
  fixNameURI($row['last_name']."_".$row['first_name']));
  $b=addResource($b,'ld:proposedAddress', "http://leipzig-data.de/Data/",
     getAddressURIfromAPI($row['full_address']));
  $b=addLiteral($b,'foaf:mbox', $row['email']);
  $a=addLiteral($a,'foaf:phone', fixPhone($row['phone_primary']));
  $a=addLiteral($a,'foaf:phone', fixPhone($row['phone_secondary']));
  $b=addResource($b,'nl:contactPerson', "http://nachhaltiges-leipzig.de/Data/Person.", $id);
  $b=addLiteral($b,'rdfs:label', $row['name']);
  $b=addResource($b,'nl:proposedURI', "http://leipzig-data.de/Data/Akteur/", fixOrgURI($row['name']));
  $b=addResource($b,'foaf:homepage', "", $row['organization_url']);
  $b=addLiteral($b,'nl:orgType', $row['organization_type']);
  $c=addResource($c,'org:member', "http://nachhaltiges-leipzig.de/Data/Person.", $id);
  $c=addResource($c,'org:organization', "http://nachhaltiges-leipzig.de/Data/Akteur.", $id);
  $c=addLiteral($c,'nl:hasPosition', $row['organization_position']);
  $b=addLiteral($b,'foaf:image', $row['organization_logo_url']);
  $b=addLiteral($b,'nl:hasDistrict', $row['district']);
//  $b=addLiteral($b,'nl:isReviewed', $row['reviewed']);
//  $b=addLiteral($b,'nl:isTradeOrganization', $row['trade_organization']);
  return
      '<http://nachhaltiges-leipzig.de/Data/Akteur.'. $id .'>'. join(" ;\n  ",$b) . " . \n" .
      '<http://nachhaltiges-leipzig.de/Data/Person.'. $id .'>'. join(" ;\n  ",$a) . " . \n" .
      '<http://nachhaltiges-leipzig.de/Data/Membership.'. $id .'>'. join(" ;\n  ",$c) . " . \n\n" ;
}

// zum Testen
echo getAkteure();

?>

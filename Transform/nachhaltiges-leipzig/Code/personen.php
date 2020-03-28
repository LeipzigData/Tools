<?php
/**
 * User: Hans-Gert Gräbe
 * Created: 2018-08-03
 * Last Update: 2020-03-27

 * Extrahiere Personeninformationen aus dem Dump ../Daten/users.json
 * Diese sind aus datenschutzrechtlichen Gründen separiert von den
 * Informationen über Akteure.

 * Es werden Instanzen der Klassen foaf:Person und org:Membership erzeugt. 

 * Prädikate in users.json: id, name, organization_type, organization_url,
 * organization_logo_url, full_address, district, latlng (array), first_name,
 * last_name, organization_position, email, phone_primary, phone_secondary

 */

include_once("helper.php");

function getPersonen() {
    $src="../Daten/users.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $out=''; // print_r($res);
    foreach ($res as $row) {
        $out.=createPerson($row);
    }
  
    return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Personen/> a owl:Ontology ;
    dct:created "2018-08-03" ; 
    rdfs:comment "Extrahiert aus der REST-Schnittstelle";
    rdfs:label "Nachhaltiges Leipzig - Personen" .

'.$out;

}

function createPerson($row) {
  if ($row['last_name']=="Reha-Fachhandel") { return ; }
  if ($row['last_name']=="Safari-Büro") { return ; }
  if ($row['last_name']=="Tauschring") { return ; }
  if ($row['last_name']=="Verein") { return ; }
  $id=$row['id'];
  $name=$row['last_name'];
  $name=str_replace("´","",$name);
  $vorname=$row['first_name']; 
  $vorname=str_replace("&#39;","",$vorname);
  $vorname=str_replace(" E. A.","",$vorname);
  $uri="http://leipzig-data.de/Data/Person/"
      .fixNameURI($name."_".$vorname);
  $a=array(); $c=array(); 
  $a[]=' a foaf:Person '; $c[]=' a org:Membership ';
  $a=addResource($a,'owl:sameAs',
  "http://nachhaltiges-leipzig.de/Data/Person.", $id);
  $a=addLiteral($a,'foaf:firstName', $vorname);
  $a=addLiteral($a,'foaf:lastName', $name);
  $a=addLiteral($a,'foaf:mbox', $row['email']);
  $a=addLiteral($a,'foaf:phone', fixPhone($row['phone_primary']));
  $a=addLiteral($a,'foaf:phone', fixPhone($row['phone_secondary']));
  $c=addResource($c,'org:member', "", $uri);
  $a=addLiteral($a,"dct:modified","2018-08-04");
  $c=addLiteral($c,"dct:modified","2018-08-04");
  $c=addResource($c,'org:organization',
  "http://nachhaltiges-leipzig.de/Data/Akteur.", $id);
  $c=addLiteral($c,'nl:hasPosition', $row['organization_position']);
  return
      '<'.$uri.'>'. join(" ;\n  ",$a) . " . \n" .
      '<http://nachhaltiges-leipzig.de/Data/Membership.'. $id .'>'
      . join(" ;\n  ",$c) . " . \n\n" ;
}

// zum Testen
// echo getPersonen();

?>

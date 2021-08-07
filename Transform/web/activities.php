<?php
/**
 * User: Hans-Gert Gräbe
 * Created: 2018-08-04
 * Last Update: 2020-03-27

 * Extrahiere Informationen zu Aktivitäten aus dem Dump ../Daten/activities.json

 * Es werden Instanzen der Klasse nl:Activity erzeugt. Jede Instanz hat die
 * NL-URI http://nachhaltiges-leipzig.de/Data/Activity.<id>. Aus der Adresse
 * wird weiter eine LD-Adress-URI berechnet, die in einem weiteren Arbeitsgang
 * zu konsolidieren sind.

 * In der neuen Version wird außerdem die neu verfügbare strukturierte
 * Adressinformation ausgewertet.

 * getActivities() ist ausführlicher und sortiert die Instanzen nach der
 * NL-URI.  Noch zu klären ist, wie mit verschiedenen Aktivitätstypen
 * umzugehen ist.

 * Prädikate sind in der Datei README.md genauer beschrieben. 

 */

include_once("helper.php");

function getActivityArray() {
    $src="../Daten/activities.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array(); // print_r($res);
    foreach ($res as $row) {
        $a=createActivity($a,$row);
    }
    return $a;
}

function getAllActivities() {
    $a=getActivityArray();
    return TurtlePrefix()
        .'<http://nachhaltiges-leipzig.de/Data/Activities/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    dct:created "2019-01-31" ; 
    rdfs:label "Nachhaltiges Leipzig - Alle Aktivitäten" .
    '. join("\n\n",$a);
}

function getEvents() {
    $a=getActivityArray();
    return TurtlePrefix()
        .'<http://nachhaltiges-leipzig.de/Data/Events/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    dct:created "2018-08-05" ; 
    rdfs:label "Nachhaltiges Leipzig - Events" .
    '. $a["Event"];
}

function getActions() {
    $a=getActivityArray();
    return TurtlePrefix()
        .'<http://nachhaltiges-leipzig.de/Data/Actions/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    dct:created "2018-08-05" ; 
    rdfs:label "Nachhaltiges Leipzig - Actions" .
    '. $a["Action"];
}

function getProjects() {
    $a=getActivityArray();
    return TurtlePrefix()
        .'<http://nachhaltiges-leipzig.de/Data/Projects/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    dct:created "2018-08-05" ; 
    rdfs:label "Nachhaltiges Leipzig - Projects" .
    '. $a["Project"];
}

function getServices() {
    $a=getActivityArray();
    return TurtlePrefix()
        .'<http://nachhaltiges-leipzig.de/Data/Services/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    dct:created "2018-08-05" ; 
    rdfs:label "Nachhaltiges Leipzig - Services" .
    '. $a["Service"];
}

function getStores() {
    $a=getActivityArray();
    return TurtlePrefix()
        .'<http://nachhaltiges-leipzig.de/Data/Stores/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    dct:created "2018-08-05" ; 
    rdfs:label "Nachhaltiges Leipzig - Stores" .
    '. $a["Store"];
}

function createActivity($u,$row) {
  $id=$row['id'];
  $type=$row['type'];
  $a=array();
  $a[]=' a nl:Activity ';
  $a=addLiteral($a,'nl:hasID', $id);
  $a=addResource($a,'nl:hasType', "http://nachhaltiges-leipzig.de/Data/Model#", $type);
  $a=addResource($a,'nl:hasAkteur', "http://nachhaltiges-leipzig.de/Data/Akteur.", $row['user_id']);
  $a=addLiteral($a,'rdfs:label', $row['name']);
  $a=addLiteral($a,'gsp:asWKT', getWKT($row['latlng']));
  $a=addMLiteral($a,'nl:hasDescription', $row['description']);
  $a=addLiteral($a,'nl:hasDistrict', $row['district']);
  $a=addLiteral($a,'nl:hasFullAddress', $row['full_address']);
  $a=addResource($a, 'ld:proposedAddress', "http://leipzig-data.de/Data/",
      proposeAddressURI($row['full_address']));
  $a=addResource($a, 'ld:inferredAddress', "http://leipzig-data.de/Data/",
      infereAddressURI($row));
  // $a=addLiteral($a,'nl:hasFallbackAddress', $row['is_fallback_address']); Wert ggf=1
  $a=addResource($a,'nl:hasInfoURL', "", fixInfoURL($row['info_url']));
  $a=addResource($a,'nl:hasImageURL', "", $row['image_url']);
  $a=addResource($a,'nl:hasVideoURL', "", $row['video_url']);
  $a=addLiteral($a,'ical:dtstart', $row['start_at']);
  $a=addLiteral($a,'ical:dtend', $row['end_at']);
  $a=addLiteral($a,'nl:hasTargetGroup', $row['target_group']);
  $a=addLiteral($a,'nl:hasCosts', $row['costs']);
  $a=addMLiteral($a,'nl:hasRequirements', $row['requirements']);
  $a=addLiteral($a,'nl:hasSpeaker', $row['speaker']);
  $a=addLiteralGroup($a,'nl:hasCategories', $row['categories']);
  $a=addLiteral($a,'nl:hasFirstRootCategory', $row['first_root_category']);
  $a=addLiteral($a,'nl:hasSummary', $row['short_description']);
  $a=addLiteralGroup($a,'nl:hasGoals', $row['goals']);
  $a=addLiteralGroup($a,'nl:hasPropertyList', $row['property_list']);
  $a=addLiteral($a,'nl:hasServiceType', $row['service_type']);
  $a=addLiteral($a,'nl:hasTargetGroupSelection', $row['target_group_selection']);
  $a=addLiteral($a,'nl:hasDuration', $row['duration']);
  $a=addLiteralGroup($a,'nl:hasProducts', $row['products']);
  $a=addLiteralGroup($a,'nl:hasTradeCategories', $row['trade_categories']);
  $a=addLiteralGroup($a,'nl:hasTradeTypes', $row['trade_types']);
  $u[$type].='
<http://nachhaltiges-leipzig.de/Data/Activity.'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
  return $u;
}

function fixInfoURL($s) {
    $s=str_replace(", Dölitzer Wassermühle", "", $s);
    $s=str_replace(", www.bund-leipzig.de", "", $s);
    return $s;
}

// zum Testen
// echo getAllActivities();

?>

<?php
/**
 * User: Hans-Gert Gräbe
 * Last Update: 2021-08-10

 * Extrahiere Akteursinformationen aus "Nachhaltiges Sachsen"

 */

include_once("helper.php");

function getNLAkteure() {
    $src="Dumps/nachhaltiges-sachsen/Users.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id=$row['id'];
        $lid="https://daten.nachhaltiges-sachsen.de/api/v1/users/$id.json";
        $b=array();
        $b[]=' a nl:Akteur';
        $b=addLiteral($b,'ld:hasSource','Nachhaltiges Leipzig');
        $b=addLiteral($b,'rdfs:label',$row['name']);
        $b=addLiteral($b,'ld:hasFullAddress',$row['full_address']);
        $b=addLiteral($b,'ld:inRegion',$row['district']);
        $b=addLiteral($b,'gsp:asWKT',getWKT($row['latlng']));
        if (!empty($row['region'])) {
            $b=addLiteral($b,'ld:inRegion',$row['region']['name']);
        }
        $b=addLiteral($b,'ld:hasType',$row['organization_type']);
        $b=addResource($b,'foaf:homepage','',$row['organization_url']);
        $a[]="<$lid>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

function getNLProducts() {
    $src="Dumps/nachhaltiges-sachsen/Products.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id=$row['id'];
        $lid="https://daten.nachhaltiges-sachsen.de/api/v1/products/$id.json";
        $b=array();
        $b[]=' a nl:Product';
        $b=addLiteral($b,'ld:hasSource','Nachhaltiges Leipzig');
        $b=addLiteral($b,'rdfs:label',$row['name']);
        $a[]="<$lid>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

function getNLRegions() {
    $src="Dumps/nachhaltiges-sachsen/Regions.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id=$row['id'];
        $lid="https://daten.nachhaltiges-sachsen.de/api/v1/regions/$id.json";
        $b=array();
        $b[]=' a nl:Region';
        $b=addLiteral($b,'ld:hasSource','Nachhaltiges Leipzig');
        $b=addLiteral($b,'rdfs:label',$row['name']);
        $a[]="<$lid>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

function getNLEvents() {
    $src="Dumps/nachhaltiges-sachsen/Activities.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        if($row['type']=="Event") {
            $id=$row['id'];
            $lid="https://daten.nachhaltiges-sachsen.de/api/v1/activities/$id.json";
            $b=array();
            $b[]=' a nl:Event';
            $b=addLiteral($b,'ld:hasSource','Nachhaltiges Leipzig');
            $b=addLiteral($b,'rdfs:label',$row['name']);
            $b=addResource($b,'foaf:homepage',"",$row['info_url']);
            $b=addLiteral($b,'ld:hasFullAddress',$row["full_address"]);
            $b=addLiteral($b,'ical:dtstart',$row["start_at"]);
            $b=addLiteral($b,'gsp:asWKT',getWKT($row['latlng']));
            if(!empty($row["region"])) {
                $b=addResource($b,'ld:inRegion','',
                               'https://daten.nachhaltiges-sachsen.de/api/v1/regions/'
                               .$row["region"]["id"].'.json');
            }
            $b=addResource($b,'ld:hasAkteur','',
                           'https://daten.nachhaltiges-sachsen.de/api/v1/users/'
                           .$row["user_id"].'.json');
            foreach($row["goals"] as $v) {
                $b=addLiteral($b,'ld:hasGoal',$v);
            }
            foreach($row["categories"] as $v) {
                $b=addResource($b,'ld:hasCategory','',
                           'https://daten.nachhaltiges-sachsen.de/api/v1/categories/'
                           .$v.'.json');
            }
        }
        $a[]="<$lid>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

$out=join("\n\n", getNLAkteure())
    .join("\n\n", getNLProducts())
    .join("\n\n", getNLRegions())
    .join("\n\n", getNLEvents())
    ;

// fixe Fehler in den Daten
$out=str_replace("http://kinobar-leipzig.de, Dölitzer Wassermühle","http://kinobar-leipzig.de",$out);
$out=str_replace("http://www.kleingarten-museum.de, www.bund-leipzig.de","http://www.kleingarten-museum.de",$out);


echo TurtlePrefix().$out;

?>

<?php

include_once("helper.php");
/*
    [0] => Array
        (
            [id] => 1847
            [type] => Event
            [user_id] => 227
            [name] => Bunte Apfelernte &amp; Rezeptetauschbörse
            [latlng] => Array
                (
                    [0] => 51.3293
                    [1] => 12.4285
                )

            [description] => Wer hat das beste Apfelmusrezept und was kann man noch so aus Äpfeln machen? Wir wollen mit euch die vollen Bäume ernten und unsere geheimen Rezepte tauschen. Kommt vorbei, wir freuen uns !
            [district] => Anger-Crottendorf
            [full_address] => Pommernstraße 10, 04318 Leipzig
            [is_fallback_address] =>
            [info_url] => http://bunte-gaerten.org
            [video_url] =>
            [image_url] => http://daten.nachhaltiges-leipzig.de/system/event/image/00001234/erntedank_bunteGaerten.jpg
            [start_at] => 2018-09-22T15:00:00.000+02:00
            [end_at] => 2018-09-22T18:00:00.000+02:00
            [target_group] =>
            [costs] =>
            [requirements] =>
            [speaker] =>
            [categories] => Array                (
                    [0] => 150
                )

            [first_root_category] => 50
        )

 */

function getActivities() {
    //$src="http://daten.nachhaltiges-leipzig.de/api/v1/activities.json";
    $src="/home/graebe/git/LD/ld-workbench/ZAK-Datenprojekt/Daten/activities.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $out=''; // print_r($res);
    $out='';
    foreach ($res as $row) {
        $out.=createActivity($row);
    }
    
    return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Activities/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Activities" .

    '.$out; 

}

function createActivity($row) {
  $id=$row['id'];
  $a=array();
  $a[]=' a nl:Activity ';
  $a=addLiteral($a,'nl:hasID', $id);
  $a=addLiteral($a,'nl:hasType', $row['type']);
  $a=addLiteral($a,'nl:hasuserID', $row['user_id']);
  $a=addLiteral($a,'rdfs:label', $row['name']);
  $a=addLiteral($a,'gsp:asWKT', getWKT($row['latlng']));
  $a=addMLiteral($a,'nl:hasDescription', $row['description']);
  $a=addLiteral($a,'nl:hasFullAddress', $row['full_address']);
  $a=addResource($a, 'ld:proposedAddress', "http://leipzig-data.de/Data/",
      proposeAddressURI($row['full_address']));
  // $a=addLiteral($a,'nl:hasFallbackAddress', $row['is_fallback_address']); Wert ggf=1
  $a=addResource($a,'nl:hasVideoURL', "", $row['video_url']);
  $a=addResource($a,'nl:hasInfoURL', "", fixInfoURL($row['info_url']));
  $a=addResource($a,'nl:hasImageURL', "", $row['image_url']);
  $a=addLiteral($a,'ical:dtstart', $row['start_at']);
  $a=addLiteral($a,'ical:dtend', $row['end_at']);
  $a=addLiteral($a,'nl:hasTargetGroup', $row['target_group']);
  $a=addLiteral($a,'nl:hasCosts', $row['costs']);
  $a=addLiteral($a,'nl:hasSpeaker', $row['speaker']);
  $a=addLiteral($a,'nl:hasFirstRootCategory', $row['first_root_category']);
  // Array categories
  $a=addLiteral($a,'nl:hasDistrict', $row['district']);
  return '<http://nachhaltiges-leipzig.de/Data/Activity.'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

function fixInfoURL($s) {
    $s=str_replace(", Dölitzer Wassermühle","",$s);
    $s=str_replace(", www.bund-leipzig.de","",$s);
    return $s;
}

// zum Testen
echo getActivities();

?>

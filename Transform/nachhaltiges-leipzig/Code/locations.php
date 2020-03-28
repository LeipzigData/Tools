<?php
/**
 * User: Hans-Gert Gräbe
 * Date: 2020-03-26
 * Last Update: 2020-03-27
 */

include_once("helper.php");

function getLocations() {
    $src="../Daten/locations.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $s=array();
    foreach($res as $row) {
        $s=theLocation($s,$row);       
    }
    ksort($s);
    return $s;
}

function getActivityLocations() {
    $src="../Daten/activities.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $lhash=getLocations();
    $s=array();
    foreach($res as $row) {
        $s=theActivityLocation($s,$row,$lhash);      
    }
    ksort($s);
    return $s;
}

function theLocation($s,$v) {
    // $s is the LocationHash, $v the new entry
    $id=$v["id"];
    $plz=$v["zip"];
    $ort=$v["city"];
    $strasse=$v["street_name"];
    $nr=$v["house_number"];
    $out="$plz|$ort|$strasse|$nr";
    $hash=sha1($out);
    $s["$hash"]="$hash|$id|$out";
    return $s;
}

function theActivityLocation($s,$v,$lhash) {
    // $s is the LocationHash, $v the new entry
    $id=$v["id"];
    $plz=$v["zip"];
    $ort=$v["city"];
    $strasse=$v["street_name"];
    $nr=$v["house_number"];
    $out="$plz|$ort|$strasse|$nr";
    $hash=sha1($out);
    $u='';
    if (array_key_exists($hash,$lhash)) { $u="x"; }
    $s["$hash"]="$hash|$id|$out|$u";
    return $s;
}

// Testen
// echo join("\n",getLocations()); // Speichere das als csv-Datei ab 
echo join("\n",getActivityLocations()); // Speichere das als csv-Datei ab 

?>

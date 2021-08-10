<?php
/**
 * User: Hans-Gert Gräbe
 * Last Update: 2021-08-07
 */

function createDump($src,$dest) {
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    jsonDump("Dumps/$dest.json",$res);
}

function createLEDump($src,$dest) {
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $data=$res["data"];
    $u=$res["links"]["next"];
    while(!empty($u)) {
        $src=$u["href"];
        $string = file_get_contents($src);
        echo "$src\n";
        $res = json_decode($string, true);
        $data=array_merge($data,$res["data"]);
        $u=$res["links"]["next"];
    } 
    jsonDump("Dumps/$dest.json",$data);
}

function jsonDump($fn,$s) {
    $fp=fopen($fn, "w");
    fwrite($fp, json_encode($s));
    fclose($fp);
}

function createBNESachsenDumps() {
    $prefix="https://bne-sachsen.de/wp-json/content/";
    createDump($prefix."offers","bne-sachsen/Offers");
    createDump($prefix."events","bne-sachsen/Events");
    createDump($prefix."materials","bne-sachsen/Materials");
    createDump($prefix."posts","bne-sachsen/Posts");
}

function createNachhaltigesSachsenDumps() {
    $prefix="https://daten.nachhaltiges-sachsen.de/api/v1/";
    createDump($prefix."activities.json","nachhaltiges-sachsen/Activities");
    createDump($prefix."categories.json","nachhaltiges-sachsen/Categories");
    createDump($prefix."locations.json","nachhaltiges-sachsen/Locations");
    createDump($prefix."regions.json","nachhaltiges-sachsen/Regions");
    createDump($prefix."products.json","nachhaltiges-sachsen/Products");
    createDump($prefix."users.json","nachhaltiges-sachsen/Users");
}

function createLeipzigerEckenDumps() {
    $prefix="https://leipziger-ecken.de/jsonapi/";
    createLEDump($prefix."akteure","leipziger-ecken/Akteure");
    createLEDump($prefix."events","leipziger-ecken/Events");
    createLEDump($prefix."districts","leipziger-ecken/Districts");
    createLEDump($prefix."akteur_types","leipziger-ecken/AkteurTypes");
    createLEDump($prefix."categories","leipziger-ecken/Categories");
    createLEDump($prefix."tags","leipziger-ecken/Tags");
    createLEDump($prefix."target_groups","leipziger-ecken/TargetGroups");
}

// ---- test ----
//createBNESachsenDumps();
//createNachhaltigesSachsenDumps();
createLeipzigerEckenDumps(); 

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
    createDump($prefix."akteure","leipziger-ecken/Akteure");
    createDump($prefix."events","leipziger-ecken/Events");
    createDump($prefix."districts","leipziger-ecken/Districts");
    createDump($prefix."akteur_types","leipziger-ecken/AkteurTypes");
    createDump($prefix."categories","leipziger-ecken/Categories");
    createDump($prefix."tags","leipziger-ecken/Tags");
    createDump($prefix."target_groups","leipziger-ecken/TargetGroups");
}

// ---- test ----
//createBNESachsenDumps();
//createNachhaltigesSachsenDumps();
createLeipzigerEckenDumps(); 

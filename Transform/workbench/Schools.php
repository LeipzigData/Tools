<?php
/**
 * User: Hans-Gert Gräbe
 * Last Update: 2021-02-10
 */

function addKeyValue($key,$value) {
    $value=str_replace('"','\"',$value);
    return 'ssc:'.$key.' "'.$value.'"';
}

function addBuildings($a,$v) {
    foreach($v as $w) {
        foreach($w as $key => $value) {
            if ($key=="school_type_keys") { $a=addSchoolTypes($a,$value); }
            else if (!empty($value)) { $a[]=addKeyValue($key,$value); }
        }
    }
    return $a;
}

function addSchoolTypes($a,$v) {
    foreach($v as $key => $value) {
        if (!empty($value)) { $a[]=addKeyValue("school_type",$value); }
    }
    return $a;
}

function displaySchool($v) {
    $id="<http://leipzig-data.de/Data/School/SN".$v["institution_key"].">";
    $a=array();
    foreach($v as $key => $value) {
        if ($key=="buildings") { $a=addBuildings($a,$value); }
        else if (!empty($value)) { $a[]=addKeyValue($key,$value); }
    }
    return "$id a ssc:School;\n".join(";\n",$a).' .';
}

function getSchools() {
    $src="../Data/schools.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $s=array();
    foreach($res as $row) {
        $s[$row["institution_number"]]=displaySchool($row);
    }
    ksort($s);
    return prefix().join("\n\n",$s);
}

function prefix() {
    return '@prefix ssc: <https://schuldatenbank.sachsen.de/Model#> .

';
}

echo getSchools();

?>

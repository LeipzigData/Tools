<?php
/** Test der JSON-Schnittstelle */

function collectAllPredicates($file) {
    $string=file_get_contents($file); 
    $res=json_decode($string, true);
    // print_r($res);
    $out=''; 
    $a=array();
    foreach ($res['marketentries'] as $row) {
        $a=collectPredicates($a,$row);
    }
    $b=array();
    foreach ($a as $key => $value) {
        $b[]="* $key => $value";
    }    
    return join("\n",$b)."\n";
}

function collectPredicates($a,$row) {
    foreach($row as $key => $value) {
        $a[$key]=(is_array($value) ? "Array" : "String" );
    }
    return $a ;
}

echo CollectAllPredicates("../Data/leipzig-de.json");

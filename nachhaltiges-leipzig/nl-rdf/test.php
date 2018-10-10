<?php
/** Test der API-Schnittstelle */

function getFileFromAPI($file) {
    $src="http://daten.nachhaltiges-leipzig.de/api/v1/$file";
    return file_get_contents($src);
}

function collectAllPredicates($file) {
    $string=getFileFromAPI($file); 
    $res=json_decode($string, true);
    // print_r($res);
    $out=''; 
    $a=array();
    foreach ($res as $row) {
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


//echo CollectAllPredicates("categories.json");
//echo CollectAllPredicates("products.json");
//echo CollectAllPredicates("trade_types.json");
//echo CollectAllPredicates("trade_categories.json");
//echo getFileFromAPI("categories.json");
//echo getFileFromAPI("products.json");
//echo getFileFromAPI("trade_types.json");
echo getFileFromAPI("trade_categories.json");

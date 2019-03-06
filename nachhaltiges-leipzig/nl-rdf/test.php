<?php
/** Test der API-Schnittstelle */

function getFileFromAPI($file) {
    $src="http://daten.nachhaltiges-leipzig.de/api/v1/$file";
    $string=file_get_contents($src);
    return json_decode($string, true);
}

function collectAllPredicates($file) {
    $res=getFileFromAPI($file); 
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

function collectAllPredicatesByType($file) {
    $res=getFileFromAPI($file); 
    // print_r($res);
    $out=''; 
    $a=array();
    foreach ($res as $row) {
        $a=collectPredicatesByType($a,$row);
    }
    $out='';
    foreach ($a as $type => $hash) {
        $b=array();
        foreach ($hash as $key => $value) {
            $b[]="* $key => $value";
        }
        $out.="$type:\n".join("\n",$b)."\n";
    }
    return $out;
}

function collectPredicates($a,$row) {
    foreach($row as $key => $value) {
        $a[$key]=(is_array($value) ? "Array" : "String" );
    }
    return $a ;
}

function collectPredicatesByType($a,$row) {
    $type=$row["type"];
    foreach($row as $key => $value) {
        $a[$type][$key]=(is_array($value) ? "Array" : "String" );
    }
    return $a ;
}

function checkAdressen() {
    $res=getFileFromAPI("activities.json");
    $a=array();
    foreach ($res as $row) {
        $address=$row["full_address"];
        $id=$row["id"];
        $a[$address]=$a[$address].", ".$id;
    }
    print_r($a);    
}

function getActivitiesByUser($id) {
    $res=getFileFromAPI("activities.json");
    $s=array();
    foreach ($res as $row) {
        if (($row["user_id"]==$id)
        and ($row["start_at"]>="2019-01-01")
        ) { $s[]=displayActivity($row); }
    }
    return join("\n-------\n",$s);
}

function listActivitiesByUser($id) {
    $res=getFileFromAPI("activities.json");
    $s=array();
    foreach ($res as $row) {
        if ($row["user_id"]==$id) { $s[]=$row["id"]; }
    }
    return join(", ",$s);
}

function displayActivity($row) {
    $s=array();
    $s[]="Event-ID: ".$row["id"];
    $s[]="Tag: ".$row["start_at"];
    $s[]="Titel: ".$row["name"]; 
    $s[]="Beschreibung: ".$row["description"]; 
    return join("\n",$s);
}


//echo CollectAllPredicatesByType("activities.json");
//echo CollectAllPredicates("activities.json");
//echo CollectAllPredicates("categories.json");
//echo CollectAllPredicates("products.json");
//echo CollectAllPredicates("trade_types.json");
//echo CollectAllPredicates("trade_categories.json");
//echo getFileFromAPI("categories.json");
//echo getFileFromAPI("products.json");
//echo getFileFromAPI("trade_types.json");
//echo getFileFromAPI("trade_categories.json");

echo getActivitiesByUser(73);
// echo listActivitiesByUser(73);

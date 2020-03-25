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

// -----  Display Bildungsangebote ------------

function getBildungsangebote() {
    $string=file_get_contents("/home/graebe/git/LD/web/demo/zd-web/activities.json");
    $res=json_decode($string, true);
    $s=array();
    foreach ($res as $row) {
        if (($row["type"]=="Service")
        and ($row["service_type"]=="Bildungsangebot")
        ) { $s[]=displayAngebot($row); }
    }
    return join("\n-------\n",$s);
}

function displayAngebot($row) {
    $s=array();
    $s[]="Event-ID: ".$row["id"];
    $s[]="Service-Type: ".$row["service_type"];
    $s[]="Titel: ".$row["name"]; 
    $s[]="Beschreibung: ".$row["description"]; 
    return join("\n",$s);
}

// -----  Display Activities ------------

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

// -----  Display Goals ------------

function collectGoals() {
    $string=file_get_contents("/home/graebe/git/LD/web/demo/zd-web/activities.json");
    $res=json_decode($string, true);
    //$res=getFileFromAPI("activities.json");
    $a=array();
    foreach ($res as $row) {
        $a=getGoals($a,$row);
    }
    return join("\n",$a);
}

function getGoals($a,$row) {
    if (isset($row["goals"])) {
        foreach($row["goals"] as $v) {
            $a[$v]=$v;
        }
    }
    return $a;
}

// -----  Display Categories ------------

function getCategories() {
    $res=getFileFromAPI("categories.json");
    $a=array();
    foreach ($res as $row) {
        $a[]=$row['id'].";0;".$row['name'];
        foreach ($row['goal_cloud'] as $v) {
            $a[]=$v['id'].";".$row['id'].";".$v['name'];
        }
    }
    return join("\n",$a);
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

// echo getActivitiesByUser(73);
// echo listActivitiesByUser(73);

// echo getCategories();
// echo collectGoals();
echo getBildungsangebote(); 
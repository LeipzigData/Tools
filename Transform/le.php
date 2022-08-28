<?php
/**
 * User: Hans-Gert Gräbe
 * Last Update: 2021-08-14

 * Extrahiere Informationen aus "Leipziger Ecken"

 */

include_once("helper.php");

/* local helper */

function getLink($v) {
    if (empty($v)) return;
    $prefix="https://leipziger-ecken.de/jsonapi/";
    $type=$v["type"];
    $type=str_replace("akteur",$prefix."akteure",$type);
    $type=str_replace("akteur_typ",$prefix."akteur_types",$type);
    $type=str_replace("bezirk",$prefix."districts",$type);
    $type=str_replace("category",$prefix."categories",$type);
    $type=str_replace("event",$prefix."events",$type);
    $type=str_replace("file",$prefix."file",$type);
    $type=str_replace("tag",$prefix."tags",$type);
    $type=str_replace("target_group",$prefix."target_groups",$type);
    return $type."/".$v["id"];
}

function getURI($v) {
    if (empty($v)) return;
    $prefix="https://leipziger-ecken.de/rdf/";
    $type=$v["type"];
    $type=str_replace("akteur",$prefix."Akteur",$type);
    $type=str_replace("akteur_typ",$prefix."AkteurType",$type);
    $type=str_replace("bezirk",$prefix."District",$type);
    $type=str_replace("category",$prefix."Category",$type);
    $type=str_replace("event",$prefix."Event",$type);
    $type=str_replace("file",$prefix."File",$type);
    $type=str_replace("tag",$prefix."Tag",$type);
    $type=str_replace("target_group",$prefix."TargetGroup",$type);
    return $type."/".$v["id"];
}

function getImage($v) {
    // Dauert zu lange
    return;
    if (empty($v)) return;
    $src=getlink($v['data']);
    if (empty($src)) return;
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    return $res['data']['attributes']['uri']['url'];
}
   
function getLEFullAddress($s) {
    if (empty($s)) { return ; }
    return $s['address_line1'].', '.$s['postal_code'].' '.$s['locality'];
}

/* Transformation */

function getLEAkteure() {
    $src="Dumps/leipziger-ecken/Akteure.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id="http://leipziger-ecken.de/rdf/Akteur/".$row["id"];
        $att=$row['attributes'];
        $rel=$row['relationships'];
        $b=array();
        $b[]=' a le:Akteur';
        $b=addLiteral($b,'ld:hasSource','Leipziger Ecken');
        $b=addResource($b,'rdfs:seeAlso','',getLink($row));
        $b=addLiteral($b,'rdfs:label',$att['title']);
        if (!empty($att['external_url'])) { 
            $b=addResource($b,'foaf:homepage','',
                           $att['external_url']['uri']);
        }
        //$b=addResource($b,'foaf:depiction','',getImage($rel['image']));
        $b=addLiteral($b,'ld:hasFullAddress',
                      getLEFullAddress($att["address"]));
        if (!empty($att['geodata'])) { 
            $b=addLiteral($b,'gsp:asWKT',$att['geodata']['value']);
        }
        $b=addResource($b,'ld:inRegion','',getURI($rel['district']['data']));
        $b=addResource($b,'ld:hasType','',getURI($rel['typ']['data']));
        foreach($rel["target_groups"]["data"] as $v) {
            $b=addResource($b,'ld:hasTargetGroup','',getURI($v));
        }
        foreach($rel["tags"]["data"] as $v) {
            $b=addResource($b,'ld:hasTag','',getURI($v));
        }
        foreach($rel["categories"]["data"] as $v) {
            $b=addResource($b,'ld:hasCategory','',getURI($v));
        }
        $a[]="<$id>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

function getLEEvents() {
    $src="Dumps/leipziger-ecken/Events.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id="http://leipziger-ecken.de/rdf/Event/".$row["id"];
        $att=$row['attributes'];
        $rel=$row['relationships'];
        $b=array();
        $b[]=' a le:Event';
        $b=addLiteral($b,'ld:hasSource','Leipziger Ecken');
        $b=addResource($b,'rdfs:seeAlso','',getLink($row));
        $b=addLiteral($b,'rdfs:label',$att['title']);
        $b=addLiteral($b,'ld:isBarrierFree',$att['barrier_free_location']);
        if (!empty($att['external_website'])) { 
            $b=addResource($b,'foaf:homepage',"",$att['external_website']);
        }
        //$b=addResource($b,'foaf:depiction','',getImage($rel['image']));
        $b=addLiteral($b,'ld:hasFullAddress',getLEFullAddress($att["address"]));
        if (!empty($att['geodata'])) { 
            $b=addLiteral($b,'gsp:asWKT',$att['geodata']['value']);
        }
        foreach($att["occurrences"] as $v) {
            $b=addLiteral($b,'ical:dtstart',$v["value"]);
        }
        $b=addResource($b,'ld:inRegion','',getURI($rel['district']['data']));
        $b=addResource($b,'ld:hasAkteur','',getURI($rel['akteur']['data']));
        foreach($rel["target_groups"]["data"] as $v) {
            $b=addResource($b,'ld:hasTargetGroup','',getURI($v));
        }
        foreach($rel["tags"]["data"] as $v) {
            $b=addResource($b,'ld:hasTag','',getURI($v));
        }
        foreach($rel["categories"]["data"] as $v) {
            $b=addResource($b,'ld:hasCategory','',getURI($v));
        }
        $a[]="<$id>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

function getLEAkteurTypes() {
    $src="Dumps/leipziger-ecken/AkteurTypes.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id="http://leipziger-ecken.de/rdf/AkteurType/".$row["id"];
        $att=$row['attributes'];
        $rel=$row['relationships'];
        $b=array();
        $b[]=' a le:AkteurType';
        $b=addLiteral($b,'ld:hasSource','Leipziger Ecken');
        $b=addResource($b,'rdfs:seeAlso','',getLink($row));
        $b=addLiteral($b,'rdfs:label',$att['name']);
        if (!empty($att['description'])) { 
            $b=addMLiteral($b,'ld:hasDescription',
                           $att['description']['processed']);
        }        
        $a[]="<$id>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

function getLECategories() {
    $src="Dumps/leipziger-ecken/Categories.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id="http://leipziger-ecken.de/rdf/Category/".$row["id"];
        $att=$row['attributes'];
        $rel=$row['relationships'];
        $b=array();
        $b[]=' a le:Category';
        $b=addLiteral($b,'ld:hasSource','Leipziger Ecken');
        $b=addResource($b,'rdfs:seeAlso','',getLink($row));
        $b=addLiteral($b,'rdfs:label',$att['name']);
        foreach($rel["parent"]["data"] as $v) {
            $b=addResource($b,'ld:hasParent','',getURI($v));
        }        
        $a[]="<$id>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

function getLEDistricts() {
    $src="Dumps/leipziger-ecken/Districts.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id="http://leipziger-ecken.de/rdf/District/".$row["id"];
        $att=$row['attributes'];
        $b=array();
        $b[]=' a le:District';
        $b=addLiteral($b,'ld:hasSource','Leipziger Ecken');
        $b=addResource($b,'rdfs:seeAlso','',getLink($row));
        $b=addLiteral($b,'rdfs:label',$att['name']);
        $a[]="<$id>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

function getLETags() {
    $src="Dumps/leipziger-ecken/Tags.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id="http://leipziger-ecken.de/rdf/Tag/".$row["id"];
        $att=$row['attributes'];
        $b=array();
        $b[]=' a le:Tag';
        $b=addLiteral($b,'ld:hasSource','Leipziger Ecken');
        $b=addResource($b,'rdfs:seeAlso','',getLink($row));
        $b=addLiteral($b,'rdfs:label',$att['name']);
        $a[]="<$id>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

function getLETargetGroups() {
    $src="Dumps/leipziger-ecken/TargetGroups.json";
    $string = file_get_contents($src);
    $res = json_decode($string, true);
    $a=array();
    foreach ($res as $row) {
        $id="http://leipziger-ecken.de/rdf/TargetGroup/".$row["id"];
        $att=$row['attributes'];
        $b=array();
        $b[]=' a le:TargetGroup';
        $b=addLiteral($b,'ld:hasSource','Leipziger Ecken');
        $b=addResource($b,'rdfs:seeAlso','',getLink($row));
        $b=addLiteral($b,'rdfs:label',$att['name']);
        $a[]="<$id>".join(" ;\n  ",$b) . " ." ;
    }
    return $a;
}

$out=join("\n\n", getLEEvents())."\n\n"
    .join("\n\n", getLEAkteure())."\n\n"
    .join("\n\n", getLEAkteurTypes())."\n\n"
    .join("\n\n", getLECategories())."\n\n"
    .join("\n\n", getLEDistricts())."\n\n"
    .join("\n\n", getLETags())."\n\n"
    .join("\n\n", getLETargetGroups())."\n\n";

// fix an error in the data
$out=str_replace("http: ","http:",$out);

echo TurtlePrefix().$out;

?>

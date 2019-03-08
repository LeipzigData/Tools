<?php
/**
 * User: Hans-Gert Gräbe
 * Created: 2019-03-07
 * Last Update: 2019-03-07

 * Extrahiert den Baum der Kategorien aus der REST-Schnittstelle
 * categories.json.

 * Es werden Instanzen der Klasse nl:Category erzeugt. Jede Instanz hat die
 * NL-URI http://nachhaltiges-leipzig.de/Data/Category.<id> und enthält die
 * Prädikate nl:hasParent sowie rdfs:label. Daraus wird NL-Categories.ttl
 * erzeugt.

 */

function getFileFromAPI($file) {
    $src="http://daten.nachhaltiges-leipzig.de/api/v1/$file";
    $string=file_get_contents($src);
    return json_decode($string, true);
}

function getCategories() {
    $res=getFileFromAPI("categories.json");
    $a=array();
    foreach ($res as $row) {
        $a[]=createEntry($row['id'],0,$row['name']);
        foreach ($row['goal_cloud'] as $v) {
            $a[]=createEntry($v['id'],$row['id'],$v['name']);
        }
    }
    return join("\n\n",$a);
}

function createEntry($id,$parentId,$name) {
    if ($id<10) { $id="0$id"; }
    if ($parentId<10) { $parentId="0$parentId"; }
    return '
nlcat:Category_'.$id.' a nl:Category ; 
  rdfs:label "'.$name.'" ;
  nl:hasParent nlcat:Category_'.$parentId.' .
' ; 
}

echo getCategories();
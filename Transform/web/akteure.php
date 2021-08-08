<?php
/**
 * User: Hans-Gert Gräbe
 * Last Update: 2021-08-08

 * Darstellung der nach rdf/Akteure.rdf extrahierten Akteure. 

 */

require_once("helper.php");

function getAkteure() {
    setNamespaces();
    $graph = new \EasyRdf\Graph('http://leipzig-data.de/rdf/Akteure/');
    $graph->parseFile('rdf/Akteure.rdf');
    //echo $graph->dump("turtle");
    $a=array();
    foreach($graph->allOfType('org:Organization') as $v) {
        $uri=$v->getURI();
        $name=$v->get("skos:prefLabel");
        $url=$v->get("foaf:homepage");
        $source=$v->get("ld:hasSource");
        $type=$v->get("ld:hasType");
        $lid=$v->get("rdfs:isDefinedBy");
        $a[]='<h2>'.createLink($lid,$name).'</h2>';
    }
    return join("\n",$a);
}

// zum Testen
// echo getAllActivities();

echo getAkteure();

?>

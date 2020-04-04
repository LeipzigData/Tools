<?php
/** 
 * Extraktion aus dem Gebäudenavigator von Konrad Abicht 
 */

require 'helper.php';

function getData() {
  $query = '
PREFIX bvlo: <https://github.com/AKSW/leds-asp-f-ontologies/raw/master/ontologies/place/ontology.ttl#>
PREFIX bvla: <https://github.com/AKSW/leds-asp-f-ontologies/raw/master/ontologies/place-accessibility/ontology.ttl#>
PREFIX schema: <http://schema.org/>
PREFIX geo: <http://www.w3.org/2003/01/geo/>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
SELECT ?s ?title ?id ?cat ?pc ?al ?sa ?lat ?long ?note
FROM <https://opendata.leipzig.de/bvlplaces/>
WHERE {
?s a bvlo:Place .
optional { ?s schema:addressLocality ?al ; schema:postalCode ?pc ; schema:streetAddress ?sa . } 
optional { ?s geo:lat ?lat; geo:long ?long . }
optional { ?s dc:title ?title ; dcterms:identifier ?id ; dbpedia-owl:category ?cat . }
optional { ?s skos:note ?note . }
} ';

  $call='https://opendata.leipzig.de/virt-sparql?default-graph-uri=&query='
      //.urlencode($query).'&format=application/sparql-results+json&timeout=0&debug=on';
      .urlencode($query).'&timeout=0&debug=on';
  $result=file_get_contents($call);
  print_r($result);
  foreach($result as $v) {
      print_r($v);
  }
}

getData();
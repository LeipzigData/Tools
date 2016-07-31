<?php

include_once("rdfquery.php");
function get_store() { return 'http://leipzig-data.de:8890/sparql'; }

function get_geodata($s) {
  echo urlencode($s['query']);
  $req = 'http://nominatim.openstreetmap.org/search.php?q=' 
    . urlencode($s['query']) . '&format=json'; 
  $result = file_get_contents($req); 
  $r = json_decode($result,true);
  print_r($r);
  if (isset($r)) {	
    foreach ($r as $k) {
      $s['display_name']=$k['display_name'];
      $s['osm_type']=$k['osm_type'];
      $s['osm_id']=$k['osm_id'];
      $s['lat']=$k['lat'];
      $s['lon']=$k['lon'];
    }
  }
  //print_r($s);
  return $s;
}

function run_query() {
  $query = '
PREFIX ld: <http://leipzig-data.de/Data/Model/>
PREFIX ical: <http://www.w3.org/2002/12/cal/ical#>
PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
SELECT distinct ?l ?p ?o ?a 
WHERE {
  ?e a ld:Event .
  ?e ical:location ?o .
  ?o ld:hasAddress ?a .
  optional { ?a geo:lat ?g .}
  optional { ?a rdfs:label ?l; ld:hasPostCode ?p .}
  filter (!bound(?g))
}
';
  
  $r = run_select_query($query,get_store());
  //print_r($r);
  if (isset($r)) {
    $s=array();
    /* generate data structure for output table */
    foreach ($r['results']['bindings'] as $k => $v) {
      $name=getvalue($v,'l');
      $plz=getvalue($v,'p');
      $ort=getvalue($v,'o');
      $url=getvalue($v,'a');
      if (!empty($name)) {$s[$url]['query']=$plz.' '.$name;}
    }
    return $s ; 		
  }
}

function test_query() {
  $s=run_query();
  print_r($s);
  foreach ($s as $key => $value) { $s[$key]=get_geodata($value); }  
  print_r($s);
}

function test_address($address) {
  $x=array('query' => $address);
  get_geodata($x); 
  print_r($x);
}

test_address('Markkleeberg.KoburgerStrasse.33');
//test_query();

?>

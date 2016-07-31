<?php

require 'vendor/autoload.php';

function compareMultipleGeocoordinates() {
  $query = '
PREFIX ld: <http://leipzig-data.de/Data/Model/>
PREFIX gsp: <http://www.opengis.net/ont/geosparql#> 
select ?a ?geo 
Where {
?a a ld:Adresse ; rdfs:label ?l .
optional { ?a gsp:asWKT ?geo . }
} ';

  $sparql = new EasyRdf_Sparql_Client('http://localhost:8890/sparql');
  $result=$sparql->query($query);
  $a=array();
  foreach($result as $v) { 
    $a[$v->a->getUri()][]=$v->geo->getValue();
  }
  $out='';
  foreach($a as $key => $value) {
    $out.="\n$key hat ".count($value)." Geodaten-Einträge.\n";
    if(count($value)>1) { 
      $out.="Dies sind ".join(", ",$value).".\n"; 
      $out.="Der Abstand beträgt ".geodistance($value[0],$value[1])." Meter.\n"; 
    }
  }
  return $out;
}

function geodistance($a,$b) {
  preg_match('/Point\((\S+)\s+(\S+)\)/',$a,$d1);
  preg_match('/Point\((\S+)\s+(\S+)\)/',$b,$d2);
  $dx=71.5*($d1[1]-$d2[1]); $dy= 111.3*($d1[2]-$d2[2]);
  $dist=1000*sqrt($dx*$dx+$dy*$dy);
  // echo "Abstand zwischen $a und $b berechnen. \n Delta($dx,$dy) => $dist Meter.\n"; 
  return $dist;
}

echo compareMultipleGeocoordinates();
<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getAdressen() {
  $query='
SELECT * FROM aae_data_adresse where 
exists (select * from aae_data_akteur where adresse=ADID) or
exists (select * from aae_data_event where ort=ADID) 
';
  $mysqli=getConnection(); 
  $mysqli->real_query($query);
  $res = $mysqli->use_result();
  $out='';
  while ($row = $res->fetch_assoc()) {
    $out.=createAdresse($row);
  }
  return TurtlePrefix().'
<http://leipziger-ecken.de/Data/Adressen/> a owl:Ontology ;
    rdfs:comment "Dump aus der Datenbank";
    rdfs:label "Leipziger Ecken - Adressen" .

'.$out;
}

function createAdresse($row) {
  $id=$row['ADID'];
  $strasse=$row['strasse'];
  if (empty($strasse)) { return ; }
  $nr=$row['nr'].$row['adresszusatz'];
  $plz=$row['plz'];
  $gps=$row['gps']; 
  if (!empty($gps) and strstr($gps,",")) { $gps=geo($gps); } else {$gps='';}
  $leipzigDataURI=fixURI($plz.'.Leipzig.'.$strasse.'.'.$nr);
  $a=array();
  $a[]=' a le:Adresse ';
  $a=addResource($a,'ld:hasAddress', "http://leipzig-data.de/Data/", $leipzigDataURI);
  $a=addLiteral($a,'rdfs:label', "$strasse $nr, $plz Leipzig");
  $a=addLiteral($a,'gsp:asWKT', "$gps");
  return '<http://leipziger-ecken.de/Data/Adresse/A'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

function geo($s) {
  $a=preg_split('/\s*,\s*/',$s);
  return "Point($a[1] $a[0])";
}

// zum Testen
// echo getAdressen();

?>

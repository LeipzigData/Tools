<?php

/* Copy inc_sample.php to inc.php and fill in your credentials */

include_once("inc.php");
include_once("helper.php");

function getAdressen() {
  $mysqli=getConnection(); 
  $mysqli->real_query("SELECT * FROM aae_data_adresse");
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
  $leipzigDataURI=fixURI($plz.'.Leipzig.'.$strasse.'.'.$nr);
  $a=array();
  $a[]=' a le:Adresse ';
  $a=addResource($a,'owl:sameAs', "http://leipzig-data.de/Data/", $leipzigDataURI);
  $a=addLiteral($a,'rdfs:label', "$strasse $nr, $plz Leipzig");
  $a=addLiteral($a,'geo:lat_long', $row['gps']);
  return '<http://leipziger-ecken.de/Data/Adresse/A'. $id .'>'. join(" ;\n  ",$a) . " . \n\n" ;
}

// zum Testen
// echo getAdressen();

?>

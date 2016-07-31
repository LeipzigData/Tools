<?php

require 'vendor/autoload.php';
require 'helper.php';

function processFile($s) {
  setNamespace(); 
  $graph = new EasyRdf_Graph("http://leipziger-ecken.de/rdf/");
  $graph->parseFile($s);
  $out='';
  foreach ($graph->resources() as $v) {
    $uri=$v->getUri(); 
    if(strstr($uri,"http://leipzig-data.de/Data")) { 
      $result=getLDAdresse($uri); 
      if (empty($result)) { $out.=URInotFound($uri); } 
      else { $out.=$result;  } 
    }
  }
  return TurtlePrefix().$out ; 
}

function URInotFound($uri) {
  return "<$uri> rdfs:comment \"not found in LD\" . \n\n" ; 
}

function processArray($s) {
  $out='';
  foreach ($s as $uri) {
    if(strstr($uri,"http://leipzig-data.de/Data")) { 
      $result=getLDAdresse($uri); 
      if (empty($result)) { $out.=URInotFound($uri); } 
      else { $out.=$result;  } 
    }
  }
  return TurtlePrefix().$out ; 
}

function getLDAdresse($uri) {
  $sample=preg_replace('|http://leipzig-data.de/Data/|','',$uri);
  // construct query wirft aktuell eine Exception in easyRDF
  // construct { ?a a ld:Adresse ; rdfs:label ?l; gsp:asWKT ?geo . }
  $query = '
PREFIX ld: <http://leipzig-data.de/Data/Model/>
PREFIX gsp: <http://www.opengis.net/ont/geosparql#> 
select ?a ?l ?geo 
from <http://leipzig-data.de/Data/Adressen/>
from <http://leipzig-data.de/Data/GeoDaten/>
Where {
?a a ld:Adresse ; rdfs:label ?l .
optional { ?a gsp:asWKT ?geo . }
filter regex(?a, "'.$sample.'") 
} ';

  $sparql = new EasyRdf_Sparql_Client('http://leipzig-data.de:8890/sparql');
  $result=$sparql->query($query);
  $out='';
  foreach($result as $v) { 
    $a=array();
    $a[]=' a ld:Adresse ';
    $a=addLiteral($a, 'rdfs:label', $v->l);
    $a=addLiteral($a, 'gsp:asWKT', $v->geo);
    $out.= "<$v->a> ". join(" ;\n  ",$a) . " . \n\n" ;
  }
  return $out;
  // return $result->serialise("turtle");
}

// echo processFile(__DIR__ . "/a.ttl"); 

$a=explode("\n",'http://leipzig-data.de/Data/04277.Leipzig.Kochstrasse.132
http://leipzig-data.de/Data/04315.Leipzig.Eisenbahnstrasse.147
http://leipzig-data.de/Data/04315.Leipzig.Eisenbahnstrasse.157
http://leipzig-data.de/Data/04315.Leipzig.Eisenbahnstrasse.49
http://leipzig-data.de/Data/04315.Leipzig.Eisenbahnstrasse.54
http://leipzig-data.de/Data/04315.Leipzig.Hedwigstrasse.20
http://leipzig-data.de/Data/04317.Leipzig.Hedwigstrasse.20
http://leipzig-data.de/Data/04315.Leipzig.Hedwigstrasse.7
http://leipzig-data.de/Data/04315.Leipzig.Hildegardstrasse.49
http://leipzig-data.de/Data/04315.Leipzig.Hildegardstrasse.51
http://leipzig-data.de/Data/04315.Leipzig.Kohlgartenstrasse.51
http://leipzig-data.de/Data/04315.Leipzig.Konradstrasse.27
http://leipzig-data.de/Data/04315.Leipzig.TorgauerPlatz.2
http://leipzig-data.de/Data/04317.Leipzig.DresdnerStrasse.59
http://leipzig-data.de/Data/04317.Leipzig.DresdnerStrasse.84
http://leipzig-data.de/Data/04317.Leipzig.Gabelsbergerstrasse.30');

echo processArray($a); 

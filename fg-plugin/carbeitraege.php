<?php 

include_once("rdfquery.php");

function carbeitraege($atts) {
  $query = '
PREFIX sd: <http://symbolicdata.org/Data/Model#>
PREFIX dct: <http://purl.org/dc/terms/>
select distinct ?a ?title ?citation 
from <http://symbolicdata.org/Data/CAR-Beitraege/>
Where { 
?a a sd:Reference .
optional { ?a dct:title ?title . } 
optional { ?a dct:bibliographicCitation ?citation . }
} order by desc(?citation)
';
  
  $r = run_select_query($query,get_store());
  // print_r($r);
  if (isset($r)) {	
    /* generate data structure for output table */
    $out="<ul>";
    foreach ($r['results']['bindings'] as $k => $v) {
      $a=getvalue($v,'a');
      $title=getvalue($v,'title');
      $citation=getvalue($v,'citation');
      $out.='
<li> <a href="'.$a.'">'.$title.'</a>, '.$citation.' </li>';
    }
    return $out."</ul>" ; 		
  }
}

add_shortcode( 'carbeitraege', 'carbeitraege' );
?>

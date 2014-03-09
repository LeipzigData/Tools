<?php 

include_once("rdfquery.php");

function arbeitsgruppen($atts) {
  $query = '
PREFIX sd: <http://symbolicdata.org/Data/Model#>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX org: <http://www.w3.org/ns/org#>
select distinct ?a ?url ?name
from <http://symbolicdata.org/Data/Arbeitsgruppen/>
Where {
?a a sd:WorkingGroup .
optional { ?a skos:prefLabel ?name . }
optional { ?a foaf:homepage  ?url . }
} order by (?a)
';
  
  $r = run_select_query($query,get_store());
  // print_r($r);
  if (isset($r)) {	
    /* generate data structure for output table */
    $out="<dl>";
    foreach ($r['results']['bindings'] as $k => $v) {
      $name=getvalue($v,'name');
      $url=getvalue($v,'url');
      $out.='
<dt> '.$name.' </dt> <dd> URL: <a href="'.$url.'">'.$url.'</a> </dd><p/> ' ;
    }
    return $out ; 		
  }
}

add_shortcode( 'arbeitsgruppen', 'arbeitsgruppen' );
?>

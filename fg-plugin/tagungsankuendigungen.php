<?php 

include_once("rdfquery.php");

function tagungen($atts) {
  $query = '
PREFIX sd: <http://symbolicdata.org/Data/Model#>
PREFIX ical: <http://www.w3.org/2002/12/cal/ical#>
select distinct ?a ?l ?from ?to ?loc ?description ?url
from <http://symbolicdata.org/Data/Tagungsankuendigungen/>
Where { 
?a a sd:Event .
?a rdfs:label ?l .
optional { ?a  ical:dtstart ?from . } 
optional { ?a  ical:dtend ?to . } 
optional { ?a  ical:location ?loc . } 
optional { ?a ical:description ?description . } 
optional { ?a sd:hasURL ?url . } 
} order by (?from) 
';
  
  $r = run_select_query($query,get_store());
  // print_r($r);
  if (isset($r)) {	
    /* generate data structure for output table */
    $out="";
    foreach ($r['results']['bindings'] as $k => $v) {
      $a=getvalue($v,'a');
      $label=getvalue($v,'l');
      $from=date_format(date_create(getvalue($v,'from')),"d.m.Y");
      $to=date_format(date_create(getvalue($v,'to')),"d.m.Y");
      $loc=getvalue($v,'loc');
      $url=getvalue($v,'url');
      $description=getvalue($v,'description');
      $out.='
<h2> <a href="'.$a.'">'.$label.'</a></h2>
<div>Vom '.$from.' bis '.$to.' in '.$loc.'.</div>
<p/><div> '.$description.'</div>
<p/><div> URL der Tagung: <a href="'.$url.'">'.$url.'</a></div><p/> ' ;
    }
    return $out ; 		
  }
}

add_shortcode( 'tagungen', 'tagungen' );
?>

<?php 

include_once("rdfquery.php");

function fgl($atts) {
  $year = $atts && $atts['year'] ? $atts['year'] : '2011' ;
  $query = '
PREFIX sd: <http://symbolicdata.org/Data/Model#>
PREFIX sdt: <http://symbolicdata.org/Data/Group/>
select distinct ?a ?url ?img ?email ?name ?telefon ?title
from <http://symbolicdata.org/Data/People/>
from <http://symbolicdata.org/Data/CAFG-Intern/>
Where { 
?a a foaf:Person .
?a foaf:member sdt:FGL'.$year.' .
optional { ?a foaf:homepage ?url . } 
optional { ?a foaf:image    ?img . }
optional { ?a foaf:mbox     ?email . }
optional { ?a foaf:name     ?name . } 
optional { ?a foaf:title    ?title . } 
optional { ?a foaf:phone    ?telefon . } 
} order by (?name)
';
  
  $r = run_select_query($query,get_store());
  // print_r($r);
  if (isset($r)) {	
    /* generate data structure for output table */
    $out="";
    foreach ($r['results']['bindings'] as $k => $v) {
      $a=getvalue($v,'a');
      $anker=str_replace("http://symbolicdata.org/Data/Person/", "", $a);
      $name=getvalue($v,'title')." ".getvalue($v,'name');
      $url=getvalue($v,'url');
      $img=getvalue($v,'img');
      $email=getvalue($v,'email');
      $telefon=getvalue($v,'telefon');
      $out.='

<div style="float: left; width: 70%; ">
<strong><a name="'.$anker.'" href="'.$a.'">'.$name.'</a></strong>'; 
      if ($url) { $out.="<br/>URL: <a href=\"$url\">$url</a> " ; }
      if ($email) { $out.="<br/>Email: $email " ; } 
      if ($telefon) { $out.="<br/>Telefon: $telefon " ; } 
      $out.='</div><div style="float: right; width: 30%">' ;
      if ($img) { 
	$out.='<img src="/data/images/'.$img
	  .'" height="160" width="120" style="float:right;" alt="'.$name.'" />';
      } 
      $out.='</div><div style="clear: both; margin-bottom: 30px; "></div>';
    }
    return $out ; 		
  }
}

add_shortcode( 'fachgruppenleitung', 'fgl' );
?>

<?php 

include_once("rdfquery.php");

function getvalue($v,$key) {
  return array_key_exists($key,$v) ? $v[$key]['value'] : "" ; 
}

function fgl($atts) {
  $year = $atts && $atts['year'] ? $atts['year'] : '2011' ;
  $query = "
PREFIX sd: <http://symbolicdata.org/Data/Model#>
PREFIX sdt: <http://symbolicdata.org/Data/Tag/>
select distinct ?a ?url ?img ?email ?name ?telefon ?adresse ?title
from <http://symbolicdata.org/Data/CAFG/Arbeitsgruppen/>
Where { 
?a a foaf:Person .
?a sd:hasTag sdt:FGL$year .
optional { ?a foaf:homepage ?url . } 
optional { ?a foaf:image    ?img . }
optional { ?a foaf:mbox     ?email . }
optional { ?a foaf:name     ?name . } 
optional { ?a foaf:title    ?title . } 
optional { ?a foaf:phone    ?telefon . } 
optional { ?a sd:DienstAdresse ?adresse . } 
} order by (?name)";
  
  $r = run_select_query($query);
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
      $adresse=getvalue($v,'adresse');
      $out.='

<div style="float: left; width: 70%; ">
<strong><a name="'.$anker.'" href="'.$a.'">'.$name.'</a></strong>'; 
      if ($url) { $out.="<br/>URL: <a href=\"$url\">$url</a> " ; }
      if ($email) { $out.="<br/>Email: $email " ; } 
      if ($telefon) { $out.="<br/>Telefon: $telefon " ; } 
      if ($adresse) { 
	$adresse=str_replace(array("\r\n", "\n", "\r"), "<br/>", $adresse);
	$out.="<br/>Dienstadresse: $adresse " ; 
      }
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

?>

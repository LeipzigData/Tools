<?php

/*
 Purpose: Query the widget Sparql endpoint for all the data.

 Does not yet work, requires some PHP extensions to be installed. 
 */

function prefix() {
  echo "
PREFIX ld: <http://leipzig-data.de/Data/Model/>
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX cal: <http://www.w3.org/2002/12/cal/ical#> 
";
}

function query($s) {
  $query=prefix().$s;
  echo $query;
  $request = new HttpRequest('http://leipzig-data.de/widget/SparqlEndpoint.php?query='.$query);
  $response = new HttpMessage($request->send( )) ;
  echo $response->getBody( ) ;

}

query("construct { ?a ?ap ?ao .  } Where { ?a ?ap ?ao .  }" )

?>
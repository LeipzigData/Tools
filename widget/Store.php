<?php

include_once("arc2/ARC2.php");
include_once("db.php");

/*initialize TripleStore */
$config = array(
    /* db */
    'db_name' => DB_NAME, 
    'db_user' => DB_USER,
    'db_pwd' => DB_PASSWORD,
    /* store */
    'store_name' => 'data_store',
    /* stop after 100 errors */
    'max_errors' => 100,
	'endpoint_features' => array( '0' => 'select'),
);
$store = ARC2::getStoreEndpoint($config);

if (!$store->isSetUp()) 
{ 
	$store->setUp(); echo "Set up store\n\n"; 
}
else
{
	echo "Found installed store.\n\n";
}

function listTriples($store) {
  $q = 'SELECT ?a ?b ?c WHERE { ?a ?b ?c . }';
  $r = '';
  if ($rows = $store->query($q, 'rows')) {
     foreach ($rows as $row) {
       $r .= $row['a'] . ' ' . $row['b'] . ' ' . $row['c'] . "\n";
     }
  }

  return $r ?  $r  : 'no Triples found\n';
}

/* Load Data from an RDF-File */
function loadDataFromFile($store) { 
  echo "read data from file\n";
  $store->query("LOAD <file:EventsDump.ttl>");
}

/* Load Data from an SPARQL-Endpoint */
function loadDataFromEndpoint($store) { 
	$config = array(
	  /* remote endpoint */
	  'remote_store_endpoint' => 'http://leipzig-data.de/widget/sparql.php',
	);
	$ep = ARC2::getRemoteStore($config);  	//get Access to remote endpoint
	$q  = 'SELECT * WHERE {					
				{ ?s ?p ?o . }
			}';								//define query to run on endpoint
	$rows = $ep->query($q , 'rows');		//connect to endpoint and run query
	echo "read data from endpoint\n";
	$store->insert($rows, '');				//insert data from endpoint to local store
  
}

$store->reset();
loadDataFromEndpoint($store);
echo '<pre>';
echo "warnings:\n";
print_r ($store->warnings);
echo "errors:\n";
print_r ($store->getErrors());
echo "imported following triples:\n";
echo listTriples($store);


?>

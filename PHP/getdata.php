<?php
 /* converting many triples may be memory und time consuming */ 
set_time_limit(360);
ini_set("memory_limit", "1024M");

/* convert class inclusion */
include_once('ExhibitJSONSerializer.php');

/* debug switch: set true to print errors and some other information and also
   to get a human readable data.json file */
$debug = true;
if($debug) {
  error_reporting(E_ALL);
  ini_set('display_errors', true);
}

/**
 *	main
 */

// get data (run sparql query)
$store = 'http://leipzig-data.de:8890/sparql';
$trips = getData($store);
/* 
if ($debug && $store->getErrors()) {
  print "\nErrors occured during sparql request:\n"; print_r($store->getErrors());
}
*/
if ($debug) { print_r($trips);}
writeToFile(getExhibitJSON($trips),'data.json');

/**
 * this function retrieves data from the triple store via a sparql http request
 * the query $q can be changed to retrieve and filter the data as needed
 */
function getData($store) {
  $query = '
		PREFIX ld: <http://leipzig-data.de/Data/Model/>
		construct { 
		  ?a ?ap ?ao .
		  ?ao ?bp ?bo .
		  ?bo ?cp ?co .
		  ?co ?dp ?do .
		  ?do ?ep ?eo .
		  ?eo ?fp ?fo .
		}
		Where { 
		  ?a ?ap ?ao .
		  ?a a ld:Event .
		  optional { ?ao ?bp ?bo .  }
		  optional { ?bo ?cp ?co .  }
		  optional { ?co ?dp ?do .  }
		  optional { ?do ?ep ?eo .  }
		  optional { ?eo ?fp ?fo .  }
		} '; 
	
  $get_parameters = 	'?default-graph-uri='                          
    //probably have to change parameters when using another store than virtuoso
    . '&query=' . urlencode ($query) 
    . '&format=application%2Frdf%2Bjson' //esp. format parameter may vary
    . '&timeout=0&debug=on';

  $req = $store . $get_parameters;
  $result=json_decode(file_get_contents($req),true);

  global $debug;
  if ($debug)
    echo 'imported '.count($result)." triples.\nThe following triples have been imported:\n\n";
  print_r($result);
  return $result;
}	
	

/**
 * writes data to a file
 */
function writeToFile($contents,$filename)
{
  $fh = fopen($filename, 'w') or die("can't open file");
  fwrite($fh, $contents);
  fclose($fh);
}

/**
 *	converts an array of rdf/json (resource centric) triples into a serialized ExhibitJSON string
 */
function getExhibitJSON($triples)
{
  $config = array();
  $my_ext = new ExhibitJSONSerializer($config);
  $exhibitJSONtriples = $my_ext->getSerializedIndex($triples);
  return $exhibitJSONtriples;
}

?>

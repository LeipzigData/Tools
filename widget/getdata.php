<pre>
<?php
/* converting many triples may be memory und time consuming */ 
set_time_limit(360);
ini_set("memory_limit", "1024M");

/* ARC2 static class inclusion */
include_once('arc2/ARC2.php');
/* Database Settings inclusion */
include_once('db.php');

/* debug switch: set true to print errors and some other information and also
   to get a human readable data.json file */
$debug = true;
if($debug)
{
	error_reporting(E_ALL);
	ini_set('display_errors', true);
}

/**
 *	main
 */
 
$local_store = false; /* set true to use the integrated store and if youre dumping data via turtle files (local or remote)
						    * set false if you want to retrieve data directly from a (remote) sparql endpoint */


if ($local_store)
{
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
	);

	// connect to store
	$store = ARC2::getStore($config);
	if (!$store->isSetUp() && $debug) 
		print "\nNo store has been Found! You first have to configure your database settings in db_credentials.php and then import some triples using Store.php!\n";
	else
		if ($debug) print "\nsuccessfully connected to store\n";
}
else
{
	/* configuration */ 
	$config = array(
		'remote_store_endpoint' => 'http://leipzig-data.de:8890/sparql',
	);
	// connect to store
	$store = ARC2::getRemoteStore($config);
}
// filter data (run sparql query)
$trips = filterData($store);
if ($debug && $store->getErrors()) {print "\nErrors occured during sparql request:\n"; print_r($store->getErrors());}
if ($debug) print_r($trips);
//$trips = ARC2::getTriplesFromIndex($trips);//TODO this is nonsense and decreases performance, but I don't know how to explain the plugin that the triples are resource indexed

// write human readable json in debug mode
if ($debug)
	writeToFile(pretty_json(getExhibitJSON($trips,true)),'data.json');
else
	writeToFile(getExhibitJSON($trips,true),'data.json');

/**
 * this function retrieves data from the triple store via sparql
 * the query can be changed to filter the data as needed
 */
function filterData($store) {
  $q = 'CONSTRUCT {?s $p $o; $p $o.} WHERE { ?s ?p ?o}'; // query for local store (dumping all of it)
  // query for remote store, uncomment if using local store
  $q = '
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
  $result = $store->query($q);
  global $debug;
  if ($debug)
	echo 'imported '.count($result['result'])." triples\n";
  return $result['result'];
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
 *	converts an array of arc2 triples into a serialized ExhibitJSON string
 */
function getExhibitJSON($triples,$indextype)
{
	$config = array();
	$my_ext = ARC2::getComponent('ARC2_ExhibitJSONSerializerPlugin', $config);
	if($indextype)
		$exhibitJSONtriples = $my_ext->getSerializedIndex($triples);
	else
		$exhibitJSONtriples = $my_ext->getSerializedTriples($triples);
	return $exhibitJSONtriples;
}

/**
 *	returns a pretty print of json
 *  source: http://snipplr.com/view.php?codeview&id=60559
 */
function pretty_json($json) {

    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = '  ';
    $newLine     = "\n";
    $prevChar    = '';
    $outOfQuotes = true;

    for ($i=0; $i<=$strLen; $i++) {

        // Grab the next character in the string.
        $char = substr($json, $i, 1);

        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;
        
        // If this character is the end of an element, 
        // output a new line and indent the next line.
        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }
        
        // Add the character to the result string.
        $result .= $char;

        // If the last character was the beginning of an element, 
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }
            
            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }
        
        $prevChar = $char;
    }

    return $result;
}

?>
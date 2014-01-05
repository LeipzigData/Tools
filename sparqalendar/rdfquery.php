<?php 

function get_store() {
  return 'http://symbolicdata.org:8890/sparql';
}

/** run a sparql query and request the result in json format
 */

function run_select_query($query) 
{
  $format = 'application%2Fsparql-results%2Bjson'; 

  $get_parameters ='?default-graph-uri=' .                         
    //probably have to change parameters when using another store than virtuoso
    '&query=' . urlencode ($query) . '&format=' . $format .	
    //esp. format parameter may vary  
    '&timeout=0&debug=on';

  $req = get_store() . $get_parameters;
  $result = wp_remote_get($req);
  $r = json_decode($result['body'],true);
  // print_r($r);
  return $r;
}
?>

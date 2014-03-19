<?php 

/** run a sparql query and request the result in json format
 */

function run_select_query($query,$store) 
{
  $format = 'application%2Fsparql-results%2Bjson'; 

  $get_parameters ='?default-graph-uri=' .                         
    //probably have to change parameters when using another store than virtuoso
    '&query=' . urlencode ($query) . '&format=' . $format .	
    //esp. format parameter may vary  
    '&timeout=0&debug=on';

  $req = $store . $get_parameters;
  $result = wp_remote_get($req);
  $r = json_decode($result['body'],true);
  // print_r($r);
  return $r;
}

function getvalue($v,$key) {
  return array_key_exists($key,$v) ? $v[$key]['value'] : "" ; 
}

?>

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
    /* endpoint */
    'endpoint_features' => 
    array('select', 'construct', 'ask', 'describe'),
    'endpoint_timeout' => 60, /* not implemented in ARC2 preview */
    'endpoint_read_key' => '', /* optional */
    'endpoint_write_key' => 'this_is_very_secret', 
    /* optional, but without one, everyone can write! */
    'endpoint_max_limit' => 100000, /* optional */
		);

/* instantiation */
$ep = ARC2::getStoreEndpoint($config);

if (!$ep->isSetUp()) {
  $ep->setUp(); /* create MySQL tables */
}

/* request handling */
$ep->go();

?>

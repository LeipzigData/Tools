<?php
/**
 * User: Hans-Gert Gräbe
 * Date: 2018-01-07
 * LastUpdate: 2018-08-05
 */

include_once("akteure.php");
include_once("personen.php");
include_once("activities.php");

function save($method,$file) {
    file_put_contents ("../Daten/$file",toRDFString($method())); 
    echo "<p>Ausgabe ../Daten/$file erzeugt</p> \n";
}
   
function main() {
    save("getAkteure","Akteure.ttl"); 
    save("getLDAkteure","NL-Akteure.ttl"); 
    save("getPersonen","Personen.ttl"); 
    save("getAllActivities","Activities.ttl"); 
}

main();

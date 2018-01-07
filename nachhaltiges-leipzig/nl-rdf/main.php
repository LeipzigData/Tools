<?php
/**
 * User: Hans-Gert Gräbe
 * Date: 2018-01-07
 */

include_once("actions.php");
include_once("adressen.php");
include_once("akteure.php");
include_once("changes.php");
include_once("events.php");
include_once("projects.php");
include_once("services.php");
include_once("stores.php");

main();

function main() {
  file_put_contents ("../Daten/Akteure.ttl",toRDFString(getAkteure())); 
  echo "<p>Ausgabe ../Daten/Akteure.ttl erzeugt</p> \n";
  file_put_contents ("../Daten/Aktionen.ttl",toRDFString(getAktionen())); 
  echo "<p>Ausgabe ../Daten/Akteure.ttl erzeugt</p> \n";
  file_put_contents ("../Daten/Adressen.ttl",toRDFString(getAdressen())); 
  echo "<p>Ausgabe ../Daten/Adressen.ttl erzeugt</p> \n";
  file_put_contents ("../Daten/Changes.txt",toRDFString(displayChanges())); 
  echo "<p>Ausgabe ../Daten/Adressen.ttl erzeugt</p> \n";
  file_put_contents ("../Daten/Events.ttl",toRDFString(getEvents()));  
  echo "<p>Ausgabe ../Daten/Events.ttl erzeugt</p> \n";
  file_put_contents ("../Daten/Projekte.ttl",toRDFString(getProjekte())); 
  echo "<p>Ausgabe ../Daten/Projekte.ttl erzeugt</p> \n";
  file_put_contents ("../Daten/Services.ttl",toRDFString(getServices())); 
  echo "<p>Ausgabe ../Daten/Services.ttl erzeugt</p> \n";
  file_put_contents ("../Daten/Stores.ttl",toRDFString(getStores())); 
  echo "<p>Ausgabe ../Daten/Stores.ttl erzeugt</p> \n";


}


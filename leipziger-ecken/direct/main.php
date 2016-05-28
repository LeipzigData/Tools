<?php
/**
 * User: Hans-Gert Gräbe
 * Date: 2016-04-20
 */

include_once("akteure.php");
include_once("adressen.php");
include_once("events.php");
include_once("sparten.php");

file_put_contents ("Daten/Akteure.ttl",getAkteure()); 
file_put_contents ("Daten/Adressen.ttl",getAdressen()); 
file_put_contents ("Daten/Events.ttl",getEvents());  
file_put_contents ("Daten/Sparten.ttl",getSparten()); 

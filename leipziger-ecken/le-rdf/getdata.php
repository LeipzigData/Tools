<?php
/**
 * User: Hans-Gert Gräbe
 * Date: 2016-04-20
 */

include_once("akteure.php");
include_once("adressen.php");
include_once("events.php");
include_once("sparten.php");

function main() {
  $what=$_GET['show'];
  if ($what=='akteure') { return asPlainText(getAkteure()); }
  else if ($what=='adressen') { return asPlainText(getAdressen()); }
  else if ($what=='events') { return asPlainText(getEvents()); }
  else if ($what=='sparten') { return asPlainText(getSparten()); }
  else return "Aufruf getdata.php?show=akteure";
}

echo main();

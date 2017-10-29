<?php
/**
 * User: Hans-Gert Gräbe
 * Date: 2017-10-28
 */

include_once("actions.php");
include_once("adressen.php");
include_once("akteure.php");
include_once("events.php");
include_once("projects.php");
include_once("services.php");
include_once("stores.php");

function main() {
    $what=$_GET['show'];
    $out='';
    if ($what=='akteure') { $out=asPlainText(getAkteure()); }
    else if ($what=='aktionen') { $out=asPlainText(getAktionen()); }
    else if ($what=='adressen') { $out=asPlainText(getAdressen()); }
    else if ($what=='events') { $out=asPlainText(getEvents()); }
    else if ($what=='projekte') { $out=asPlainText(getProjekte()); }
    else if ($what=='services') { $out=asPlainText(getServices()); }
    else if ($what=='stores') { $out=asPlainText(getStores()); }
    else $out="Aufruf getdata.php?show=akteure";
    if (defined($_GET['embedded'])) { $out=htmlwrap($out); }
    return $out;
}

function htmlwrap($out) {
    return '
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="LD Nachhaltiges Leipzig Standalone Info Page"/>
    <meta name="author" content="Leipzig Data Project"/>
'. $out. '
  </body>
</html>';
}    

echo main();

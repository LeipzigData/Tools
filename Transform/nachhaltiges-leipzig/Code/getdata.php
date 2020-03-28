<?php
/**
 * User: Hans-Gert Gräbe
 * Date: 2018-01-07
 * LastUpdate: 2018-08-05
 */

include_once("akteure.php");
include_once("personen.php");
include_once("activities.php");

function main() {
    $what=$_GET['show'];
    $out='';
    if ($what=='personen') { $out=getPersonen(); }
    else if ($what=='akteure') { $out=getAkteure(); }
    else if ($what=='ldakteure') { $out=getLDAkteure(); }
    else if ($what=='aktivitaeten') { $out=getAllActivities(); }
    else if ($what=='events') { $out=getEvents(); }
    else if ($what=='aktionen') { $out=getActions(); }
    else if ($what=='projekte') { $out=getProjects(); }
    else if ($what=='services') { $out=getServices(); }
    else if ($what=='stores') { $out=getStores(); }
    else $out="GET war $what. Aufruf getdata.php fehlerhaft";
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
'. asPlainText($out). '
  </body>
</html> ';
}    

echo main();

<?php
/**
 * User: Hans-Gert Gräbe
 * Date: 2016-04-20
 */

include_once("akteure.php");
include_once("adressen.php");
include_once("events.php");

function main() {
  $what=$_GET['show'];
  if ($what=='akteure') { return asPlainText(getAkteure()); }
  else if ($what=='adressen') { return asPlainText(getAdressen()); }
  else if ($what=='events') { return asPlainText(getEvents()); }
  else return applicationList();
}

function pageHeader() {
  return '
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="SymbolicData Standalone Info Page"/>
    <meta name="author" content="SymbolicData Project"/>

    <title>Leipziger Ecken RDF Infoseite</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    
  </head>
<!-- end header -->
  <body>

';
}

function generalContent() {
  return '
<div class="container">
<div style="text-align:left"><a href=".">Back</a></div>

  <h1 align="center">Leipziger Ecken RDF Infoseite</h1>

<p> Bla Bla Bla </p> 

</div> 
';
}

function applicationList() {
  return '
<div class="container">
<ul>
<li> <a href="./?show=akteure">Die Akteure</a></li>
<li> <a href="./?show=adressen">Die Adressen</a></li>
<li> <a href="./?show=events">Die Events</a></li>
</ul>
</div> 
';
}

function pageFooter() {
  return '

    <!-- jQuery (necessary for Bootstrap JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>';
}

function showPage($content) {
  return pageHeader().generalContent().main().pageFooter();
}

echo pageHeader().generalContent().main().pageFooter();

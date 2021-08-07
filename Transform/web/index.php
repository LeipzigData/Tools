<?php
/**
 * User: Hans-Gert Gräbe
 * LastUpdate: 2020-03-27
 */

include_once("layout.php");

$content='
<div class="container">

  <h2 align="center">Demo für Transformationen von Datenmodellen</h2>

<p> Mit dieser kleinen Anwendung wird gezeigt, wie ... verschiedene
Informationen darstellen lassen.  </p>

<p> Details dazu in der <a href="README.md">README-Datei</a>.
</p>

</div> 
';

echo showPage($content);

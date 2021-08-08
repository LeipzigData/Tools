<?php

/**
 * User: Hans-Gert Gräbe
 * last update: 2021-08-08
 */

include __DIR__ . '/vendor/autoload.php';

/* ======= helper function ======== */

function setNamespaces() {
    \EasyRdf\RdfNamespace::set('dc', 'http://purl.org/dc/elements/1.1/');
    \EasyRdf\RdfNamespace::set('dcterms', 'http://purl.org/dc/terms/');
    \EasyRdf\RdfNamespace::set('foaf', 'http://xmlns.com/foaf/0.1/');
    \EasyRdf\RdfNamespace::set('ical', 'http://www.w3.org/2002/12/cal/ical#');
    \EasyRdf\RdfNamespace::set('owl', 'http://www.w3.org/2002/07/owl#');
    \EasyRdf\RdfNamespace::set('skos', 'http://www.w3.org/2004/02/skos/core#');
    \EasyRdf\RdfNamespace::set('ld', 'http://leipzig-data.de/Data/Model/');
}

function htmlEnv($out) 
{
    return '
<HTML>
<HEAD>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
</HEAD><BODY>
'.$out.'
</BODY></HTML>
';
}

function fixEncoding($out) {
    return str_replace(
        array("„","“","–"), array("&#8222","&#8221","&ndash;"), $out
    );
}

function showLanguage($a,$sep) {
    $out='';
    $b=array();
    foreach($a as $v) {
        $l=$v->getLang();
        if (empty($l)) { $l='en'; }
        $b[$l]="$l: $v";
    }
    ksort($b);
    return join($sep,$b);
}

function createLink($url,$text) {
    return '<a href="'.$url.'">'.$text.'</a>';
}

function createUniLink($url) {
    return '<a href="'.$url.'">'.$url.'</a>';
}

function genericLink() {
    return '
<h4>This web site is part of the <a href="http://wumm.uni-leipzig.de">WUMM Demonstration Project</a></h4>
';
}

function showDate($s) {
    return date("D d M Y",strtotime($s));
}

function multiline($s) {
    return str_replace("\n","<br/>",$s);
}

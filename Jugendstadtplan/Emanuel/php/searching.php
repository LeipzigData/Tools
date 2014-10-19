<?php
/**
 * Created by JetBrains PhpStorm.
 * User: emanuelott
 * Date: 07.06.13
 * Time: 12:27
 * To change this template use File | Settings | File Templates.
 */

error_reporting(0);

ini_set('default_charset', 'utf-8');
//$start = time();
require_once "easyrdf/lib/EasyRdf.php"; // Loads the EasyRdf Framework

function search_for_uri()
{

    EasyRdf_Namespace::set('ldo', 'http://leipzig-data.de/Data/Ort/');
    EasyRdf_Namespace::set('ldp', 'http://leipzig-data.de/Data/Person/');
    EasyRdf_Namespace::set('ldtag', 'http://leipzig-data.de/Data/Tag/');
    EasyRdf_Namespace::set('ld', 'http://leipzig-data.de/Data/Model/');
    EasyRdf_Namespace::set('owl', 'http://www.w3.org/2002/07/owl#');
    EasyRdf_Namespace::set('sysont', 'http://ns.ontowiki.net/SysOnt/');
    EasyRdf_Namespace::set('xsd', 'http://www.w3.org/2001/XMLSchema#');
    EasyRdf_Namespace::set('jsp1', 'http://localhost/jsp/');
    EasyRdf_Namespace::set('jsp', 'http://leipzig-data.de/Data/Jugendstadtplan/');
    EasyRdf_Namespace::set('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');


// URL zum Dokument
    $docuri = "http://leipzig-data.de/Jugendstadtplan/Emanuel/Data/unsere_data_1.json"; // JSP Daten

    $graph = EasyRdf_Graph::newAndLoad($docuri); // Läd das RDF-File
    foreach ($graph->allOfType('jsp:Ort') as $strKey) {
        $inarray = 0;
        if (preg_match('/' . $_REQUEST['q'] . '/i', $strKey->label())) {

            // paar Überprüfungen fehlen hier noch ob überhaupt darstellbar && filter

            $address1 = $strKey->get('jsp:hasAddress');

            $res3 = $graph->resource($address1);

            $latitude = $res3->get('geo:lat');
            $longitude = $res3->get('geo:long');

            $cat = explode("|", $_REQUEST['cat']);

            foreach ($strKey->all('jsp:hascategory') as $art) {
                $res2 = $graph->resource($art);
                $type = str_replace("http://leipzig-data.de/Data/Jugendstadtplan/", "", $res2);

                if (in_array($type, $cat)) {
                    $inarray = 1;
                }
                $hascategory++;
            }
            // Falls keine Kategorie angegeben -> wird zu No Category Kategorie gezählt
            if(!isset($hascategory)) {
                if (in_array("NA", $cat)) {
                    $inarray = 1;
                }

            }

            if($cat[0] == "all") $inarray = 1;



            // Wenn lat & long vorhanden dann suche ausgeben
            if ($inarray == 1) {
                echo "<a href='#' onclick='activatemarker(\"" . str_replace('http://localhost/jsp/', 'http://leipzig-data.de/Data/Jugendstadtplan/', $strKey) . "\")'>" . $strKey->label() . "</a><br/>";
            }
            $i++;


        }

        $ii++;
    }

    if (!isset($i)) echo "Sorry no match";

//$end = time();
//$laufzeit = $end-$start;
//
//echo "Laufzeit: ".$laufzeit." Sekunden!";

}

if (strlen($_REQUEST['q']) > 2) {
    search_for_uri();
}
?>
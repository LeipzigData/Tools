<?php
/**
 * Created by JetBrains PhpStorm.
 * User: emanuelott
 * Date: 19.06.13
 * Time: 21:36
 * To change this template use File | Settings | File Templates.
 */

require_once "php/easyrdf/lib/EasyRdf.php"; // Loads the EasyRdf Framework
ini_set('default_charset', 'utf-8');
EasyRdf_Namespace::set('ldo', 'http://leipzig-data.de/Data/Ort/');
EasyRdf_Namespace::set('ldp', 'http://leipzig-data.de/Data/Person/');
EasyRdf_Namespace::set('ldtag', 'http://leipzig-data.de/Data/Tag/');
EasyRdf_Namespace::set('ld', 'http://leipzig-data.de/Data/Model/');
EasyRdf_Namespace::set('sysont', 'http://ns.ontowiki.net/SysOnt/');
EasyRdf_Namespace::set('xsd', 'http://www.w3.org/2001/XMLSchema#');
EasyRdf_Namespace::set('jsp1', 'http://localhost/jsp/');
EasyRdf_Namespace::set('jsp', 'http://leipzig-data.de/Data/Jugendstadtplan/');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
Most of the used functions are defined here
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* print_categories gibt alle in "jsp:hascategory" gesetzten URIs zurück */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function print_cathegories($lang)
{


    // Graphen parsen
    $docuri1 = "http://leipzig-data.de/Jugendstadtplan/Emanuel/Data/unsere_data_1.json"; // RDF File, der einfachheit selbiges JSON was Javascript auch nutzt
    $graph1 = EasyRdf_Graph::newAndLoad($docuri1); // Läd den vollen Graphen
    $count = 0;
    $testarray = array();

    foreach ($graph1->resources() as $res) {
        if ($res->hasProperty('jsp:hascategory') == 1)

        {

            foreach ($res->all('jsp:hascategory') as $art ) {

            if (!in_array($art, $testarray)) {
                $testarray[] = $art;
                $res2= $graph1->resource($art);
                $labelres2 = $res2->label($lang);

                $type = str_replace("http://leipzig-data.de/Data/Jugendstadtplan/","",$res2);
                echo "<div class='bottomnavi' id='cat".$count."'><a href='#' onclick='disable_marker(\"" . $type . "\",".$count.");showResult(document.getElementById(\"searchfield\").value);'>" . $labelres2 . "</a></div>\n";
            $count++;
            }
            }

        }
    }
    echo "<div class='bottomnavi' id='cat".$count."'><a href='#' onclick='disable_marker(\"NA\",".$count.");showResult(document.getElementById(\"searchfield\").value)'>NO Category</a></div>\n";
    echo "<div class='bottomnavi bottomnavi_selected' id='cat".($count+1)."'><a href='#' onclick='disable_marker(\"all\",".($count+1).");showResult(document.getElementById(\"searchfield\").value);'>Alle Orte</a></div>\n";


}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Funktion zum Hinzufügen der fehlenden GEO-Coordinaten
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function get_missing_geo_data($do)
{
    global $log2;
    global $log3;

    $docuri = "http://leipzig-data.de/Jugendstadtplan/Emanuel/Data/unsere_data_1.json";

    $my_graph = new EasyRdf_Graph();
    $count = 0;
    $graph = EasyRdf_Graph::newAndLoad($docuri); // Läd das RDF-File

    // Geht alle jsp:Ort durch und überprüft die Orte ob jsp:hasAddress nicht leer und Geo Koordinaten gesetzt
    foreach ($graph->allOfType("jsp:Ort") as $resource1) {
        $uri_1 = $resource1->getUri();

        $adress_res = $resource1->get('jsp:hasAddress', "resource");
        $adress_graph = $graph->resource($adress_res);
        $adress_google = str_replace('http://leipzig-data.de/Data/Adresse/', '', $adress_res);
        $latitude = $adress_graph->get('geo:lat');
        $longitude = $adress_graph->get('geo:long');
        if ((!empty($adress_res)) && (empty ($longitude) || empty($latitude))) {

            // hier werden die in den Adressen fehlden Geocordinaten über Nominatem von OSM versucht zu extrahieren
            $g_path = 'http://nominatim.openstreetmap.org/search/' . $adress_google . '?format=json&limit=1';
            $geocode = file_get_contents($g_path);
            $geo_output = json_decode($geocode);


            if ($geocode != "[]") { //sollte die Anfrage bei Nominatem etwas zurückliefern

                $latitude = $geo_output[0]->lat;
                $longitude = $geo_output[0]->lon;

                if ($latitude != 0 && $longitude != 0) { // und Lat und Long extrahiert werden können dann werden diese entweder dem bestehenden Graphen zugeführt
                    # Optionale Funktion zur Ausgabe der durch Nominatem erzeugten Daten im turtle Format
                    if ($do == "turtle") {
                        //hierzu werden die Geo-Daten in einen neuen Graphen my_graph geladen
                        $my_graph->addLiteral($adress_res, 'geo:lat', $latitude);
                        $my_graph->addLiteral($adress_res, 'geo:long', $longitude);
                        $data = $my_graph->serialise('turtle');
                        if (!is_scalar($data)) {
                            $data = var_export($data, true);
                        }
                    } # Normale Funktion: hinzufügen der Geo-Daten in den bisher schon existenten Graphen der RDF Datei

                    else {
                        $graph->addLiteral($adress_res, 'geo:lat', $latitude);
                        $graph->addLiteral($adress_res, 'geo:long', $longitude);

                        # Modifizierten Graphen als JSON anlegen
                        $data = $graph->serialise('json');
                        if (!is_scalar($data)) {
                            $data = var_export($data, true);
                        }
                    }
                    $count++;
                }
            } # Falls keine Geokordinaten durch Nominatem ermittelt werden konnten zur Adresse Error Log im Array error_log anlegen
            else $error_log[] = "für die URI" . $uri_1 . "mit der Adresse " . $adress_google . " konnten kein GEO-Koordinaten gefunden werden.";


        }


    }


    // Ausgabe des Fehlerlogs:
    foreach ($error_log as $message) {
        $log3 .= $message;
    }

    // Wenn Turtle ausgabe aktiviert, dann Ausgabe des Turtle Codes, der einfaches Copy&Past möglich macht
    if ($do == "turtle") {
        if ($count > 0) {
            print "<pre>" . htmlspecialchars($data) . "</pre>";
        } else echo "no Need of changing something inside the rdf";

    } //Modifizieren des JSON bestehenden Dumps bei $do ==""
    else {
        if ($count > 0) {
            $dateihandle = fopen("Data/unsere_data_1.json", "w");
            fwrite($dateihandle, $data);
            if (file_exists("unsere_data_1.json")) {
                $log2 = "Dump modified";
            }
        } else $log2 = "nothing to change at the dump File";
    }


}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Funktion zum Dynamischen laden der Daten vom Sparql Endpunkt
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function get_json_dump_file()
{

//Über den SPARQL Endpunkt von Open-Data ein json Dump ziehen der jsp:Ort Daten
    $url = 'http://leipzig-data.de:8890/sparql?default-graph-uri=&query=PREFIX+jsp%3A+%3Chttp%3A%2F%2Fleipzig-data.de%2FData%2FJugendstadtplan%2F%3E++%0D%0Aconstruct+%7B%0D%0A+%3Fa+%3Fap+%3Fao+.%0D%0A+%3Fao+%3Fbp+%3Fbo+.%0D%0A+%3Fbo+%3Fcp+%3Fco+.%0D%0A+%3Fco+%3Fdp+%3Fdo+.%0D%0A%7D%0D%0AWhere+%7B%0D%0A+%3Fa+%3Fap+%3Fao+.%0D%0A+%3Fa+a+jsp%3AOrt+.%0D%0A+optional+%7B+%3Fao+%3Fbp+%3Fbo+.++%7D%0D%0A+optional+%7B+%3Fbo+%3Fcp+%3Fco+.++%7D%0D%0A+optional+%7B+%3Fco+%3Fdp+%3Fdo+.++%7D%0D%0A%7D%0D%0A&format=application%2Frdf%2Bjson&timeout=0&debug=on';
    $data = 'Data/unsere_data_1.json';
    $test = glob($data);
    $timestampold = filemtime($test[0]);
    global $log;


    $timestamp = time();
    $timedifference = $timestamp - $timestampold;
    if(isset($_REQUEST['load'])) $break ="10";
    else $break= 43200;// 12 Stunden
    if ($timedifference > $break) // Wenn der Dump älter als break
    {


        // hier muss noch ne überprüfung rein ob valides file und obs geklappt hat irgendwas abzufragen
        $content = file_get_contents($url);

        //Nachfolgend noch prüfen ob der SPARQL QUERY überhaupt irgendwas erzeugt und ob er mit ner JSON Ressource anfängt
        $content_start = substr($content, 0, 12);
        $content_has_to_start = '{
  "http://';
        if ((!empty($content)) && $content_start == $content_has_to_start) {
            //Daten überschreiben
            $dateihandle = fopen($data, "w");
            fwrite($dateihandle, $content);

            if (file_exists($data)) {
                $log = "new Dump created";
                get_missing_geo_data("");
                create_filter_file();
            }

        }


    } else $log = "hour is not finished yet";

}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function to create the filter kategorien
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function create_filter_file()
{

    // Graphen parsen
    $docuri = "http://leipzig-data.de/Jugendstadtplan/Emanuel/Data/unsere_data_1.json"; // RDF File, der einfachheit selbiges JSON was Javascript auch nutzt
    $graph = EasyRdf_Graph::newAndLoad($docuri); // Läd den vollen Graphen
    $testarray2 = array();
    $testarray3 = array();
    $testarray = array();
    foreach ($graph->allOfType("jsp:Ort") as $test1) {
        $counter = 0;

        foreach ($test1->properties() as $bezeichner) {

            $URI_value = $test1->getResource($bezeichner);

            $class = $graph->resource($URI_value);

            $type22 = $class->type();
            if ((!empty($type22)) AND ($type22 != "owl:Class")) {


                $res22 = $graph->resource($type22);
                $res22_type = $res22->type();

                if ($res22_type == "owl:Class") {
                    $relation = $res22->all("jsp:hasRelation");


                    if ((!empty($URI_value)) && ($bezeichner != "ld:hasURL") && ($bezeichner != "jsp:hasAddress") && ($type22 != "jsp:Ortskategorie") && ($bezeichner != "rdf:type")) {

                        $URI_value = str_replace("http://leipzig-data.de/Data/Jugendstadtplan/", "", $URI_value->__toString());

                        if (!in_array($URI_value, $testarray2)) {
                            $testarray2[] = $URI_value;
                        }
                        $URI_2 = $test1->__toString();


                        foreach ($relation as $relation1) {
                            if (!in_array($relation1, $testarray3)) {
                                $relation1 = $relation1->__toString();
                                $testarray3[] = $relation1;

                            }
                            $relation1= str_replace("http://leipzig-data.de/Data/Jugendstadtplan/", "", $relation1);
                            $testarray[$relation1][$URI_value][] = array($URI_2, 1);
                        }


                    }
                }
            }

            $counter++;;
        }

    }
    /* For Debugging only*/
     echo "<pre>";
      print_r($testarray['Allgemein']);
      echo "</pre>";
  
    $data = 'Data/filter.json';

    $dateihandle = fopen($data, "w");
    fwrite($dateihandle, json_encode($testarray));
    if (file_exists($data)) {
    }

    $data2 = 'Data/filter1.json';

    $dateihandle2 = fopen($data2, "w");
    fwrite($dateihandle2, json_encode($testarray2));
    if (file_exists($data2)) {
    }

}




?>



<?php
error_reporting(E_ALL);
/**
 * Created by JetBrains PhpStorm.
 * User: emanuelott
 * Date: 07.06.13
 * Time: 21:42
 * To change this template use File | Settings | File Templates.
 */

require_once "easyrdf/lib/EasyRdf.php"; // Loads the EasyRdf Framework
ini_set('default_charset', 'utf-8');

$text_elements_mainpage['Details'][5]['de'] =  "Information leider nocht nicht verfügbar.";
$text_elements_mainpage['Details'][5]['en'] =  "Sorry information not availible.";

function dump_info() {
EasyRdf_Namespace::set('ldo', 'http://leipzig-data.de/Data/Ort/');
EasyRdf_Namespace::set('ldp', 'http://leipzig-data.de/Data/Person/');
EasyRdf_Namespace::set('ldtag', 'http://leipzig-data.de/Data/Tag/');
EasyRdf_Namespace::set('ld', 'http://leipzig-data.de/Data/Model/');
EasyRdf_Namespace::set('sysont', 'http://ns.ontowiki.net/SysOnt/');
EasyRdf_Namespace::set('xsd', 'http://www.w3.org/2001/XMLSchema#');
EasyRdf_Namespace::set('jsp1', 'http://localhost/jsp/');
EasyRdf_Namespace::set('jsp', 'http://leipzig-data.de/Data/Jugendstadtplan/');


// Graphen laden
$docuri = "http://leipzig-data.de/Jugendstadtplan/Emanuel/Data/unsere_data_1.json"; //RDF File
$graph = EasyRdf_Graph::newAndLoad($docuri); // Läd den vollen Graphen
$requested_res = $_REQUEST['URI']; // Je nach GET Anfrage wird ein unterschiedlicher Graph zu laden versucht
$lang=$_REQUEST['lang'];
    if(!isset($_REQUEST['lang'])) $lang = "de";
        $requested_res_data = $graph->resource($requested_res); //Zieht sich die Ressource passend zur übermittelten


        echo "<div id='eigenschaften'><table>";
           foreach ($requested_res_data->properties() as $bezeichner){
                if (($bezeichner != "rdf:type") AND ($bezeichner != "rdfs:label") AND ($bezeichner != "ld:hasURL") AND ($bezeichner != "jsp:hasAddress")AND ($bezeichner != "jsp:hasOpeningHours") AND ($bezeichner != "jsp:hasdescription") AND ($bezeichner != "jsp:hasIrregularOpeningHours")) {
                $description = str_replace("http://leipzig-data.de/Data/Jugendstadtplan/","",$requested_res_data->get($bezeichner));

                $bezeichner_human = explode(":",$bezeichner);
                echo "<tr><td>".$bezeichner_human[1]."</td><td>".$description."</td></tr>";
                }
            }

        echo "</table></div>";

    // Label
    $label = $requested_res_data->label();
    echo "<div id='heading'><a href='#' onclick='expand_divs(\"description\")'>".$label."</a></div>";

    // Description
    $description = $requested_res_data->getLiteral("jsp:hasdescription",$lang);
    if(empty($description) && $_REQUEST['lang']=="en") $description="no information available";
    elseif (empty($description)) $description="Keine Information vorhanden";
    echo "<div id='description'>".$description."</div>";

    //Kontakt

        $address_uri=$requested_res_data->get("jsp:hasAddress");
        $address_ressource = $graph->resource($address_uri);

        // resolve street_name
        $street_uri = $address_ressource->get("ld:inStreet");
        $street_ressource = $graph->resource($street_uri);
        $street_name = $street_ressource->label();

        //House Number
        $housenumber = $address_ressource->get("ld:hasHouseNumber");

        //ZIP
        $postcode = $address_ressource->get("ld:hasPostCode");

        //City
        $city = "Leipzig"; //MUss noch besser
        $URL = $requested_res_data->get("ld:hasURL");

         if(empty($street_name)) $street_name="sorry no contact information availible";
        echo "<div id='address'><b>".$label."</b><br/>". $street_name." ". $housenumber."<br/>\n".$postcode." ".$city."<br/><br><a href='".$URL."' target='_blank'>".$URL."</a></div>";


//Opening Hours
    $openinghours = $requested_res_data->get("jsp:hasOpeningHours");
    if(empty($openinghours)) "echo no regular opening hours";

    preg_match_all('/(Mo|Di|Mi|Do|Fr|Sa|So)[.0-9a-zA-Z\s]*\((\d+:[0-9][0-9])(\-|\–)(\d+\:[0-9][0-9])\)/', $openinghours,$array );


    echo "<div id='openinghours'><table><tr></tr>";

    foreach ($array[1] as $Day) {
        echo "<td>".$Day."</td>";

    }
    echo "</tr>\n<tr>";


    foreach ($array[2] as $Day) {
        echo "<td>".$Day."</td>";

    }

    echo "</tr>\n<tr>";
foreach ($array[1] as $Day) {
    echo "<td>-</td>";


}
    echo "</tr>\n<tr>";

    foreach ($array[4] as $Day) {
        echo "<td>".$Day."</td>";

    }
    echo "</tr></table>";

    $hasirregularopeninghours = $requested_res_data->get("jsp:hasIrregularOpeningHours");

    if (!empty($hasirregularopeninghours)) {echo "<br/>*". $hasirregularopeninghours;}

    echo "</div>";

}

if (isset($_REQUEST['URI'])) {
    dump_info();
}
?>




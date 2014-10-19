<?php
error_reporting(0);
require_once "easyrdf/lib/EasyRdf.php"; // Loads the EasyRdf Framework
EasyRdf_Namespace::set('ldo', 'http://leipzig-data.de/Data/Ort/');
EasyRdf_Namespace::set('ldp', 'http://leipzig-data.de/Data/Person/');
EasyRdf_Namespace::set('ldtag', 'http://leipzig-data.de/Data/Tag/');
EasyRdf_Namespace::set('ld', 'http://leipzig-data.de/Data/Model/');
EasyRdf_Namespace::set('sysont', 'http://ns.ontowiki.net/SysOnt/');
EasyRdf_Namespace::set('xsd', 'http://www.w3.org/2001/XMLSchema#');
EasyRdf_Namespace::set('jsp1', 'http://localhost/jsp/');
EasyRdf_Namespace::set('jsp', 'http://leipzig-data.de/Data/Jugendstadtplan/');



echo "<div id='allgemein'>";


// Graphen parsen
$docuri = "http://leipzig-data.de/Jugendstadtplan/Emanuel/Data/unsere_data_1.json"; // RDF File, der einfachheit selbiges JSON was Javascript auch nutzt
$graph = EasyRdf_Graph::newAndLoad($docuri); // Läd den vollen Graphen
$testarray2 = array();
$hilfsarray = array();
foreach ($graph->allOfType("jsp:Ort") as $test1) {
    $counter = 0;


    foreach ($test1->properties() as $bezeichner) {

        $URI_value = $test1->getResource($bezeichner);

        $class = $graph->resource($URI_value);

        $type22 = $class->type();
        if ((!empty($type22)) AND ($type22 != "owl:Class")) {


            $res22 = $graph->resource($type22);
            $res22_type = $res22->type();
            $relation = $res22->all("jsp:hasRelation");

            if ($res22_type == "owl:Class") {


                if ((!empty($URI_value)) && ($bezeichner != "ld:hasURL") && ($bezeichner != "jsp:hasAddress") && ($type22 != "jsp:Ortskategorie") && ($bezeichner != "rdf:type")) {

                    $URI_value = str_replace("http://leipzig-data.de/Data/Jugendstadtplan/", "", $URI_value->__toString());


                    foreach ($relation as $relation1) {
                        $relation1= str_replace("http://leipzig-data.de/Data/Jugendstadtplan/", "", $relation1);

                        if (!in_array($type22, $hilfsarray[$relation1])) $hilfsarray[$relation1][] = $type22;


                        if (!in_array($URI_value, $testarray2[$relation1][$type22])) {
                        $testarray2[$relation1][$type22][] = $URI_value;

                    }
                    }


                }
            }
        }

        $counter++;;
    }

}
/*echo "<pre>";
print_r($hilfsarray);
echo "</pre>";
*/

echo "<table style='width:500px;'>";
foreach ($hilfsarray[$_REQUEST['l']] as $ueberschrift) {


    echo "<tr><td><b>" . $ueberschrift . "</b> </td>";
    foreach ($testarray2[$_REQUEST['l']][$ueberschrift] as $checkbox) {
        echo "<td>" . $checkbox . "<input type='checkbox'  onChange='apply_filter(\"" . (str_replace("http://leipzig-data.de/Data/Jugendstadtplan/", "", $checkbox)) . "\");' id='" . $checkbox . "' checked/></td>";

    }
    echo "</tr>";

}
echo "</table>";


echo "</div>";



?>
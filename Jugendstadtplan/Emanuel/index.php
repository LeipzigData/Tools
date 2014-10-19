<?php
error_reporting(1);

set_time_limit(360);
ini_set("memory_limit", "1024M");
error_reporting(E_ALL);
ini_set('display_errors', true);

$lat = 51.3400;

$lon = 12.3800;

if($_REQUEST['lang']=="en")
{
    $lang="en";

}
else $lang="de";

include_once "php/functions.php";

//Langues Elements

$text_elements_mainpage['Details'][0]['de'] =  "[Öffnungszeiten]";
$text_elements_mainpage['Details'][0]['en'] =  "[opening hours]";
$text_elements_mainpage['Details'][1]['de'] =  "[Eigenschaften]";
$text_elements_mainpage['Details'][1]['en'] =  "[characteristics]";
$text_elements_mainpage['Details'][2]['de'] =  "[Kontakt]";
$text_elements_mainpage['Details'][2]['en'] =  "[contact]";

$text_elements_mainpage['Details'][3]['de'] =  "Bitte Ort auswählen.";
$text_elements_mainpage['Details'][3]['en'] =  "Please choose a place in the map.";
$text_elements_mainpage['Details'][4]['de'] =  "Kein Ort ausgewählt";
$text_elements_mainpage['Details'][4]['en'] =  "No place choosen";


$text_elements_mainpage['Details'][6]['de'] =  "Informationen anzeigen";
$text_elements_mainpage['Details'][6]['en'] =  "show details";
get_json_dump_file();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Jugendstadtplan 2013</title>

    <!-- Java Scripts -->
    <script src="http://cdn.leafletjs.com/leaflet-0.5/leaflet.js" type="text/javascript"></script>
    <script src="javascript/jquery-1.10.1.min.js" type="text/javascript"></script>
    <script src="javascript/functions.js" type="text/javascript"></script>

    <script src="javascript/leaflet.awesome-markers.js" type="text/javascript"></script>

    <!-- StyleSheets -->
    <link rel="stylesheet" href="css/leaflet.css"/>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="css/leaflet.css"/>
    <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
    <![endif]-->
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/leaflet.awesome-markers.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">

</head>
<body>


<div id="header">

    <?php if($lang=="en") echo '<a href="index.php"><img src="images/flag_de.jpg" alt="German"/></a>'; else echo '<a href="index.php?lang=en"><img src="images/flag_en.jpg" alt="English"/></a>';?></a><img src="images/flag_fr.jpg" alt="French"/><input type="search"
                                                                                                    id="searchfield"
                                                                                                    onkeyup="showResult(this.value)"/>

    <div id="livesearch"></div>

</div>

<div id="inner-wrap">
    <div id="content">
        &nbsp;
    </div>
    <div id="wrap-details">
        <div id="detailsbox"><img src="images/testpic.jpg" width="220px" alt="Testpic"/>

            <div id="label"><a href="#" onclick="expand_divs('description')"><?php echo  $text_elements_mainpage['Details'][4][$lang] ?></a></div>
            <div id="description"><?php echo  $text_elements_mainpage['Details'][3][$lang] ?>
            </div>
            <div class="details_subnavi"><a href="#" onclick="expand_divs('adresse')"><?php echo  $text_elements_mainpage['Details'][0][$lang] ?></a></div>
            <div id="adresse" style="display:none;"><?php echo  $text_elements_mainpage['Details'][3][$lang] ?></div>
            <div class="details_subnavi"><a href="#" onclick="expand_divs('eigenschaften')"><?php echo  $text_elements_mainpage['Details'][1][$lang] ?></a></div>
            <div id="eigenschaften" style="display:none;"><?php echo  $text_elements_mainpage['Details'][3][$lang] ?></div>
            <div class="details_subnavi"><a href="#" onclick="expand_divs('kontakt')"><?php echo  $text_elements_mainpage['Details'][2][$lang] ?></a></div>
            <div id="kontakt" style="display:none;"><?php echo  $text_elements_mainpage['Details'][3][$lang] ?></div>
        </div>

    </div></div>
    <div id="footer">
        <?php print_cathegories($lang); ?>
    </div>

<script type="text/javascript">

    /* global variables */

    var marker_brain = new Array(); // Internal storage array for the observation which cathegory is choosen and which isn't
    var map;
    var JSONFile = "Data/unsere_data_1.json";
    var glat;
    var glong;
    var lang = <?php echo "'".$lang."';"; ?>

    /* Define Awesome Markers */
    var redMarker = L.AwesomeMarkers.icon({
        icon: 'star',
        color: 'green'
    });


    /* Creating the Map */
    function init() {
        map = L.map('content').setView([<?php echo $lat;?>, <?php echo $lon;?>], 15);

        L.tileLayer('http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>'
        }).addTo(map);
        map.attributionControl.setPosition(
            'bottomleft');
    }


    /* Data processing done down here
     */

    // strings for JSON keys
    var rdfType = "http://www.w3.org/1999/02/22-rdf-syntax-ns#type";
    var rdfLabel = "http://www.w3.org/2000/01/rdf-schema#label";
    var owlSameAs = "http://www.w3.org/2002/07/owl#sameAs";
    var hasAddress = "http://leipzig-data.de/Data/Jugendstadtplan/hasAddress";
    var geoLat = "http://www.w3.org/2003/01/geo/wgs84_pos#lat";
    var geoLong = "http://www.w3.org/2003/01/geo/wgs84_pos#long";
    var category = "http://leipzig-data.de/Data/Jugendstadtplan/hascategory";
    var hasURL = "http://leipzig-data.de/Data/Model/hasURL";

    var jsp_URI = new Array();
    var testcounter = 0;
    var allmarker = new Array();
    allmarker['all']  = new Array();
    var allmarker2 = new Array();
    var count_coordinaten_gesaugt = 0;
    var log_probs = new Array();
    var cathegories = new Array();
    cathegories.push('all');
    var marker_uris = new Array();
    $.ajax({
        type: 'GET',
        url: JSONFile,
        dataType: 'json',
        success: function (data) {
            init();
            /* Unsauber muss man nochmal ran */
            $.each(data, function (key) {
                jsp_URI.push(key);
            });


            for (var i in data) {
                var jsp_uri = jsp_URI[testcounter];

                // if this is jsp:Ort
                if (typeof (data[i][rdfType]) == "undefined") console.log("rdfTypenot set");
                else {
                    if (data[i][rdfType][0].value == "http://leipzig-data.de/Data/Jugendstadtplan/Ort") {

                        if (data[i][hasAddress] != null) {
                            //if jsp:Ort has an address minimum requirements are fullfilled, let's mark the place
                            var address = data[i][hasAddress][0].value;
                            //Geo-Coordinates:
                            if (typeof (data[address]) == "undefined") console.log(jsp_URI[testcounter] + " Adress Ressource non-exisent :" + address);
                            else {


                                if (typeof (data[address][geoLat]) == "undefined") console.log(jsp_URI[testcounter] + " Adress Ressource without GEODATA :" + address);
                                else {
                                    //if geocordinates existing -> we are happy using them
                                    var lat = parseFloat(data[address][geoLat][0].value);
                                    var lng = parseFloat(data[address][geoLong][0].value);


                                    if (typeof lat != "undefined") {
                                        //fetching the rest of the Data
                                        // URI, die die ID für das Array mit allen markern wird
                                        // for the cathegory Filter
                                        //gleich noch ne schleife hier einfügen


                                        // Label
                                        if (typeof (data[i][rdfLabel]) == "undefined") console.log(jsp_URI[testcounter] + "RDF Label non-existent");
                                        else {
                                            var label = data[i][rdfLabel][0].value;


                                            // AB HIER ENTSTEHT DER OUTPUT

                                            //TODO: Doppeltagging beachten!!

                                            if (type == "Museum") { // Hier später highlight der mintorte
                                                var LamMarker = L.marker([lat, lng], {icon: redMarker}).addTo(map)
                                                    .bindPopup('<b>' + label + '</b><br/><a href="#" onclick="contentloader(\'' + jsp_uri + '\',\'' + lang + '\');"><?php echo $text_elements_mainpage['Details'][6][$lang]; ?></a>.');
                                                allmarker2[jsp_uri] = new Array();

                                            }
                                            else {
                                                var LamMarker = L.marker([lat, lng]).addTo(map)
                                                    .bindPopup('<b>' + label + '</b><br/><a href="#" onclick="contentloader(\'' + jsp_uri + '\',\'' + lang + '\');"><?php echo $text_elements_mainpage['Details'][6][$lang]; ?></a>.');
                                                allmarker2[jsp_uri] = new Array();

                                            }
                                            marker_uris.push(jsp_uri);
                                            allmarker2[jsp_uri].push(LamMarker);
                                            allmarker2[jsp_uri].push(lat);
                                            allmarker2[jsp_uri].push(lng);
                                            map.addLayer(allmarker2[jsp_uri][0]);
                                            /*Hier wird das letzt hinzugefügte Array ausgegeben */

                                            //Filter ab hier

                                            //TODO: cathegory allgemein wenn keiner gesetzt
                                            if (typeof data[i][category] == "undefined") {
                                                console.log(jsp_URI[testcounter] + " jsp:hascategory non-existent");
                                                var type="NA"; // Variable for all the ones without a category
                                            }
                                            else {

                                                var type = data[i][category][0].value.replace("http://leipzig-data.de/Data/Jugendstadtplan/", ""); // hier nacher noch schleife um mehrere arts abzudecken
                                            }
                                                //Filtern nach Type
                                                if (typeof allmarker[type] == 'undefined') {
                                                    cathegories.push(type);
                                                    allmarker[type] = new Array();
                                                    //set the marker brain as active
                                                    marker_brain[type] = 1;
                                                }

                                                var pushtest1 = allmarker[type].push(jsp_uri);
                                                // In Kategorie alle packen
                                                allmarker['all'].push(jsp_uri);
                                            //Filter nach irgendwas anderes


                                            count_coordinaten_gesaugt = count_coordinaten_gesaugt + 1;
                                        }

                                    }

                                }
                            }


                        }

                    }
                }
                testcounter = testcounter + 1;

            }
        },
        data: {},
        async: false
    });


   /*alert(count_coordinaten_gesaugt + " Orte hinzugefügt");*/

</script>

<div id="filter"></div>
<?php echo "<br/>Temporärer PHP Error Log:<br/>" . $log . "<br/>" . $log2 . "<br/>" . $log3; ?>
</body>
</html>

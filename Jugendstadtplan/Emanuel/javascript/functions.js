
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
This File stores most of the javascript functions used for everything else but the basic map features
most of the functions require the jquery Library included in the index.php */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

var bigbrain = 0;




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* contentloader loads the content asynchronously into the divs of the details box   */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function contentloader(uri, lang) {
    $("#label").load("php/details.php?lang=" + lang + "&URI=" + uri + " #heading");
    $("#eigenschaften").load("php/details.php?lang=" + lang + "&URI=" + uri + " #eigenschaften");
    $("#kontakt").load("php/details.php?lang=" + lang + "&URI=" + uri + " #address");
    $("#adresse").load("php/details.php?lang=" + lang + "&URI=" + uri + " #openinghours");
    $("#description").load("php/details.php?lang=" + lang + "&URI=" + uri + " #description");

}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* activatemarker used by the search to pan the map to the marker's position and open it  */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function activatemarker(uri) {
    //Map zentrieren an gewünschter Stelle
    map.panTo([allmarker2[uri][1], allmarker2[uri][2]]);
    //PopUp öffnen
    allmarker2[uri][0].openPopup();
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* disable_marker function is the function disable and enable the markers of each category. for this the var bigbrain
  *
   */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function disable_marker(cat_type, catnumber) {

    // remove all markers before doing something else (only the first click on a category item)
    if (bigbrain == 0) {
        remove_all_marker();

        bigbrain = bigbrain + 1;


    }

    if (marker_brain[cat_type] != 1) {
        remove_all_marker();
        for (i = 0; i < allmarker[cat_type].length; i++) {
            map.addLayer(allmarker2[allmarker[cat_type][i]][0]);


        }
        marker_brain[cat_type] = 1;
        $('#cat' + catnumber).toggleClass("bottomnavi_selected");
        get_filtered_data();

        show_filter(cat_type);

    }

    else {
        for (i = 0; i < allmarker[cat_type].length; i++) {
            map.removeLayer(allmarker2[allmarker[cat_type][i]][0]);

        }
        marker_brain[cat_type] = 0;

        $('#cat' + catnumber).toggleClass("bottomnavi_selected");
        $("#filter").empty();

    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* remove_all_marker loops trough the allmarker2 array and removes marker after marker from the map...
also it sets the marker_brain arrays to zero to refresh the internal memory, which marker has been set and which not
 *
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function remove_all_marker() {

    // remove all markers from the map, in parsing the allmarker2 array
    for (ii = 0; ii < cathegories.length; ii++) {
        for (i = 0; i < allmarker[cathegories[ii]].length; i++) {

            map.removeLayer(allmarker2[allmarker[cathegories[ii]][i]][0]);


        }
        //setzen aller gesetzten categories auf 0, also nicht ausgewählt
        marker_brain[cathegories[ii]] = 0;
        // toggle the css classes of the bottomnavigation
        $('#cat' + ii).removeClass("bottomnavi_selected");
    }
    //finally toggle the "extra" category for markers without
    ii = ii + 1;
    $('#cat' + ii).removeClass("bottomnavi_selected");


    //and set the extra catgeorie brain to zero
    marker_brain["NA"] = 0;
    marker_brain["all"] = 0;


}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 add_all_marker as the opposite to the remove_all_marker
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function add_all_marker() {
    for (i = 0; i < marker_uris.length; i++) {
        map.addLayer(allmarker2[marker_uris[i]][0]);

    }


}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* expand_divs is responsible for the jquery animated displaying of the Detailsbox
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function expand_divs(div) {

    if (document.getElementById(div).style.display == 'none') {
        if (document.getElementById('description').style.display != 'none') {
            var divopen = "#description";
        }
        else if (document.getElementById('kontakt').style.display != 'none') {
            var divopen = "#kontakt";
        }
        else if (document.getElementById('eigenschaften').style.display != 'none') {
            var divopen = "#eigenschaften";

        }

        else divopen = "#adresse";

        $(divopen).animate({"height": "toggle"}, { duration: 1000 });

        $(divopen).promise().done(function () {
            // will be called when all the animations on the queue finish
            $('#' + div).animate({"height": "toggle"}, { duration: 1000 });

        });


    }
    else if (div == 'description') {
    }
    else {

        $('#' + div).animate({"height": "toggle"}, { duration: 1000 });

        $('#' + div).promise().done(function () {
            $('#description').animate({"height": "toggle"}, { duration: 1000 });
        });

    }

}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* search field respond function on top of the index page defined here loads asynchronously the searching.php with the
results list
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function showResult(str) {
    var catstring = "";
    for (var i = 0; i < cathegories.length; i++) {

        if (marker_brain[cathegories[i]] == 1) {
            catstring += cathegories[i] + "|";

        }
    }


    $('#livesearch').load('php/searching.php?q=' + str + '&cat=' + catstring);

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* get_filtered_data loads the to filter json files for the detailed filter STILL WORK IN PROGRESS [HAS TO BE COMBINED
WITH THE GENERAL CATEGORY FILTER AT A LATER POINT]
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

var data_filtered;
var data_filtered_cat;

function get_filtered_data() {
    $.ajax({
        url: 'Data/filter.json',
        async: false,
        dataType: 'json',
        success: function (response) {
            data_filtered = response;
        }
    });
    $.ajax({
        url: 'Data/filter1.json',
        async: false,
        dataType: 'json',
        success: function (response) {
            data_filtered_cat = response;

        }
    });


}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 apply_filter is the one responsible for the detailed filter system, parsing a array matrix WORK IN PROGRESS [HAS TO
 BE CLEANER AND THE NOT AVAILABLE CATEGORIES HAVE TO BE CONSIDERED]
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function apply_filter(filter_typ) {
    // Schleife durchgehen
    //alle URIS die dem typ filter_typ im array zugeordnet sind auslesen
    for (i = 0; i < data_filtered['Allgemein'][filter_typ].length; i++) {
        var somewhere_active = 0;
        //erstmal den Arrayeintrag zur URL gleich 0 setzen
        if (data_filtered['Allgemein'][filter_typ][i][1] == 1) {
            data_filtered['Allgemein'][filter_typ][i][1] = 0;
        }
        else
        {
            data_filtered['Allgemein'][filter_typ][i][1] = 1;

        }

            // alle arrays durchsuchen ob zur gewünschten URL noch irgendwo in nem anderen array n 1er steht und somit aktiv ist

            for (i1 = 0; i1 < data_filtered_cat.length; i1++) {


                if (typeof data_filtered['Allgemein'][data_filtered_cat[i1]] == "undefined") {
                }
                else {
                    for (i2 = 0; i2 < data_filtered['Allgemein'][data_filtered_cat[i1]].length; i2++) {
                        if (jQuery.inArray(data_filtered['Allgemein'][filter_typ][i][0], data_filtered['Allgemein'][data_filtered_cat[i1]][i2]) != -1) {


                            /*"Die URI "+data_filtered[filter_typ][i][0]+" ist auch von "+data_filtered_cat[i1]+" und ist value "+data_filtered[data_filtered_cat[i1]][i2][1]);*/
                            if (data_filtered['Allgemein'][data_filtered_cat[i1]][i2][1] != 0) {
                                somewhere_active = somewhere_active + 1;
                            }


                        }


                    }
                }

            }







            //Sofern der Marker sonst nirgends mehr als aktiv gelistet ist von der map runternehmen
            if (somewhere_active == 0) {

                map.removeLayer(allmarker2[data_filtered['Allgemein'][filter_typ][i][0]][0]);
            }
        else if(data_filtered['Allgemein'][filter_typ][i][1] == 1) {

                map.addLayer(allmarker2[data_filtered['Allgemein'][filter_typ][i][0]][0]);

            }
        else {console.log("error");}

    }

    console.log(data_filtered);
}




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 show filter loads the filter panel (filter.php) into the filter div
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function show_filter(cat) {
    if (cat == "all") cat = "Allgemein";
    $("#filter").load("php/filters.php?l=" + cat);

}

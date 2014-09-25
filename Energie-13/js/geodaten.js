/*
 * Nachdem das Document geladen wurde, werden die Anlagendaten und die
 * benötigten Labels von einem SPARQL-Endpoint mittels AJAX abgefragt. Dies
 * passiert mit insgesamt drei Abfragen, die erste lädt die Stammdaten, die
 * zweite die Geodaten und die letzte Abfrage liefert die Labels. Danach wird
 * über alle Anlagen iteriert und für jede Anlage ein Marker erzeugt.
 * Gleichzeitig werden die Grenzwerte für die Filter ermittelt und die
 * Filter-Elemente entsprechent konfiguriert. Sobald ein Filter vom Benutzer
 * verändert wird, werden alle Marker gelöscht, danach wieder über alle
 * Anlagen iteriert und für jede Anlage ein Marker gesetzt, welche die
 * Filterbedingungen nicht verletzt.  
 *
 * Für die Visualisierung wurde nun OpenStreetMap und OpenLayers verwendet.
 * Nützliche Infos und ein Visualisierungs-Beispiel, was für die
 * Implementierung benutzt wurde, ist unter folgenden Links zu finden:
 * http://dev.openlayers.org/docs/files/OpenLayers-js.html
 * http://www.vorlagen.uni-erlangen.de/vorlagen/karten.shtml
 */
$( document ).ready(function() {
    // labels enthält eine Zuordnung URI -> Label, aller benötigter Label
    labels = new Array();
    
    // stammDaten enthält alle Anlagen und die dazugehörigen Stammdaten
    stammDaten = new Array();
    
    // geoDaten enhält alle Anlagen jund die dazugehörigen Geodaten
    geoDaten = new Array();
    
    // energietraeger enthält alle zur Verfügung stehenden Energieträger
    energietraeger = new Object();
    // energietraegerFilter enthält alle Energieträger, die durch den Filter
    // ausgewählt wurden
    energietraegerFilter = new Object();
    
    // einspeisungsebene enthält alle zur Verfügung stehenden Einspeiseebenen
    einspeisungsebene = new Object();
    // einspeisungsebeneFilter enthält alle Einspeiseebenen, die durch den
    // Filter ausgewählt wurden
    einspeisungsebeneFilter = new Object();
    
    // postleitzahlenAll enthält alle zur Verfügung stehenden Postleitzahlen
    postleitzahlenAll = new Object();
    // postleitzahlenFilter enthält alle Postleitzahlen, die durch den Filter
    // ausgewählt wurden
    postleitzahlenFilter = new Object();
    
    // netzbetreiberAll enthält alle zur Verfügung stehenden Netzbetreiber
    netzbetreiberAll = new Object();
    // netzbetreiberFilter enthält alle Netzbetreiber, die durch den Filter
    // ausgewählt wurden
    netzbetreiberFilter = new Object();
    
    // firstRun speichert, ob die makeMarkers Funktion das erste Mal
    // ausgeführt wird oder nicht
    firstRun = true;
    
    // inbetriebnahmedatumMin und inbetriebnahmedatumMax speichern das jüngste
    // und älteste Inbetriebnahmedatum aller Anlagen und werden mit dem
    // aktuellen Datum initiiert
    inbetriebnahmedatumMin = new Date();
    inbetriebnahmedatumMax = new Date();
    
    // leistungMin und leistungMax speichern die kleinste und größte Leistung
    // aller Anlagen
    leistungMin = 0;
    leistungMax = 0;
    
    // assetLayerGroup gruppiert alle Marker in einer Gruppe, um sie bei
    // Änderung, z.B. an einem Filter, durch einen einzigen Befehl alle
    // löschen zu können
    markersGroup = new OpenLayers.Layer.Markers( "Markers" );
    
    // map enhält die Referenz auf die von der Funktion makeMap erzeugten
    // Karte
    map = makeMap(map);
    
    // verknüpft die Marker Gruppe mit der Karte
    map.addLayer(markersGroup);
    
    // Aufruf der Funktion zur Abfrage der Stammdaten vom Server
    stammDaten = getStammDaten(stammDaten);
    // Aufruf der Funktion zur Abfrage der Geodaten vom Server
    geoDaten = getGeoDaten(geoDaten);

    // Aufruf der Funktion zur Abfrage der Labels
    labels = getLabels(labels);
    
    // Beim ersten Aufruf sind noch keine Beschränkungen aktiv,
    // d.h. energietraegerFilter bzw.  einspeisungsebeneFilter enhalten alle
    // Elemente aus energietraeger bzw. einspeisungsebene.
    energietraegerFilter = energietraeger;
    einspeisungsebeneFilter = einspeisungsebene;
    
    // An das ENR Filter Input Element wid ein Event gekoppelt, welches die
    // makeMakers Funktion auslöst und somit die Marker neu erzeugt, sobald in
    // das ENR Element etwas geschrieben wird.
    $('#enr input').change(function() {
        makeMarkers(stammDaten, geoDaten, map, labels);
    });
    
    // Die Datumsfelder für das Inbetriebnahmedatum werden mit einem Jquery UI
    // Datepicker versehen und einsprechende Konfigurationen gesetzt. Außerdem
    // wird eine Event gesetzt, um nach Ändern des Elements die Maker neu zu
    // erzeugen.
    $( "#inbetriebnahmedatum #from" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3,
        onClose: function( selectedDate ) {
            $( "#inbetriebnahmedatum #to" ).datepicker( "option", "minDate", selectedDate );
            makeMarkers(stammDaten, geoDaten, map, labels);
        }
    });
    $( "#inbetriebnahmedatum #to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3,
        onClose: function( selectedDate ) {
            $( "#inbetriebnahmedatum #from" ).datepicker( "option", "maxDate", selectedDate );
            makeMarkers(stammDaten, geoDaten, map, labels);
        }
    });
    
    // Die makeMakers Funktion wird zum ersten Mal aufgerufen, um nach dem
    // Seitenaufruf alle Marker zu erzeugen und anzuzeigen. Dabei werden auch
    // Variablen wie inbetriebnahmedatumMin, inbetriebnahmedatumMax,
    // leistungMin und leistungMax gesetzt.
    makeMarkers(stammDaten, geoDaten, map, labels);
    
    // Die durch die Funktion makeMarkers ermittelten Werte für
    // inbetriebnahmedatumMin und inbetriebnahmedatumMax werden in die
    // Inbetriebnahmedatum Datumsfelder als Startwerte übernommen.
    $( "#inbetriebnahmedatum #from" ).datepicker("setDate", inbetriebnahmedatumMin);
    $( "#inbetriebnahmedatum #to" ).datepicker("setDate", inbetriebnahmedatumMax);
    
    // Für das Leistungs-Filter wird ein Jquery Slider gesetzt und die
    // leistungMin bzw. leistungMax Werte werden als kleinster und größter
    // Wert festgelegt. Außerdem wird wieder ein Event gesetzt, um die Maker
    // neu zu generieren, sobald der Filter geändert wurde.
    $( "#slider-range" ).slider({
        range: true,
	// für eine bessere Benutzbarkeit werden die Grenzwerte etwas verändert
        min: leistungMin - 1, 
        max: leistungMax + 10,
        values: [ leistungMin, leistungMax ],
        slide: function( event, ui ) {
            $( "#amount" ).val( ui.values[ 0 ] + " kW - " + ui.values[ 1 ] + " kW" );
        },
        stop: function( event, ui ) {
            makeMarkers(stammDaten, geoDaten, map, labels);
        }
    });
    
    // Da der Leistungs-Filter neben dem Slider auch noch ein Anzeigefeld für
    // den eingestellten Leistungsbereich hat, wird dieses Anzeigefeld hier
    // initialisiert.
    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
    " kW - " + $( "#slider-range" ).slider( "values", 1 ) + " kW");
    
    // Für jeden Energieträger wir hier ein enstprechendes Filterelement
    // erzeugt.
    for (var value in energietraeger) {
        $('#energietraeger ol#selectable')
	    .append('<li class="ui-widget-content ui-selected" value="' 
		    + value + '">' + labels[value] + '</li>');
    };
    // Der Energieträger-Filter wird mit einem Event verknüpft, um die Marker
    // neu zu erzeugen, sobald der Filter geändert wurde.
    $( "#energietraeger ol#selectable" ).selectable({
        stop: function() {
            energietraegerFilter = new Object();
            $( ".ui-selected", this ).each(function() {
                energietraegerFilter[$(this).attr('value')] = ( $(this).attr('value') );
            });
            makeMarkers(stammDaten, geoDaten, map, labels);
        }
    });
    
    // Für jede Einspeiseebene wir hier ein enstprechendes Filterelement
    // erzeugt.
    for (var value in einspeisungsebene) {
        $('#einspeisungsebene ol#selectable')
	    .append('<li class="ui-widget-content ui-selected" value="' 
		    + value + '">' + labels[value] + '</li>');
    };
    // Der Einspeiseebene-Filter wird mit einem Event verknüpft, um die Marker
    // neu zu erzeugen, sobald der Filter geändert wurde.
    $( "#einspeisungsebene ol#selectable" ).selectable({
        stop: function() {
            einspeisungsebeneFilter = new Object();
            $( ".ui-selected", this ).each(function() {
                einspeisungsebeneFilter[$(this).attr('value')] = ( $(this).attr('value') );
            });
            makeMarkers(stammDaten, geoDaten, map, labels);
        }
    });
    
    // Für jede Postleitzahl wir hier ein enstprechendes Filterelement
    // erzeugt.
    for (var value in postleitzahlenAll) {
        $('#plz ol#selectable').append('<li class="ui-widget-content ui-selected">' + value + '</li>');
    };
    // Der Postleitzahlen-Filter wird mit einem Event verknüpft, um die Marker
    // neu zu erzeugen, sobald der Filter geändert wurde.
    $( "#plz ol#selectable" ).selectable({
        stop: function() {
            postleitzahlenFilter = new Object();
            $( ".ui-selected", this ).each(function() {
                postleitzahlenFilter[$(this).html()] = ( $(this).html() );
            });
            makeMarkers(stammDaten, geoDaten, map, labels);
        }
    });
    
    // Für jeden Netzbetreiber wir hier ein enstprechendes Filterelement
    // erzeugt.
    for (var value in netzbetreiberAll) {
        $('#netzbetreiber ol#selectable')
	    .append('<li class="ui-widget-content ui-selected">' + value + '</li>');
    };
    // Der Netzbetreiber-Filter wird mit einem Event verknüpft, um die Marker
    // neu zu erzeugen, sobald der Filter geändert wurde.
    $( "#netzbetreiber ol#selectable" ).selectable({
        stop: function() {
            netzbetreiberFilter = new Object();
            $( ".ui-selected", this ).each(function() {
                netzbetreiberFilter[$(this).html()] = ( $(this).html() );
            });
            makeMarkers(stammDaten, geoDaten, map, labels);
        }
    });
    
});

/*
 * Die Funktion erzeugt eine Map mit Hilfe von Leaflet, dabei werden die
 * Anfangskoordinaten gesetzt (Koordinaten von Leipzig), der Link zu den
 * Kartendate und die Zoom-Einstellung.
 * @param map
 */
function makeMap(map) {
    
    var attr =  new OpenLayers.Control.Attribution();
    var scale = new OpenLayers.Control.ScaleLine({bottomOutUnits: false, 
						  bottomInUnits: false});
    map = new OpenLayers.Map('map', {
        controls: [scale, attr, new OpenLayers.Control.PanZoomBar(), 
		   new OpenLayers.Control.Navigation()]
    });
    attr.div.style.bottom = '5px';
    attr.div.style.right = '7px';
    scale.div.style.bottom = '7px';
    scale.div.style.left = '7px';
    
    var mapnik         = new OpenLayers.Layer.OSM();
    // Transform from WGS 1984
    var fromProjection = new OpenLayers.Projection("EPSG:4326");   
    // to Spherical Mercator Projection
    var toProjection   = new OpenLayers.Projection("EPSG:900913"); 
    var position       = new OpenLayers.LonLat(12.37475113,51.340333333333)
	.transform( fromProjection, toProjection);
    var zoom           = 11; 

    map.addLayer(mapnik);
    map.setCenter(position, zoom );
    
    return map;
}

/**
 * Die Funktion führt eine AJAX-Anfrage aus, welche einen SPARQL-Endpoint mit
 * einem SPARQL-Query anfragt, in diesem Fall werden alle Anlagen mit
 * dazugehörigen Stammdaten abgefragt, das dazugehörige SPARQL-Query wurde in
 * der index.php definiert.
 */
function getStammDaten(stammDaten) {
    
    // Dieser Ajax-Befehl fragt einen SPARQL-Enpoint an. In diesem Fall werden
    // die Anlagen-Stammdaten abgefragt, das dazugehörige SPARQL-Query wurde in
    // index.php definiert.
    $.ajax({
        async:false,
        data: {
            "default-graph-uri": "http://leipzig-data.de/Data/EEG_Stammdaten_2012/",
            "named-graph-uri" : null,
            "format" : "application/sparql-results+json",
            query : stammSparql
        },
        dataType: "json",
        type: "POST",
        url: sparqlEndpoint,
    
        // complete, no errors
        success: function ( res )
        {
            // Stammdaten werden als Return-Wert bereitgelegt
            stammDaten = res;
        },
        
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log (jqXHR);
            console.log (textStatus);
            console.log (errorThrown);
        }
    });
    
    return stammDaten;
}

/**
 * Die Funktion führt eine AJAX-Anfrage aus, welche einen SPARQL-Endpoint mit
 * einem SPARQL-Query anfragt, in diesem Fall werden alle Anlagen mit
 * existierenden Geodaten abgefragt, das dazugehörige SPARQL-Query wurde in
 * der index.php definiert.
 */
function getGeoDaten(geoDaten) {
    
    // Dieser Ajax Befehl fragt einen SPARQL-Enpoint an. In diesem Fall werden
    // die Anlage Stammdaten abgefragt, das dazugehörige SPARQL-Query wurde in
    // index.php definiert.
    $.ajax({
        async:false,
        data: {
            "default-graph-uri": "http://leipzig-data.de/Data/EEG_Stammdaten_2012/",
            "named-graph-uri" : null,
            "format" : "application/sparql-results+json",
            query : geoSparql
        },
        dataType: "json",
        type: "POST",
        url: sparqlEndpoint,
    
        // complete, no errors
        success: function ( res )
        {
            // Stammdaten werden in der geadaten Variable abgelegt
            geoDaten = res;
        },
        
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log (jqXHR);
            console.log (textStatus);
            console.log (errorThrown);
        }
    });
    
    // Neusortierung des Ergebnis-Array, um Geodaten einer bestimmten Anlage
    // mittels URI schnell zu finden.
    resultGeoDaten = new Object();
    $.each(geoDaten.results.bindings, function( index, value ) {
        resultGeoDaten[value.anlage.value] = value;
    });
    
    return resultGeoDaten;
}

/**
 * Die Funktion führt eine AJAX-Anfrage aus, welche einen SPARQL-Endpoint mit
 * einem SPARQL-Query anfragt, in diesem Fall werden die Labels aller
 * Resourcen/Klassen abgefragt, das dazugehörige SPARQL-Query wurde in der
 * index.php definiert.
 */
function getLabels(labels) {
    $.ajax({
        async:false,
        data: {
            "default-graph-uri" : "http://leipzig-data.de/Data/EnergiewendeVokabular/",
            "named-graph-uri" : null,
            "format" : "application/sparql-results+json",
            "query" : labelSparql,
        },
        dataType: "json",
        type: "POST",
        url: sparqlEndpoint,
    
        // complete, no errors
        success: function ( res )
        {
            // Aus dem Ergebnis-Array res wird das Labels-Array labels erzeugt. 
            $.each(res.results.bindings, function( index, value ) {
                labels[value.class.value] = value.label.value;
                // wenn der Triple type die URI der Klasse
                // Einergieträger/Einspeisungsebene ist, wird für diese
                // Klassen-URI das Kabel mit abgelegt.
                if (undefined != value.type && 
		    'http://leipzig-data.de/Data/Model/Energietraeger' == value.type.value) {
                    energietraeger[value.class.value] = value.class.value;
                } 
		else if (undefined != value.type && 
			 'http://leipzig-data.de/Data/Model/Einspeisungsebene' == value.type.value) {
                    einspeisungsebene[value.class.value] = value.class.value;
                }
            });
        },
        
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log (jqXHR);
            console.log (textStatus);
            console.log (errorThrown);
        }
    });
    
    return labels;
}
/*
 * Diese Funktion erzeugt die Marker auf der Karte. Dabei wird beim ersten
 * Aufruf über alle Elemente (Anlagen) iteriert und für jedes Element ein
 * Maker erzeugt, gleichzeitig werden noch die Grenzwerte für die
 * verschiedenen Filter ermittelt. Bei einem wiederholten Aufruf der Funktion
 * wird der Inhalt der Filter geprüft und danach wiederum über alle Elemente
 * (Anlagen) iteriert.  Passt ein Element nicht zu einer Filter-Eigenschaft,
 * so wird für dieses Element kein Maker erzeugt.
 * 
 * @param {Array}   geoDaten    Enthält alle Anlagen und ihre Eigenschaften
 * @param           map         Enthält die Referenz auf die Karte
 * @param {Array}   labels      Enthält alle benötigten Labels (URI => Label)
 */
function makeMarkers(stammDaten, geoDaten, map, labels) {
    //Löschen aller alten Marker
    markersGroup.clearMarkers();
    
    // Setzen des Inbetriebnahmedatum-Filters auf ältestes bzw. aktuelles Datum 
    inbetriebnahmedatumVonFilter = new Date(0);
    inbetriebnahmedatumBisFilter = new Date();
    // Setzen des Leistungsfilters auf größtmögliche Werte
    leistungMinFilter = 0;
    leistungMaxFilter = 1000000;
    // Übernahme des ENR Filter Inhalt in eine Variable
    enrFilter = $('#enr input').val();
    
    // Wird immer ausgeführt außer beim ersten Mal
    if (!firstRun) {
        // Setzen des Inbetriebnahmedatum-Filters. Dazu wird aus den
        // Filter-HTML-Elementen das Datum ermittelt und jeweils um einen Tag
        // nach früher/später korrigiert.
        inbetriebnahmedatumVonFilter = $('#inbetriebnahmedatum #from').datepicker("getDate");
        inbetriebnahmedatumVonFilter.setDate(inbetriebnahmedatumVonFilter.getDate() - 1);
        inbetriebnahmedatumBisFilter = $('#inbetriebnahmedatum #to').datepicker("getDate");
        inbetriebnahmedatumBisFilter.setDate(inbetriebnahmedatumBisFilter.getDate() + 1);
        // Setzen des Leistungsfilters mit Hilfe der Werte aus den
        // Filter-HTML-Elementen.
        leistungMinFilter = $( "#slider-range" ).slider( "values", 0 );
        leistungMaxFilter = $( "#slider-range" ).slider( "values", 1 );
    }
    
    // Iteration über alle Elemente (Anlagen)
    $.each(stammDaten.results.bindings, function( index, value ) {
        
        // Nur Anlagen, zu denen Geodaten existieren, werden angezeigt, alle
        // anderen werden übersprungen.
        if (undefined == geoDaten[value.anlage.value]) {
            return;
        }
        
        // Abspeichern des Inbetriebnahmedatums der Anlage.
        inbetriebnahmedatum = new Date(value.inbetriebnahmedatum.value);
        // Abspeichern der Leistung der Anlage und Rundung auf zwei Dezimalstellen. 
        leistung = Math.round(value.leistung.value * 100) / 100;
        
        // Wird nur beim ersten Durchlauf ausgeführt.
        if (firstRun) {
            // Die Werte der ersten Anlage werden für die Filter Grenzwerte
            // übernommen.
            if (0 == index) {
                inbetriebnahmedatumMin = inbetriebnahmedatum;
                inbetriebnahmedatumMax = inbetriebnahmedatum;
                leistungMin = leistung;
                leistungMax = leistung;
            // Bei allen anderen Anlagen wird geprüft, ob deren Werte die
            // Grenzwerte überschreiten. Ist dies der Fall, so werden jeweils
            // deren Werte als neue Grenzwerte abgelegt.
            } else {
                if (inbetriebnahmedatum < inbetriebnahmedatumMin)
                    inbetriebnahmedatumMin = inbetriebnahmedatum;
                if (inbetriebnahmedatum > inbetriebnahmedatumMax)
                    inbetriebnahmedatumMax = inbetriebnahmedatum;
                if (leistung < leistungMin)
                    leistungMin = leistung;
                if (leistung > leistungMax)
                    leistungMax = leistung;
            }
            
            // Abspeichern der Postleitzahl einer Anlage in einem Array, um so
            // alle vorhandenen Postleitzahlen zu ermitteln.
            postleitzahlenAll[geoDaten[value.anlage.value].postleitzahl.value] 
		= geoDaten[value.anlage.value].postleitzahl.value;
            // Beim ersten Durchlauf sollen keine Postleitzahlen ausgefiltert
            // werden, also ist das Array postleitzahlenFilter gleich dem Array
            // postleitzahlenAll.
            postleitzahlenFilter = postleitzahlenAll;
            
            // Abspeichern des Netzbetreiber einer Anlage in einem Array, um
            // so alle vorhandenen Netzbetreiber zu ermitteln.
            netzbetreiberAll[value.netzbetreiber.value] = value.netzbetreiber.value;
            // Beim ersten Durchlauf sollen keine Netzbetreiber ausgefiltert
            // werden, also ist das Array netzbetreiberFilter gleich dem Array
            // netzbetreiberAll.
            netzbetreiberFilter = netzbetreiberAll;
        }

        // Diese If-Anweisung filtert die Anlagen aus. Sobald eine Eigenschaft
        // nicht den eingestellten Filter-Bedingungen genügt, wird die
        // Schleife unterbrochen und mit dem nächsten Element (Anlage)
        // fortgesetzt.
        if (undefined == energietraegerFilter[value.energietraeger.value]
            || undefined == einspeisungsebeneFilter[value.einspeisungsebene.value]
            || inbetriebnahmedatumVonFilter > inbetriebnahmedatum
            || inbetriebnahmedatumBisFilter < inbetriebnahmedatum
            || leistung < leistungMinFilter
            || leistung > leistungMaxFilter
            || ('' != enrFilter && -1 == value.enr.value.search(enrFilter))
            || undefined == postleitzahlenFilter[geoDaten[value.anlage.value].postleitzahl.value]
            || undefined == netzbetreiberFilter[value.netzbetreiber.value]) {
            return;
        }
        
        // Der HTML Content für das Popup-Menü des Markers wird erzeugt und
        // die Eigenschaften der Anlage eingetragen.
        popupContentHTML = '<div class="markerPopup">'+
	    '<div class="popUpHeadLine">Energieanlage</div>' +
            '<table>' +
            '<tr><td>Uri:</td><td><a href="' + value.anlage.value + '">' 
	    + value.anlage.value.match(/EEGAnlageLeipzig\/.*$/)[0] + '</a></td>' +
            '<tr><td>' + labels['http://leipzig-data.de/Data/Model/hatEinspeisungsebene'] 
	    + ':</td><td>' + labels[value.einspeisungsebene.value] + '</td>' +
            '<tr><td>' + labels['http://leipzig-data.de/Data/Model/hatEnergietraeger'] 
	    + ':</td><td>' + labels[value.energietraeger.value] + '</td>' +
            '<tr><td>' + labels['http://leipzig-data.de/Data/Model/Netzbetreiber'] 
	    + ':</td><td>' + value.netzbetreiber.value + '</td>' +
            '<tr><td>' + labels['http://leipzig-data.de/Data/Model/PLZ'] 
	    + ':</td><td>' + geoDaten[value.anlage.value].postleitzahl.value + '</td>' +
            '<tr><td>' + labels['http://leipzig-data.de/Data/Model/hasENR'] 
	    + ':</td><td>' + value.enr.value + '</td>' +
            '<tr><td>' + labels['http://leipzig-data.de/Data/Model/Inbetriebnahmedatum'] 
	    + ':</td><td>' + inbetriebnahmedatum.getDate() + '.' 
	    + (parseInt(inbetriebnahmedatum.getMonth()) + 1) + '.' 
	    + inbetriebnahmedatum.getFullYear() + '</td>' +
            '<tr><td>' + labels['http://leipzig-data.de/Data/Model/installierteLeistung'] 
	    + ':</td><td>' + leistung + '</td>' +
            '</table>' +
            '</div>';
        
        // Position und Icon Url für den Marker wird erzeugt.

	// Transform from WGS 1984
        fromProjection = new OpenLayers.Projection("EPSG:4326");   
	// to Spherical Mercator Projection
        toProjection   = new OpenLayers.Projection("EPSG:900913"); 
        position       = new OpenLayers.LonLat(geoDaten[value.anlage.value].long.value,
					       geoDaten[value.anlage.value].lat.value)
	    .transform( fromProjection, toProjection);
        iconUrl        = 'js/marker.png';
        
        // Auswahl des Marker Icons je nach Energieträger

	// hgg, 2014-09-25: fixed to local images since the url to
	// http://www.openlayers.org/dev/img/ did no more work

        switch (value.energietraeger.value) {
            case "http://leipzig-data.de/Data/Model/Solar":
                iconUrl = 'js/marker-gold.png'
                break;
            case "http://leipzig-data.de/Data/Model/Biomasse":
                iconUrl = 'js/marker-green.png'
                break;
            case "http://leipzig-data.de/Data/Model/Wasser":
                iconUrl = 'js/marker-blue.png'
                break;
            case "http://leipzig-data.de/Data/Model/Wind":
                iconUrl = 'js/marker-red.png'
                break;
            default:
                iconUrl = 'js/marker.png'
        }
       
        // Marker und Popup wird in einem Feature erzeugt
        makeFeature(position, popupContentHTML, iconUrl)
    });
    // Nach dem ersten Aufruf wird die Variable firstRun auf false gesetzt, um
    // bei weiteren Aufrufen diese Information zu nutzen.
    firstRun = false;
}

/*
 * Diese Funktion erzeugt ein sogenanntes Feature, was sowohl den Marker als
 * auch das Popup-Fenster enthält. Sobald der Marker angeklickt wird, erscheint
 * das Popup-Fenster.
 * 
 * @param   position            Positionsangabe für den Marker
 * @param   popupContentHTML    HTML Content des Popup
 * @param   iconType            Icon URL
 */
function makeFeature(position, popupContentHTML, iconType) {
    var size = new OpenLayers.Size(21,25);
    var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
    var feature = new OpenLayers.Feature(markersGroup, position);
    feature.closeBox = true;
    feature.popupClass = OpenLayers.Popup.FramedCloud;
    feature.data.popupContentHTML = popupContentHTML;
    feature.data.icon = new OpenLayers.Icon(iconType, size, offset);
    feature.layer.div.style.cursor = 'pointer';
    var marker = feature.createMarker();
    var markerClick = function (evt) {
            if (this.popup == null) {
                this.popup = this.createPopup(this.closeBox);
                map.addPopup(this.popup);
                this.popup.show();
            } else {
                this.popup.toggle();
            }
            currentPopup = this.popup;
            OpenLayers.Event.stop(evt);
        };
    marker.events.register("mousedown", feature, markerClick);
    markersGroup.addMarker(marker);
}

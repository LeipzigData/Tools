	<html>
<head>
    <title>ZAK</title>
    <!-- importing Data -->
	<link href="../../data.json" type="application/json" rel="exhibit/data" />
	<!-- importing Exhibit Main -->
    <script src="http://api.simile-widgets.org/exhibit/2.2.0/exhibit-api.js" type="text/javascript"></script>
	<!-- importing Date Picker -->
    <script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/time/time-extension.js" type="text/javascript"></script>
	<!-- importing Calendar View -->
	<script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/calendar/calendar-extension.js"></script>
	<!-- importing Map View -->
	<script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/map/map-extension.js?gmapkey=<?php include('gmaps_api_key.php');echo API_KEY;?>"></script>
	<!-- <script src="copyright.js" type="text/javascript"></script> -->
	<link rel='stylesheet' href='styles.css' type='text/css' />
</head> 
<body><!-- ex:exhibitLogoColor="LimeGreen"> -->

<div ex:role="collection" id="CalendarEvents" ex:itemTypes="Event"></div>
<div ex:role="collection" id="Bundles" ex:itemTypes="Bundle"></div>
<div ex:role="collection" id="Bundles" ex:itemTypes="item"></div>
<div ex:role="collection" id="Adressen" ex:itemTypes="Adresse"></div>
<div id="body">
    <div style="width: 100%">
        <table cellpadding="0" cellspacing="10" border="0" id="exhibit" width="100%">
            <tr>
                <td style="width:250px">
                    <b>Suche</b>
                    <div ex:role="facet" ex:facetClass="TextSearch" ex:collectionID="CalendarEvents"></div>
                    <hr/>
					<div ex:role="facet" ex:facetLabel="Tag Cloud Events"
						 ex:facetClass="Cloud" ex:expression=".hasTag" ex:collectionID="CalendarEvents" ex:showMissing="false" ex:collectionID="CalendarEvents">
					</div>
                </td>

                <td>
					<div ex:role="viewPanel">
						<div ex:role="lens" ex:itemTypes="Event" ex:onshow="prepareLens(this);" ex:formats="date { mode: short; show: date-time; template: 'dd.MM.yyyy HH:mm' }">
							<div class="exhibit-lens-title"><span ex:content=".label"></span> <span ex:control="item-link"></span></div>
							<div class="exhibit-lens-body">
								<table  class="exhibit-lens-properties">
									<tbody>
										<tr class="exhibit-lens-property" ex:if-exists=".label">
											<td class="exhibit-lens-property-name">Bezeichnung: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".label"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".untertitel">
											<td class="exhibit-lens-property-name">Untertitel: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".untertitel"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".description">
											<td class="exhibit-lens-property-name">Beschreibung: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".description"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".dtstart">
											<td class="exhibit-lens-property-name">Beginn: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".dtstart"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".dtend">
											<td class="exhibit-lens-property-name">Ende: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".dtend"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".location">
											<td class="exhibit-lens-property-name">Ort: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".location"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".OrtZusatz">
											<td class="exhibit-lens-property-name">Ortszusatz: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".Ortzusatz"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".organizer">
											<td class="exhibit-lens-property-name">Organisator: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".organizer"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".zurReihe">
											<td class="exhibit-lens-property-name">zur Reihe: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".zurReihe"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".Kosten">
											<td class="exhibit-lens-property-name">Kosten: </td>                 <!-- deprecated -->
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".Kosten"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".contactPerson">
											<td class="exhibit-lens-property-name">Kontakt-Person: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".contactPerson"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".hasTag">
											<td class="exhibit-lens-property-name">Schlagwort: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".hasTag"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".hasURL">
											<td class="exhibit-lens-property-name">weitere Informationen unter: </td>
											<td class="exhibit-lens-property-values"><span class="exhibit-value" ex:content=".hasURL"></span></td>
										</tr>
										<tr class="exhibit-lens-property" ex:if-exists=".hasUW_id">
											<td class="exhibit-lens-property-name">weitere Informationen unter: </td>
											<td class="exhibit-lens-property-values"><a ex:href-content="concat('http://www.umweltbildungsportal.de/homepagekalender/uport_eventdetail.php?master_id=', .hasUW_id)" target="_blank">Link zur Umweltbibliothek</a></span></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
                        <div role="view" 
                            ex:viewClass="Thumbnail"
							ex:collectionID="CalendarEvents"
                            ex:showAll="true"
							ex:label="Events"
                            ex:possibleOrders=".organizer, .location, .dtstart, .label ">
							
							<table ex:role="lens" ex:formats="date { mode: short; show: date-time; template: 'dd.MM.yyyy HH:mm' }" class="itemThumbnail" style="display: none;">
                                <tr>
                                    <td class="itemThumbnail-caption"><span ex:content="value" /></td>
                                </tr>
                            </table>
                        </div>
						<div role="view" ex:label="Kategorien "ex:possibleOrders=".type, .organizer, .dtstart, .location, .label"></div>
                        <div ex:role="view" 
                            ex:viewClass="Timeline"
							ex:collectionID="CalendarEvents"
                            ex:start=".dtstart"
                            ex:colorKey=".label"
                            ex:topBandUnit="month"
                            ex:topBandPixelsPerUnit="90"
                            ex:bottomBandUnit="week"
                            ex:bottomBandPixelsPerUnit="50"
                            ex:bubbleWidth="400"
                            ex:bubbleHeight="250">
                        </div>
						   <div ex:role="view"
							   ex:viewClass="Map"
							   ex:collectionID="CalendarEvents"
							   ex:proxy=".location.hasAddress"
							   ex:scaleControl = "true"
							   ex:lat = ".lat"
							   ex:lng = ".long"
							   ex:marker=".organizer.label"
							   ex:zoom="12"
							   ex:center="51.340049, 12.371189">
						   </div>
						<div ex:role="view" 
							ex:viewClass="Calendar"
							ex:collectionID="CalendarEvents"
							ex:label="Kalender"
							ex:start=".dtstart"
							ex:end=".dtstart"
							ex:eventLabel=".label"
							ex:formats="date { mode: short; show: date-time; template: 'MM/dd/yyyy' } item { title: expression(.title) }">
						</div>
                    </div>
                </td>
                <td style="width:250px">
					<div id="event_date" 
						class="facet" 
						ex:role="facet" 
						ex:beginDate=".dtstart" 
						ex:endDate=".dtstart" 
						ex:facetLabel="Veranstaltungszeitraum auswählen" 
						ex:facetClass="DatePicker" 
						ex:collapsible="true"
						ex:collectionID="CalendarEvents">
					</div>
                    <div ex:role="facet" ex:facetLabel="Veranstaltungsort" ex:expression=".location"  ex:height="15em" ex:collectionID="CalendarEvents"></div>
					
					<div ex:role="facet"
						ex:facetLabel="Kategorien"
						ex:facetClass="Exhibit.HierarchicalFacet"
						ex:expression=".type"
						ex:uniformGrouping=".subtopicOf">
					</div>
				
				</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>

# Erzeugung von RDF-Daten aus der API "Nachhaltiges Leipzig"

## Grundsätzliche Struktur des Verzeichnisses

In diesem Verzeichnis sind verschiedene PHP-Transformationsroutinen
zusammengestellt, die über die verfügbare REST-API (siehe die Beschreibung in
der Datei *helper.php*) die Instanzen der Klassen *org:Organization* (Akteure),
*foaf:Person* und *org:Membership* (Person, Rolle dieser Person beim Akteur)
aus users.json und *nl:Activity* (Aktivitäten) aus activities.json mit URIs im
Namensraum-Präfix <http://nachhaltiges-leipzig.de/Data/> erzeugen und in
verschiedenen RDF-Graphen zusammenfassen.

Die entsprechenden Transformationen werden von den Scripten `activities.php`,
und `akteure.php` (Dump unter Daten/NL-Akteure.ttl) und `personen.php` (Dump
unter Daten/NL-Personen.ttl) ausgeführt und durch die gemeinsame Datei
`helper.php` unterstützt, in der vor allem verschiedenen Routinen zum
Adjustieren von Strings sowie zum Erstellen von Einträgen zusammengefasst sind,
die immer wieder benötigt werden.

Die weiteren Scripte sind obsolet.

Nicht aktuell: Die Dateien `main.php` und `index.php` können verwendet werden,
um die Transformationen auszuführen, wobei `index.php` das Ergebnis auf einer
Webseite anzeigt, `main.php` dagegen die Transformationen als Turtle-Dateien in
das Unterverzeichnis `Daten` schreibt (Aufruf `php main.php` von der
Kommandozeile aus).  `getdata.php` stellt diese Funktionalität als einfachen
Webservice zur Verfügung der etwa als `getdata.php?show=akteure` aufgerufen
werden kann.

## Namensschemata für lokale URIs

Lokale URIs werden direkt aus den Primärschlüsseln (der Id) des entsprechenden
Datensatzes erzeugt. Diese haben (bis auf Personen, deren Daten dem
Namensschema von leipzig-data.de folgen, die Informationen werden auch
Datenschutzgründen nur intern verwendet) grundsätzlich die Struktur
`<Präfix>/<Typ>.<Id>`.

Dabei werden die Namensraumpräfixe

-  nl: <http://nachhaltiges-leipzig.de/Data/Model#> 
-  ld: <http://leipzig-data.de/Data/Model/> 

für Datenstrukturen verwendet, die entweder spezifisch für
`nachhaltiges-leipzig.de` oder für `leipzig-data.de` sind, sowie weitere
verbreitete Ontologien wie

-  dct: <http://purl.org/dc/terms/>
-  foaf: <http://xmlns.com/foaf/0.1/> 
-  gsp: <http://www.opengis.net/ont/geosparql#> 
-  ical: <http://www.w3.org/2002/12/cal/ical#>
-  org: <http://www.w3.org/ns/org#>

eingesetzt.

## Datenmodell und dessen Transformation

*activities* ist ein Obertyp zu verschiedenen Arten von Aktivitäten (Aktionen,
Events, Projekte, Services, Stores), die mit dem Prädikat *nl:hasType* näher
spezifiziert werden.

In der Collection *users* (Akteure) sind Informationen über Akteure
zusammengefasst, wobei nicht zwischen den juristischen Personen und den für
diese agierenden personellen Verantwortlichen unterschieden wird. Das wir im
Transformationsprozess über das Konzept org:Membership getrennt und über die
RDF-Klassen nl:Akteur und foaf:Person auch in verschiedenen RDF-Graphen
erfasst.

Prädikate in users.json:

* id => String
* name => String
* organization_type => String
* organization_url => String
* organization_logo_url => String
* full_address => String
* district => String
* latlng => Array
* first_name => String
* last_name => String
* organization_position => String
* email => String
* phone_primary => String
* phone_secondary => String

In der Collection *activities* (Aktivitäten) sind Informationen über die
verschiedenen Typen von Aktivitäten zusammengefasst.

Prädikate in activities.json:

* id => String
* type => String  (Typ der Aktivität)
* user_id => String (Id des beteiligten Akteurs)
* name => String
* latlng => Array
* description => String
* district => String
* full_address => String
* is_fallback_address => String
* info_url => String
* video_url => String
* image_url => String
* start_at => String
* end_at => String
* target_group => String
* costs => String
* requirements => String
* speaker => String
* categories => Array
* first_root_category => String
* short_description => String
* goals => Array
* property_list => Array
* service_type => String
* target_group_selection => String
* duration => String
* products => Array
* trade_categories => Array
* trade_types => Array

Transformationen:

* full_address => String - Verwandlung in ld:proposedAddress im Datenmodell von
  leipzig-data.de

* latlng => Array - Verwandlung in gsp:asWKT "Point(lng lat)" 

Jede Instanz wird über eine ID referenziert.

Die weiteren Informationen beziehen sich auf frühere Untersuchungen, die direkt
auf der datenbank ausgeführt wurden.

Über die Tabelle *activities* werden *[id user_id item_id item_type]* mit
*item_type* in *[Projekt, Action, Service, Store, Event]* zugeordnet. *id* ist
eine eigene ID der activity, *item_id* verweist auf die ID in der Tabelle des
jeweiligen *item_type*; eine *item_id* kann also mehrfach auftreten.

*categories* repräsentiert eine baumartige Struktur verschiedener Tags, die
einzelnen Aktivitäten über die Tabelle *activity_categories* zugewiesen sind
als Quadrupel *[id activity_id activity_type category_id]*.

*goals* repräsentiert eine geordnete Liste verschiedener Tags, die einzelnen
Aktivitäten über die Tabelle *activity_goals* zugewiesen sind als Quadrupel
*[id activity_id activity_type goal_id]*.

*products* repräsentiert eine Liste verschiedener Produktkategorien, die
einzelnen Stores über die Tabelle *products_stores* zugewiesen sind als Paare
*[product_id store_id]*.

*trade_types* und *trade_categories* repräsentieren zwei geordnete Listen
verschiedener Tags, die einzelnen Akteuren über die Tabellen
*trade_categories_users* und *trade_types_users* zugewiesen sind jeweils als
Tripel *[id trade_id user_id]*.


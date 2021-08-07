# Erzeugung von RDF-Daten aus den APIs der verschiedenen Projekte

## Grundsätzliche Struktur des Verzeichnisses

In diesem Verzeichnis sind verschiedene PHP-Transformationsroutinen
zusammengestellt, die über die verfügbare REST-API (siehe die Beschreibung in
der Datei *helper.php*) die Instanzen der Klassen *org:Organization*
(Akteure), *foaf:Person* und *org:Membership* (Person, Rolle dieser Person
beim Akteur) aus users.json sowie *nl:Activity* (Aktivitäten) und die
Unterklassen **nl:Event**, **nl:Action**, **nl:Project**, **nl:Service**,
**nl:Store** aus activities.json mit URIs im Namensraum-Präfix
<http://nachhaltiges-leipzig.de/Data/> erzeugen und in verschiedenen
RDF-Graphen zusammenfassen.

Die entsprechenden Transformationen werden von den Scripten `activities.php`,
`akteure.php` und `personen.php` ausgeführt und durch die gemeinsame Datei
`helper.php` unterstützt, in der vor allem verschiedene Routinen zum
Adjustieren von Strings sowie zum Erstellen von Einträgen zusammengefasst
sind, die immer wieder benötigt werden. `test.php` enthält einige Routinen zur
Analyse der json-Dateien, die von der REST-API zurückgegeben werden.

Die Dateien `main.php` und `index.php` können verwendet werden, um die
Transformationen auszuführen, wobei `index.php` das Ergebnis auf einer
Webseite anzeigt, `main.php` dagegen die Transformationen als Turtle-Dateien
in das Verzeichnis `../Daten` schreibt (Aufruf `php main.php` von der
Kommandozeile aus).  `getdata.php` stellt diese Funktionalität als einfachen
Webservice zur Verfügung, der etwa als `getdata.php?show=akteure` auch direkt
aufgerufen werden kann.

## Namensschemata für lokale URIs

Lokale URIs werden direkt aus den Primärschlüsseln (der Id) des entsprechenden
Datensatzes erzeugt. Diese haben (bis auf Personen, deren Daten dem
Namensschema von leipzig-data.de folgen, die Informationen werden auch
Datenschutzgründen nur intern verwendet) grundsätzlich die Struktur
`<Präfix>/<Typ>.<Id>`, wobei <Typ> \in {Person, Akteur, Activity} gilt.

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

## Datenmodell und dessen Transformation. Die Grundklassen.

*activities* ist ein Obertyp zu verschiedenen Arten von Aktivitäten (Aktionen,
Events, Projekte, Services, Stores), die mit dem Prädikat *nl:hasType* näher
spezifiziert werden. *activities.php* stellt Routinen für gesonderte Dumps der
einzelnen Typen zur Verfügung.

In der Collection *users* (Akteure) sind Informationen über Akteure
zusammengefasst, wobei nicht zwischen den juristischen Personen und den für
diese agierenden personellen Verantwortlichen unterschieden wird. Das wir im
Transformationsprozess über das Konzept org:Membership getrennt und über die
RDF-Klassen nl:Akteur und foaf:Person auch in verschiedenen RDF-Graphen
erfasst.  *akteure.php* stellt Routinen für gesonderte Dumps der Akteure und
der Personen zur Verfügung.

Genauere Informationen zu den Prädikaten der einzelnen Datentypen sind unter
`../Dokumente/Betreiberkonzept.tex` zu finden.

Transformationen:

* full_address => String - Verwandlung in ld:proposedAddress im Datenmodell von
  leipzig-data.de

* latlng => Array - Verwandlung in gsp:asWKT "Point(lng lat)" 

Jede Instanz wird über eine ID referenziert.

## Datenmodell und dessen Transformation. Weitere Klassen.

Die folgenden Teile der Modellierung sind noch wenig ausgearbeitet und
enthalten oft nur wenige Instanzen pro Klasse. Die entsprechenden JSON-Dateien
sind zu Referenzzwecken im Verzeichnis ../Daten gespeichert.

*categories* repräsentiert eine baumartige Struktur verschiedener Tags, die
einzelnen Aktivitäten zugewiesen sind.

* id => String
* name => String
* depth => String
* parent_id => String
* children => Array
* goal_cloud => Array

*goals* repräsentiert eine geordnete Liste verschiedener Tags, die einzelnen
Aktivitäten zugewiesen sind.

*products* repräsentiert eine Liste verschiedener Produktkategorien, die
einzelnen Stores zugewiesen sind.

* id => String
* name => String

*trade_types* und *trade_categories* repräsentieren zwei geordnete Listen
verschiedener Tags, die einzelnen Akteuren über die Tabellen
*trade_categories_users* und *trade_types_users* zugewiesen sind.

* id => String
* name => String

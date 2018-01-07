# Erzeugung von RDF-Daten aus der Datenbank "Nachhaltiges Leipzig"

## Installation

* Kopie eines DB-Dumps von leipziger-ecken.de in eine Datenbank laden, 
* die Datei *inc_sample.php* nach *inc.php* kopieren und dort die
  DB-Credentials dieser Datenbank eintragen,
* ggf. einen PHP-fähigen Webserver auf localhost: starten 
* und die Seite *index.php* aufrufen.

Anmerkung: In *inc.php* ist die Funktion db_query($query) definiert.  Eine
vergleichbare Funktion greift in den meisten CMS auf die Datenbank zu, so dass
es einfach sein sollte, diese Installation lokal anzupassen.

## Grundsätzliche Struktur des Verzeichnisses

In diesem Verzeichnis sind verschiedene php Transformationsroutinen
zusammengestellt, die direkt auf die Datenbank zugreifen und die Instanzen der
Klassen *nl:Adresse* (Adressen), *foaf:Person* (Akteur), *nl:Aktion*
(Aktionen), *nl:Event* (Events), *nl:Projekt* (Projekte),*nl:Service*
(Services), *nl:Store* (Stores) in verschiedenen RDF-Graphen erzeugen.

Die entsprechenden Transformationen werden von den Scripts `actions.php`,
`adressen.php`, `akteure.php`, `events.php`, `projects.php`, `services.php` und
`stores.php` ausgeführt, die durch die gemeinsame Datei `helper.php`
unterstützt werden, in der vor allem verschiedenen Routinen zum Adjustieren von
Strings sowie zum Erstellen von Einträgen in einer Turtle-Datei zusammengefasst
sind, die immer wieder benötigt werden.

Generelles Vorgehen: über Select-Anfragen an die Datenbank werden die
relevanten Information ausgelesen und dann datensatzweise über eine oder
mehrere Methoden in das RDF-Zielformat transformiert.  Fremdschlüssel werden
dabei in URIs der entsprechenden Klassen verwandelt und so dieselbe Verbindung
über RDF-Mittel hergestellt.

Die Dateien `main.php` und `index.php` können verwendet werden, um die
Transformationen auszuführen, wobei `index.php` das Ergebnis auf einer Webseite
anzeigt, `main.php` dagegen die Transformationen als Turtle-Dateien in das
Unterverzeichnis `Daten` schreibt (Aufruf `php main.php` von der Kommandozeile
aus).  `getdata.php` stellt diese Funktionalität als einfachen Webservice zur
Verfügung der etwa als `getdata.php?show=akteure` aufgerufen werden kann.

## Namensschemata für lokale URIs

Lokale URIs werden direkt aus den Primärschlüsseln (der Id) des entsprechenden
Datensatzes erzeugt. Diese haben grundsätzlich die Struktur
`<Präfix>/<Typ>/X<Id>`, wobei X aus technischen Gründen ein Buchstabe ist.

Dabei werden die Präfixe

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

Das ist weiter auszuführen. 
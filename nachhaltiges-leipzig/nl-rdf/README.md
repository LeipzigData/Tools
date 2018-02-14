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
Klassen *org:Organization*, *foaf:Person* und *org:Membership* (Akteur, Person,
Rolle dieser Person beim Akteur), *nl:Aktion* (Aktionen), *nl:Event* (Events),
*nl:Projekt* (Projekte),*nl:Service* (Services), *nl:Store* (Stores) mit URIs
im Namensraum-Präfix <http://nachhaltiges-leipzig.de/Data/> erzeugen und in
verschiedenen RDF-Graphen zusammenfassen.

Die entsprechenden Transformationen werden von den Scripts `actions.php`,
`akteure.php`, `events.php`, `projects.php`, `services.php` und `stores.php`
ausgeführt, die durch die gemeinsame Datei `helper.php` unterstützt werden, in
der vor allem verschiedenen Routinen zum Adjustieren von Strings sowie zum
Erstellen von Einträgen zusammengefasst sind, die immer wieder benötigt werden.

`ld-adressen.php` und `ld-akteure.php` erzeugen aus relevanten Daten Instanzen
mit URIs aus dem Namensraum <http://leipzig-data.de/Data/>, die nach
entsprechender Qualitätskontrolle in Leipzig Data integriert werden können.

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

Die Tabellen *actions* (Aktionen), *events* (Events), *projects* (Projekte),
*services* (Services), *stores* (Stores), *users* (Akteure) enthalten die
Detaildaten verschiedener Aktivitäts-Klassen. Jede Instanz wird über eine ID
referenziert.

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

Einheitliche Ortsprädikate

- *address* : Straße und Hausnummer - gelegentlich auch ohne Hausnummer, wenn
  Treffpunkt statt Adresse
- *zip* : Postleitzahl
- *location* : Ort
- *latitude* : Geokoordinate
- longitude : Geokoordinate

sind in den Tabellen *users*, *actions*, *events*, *projects*, *services* und
*stores* enthalten.  Aus diesen wird eine *ld:Adresse* erzeugt und im aktuellen
Datensatz als *ld:proposedAddress* hinterlegt.  Dies kann dann gegen die bei
Leipzig Data hinterlegten Adressen geprüft werden.  Gleichzeitig wird mit dem
Skript `ld-adressen.php` eine Turtle-Datei mit Adressen im LD-Format erzeugt,
mit denen die LD-Adressen nach einer entsprechenden Qualitätssicherung von Zeit
zu Zeit angereichert werden.


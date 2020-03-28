# Erzeugung von RDF-Daten aus der Datenbank "Leipziger Ecken"

## Installation

* Kopie eines DB-Dumps von leipziger-ecken.de in eine Datenbank laden, 
* die Datei *inc_sample.php* nach *inc.php* kopieren und dort die
  DB-Credentials dieser Datenbank eintragen,
* ggf. einen PHP-fähigen Webserver auf localhost: starten 
* und die Seite *index.php* aufrufen. 

Anmerkung: In *inc.php* ist die Funktion db_query($query) definiert.  Eine
Funktion gleichen Namens greift in Drupal auf die Datenbank zu, so dass es
einfach sein sollte, diese Installation in ein Drupal-Modul zu verwandeln.

Eine mglw. nicht aktuelle Version dieser Webservices ist auf der
Produktivinstanz leipziger-ecken.de/Data ausgerollt.

## Anmerkungen

HGG 2017-11-12: "composer" ist aktuell nicht mehr erforderlich, da die
Anhängigkeiten von EasyRDF eliminiert wurden. Damit wird allerdings bei der
Ausgabe die jeweilige Information auch nicht mehr mittels EasyRDF im
Turtle-Format normalisiert. Das muss auf dem Weg der Weiterverarbeitung
geschehen.

## Grundsätzliche Struktur des Verzeichnisses

In diesem Verzeichnis sind verschiedene php Transformationsroutinen
zusammengestellt, die direkt auf die Datenbank zugreifen und die Instanzen der
Klassen *le:Akteur*, *org:Membership*, *le:Ort*, *le:Adresse*, *le:Event* und
*le:Sparte* in verschiedenen RDF-Graphen erzeugen.

Die entsprechenden Transformationen werden von den Scripts `adressen.php`,
`akteure.php`, `events.php` und `sparten.php` ausgeführt, die durch die
gemeinsame Datei `helper.php` unterstützt werden, in der vor allem
verschiedenen Routinen zum Adjustieren von Strings sowie zum Erstellen von
Einträgen in einer Turtle-Datei zusammengefasst sind, die immer wieder benötigt
werden.

Generelles Vorgehen: über Select-Anfragen an die Datenbank werden die
relevanten Information ausgelesen und dann datensatzweise über eine oder
mehrere Methoden in das RDF-Zielformat transformiert.  Fremdschlüssel werden
dabei in URIs der entsprechenden Klassen verwandelt und so dieselbe Verbindung
über RDF-Mittel hergestellt.

Die Datei `index.php` zeigt das Ergebnis auf einer Webseite an.  `getdata.php`
stellt diese Funktionalität als einfachen Webservice zur Verfügung, der auch
direkt etwa als `getdata.php?show=akteure` aufgerufen werden kann.

## Namensschemata für lokale URIs

Lokale URIs werden direkt aus den Primärschlüsseln (der Id) des entsprechenden
Datensatzes erzeugt. Diese haben grundsätzlich die Struktur
`<Präfix>/<Typ>.<Id>`.

Dabei werden die Präfixe

-  le: <http://leipziger-ecken.de/Data/Model#>
-  ld: <http://leipzig-data.de/Data/Model/> 

für Datenstrukturen verwendet, die entweder spezifisch für `leipziger-ecken.de`
oder für `leipzig-data.de` sind, sowie weitere verbreitete Ontologien wie

-  dct: <http://purl.org/dc/terms/>
-  foaf: <http://xmlns.com/foaf/0.1/> 
-  gsp: <http://www.opengis.net/ont/geosparql#> 
-  ical: <http://www.w3.org/2002/12/cal/ical#>
-  org: <http://www.w3.org/ns/org#>

eingesetzt.

## Datenmodell und dessen Transformation

### Allgemeines

Verweise auf Personen in Feldern wie *creator* oder Tabellen wie
aae_data_akteur_hat_user werden z.B. als
``` 
org:hasMember <http://leipziger-ecken.de/Data/Person.13> .
``` 
dargestellt, können aber nicht weiter aufgelöst werden, da die Schlüssel in
eine User-Tabelle verweisen, die nicht mit im Daten-Dump enthalten ist.  Hier
wäre es sinnvoll, diese Angaben als foaf:Person zu extrahieren und damit die
exportierten RDF-Daten zu ergänzen.

### le:Adresse 

Besteht aus plz, strasse, nr, adresszusatz, bezirk, gps

Entspricht damit nicht ganz dem Konzept *ld:Adresse*; dort charakterisiert der
Adresszusatz die Lage eines *ld:Ort* innerhalb des Gebäudekomplexes, der unter
der gegebenen Adresse zu finden ist. gps=(long,lat) ist ein Aggregat, das
einfach in ein *gsp:asWKT* transformiert werden kann.  Die Geodaten der
Plattform sind mit Vorsicht zu genießen.

**Transformation:** *bezirk* und *adresszusatz* werden nicht extrahiert, der
Rest gegen *ld:Adresse* normalisiert. Es werden überhaupt nur Adressen
extrahiert, die bei Akteuren oder Events verwendet werden. Dazu wird aus den
Einzelteilen eine *le:proposedAddress* generiert, die als Basis für die weitere
Kuratierung dient.

`gsp:asWKT "Point(long lat)"` wird gegenüber der getrennten Verwendung von
`lat` und `long` der Vorzug gegeben, um Geokoordinaten als Datenaggregat zu
behandeln und damit Geodaten aus verschiedenen Quellen für dieselbe Adresse
vergleichen zu können.

### le:Akteur 

Mischung aus *ld:Ort* und *org:Organization* (als Oberklasse verschiedener
Arten juristischer Personen in LD), auch noch zwei Felder *ansprechpartner* und
*funktion*, die zusammen ein *org:Membership* beschreiben.

**Transformation:** Aus jedem Eintrag werden Einträge *le:Akteur* (juristische
Person), *le:Ort* (entspricht *ld:Ort*) und *org:Membership* extrahiert.
Zuordnungen erfolgen nach diesem Muster:

* le:Ort ld:hasSupplier le:Akteur 
* org:Membership org:organization le:Akteur

*le:Akteur* als juristische Person und Träger einer Einrichtung ist in
LeipzigData als Unterklassen von *org:Organization* modelliert und inzwischen
auf mehrere RDF-Graphen aufgeteilt:

* Buergervereine.ttl 
* Hochschulen.ttl
* KirchlicheEinrichtungen.ttl
* OeffentlicheEinrichtungen.ttl
* Stadtverwaltung.ttl
* Unternehmen.ttl
* Vereine.ttl

### le:Event

Die Modellierung folgt der von *ld:Event*. In der neuen LE-Version sind für
Events nur noch Start- und Endzeit gegeben, die komplexeren Möglichkeiten von
regelmäßig stattfindenden Events wird aktuell -- wie in ld:Event -- nicht
unterstützt.  Filtere die Events mit ersteller=0 raus. 

Unterschiede zu ld:Event:

* *ical:location* verweist nicht auf einen *ld:Ort*, sondern auf eine
  *le:Adresse*.
* *ical:creator* verweist wieder auf eine Person in der nicht zugänglichen
  Personentabelle.
* Über *le:hatAkteur* ist einem Event teilweise ein Akteur zugeordnet.
* Über *le:zurSparte* sind einem Event Schlagworte zugeordnet.

### le:Sparte 

Nicht konsolidierte Menge von 95 (Stand 02/2016) Schlüsselwörtern, die Akteuren
oder Event zugeordnet werden können.  In *Sparten.ttl* sind die URIs aus der
Tabelle aae_data_sparte erzeugt. 

Die Einträge in den Tabellen aae_data_akteur_hat_sparte und
aae_data_event_hat_sparte sind dem jeweiligen *le:Ort* bzw. *le:Event*
zugeordnet.

Die aktuelle Liste der Sparten ist sehr redundant, das müsste aufgeräumt
werden.

### le:Bezirk 

71 Einträge, entsprechen *ld:Ortsteil*, in Klammern dazu jeweils
*ld:Stadtbezirk*, die über *ld:Adresse* rekonstruiert werden können.

## Alignment mit Leipzig Data

Siehe dazu das Verzeichnis ../Daten und die dortige README.md.

# Erzeugung von RDF-Daten aus der Datenbank "Leipziger Ecken"

## Installation

* Laden Sie eine Kopie eines DB-Dumps von leipziger-ecken.de in eine Datenbank, 
* kopieren Sie die Datei inc_sample.php nach inc.php und tragen dort die
  DB-Credentials dieser Datenbank ein,
* installieren Sie das PHP-Projekt mit `composer update`,
* starten Sie ggf. einen PHP-fähigen Webserver auf localhost: 
* und rufen Sie nun die Seite `index.php` auf. 

## Grundsätzliche Struktur des Verzeichnisses

In diesem Verzeichnis sind verschiedene php Transformationsroutinen
zusammengestellt, die direkt auf die Datenbank zugreifen und die Instanzen der
Klassen *Akteur*, *Adresse*, *Event* und *Sparte* jeweils in einen RDF-Graphen
transformieren.

Die entsprechenden Transformationen werden von den Scripts `adressen.php`,
`akteure.php`, `events.php` und `sparten.php` ausgeführt, die durch die
gemeinsame Datei `helper.php` unterstützt werden, in der vor allem
verschiedenen Routinen zum Adjustieren von Strings sowie zum Erstellen von
Einträgen in einer Turtle-Datei zusammengefasst sind, die immer wieder
benötigt werden.

Allgemein wird über eine Select-Anfrage an die Datenbank die relevante
Information ausgelesen und dann datensatzweise über eine oder mehrere Methoden
in das RDF-Zielformat transformiert.  Fremdschlüssel werden dabei in URIs der
entsprechenden Klassen verwandelt und so dieselbe Verbindung über RDF-Mittel
hergestellt. 

Die Dateien `main.php` und `index.php` können verwendet werden, um die
Transformationen auszuführen, wobei `index.php` das Ergebnis auf einer
Webseite anzeigt, `main.php` dagegen die Transformationen als Turtle-Dateien
in das Unterverzeichnis `Daten` schreibt (Aufruf `php main.php` von der
Kommandozeile aus möglich).  Bei der Ausgabe wird dabei die jeweilige
Information über eine RDF-Graph-Formatisierung mittels EasyRDF im
Turtle-Format normalisiert.

Im Unterverzeichnis Daten befinden sich verschiedene Dateien `*-checked.ttl`,
die manuell nacheditiert wurden. 

## Namensschema für lokale URIs

Lokale URIs werden direkt aus den Primärschlüsseln (der Id) des entsprechenden
Datensatzes erzeugt. Diese haben grundsätzlich die Struktur
`<Präfix>/<Typ>/X<Id>`, wobei X aus technischen Gründen ein Buchstabe ist.

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

Die entsprechenden Typen werden wie folgt abgebildet: 

## Transformation der einzelnen Klassen

### Adressen auf le:Adresse

`rdfs:label` und Geokoordinaten als `gsp:asWKT` werden extrahiert sowie aus
den Daten ein Vorschlag für eine *LeipzigData Adressen-URI* generiert, der als
`ld:hasAddress` vermerkt ist.

`gsp:asWKT "Point(long lat)"` wird gegenüber der getrennten Verwendung von
`lat` und `long` der Vorzug gegeben, um Geokoordinaten aus verschiedenen
Quellen für dieselbe Adresse vergleichen zu können.

Die genaue semantische Bedeutung von *Adresse* unterscheidet sich, da
LD-Adressen konsequent Postadressen sind, LE-Adressen teilweise durch Zusätze
innerhalb einer LeipzigData-Adresse weiter unterteilt werden.

Es werden nur diejenigen Adressen aus der Datenbank extrahiert, die bei einem
Akteur oder Event auch tatsächlich als Adresse vorkommen.

Ein Abgleich mit den *LeipzigData Adressen* ist offen. 

### Akteure auf le:Akteur und org:Organization

`le:Akteur` ist in der Stadtteilplattform eine juristische Person als Träger
einer Einrichtung.  In LeipzigData sind derartige juristische Personen als
Unterklassen von `org:Organization` modelliert und inzwischen auf mehrere
RDF-Graphen aufgeteilt:
* Buergervereine.ttl 
* KirchlicheEinrichtungen.ttl
* OeffentlicheEinrichtungen.ttl
* StadtLeipzig.ttl
* UniversitaetLeipzig.ttl
* Unternehmen.ttl
* Vereine.ttl

Der Verweis etwa von `dct:creator` auf eine Person kann nicht weiter aufgelöst
werden, da die Fremdschlüssel in eine User-Tabelle verweisen, die nicht mit im
Daten-Dump enthalten ist, der bisher zur Auswertung in eine lokale Datenbank
geladen wurde.

Die Übernahme nach LeipzigData ist offen. 

### Events auf le:Event

Die Modellierung folgt der von `ld:Event`. In der neuen LE-Version sind für
Events nur noch Start- und Endzeit gegeben, die komplexeren Möglichkeiten von
regelmäßig stattfindenden Events wird aktuell -- wie in ld:Event -- nicht
unterstützt.  

Unterschiede zu ld:Event:
* `ical:location` verweist nicht auf einen `ld:Ort`, sondern auf eine
  `le:Adresse`.
* `ical:creator` verweist wieder auf eine Person in der nicht zugänglichen
  Personentabelle.
* Über `le:hatAkteur` ist einem Event teilweise ein Akteur zugeordnet.
* Über `le:zurSparte` sind einem Event Schalgworte zugeordnet.

### Sparten auf le:Sparte

Die Transformation extrahiert die Sparten in eine RDF-Datei `Sparten.ttl`.
Die aktuelle Liste der Sparten ist sehr redundant, das müsste aufgeräumt
werden.

Die Zuordnungen von Akteuren und Events zu Sparten wird in den jeweiligen
RDF-Graphen `Akteuee.ttl` und `Events.ttl` vermerkt.

## Anmerkungen: Analyse des dumps ledump-20160223.sql

Finde die Adressen, die wirklich verwendet werden:

```
SELECT * FROM aae_data_adresse where exists (select * from
aae_data_akteur where adresse=ADID) or exists (select * from
aae_data_event where ort=ADID); 
```

Finde die Adressen, die wirklich verwendet werden, aber keinen Straßennamen haben:

```
SELECT * FROM aae_data_adresse where (exists (select * from
aae_data_akteur where adresse=ADID) or exists (select * from
aae_data_event where ort=ADID)) and strasse=''; 

+------+---------+--------------+--------+------+------+------+
| ADID | strasse | adresszusatz | bezirk | nr   | plz  | gps  |
+------+---------+--------------+--------+------+------+------+
|   62 |         |              |     21 |      |      |      |
|   77 |         |              |     20 |      |      |      |
|   79 |         |              |     22 |      |      |      |
+------+---------+--------------+--------+------+------+------+
```

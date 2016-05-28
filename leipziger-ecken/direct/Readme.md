# Erzeugung von RDF-Daten aus der Datenbank "Leipziger Ecken"

## Grundsätzliche Struktur des Verzeichnisses

In diesem Verzeichnis sind verschiedene php Transformationsroutinen
zusammengestellt, die direkt auf die Datenbank zugreifen und die Instanzen der
Klassen *Akteur*, *Adresse* und *Event* jeweils in einen RDF-Graphen
transformieren.

Die entsprechenden Transformationen werden von den Dateien
```
 adressen.php, akteure.php und events.php
```
ausgeführt, die durch die gemeinsame Datei `helper.php` unterstützt werden, in
der vor allem verschiedenen Routinen zum Adjustieren von Strings sowie zum
Erstellen von Einträgen in einer Turtle-Datei zusammengefasst sind, die immer
wieder benötigt werden.  

Allgemein wird über eine Select-Anfrage an die Datenbank die relevante
Information ausgelesen und dann datensatzweise über eine oder mehrere Methoden
in das RDF-Zielformat transformiert.  Fremdschlüssel werden dabei in URIs der
entsprechenden Klassen verwandelt und so dieselbe Verbindung über RDF-Mittel
hergestellt. 

Die Dateien `main.php` und `index.php` können verwendet werden, um die
Transformationen auszuführen, wobei `index.php` das Ergebnis auf einer Webseite
anzeigt, `main.php` dagegen die Transformationen als Turtle-Dateien in das
Unterverzeichnis `Daten` schreibt.

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

-  dcterms: <http://purl.org/dc/terms/>
-  foaf: <http://xmlns.com/foaf/0.1/> 
-  geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>
-  ical: <http://www.w3.org/2002/12/cal/ical#>
-  org: <http://www.w3.org/ns/org#>

Die entsprechenden Typen werden wie folgt abgebildet: 

## Transformation der einzelnen Klassen

### Adressen auf le:Adresse

`rdfs:label` und Geokoordinaten als `geo:lat_long` werden extrahiert sowie aus
den Daten ein Vorschlag für eine *LD Adressen-URI* generiert, der als
`owl:sameAs` vermerkt ist.  

`geo:lat_long` wird gegenüber der getrennten Verwendung von `geo:lat` und
`geo:long` der Vorzug gegeben, um Geokoordinaten aus verschiedenen Quellen für
dieselbe Adresse vergleichen zu können.

Die genaue semantische Bedeutung von *Adresse* unterscheidet sich, da
LD-Adressen konsequent Postadressen sind, LE-Adressen teilweise durch Zusätze
innerhalb einer LD-Adresse weiter unterteilt werden. 

Ein Abgleich mit *LD Adressen.ttl* ist offen. 

### Akteure auf ld:Akteur, org:Organization

`ld:Akteur` ist in `leipzig-data.de` eine neue Klasse für juristische Personen
verschiedener Größe, in welcher das bisherige Konglomerat `Traeger.ttl`
aufgelöst werden soll.  Die innere Organisation dieser juristischen Personen
soll so weit wie möglich nach `org:Organization` modelliert werden. Deshalb
sind Ansprechpartner einzelner Akteure als Instanzen von `org:Membership`
modelliert.

Der Verweis `le:hatErsteller` auf eine Person kann nicht weiter aufgelöst
werden, da die Fremdschlüssel in eine User-Tabelle verweisen, die nicht mit im
Daten-Dump enthalten ist, der bisher zur Auswertung in eine lokale Datenbank
geladen wurde.

Die Übernahme als *LD Akteure.ttl* ist offen. 

### Events auf ld:Event

Die Modellierung folgt der von `ld:Events`. Problematisch bleibt die
Modellierung von Events, die nicht klar an einem Tag stattfinden, sondern über
mehrere Tage erstrecken oder sich regelmäßig wiederholen. Hierzu ist die
Modellierung auf der Ebene von LD zu schärfen.

Unklar ist die Bedeutung des Verweises auf einen *Ort*.  Hier wird derzeit eine
eigene URI aus dem Namensraum `http://leipziger-ecken.de/Data/Ort/` erzeugt,
die kein Pendant in anderen Strukturen hat. Das bleibt aufzulösen. 

`ical:creator` verweist wieder auf eine Person in der nicht zugänglichen
Personentabelle.

### Sparten auf le:Sparte

Die Transformation extrahiert die Sparten sowie die Zuordnungen von Akteuren
und Events zu Sparten in eine RDF-Datei `Sparten.ttl`.  Die aktuelle Liste der
Sparten ist sehr redundant, das müsste aufgeräumt werden. 

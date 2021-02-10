# Quellen für Datentransformationen

## kitas.json

Kitas in Leipzig. Extrahiert von codefor.de/leipzig aus gescrapten Stadtdaten,
Stand 2014. Transformiert in Kitas.ttl

Quelle: <https://codefor.de/projekte/le-kitas_und_schulen_in_leipzig/>

## playgrounds.json

Spielplätze in Leipzig. Extrahiert von codefor.de/leipzig aus gescrapten
Stadtdaten, Stand 2014. Transformiert in Spielplaetze.ttl

## horte-leipzig.csv

Horte in Leipzig. Extrahiert von Tobias Mann im Rahmen des Zukunftsdiploms aus
gescrapten Stadtdaten, Stand Juni 2018. Transformiert in Horte.ttl

Quelle: <https://www.leipzig.de/jugend-familie-und-soziales/kinderbetreuung/horte> 

## Schulen

### grundschulen.csv

Grundschulen in Leipzig. Extrahiert von Tobias Mann im Rahmen des
Zukunftsdiploms aus gescrapten Stadtdaten, Stand Juli 2018. In Schulen.ttl
eingearbeitet.

Quelle: <https://www.leipzig.de/jugend-familie-und-soziales/schulen-und-bildung/schulen/grundschulen/>

### berufsschulen.csv

Berufsschulen in Leipzig. Extrahiert von Tobias Mann im Rahmen des
Zukunftsdiploms aus gescrapten Stadtdaten, Stand Juli 2018. In Schulen.ttl
eingearbeitet.

Quelle: <https://www.leipzig.de/jugend-familie-und-soziales/schulen-und-bildung/schulen/berufliche-schulen/>

### Schulen in Sachsen

Die sächsische Schuldatenbank kann über eine API, die unter
<https://schuldatenbank.sachsen.de/docs/api.html> beschrieben ist, ausgelesen
werden. Wie das genau funktioniert, ist wenig plausibel, allerdings kann ein
[Dump aller Schulen](https://schuldatenbank.sachsen.de/api/v1/schools)
heruntergeladen werden (aber nur direkt von der Webseite, ansonsten greift die
Beschränkung auf 20 Einträge). Dieser ist unter schools.json gespeichert. 

## stops.txt

Haltestellenliste (Stand 2018)

Quelle: <https://opendata.leipzig.de/dataset/lvb-fahrplandaten>

Transformiert in Haltestellen.ttl Extraktion der zugehörigen Linien ist etwas
diffizil, siehe dazu ld-workbench/OpenData-Leipzig/Fahrplaene

## leipzig-de.json

Dump von <https://afeefa.de/api/marketentries?area=leipzig>.  API soll aber
noch umgestaltet werden. (Stand 2018)

Analyse der Schnittstelle:

* id => String
* entryType => String
* category => Array
* certified => String
* description => String
* descriptionShort => String
* entryId => String
* facebook => String
* image => String
* imageType => String
* location => Array
* mail => String
* name => String
* phone => String
* speakerPublic => String
* spokenLanguages => String
* subCategory => String
* supportWantedDetail => String
* tags => String
* type => String
* web => String
* inheritance => Array
* created_at => String
* updated_at => String
* parentOrgaId => String
* dateFrom => String
* timeFrom => String
* dateTo => String
* timeTo => String

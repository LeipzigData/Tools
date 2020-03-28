Quellen für Datentransformationen

* kitas.json - Kitas in Leipzig. Extrahiert von codefor.de/leipzig aus
  gescrapten Stadtdaten, Stand 2014. Transformiert in Kitas.ttl
  https://codefor.de/projekte/2014-05-06-le-kitas_und_schulen_in_leipzig.html

* playgrounds.json - Spielplätze in Leipzig. Extrahiert von codefor.de/leipzig
  aus gescrapten Stadtdaten, Stand 2014. Transformiert in Spielplaetze.ttl

* horte-leipzig.csv - Horte in Leipzig. Extrahiert von Tobias Mann im Rahmen
  des Zukunftsdiploms aus gescrapten Stadtdaten, Stand Juni 2018. Transformiert
  in Horte.ttl
  https://www.leipzig.de/jugend-familie-und-soziales/kinderbetreuung/horte

* grundschulen.csv - Grundschulen in Leipzig. Extrahiert von Tobias Mann im
  Rahmen des Zukunftsdiploms aus gescrapten Stadtdaten, Stand Juli 2018. In
  Schulen.ttl eingearbeitet.
  https://www.leipzig.de/jugend-familie-und-soziales/schulen-und-bildung/schulen/grundschulen/

* berufsschulen.csv - Berufsschulen in Leipzig. Extrahiert von Tobias Mann im
  Rahmen des Zukunftsdiploms aus gescrapten Stadtdaten, Stand Juli 2018. In
  Schulen.ttl eingearbeitet.
  https://www.leipzig.de/jugend-familie-und-soziales/schulen-und-bildung/schulen/berufliche-schulen/

* stops.txt - Haltestellenliste (Stand 2018)
  Quelle: https://opendata.leipzig.de/dataset/lvb-fahrplandaten
  Transformiert in Haltestellen.ttl
  Extraktion der zugehörigen Linien ist etwas diffizil, siehe dazu
  ld-workbench/OpenData-Leipzig/Fahrplaene

* leipzig-de.json - Dump von https://afeefa.de/api/marketentries?area=leipzig
  API soll aber noch umgestaltet werden. 

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

# Data Alignment der "Leipziger Ecken" mit Leipzig Data

## Tools

* `getdump.sh` - Extraktion der Adressen, Akteure, Events und Sparten aus
  leipziger-ecken.de über die dort ausgerollte Webservice-Schnittstelle le-rdf.
* `Queries.txt` - verschiedene Queries auf einem lokalen RDF Store (etwa
  fuseki), in den Teile der Daten zur Analyse geladen werden.
* `postprocess.pl` - temporäres Perl-Skript. Obsolet.

## Daten

* Dump-<Klasse>.ttl - aktuelle Dumps, die mit `getdump.sh` erzeugt wurden.
* <Klasse>-checked.ttl - konsolidierte Version einer ggf. früheren Version von
  von Dump-<Klasse>.ttl
* LD-Adressen.ttl - eine nach le:proposedAddress sortierte und weiter
  konsolidierte Übersicht der Adressen zum Abgleich mit den Leipzig Data
  Adressen.

## Probleme

* Geodaten sind von teilweise sehr geringer Qualität.
* Wie mit Adressen umgehen, zu denen keine Hausnummer existiert? 

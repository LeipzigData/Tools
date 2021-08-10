# Leipziger Soziale Plattformen

## Vision

In Leipzig gibt es eine größere Zahl von Betreibern, die
Informationsplattformen zu Akteuren, Projekten, Angeboten und Events
vorhalten, etwa

- http://www.mehr-als-chillen.de/de/2/p1/home.html
- http://leipziger-ecken.de/
- http://daten.nachhaltiges-sachsen.de/

Die dort von verschiedenen Betreibern zusammengetragenen Informationen sind in
einem stadtweiten Austauschprozess gegenseitig sichtbar, die Datenstrukturen
sind harmonisiert und unter den Betreibern abgestimmt, die Daten sind
konsolidiert und kuratiert.

Weitere relevante Links:

- http://leipzig-data.de/MINT-Orte/#/
- https://github.com/LeipzigData/MINT-Orte

## Konzeptionelle Überlegungen 

Daten werden von den Betreibern als Webservice der jeweiligen
Produktiv-Plattform in Form einer JSON-REST-API zur Verfügung gestellt.  Auf
der Basis kann über eine Harmonisierung der verwendeten Datenmodelle und eine
Integrationslösung nachgedacht und verhandelt werden.

Eine Analyse der verschiedenen Datenmodelle potenzieller und realer Partner
wurde 2018 begonnen und ist hier in der Datei _Datenmodelle.pdf_
zusammengetragen.  Die Datei _Datenmodelle.tex_ enthält den LaTeX-Quellcode.
Die Übersicht wird sporadisch aktualisiert.

In einer ersten Ausbaustufe zur weiteren Harmonisierung werden mit
`createDumps.php` Dumps der Daten aus den APIs der einzelnen Plattformen
erzeugt und im Verzeichnis _Dumps_ abgelegt, um Latenzzeiten bei der Arbeit
mit den Daten zu verringern.  Da dieses Verzeichnis ein abgeleitetes
Verzeichnis ist, wurde es nicht mit ins Repo aufgenommen.

Solche Dumps können derzeit von den Plattformen
- http://leipziger-ecken.de/
- http://daten.nachhaltiges-sachsen.de/
erzeugt werden.

Daraus werden mit den plattformspezifischen Skripts
- `le.php` für http://leipziger-ecken.de/
- `nl.php` für http://daten.nachhaltiges-sachsen.de/
RDF-Daten im Turtle-Format erzeugt, die ihrerseits für die prototypische Demo
unter <http://leipzig-data.de/demo/transform/> bereitgestellt werden.  Siehe
dazu das Verzeichnis <http://leipzig-data.de/demo/transform/rdf/>, in dem die
Quellen im RDF-XML-Format abgelegt sind.

## Vorarbeiten

In einer *Seminararbeit von Tobias Hahn* (HTWK Leipzig) war zunächst
untersucht worden, welche Architekturkonzepte für eine solche Integration
überhaupt zur Anwendung kommen und welche Transformations-Frameworks und
-werkzeuge dabei eingesetzt werden könnten.  Das Ergebnis blieb
unbefriedigend, da nicht betrachtet wurde, ob die untersuchten Frameworks in
der gegebenen konkreten Situation auch sinnvoll angewendet werden können. In
einer kleinen Studie zur Anpassung von
[r2rml](https://github.com/nkons/r2rml-parser) für den konkreten
Anwendungsfall war es sehr schwierig, die gewünschte Datenqualität flexibel
genug zu steuern.

Als Ergebnis ist festzuhalten, dass diese Untersuchungen nahe legen, dass
Aufwand und Nutzen des Einsatzes eines Frameworks in einer so agilen Situation
wie hier, wo selbst über ein gemeinsames Datenmodell erst Konsens hergestellt
werden muss, in keinem Verhältnis zueinander stehen. Der Fokus liegt primär auf
der Organisation der _sozialen_ Abstimmungsprozesse, wofür die zu gewinnenden
Akteure leichtgewichtige Werkzeuge benötigen, die sie auch sicher in ihrem
jeweiligen Kontext beherrschen können. 

Im Sommersemester 2015 wurde in einem *Projektpraktikum an der Uni Leipzig*
der Verein "Helden wider Willen e.V." unterstützt, eine Drupal-basierte
Stadtteilplattform aufzubauen, die nach einer weiteren Konsolidierungsphase im
Wintersemester 2015 seither unter <http://leipziger-ecken.de/> zu erreichen
ist.  Die Daten wurden in einer ersten Version 2016 für den RDF-Austausch
aufbereitet, zunächst aus einem Dump der Datenbank heraus.  Aktuell wird die
von der Plattform mit dem Übergang zu Drupal 8 bereitgestellte JSON-API
verwendet.

Im Herbst 2017 wurden die Daten der Plattform "Nachhaltiges Leipzig" (heute
"Nachhaltiges Sachsen") nach demselben Muster aufbereitet.  Mit der
Weiterentwicklung der Plattform durch die appPlant GmbH wurde diese
Schnittstelle auch in die Produktivversion integriert und steht seit Mitte
2018 als JSON-API zur Verfügung, die von verschiedenen Partnern, die Teile der
Daten in ihre Webpräsenzen integriert haben, auch produktiv genutzt. 

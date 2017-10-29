# Plattform Nachhaltiges Leipzig 

**Vision:** In Leipzig gibt es eine größere Zahl von Akteuren, die
Informationsplattformen zu Akteuren, Projekten, Angeboten und Events betreiben,
etwa

- http://www.mehr-als-chillen.de/de/2/p1/home.html
- http://leipziger-ecken.de/
- http://daten.nachhaltiges-leipzig.de/

Es sollen Bemühungen unterstützt werden, die dort zusammengetragenen
Informationen in einem stadtweiten Austauschprozess gegenseitig sichtbar zu
machen und dabei zugleich zu harmonisieren, zu konsolidieren und zu
kuratieren. 

Weitere relevante Links:

- http://leipzig-data.de/MINT-Orte/#/
- https://github.com/LeipzigData/MINT-Orte

## Vorarbeiten 

Im Sommersemester 2015 wurde in einem Projektpraktikum an der Uni Leipzig der
Verein "Helden wider Willen e.V." unterstützt, eine Drupal-basierte
Stadtteilplattform aufzubauen, die nach einer weiteren Konsolidierungsphase im
Wintersemester 2015 seither unter http://leipziger-ecken.de/ zu erreichen ist.
Die Daten wurden in einer ersten Version 2016 für den RDF-Austausch
aufbereitet, zunächst aus einem Dump der Datenbank heraus.

Im Herbst 2017 wurden die Daten Plattform "Nachhaltiges Leipzig" nach demselben
Muster aufbereitet.

## Konzeptionelle Überlegungen 

Es ist daran gedacht, die Daten, die derzeit aus einem Dump der jeweiligen
Datenbank im RDF-Format extrahiert werden, in Zukunft als Webservice der
jeweiligen Produktiv-Plattform zur Verfügung zu stellen.  Auf der Basis kann
über eine Harmonisierung der verwendeten Datenmodelle und eine
Integrationslösung nachgedacht und verhandelt werden.

Als "einfache Lösung" wurden mit `le-rdf` bzw. `nl-rdf` direkte
Daten-Transformationen als sehr einfach gehaltene PHP-Lösung eingerichtet, die
schnell an veränderte Datenkonzepte angepasst werden kann. Die jeweilige
Transformation lässt sich im Backend ausrollen und über einen Web Service
getdata.php ansprechen.

## Vorarbeiten

In einer *Seminararbeit von Tobias Hahn* (HTWK Leipzig) zunächst untersucht,
welche Architekturkonzepte für eine solche Integration überhaupt zur Anwendung
kommen und welche Transformations-Frameworks und -werkzeuge dabei eingesetzt
werden könnten.  Das Ergebnis blieb unbefriedigend, da nicht betrachtet wurde,
ob die untersuchten Frameworks in der gegebenen konkreten Situation auch
sinnvoll angewendet werden können. In einer kleinen Studie zur Anpassung von
[r2rml](https://github.com/nkons/r2rml-parser) für den konkreten Anwendungsfall
war es sehr schwierig, die gewünschte Datenqualität flexibel genug zu steuern.

Als Ergebnis ist festzuhalten, dass diese Untersuchungen nahe legen, dass
Aufwand und Nutzen des Einsatzes eines Frameworks in einer so agilen Situation
wie hier, wo selbst über ein gemeinsames Datenmodell Konsens erst hergestellt
werden muss, in keinem Verhältnis zueinander stehen. Der Fokus liegt primär auf
der Organisation der *sozialen* Abstimmungsprozesse, wofür die zu gewinnenden
Akteure leichtgewichtige Werkzeuge benötigen, die sie auch sicher in ihrem
jeweiligen Kontext beherrschen können. 

Die Vorarbeiten sind im privaten Bereich in der ld-workbench (Kontakt:
graebe@informatik.uni-leipzig.de) verfügbar.


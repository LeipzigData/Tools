# Leipziger Soziale Plattformen

## Vision

In Leipzig gibt es eine größere Zahl von Betreibern, die
Informationsplattformen zu Akteuren, Projekten, Angeboten und Events
vorhalten, etwa

- http://www.mehr-als-chillen.de/de/2/p1/home.html
- http://leipziger-ecken.de/
- http://daten.nachhaltiges-leipzig.de/

Die dort von verschiedenen Betreibern zusammengetragenen Informationen sind in
einem stadtweiten Austauschprozess gegenseitig sichtbar, die Datenstrukturen
sind harmonisiert und unter den Betreibern abgestimmt, die Daten sind
konsolidiert und kuratiert.

Weitere relevante Links:

- http://leipzig-data.de/MINT-Orte/#/
- https://github.com/LeipzigData/MINT-Orte

## Konzeptionelle Überlegungen 

Daten werden von den Betreibern als Webservice der jeweiligen
Produktiv-Plattform in Form einer REST-API zur Verfügung gestellt, die
JSON-Objekte ausliefert.  Auf der Basis kann über eine Harmonisierung der
verwendeten Datenmodelle und eine Integrationslösung nachgedacht und
verhandelt werden.

Eine solche REST-API ist inzwischen für die Nachhaltigkeitsdatenbank Leipzig
(NDL) http://daten.nachhaltiges-leipzig.de implementiert, siehe dazu nähere
Ausführungen im Verzeichnis `nachhaltiges-leipzig/Code`.

Ein erster Zugang wurde 2018 auch für http://leipziger-ecken.de/ analysiert,
muss allerdings an die Datenstrukturen des Relaunchs der Website angepasst
werden.  Siehe dazu den Code im Verzeichnis `leipziger-ecken/Code`.

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
der Organisation der *sozialen* Abstimmungsprozesse, wofür die zu gewinnenden
Akteure leichtgewichtige Werkzeuge benötigen, die sie auch sicher in ihrem
jeweiligen Kontext beherrschen können. 

Die Vorarbeiten sind im privaten Bereich in der ld-workbench (Kontakt:
graebe@informatik.uni-leipzig.de) verfügbar.

Im Sommersemester 2015 wurde in einem Projektpraktikum an der Uni Leipzig der
Verein "Helden wider Willen e.V." unterstützt, eine Drupal-basierte
Stadtteilplattform aufzubauen, die nach einer weiteren Konsolidierungsphase im
Wintersemester 2015 seither unter http://leipziger-ecken.de/ zu erreichen ist.
Die Daten wurden in einer ersten Version 2016 für den RDF-Austausch
aufbereitet, zunächst aus einem Dump der Datenbank heraus.

Im Herbst 2017 wurden die Daten der Plattform "Nachhaltiges Leipzig" nach
demselben Muster aufbereitet.  Mit der Weiterentwicklung der Plattform durch
die appPlant GmbH wurde diese Schnittstelle auch in die Produktivversion
integriert und steht seit Mitte 2018 als REST-API zur Verfügung, die von
verschiedenen Partnern, die Teile der Daten in ihre Webpräsenzen integriert
haben, auch produktiv genutzt.  Siehe dazu die Betreiberdokumentation der NDL
unter `nachhaltiges-leipzig/Dokumente`.

Die Datei `Datenmodelle.tex` enthält eine Beschreibung der Datenmodelle
verschiedener potenzieller und realer Partner, so weit sich diese durch eine
externe Analyse erschließen ließen.  Die Übersicht wird sporadisch
aktualisiert.
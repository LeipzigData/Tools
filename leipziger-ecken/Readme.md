# Semantische Stadtteilplattform 

**Vision:** In Leipzig gibt es eine größere Zahl von Akteuren, die
stadtteilzentrierte Informationsplattformen zu Akteuren, Projekten, Angeboten
und Events betreiben, etwa

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
Wintersemester 2015 unter http://leipziger-ecken.de/ zu ereichen ist.  Die
Stadtteilplattform ist eine Standard-Drupal-Installation, für die ein weiteres
Modul `aae_data` zur Verwaltung der Daten zu Akteuren und Events entwickelt
wurde.  Der Code dazu ist zusammen mit einem eher spezifischen Theme
`aae_theme` als Projekt "easteasteast" bei
[github.com](https://github.com/JuliAne/easteasteast) zu finden und wird
ständig weiterentwickelt.

- http://pcai042.informatik.uni-leipzig.de/swp/SWP-15/AAE-15.html
- https://github.com/JuliAne/easteasteast

## Konzeptionelle Überlegungen 

Da der Anspruch der Entwicklung einer *semantischen* Stadtteilplattform dabei
nicht realisiert wurde, die in der Lage ist, die oben formulierte Vision des
Datenaustauschs auf RDF-Basis umzusetzen, soll diese Vision nun in einem
kleinen Nachfolgeprojekt mit sehr beschränkten Ressourcen weiter konkretisiert
werden.

Dazu wurde in einer *Seminararbeit von Tobias Hahn* (HTWK Leipzig) zunächst
untersucht, welche Architekturkonzepte hier zur Anwendung kommen und welche
Transformations-Frameworks und -werkzeuge dabei eingesetzt werden könnten.  Das
Ergebnis blieb unbefriedigend, da nicht betrachtet wurde, ob die untersuchten
Frameworks in der gegebenen konkreten Situation auch sinnvoll angewendet werden
können. In einer kleinen Studie zur Anpassung von
[r2rml](https://github.com/nkons/r2rml-parser) für den konkreten Anwendungsfall
war es sehr schwierig, die gewünschte Datenqualität flexibel genug zu steuern.

Als Ergebnis ist festzuhalten, dass diese Untersuchungen nahe legen, dass
Aufwand und Nutzen des Einsatzes eines Frameworks in einer so agilen Situation
wie hier, wo selbst über ein gemeinsames Datenmodell Konsens erst hergestellt
werden muss, in keinem Verhältnis zueinander stehen. Der Fokus liegt primär auf
der Organisation der *sozialen* Abstimmungsprozesse, wofür die zu gewinnenden
Akteure leichtgewichtige Werkzeuge benötigen, die sie auch sicher in ihrem
jeweiligen Kontext beherrschen können. Dies wird aktuell im Verzeichnis
`leipziger-ecken` mit zwei Ansätzen weiter vorangetrieben.

Die Vorarbeiten sind im privaten Bereich in der ld-workbench (Kontakt:
graebe@informatik.uni-leipzig.de) verfügbar.

Als "einfache Lösung" wurde eine direkte Daten-Transformation eingerichtet, die
sich im Backend ausrollen lässt, über einen Web Service getdata.php
angesprochen werden kann und unmittelbar über die entsprechende
Drupal-Schnittstelle auf die Datenbank zugreifen soll.


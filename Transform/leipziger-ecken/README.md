# Semantische Stadtteilplattform leipzigeer-ecken.de 

## Hintergrund

Im Sommersemester 2015 wurde in einem Projektpraktikum an der Uni Leipzig der
Verein "Helden wider Willen e.V." unterstützt, eine Drupal-basierte
Stadtteilplattform aufzubauen, die nach einer weiteren Konsolidierungsphase im
Wintersemester 2015 seither unter http://leipziger-ecken.de/ zu erreichen ist.
Die Stadtteilplattform ist eine Standard-Drupal-Installation, für die ein
weiteres Modul `aae_data` zur Verwaltung der Daten zu Akteuren und Events
entwickelt wurde.  Der Code dazu ist zusammen mit einem eher spezifischen Theme
`aae_theme` als Projekt "easteasteast" bei
[github.com](https://github.com/JuliAne/easteasteast) zu finden und wird
ständig weiterentwickelt.

- http://pcai042.informatik.uni-leipzig.de/swp/SWP-15/AAE-15.html
- https://github.com/JuliAne/easteasteast

## Konzeptionelle Überlegungen 

Da der Anspruch der Entwicklung einer *semantischen* Stadtteilplattform dabei
nicht realisiert wurde, die in der Lage ist, die oben formulierte Vision des
Datenaustauschs auf RDF-Basis umzusetzen, soll diese Vision nun in einem
kleinen Nachfolgeprojekt mit beschränkten Ressourcen weiter konkretisiert
werden.

Als "einfache Lösung" wurde eine direkte Daten-Transformation eingerichtet,
die sich im Backend ausrollen lässt, über einen Web Service `getdata.php`
angesprochen werden kann und unmittelbar über die entsprechende
Drupal-Schnittstelle auf die Datenbank zugreift. Der Code dazu ist im
Verzeichnis `Code` zu finden,

Nach dem Relaunch der Website http://leipziger-ecken.de muss der Code noch
angepasst werden.
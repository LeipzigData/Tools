# Semantische Stadtteilplattform leipziger-ecken.de 

## Hintergrund

Im Sommersemester 2015 wurde in einem Projektpraktikum an der Uni Leipzig der
Verein "Helden wider Willen e.V." unterstützt, eine Drupal-basierte
Stadtteilplattform aufzubauen, die nach einer weiteren Konsolidierungsphase im
Wintersemester 2015 seither unter <http://leipziger-ecken.de/> zu erreichen
ist.

Die Stadtteilplattform ist eine Standard-Drupal-Installation, für die ein
weiteres Modul `aae_data` als RDF/JSON API zu den Daten der Akteure und Events
entwickelt wurde.  Der Code dazu ist zusammen mit einem eher spezifischen
Theme `aae_theme` als github-Projekt "easteasteast" zu finden, scheint aber
nicht weiterentwickelt zu werden - die letzten commits sind vom Oktober 2017.

- <http://pcai042.informatik.uni-leipzig.de/swp/SWP-15/AAE-15.html>
- <https://github.com/JuliAne/easteasteast>

## Konzeptionelle Überlegungen 

Ein sinnvoller semantischer Austausch zwischen verschiedenen Plattformen
bzw. auch nur die Nutzung von Daten aus verschiedenen solchen Quellen in einer
gemeinsamen Website ist nur bei einigermaßen harmonisierten Datenmodellen
möglich.

Eine solche Harmonisierung ist weniger ein _technischer_ als vielmehr ein
_sozialer_ Prozess, denn über eine Harmonisierung können nur Betreiber
verhandeln, die zu einer solchen Harmonisierung _bereit_ sind und nicht darauf
beharren, dass ihre eigene Plattform der Nabel der Welt ist und alle anderen
sich daran anzupassen haben.

## Die API

Um dies zu befördern, müssen sinnvolle Daten zunächst von einer API
bereitgestellt werden.  Dies ist mit der API
<https://leipziger-ecken.de/Data/> umgesetzt, welche eine Webseite erzeugt,
auf der die exportierten Daten angezeigt werden (Stand April 2020).

Die Funktionalität, Daten unmittelbar aus der Datenbank zu extrahieren und als
RDF/JSON zu exportieren, sind in einem Drupal-Modul implementiert, dessen Code
im Verzeichnis `API-Code` zu finden ist.

Die API kann auch über einen Web Service `getdata.php` angesprochen werden,
siehe dazu das `Makefile` in diesem Verzeichnis.

Eine experimentelle Nutzung der API ist im Repo `LeipzigData/web` im
Verzeichnis `demo/le-web` ausgerollt. 
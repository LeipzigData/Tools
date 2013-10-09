== RDF2WP ==
Contributors: swp11-6
Donate Link: http://pcai042.informatik.uni-leipzig.de/~swp11-6/index.html
Tags: linked data, semantics, table, rdf, n3, turtle, xml, catalogus professorum lipsiensis, arc2, sparql, ksc, editor
Requires at least: 2.7
Tested up to: 3.1.2
Stable tag: 1.0

== Description ==

Das Plugin bestitzt 3 Hauptkomponenten:

Eine Import und Update Schnittstelle �ber die man RDF einem Blogeintrag hinzuf�gen kann und ver�ndern.
Das Plugin erm�glicht das Editieren von RDF Daten und es publiziert die Daten als RDF und LinkedData.
�ber ein einfaches Template System k�nnen zu einem Blogeintrag zus�tzliche Informationen aus einem       semantischen Triple Store mit SPARQL geholt und angezeigt werden.

== Installations- und Konfigurationsanleitung ==

-	Installation Plugin:
Die Installation des RDF2WP Plugins entspricht der Standard- Plugin- Installation in Wordpress. 
Sollte Ihnen das Plugin in einer .zip- Datei vorliegen, so kann es �ber die WordPress Schnittstelle im Admin-Bereich installiert werden. Gehen Sie daf�r in das Settings-Men� �Plugins� Eintrag �Add New� und w�hlen in der oberen Link-Leiste den Eintrag Upload. Hier kann der .zip Ordner von der lokalen Festplatte hochgeladen und installiert werden.
Anderenfalls l�sst sich das Plugin durch einfaches Kopieren des Plugin Ordners �RDF2WP� in den Plugin Ordner Ihrer Lokalen Wordpress Installation hinzuf�gen. Dieser befindet sich in den h�ufigsten F�llen unter �<Pfad zur WP-Installation>/wordpress-<version>/wp-content/plugins�.

M�chten Sie einige der Pakete nicht nutzen, so k�nnen Sie diese in der Datei RDF2WP.php in den Zeilen 11 bis 53 auskommentieren. So kommentieren Sie z.B. das Widget Paket aus:
Zeile 18: //include_once('Widget/KSCWidget.php');
Zeile 19: //$widget = new KSCWidget();
Welcher Teil zu einem Package geh�rt, ist dort ausdr�cklich kommentiert.

-	Konfiguration Plugin
Im Folgenden wird beschrieben wie sie das Plugin und seine Komponenten (Packages) an ihre Anforderungen Anpassen und entsprechende Konfigurationen vornehmen.

1.	Package Import

Inhalt:
Das Import- Package bezieht sich auf den Import des Professorenkatalogs der Universtit�t Leipzig, ist aber durchaus in der Lage RDF Ressourcen aus anderen Endpunkten in die Wordpress Installation einzubinden. 

WordPress- Pfad:
Die Importschnittstelle befindet sich im Admin- Bereich Men�- Eintrag �Settings� Unterpunkt �Import Professorum Catalogum Lipsiensis�.

Konfiguration:
Die Importseite gliedert sich in drei Bereiche. 
Im obersten Bereich werden die Einstellungen f�r den Import vorgenommen. Definieren Sie hier den SPARQL- Endpunkt an den Ihre Anfrage gestellt werden soll und die SPARQL- Anfrage selbst. Des Weiteren die maximale Anzahl der zu importierenden Ressourcen mit LIMIT. Wird kein Limit angegeben, so werden alle Ressourcen die sich im Ergebnis befinden importiert. Beachten Sie hierbei, dass das Interface nur Anfragen die sich auf eine RDF Klasse beziehen, wie es beim Professorenkatalog die Professoren sind, ordnungsgem�� importiert. Von dieser Klasse k�nnen au�erdem beliebig viele Pr�dikate abgefragt werden. Abfragen �hnlich, die des �Graphical Query Builders�  sind somit kein Problem. Von jeder Instanz der RDF- Klasse wird ein 
Post mit dem gesamten Inhalt der Ressource erstellt. F�r die angefragten Attribute werden jeweils eigene Kategorien erstellt. Alle Instanzen der angegebenen Klasse werden in eine Oberkategorie mit dem Namen dieser Klasse importiert. Alle erstellten Kategorien werden in einer Oberkategorie abgelegt. Ihr Standardname ist �Catalog�. Der Name l�sst sich auf einfache Weise anpassen, indem in der Datei CategoryCreator.php die Konstante �mainCategorie� auf den gew�nschten Namen gesetzt wird. Im Weiteren Definieren Sie in welche Weise die Posts in WordPress erstellt werden sollen. Jede �nderung muss 
mit dem �Save Changes� Button best�tigt werden, wobei der Enpunkt und die Query auf Korrektheit gepr�ft werden.
Im mittleren Bereich wird der Import, im unteren Bereich das L�schen, wie dort beschrieben durchgef�hrt.

Plugin-Pfad:
RDF2WP/Import/

Empfehlung:
Es wird empfohlen das Collapsing Categories Plugin  zu installieren, um eine hierarchische Darstellung der erzeugten Kategorien zu erm�glichen.

Ressourcen:
GraphicalQueryBuilder
http://catalogusprofessorum.org/graphicalquerybuilder/display/position/3/active?m=http%3A%2F%2Fcatalogus-professorum.org
%2Flipsiensis%2F
CollapsingCategories
http://wordpress.org/extend/plugins/collapsing-categories/

2.	Package Widget

Inhalt:
Mit dem Widget-Package wird die Anzeige von RFD Daten in Wordpress erm�glicht.  Ein frei konfigurierbares Widget zeigt 
immer die aktuellen Informationen in der Widget-Sidebar an.

WordPress- Pfad:
Die Einstellungen zum Widget befinden sich im Admin- Bereich Men�- Eintrag �Appearance� Unterpunkt �Widgets�.

Konfiguration:
Damit das Widget angezeigt wird, muss es im Sidepad sein. Ziehen Sie dazu das RDF Widget in das Sidepad per DragNDrop. Nun 
k�nnen Sie folgende Einstellungen vornehmen:
Title � Titel des Widgets. Dieser wird �ber dem Widget angezeigt.
SPAQRL Endpoint � Der Endpunkt an dem die SPAQRL Anfrage gesendet wird.
Categories � eine Liste der Top-Level Kategorien in Wordpress unter welchen das Widget angezeigt werden soll. Die einzelnen Kategorien werden durch ein Komma getrennt. Falls Sie dieses Feld frei lassen, so ist das Widget uneingeschr�nkt sichtbar.
Sollten Sie ein Widget erstellen wollen, welches nur auf der Hauptseite sichtbar sein soll, so Klammern Sie in der Datei KSCWidget.php den Kommentar in der Funktion �widget� ein und die darunterliegende Zeile aus. Wird das Kategorie Feld freigelassen, so werden die Widgets nun nur noch auf der Blog-Hauptseite angezeigt.
Query � die SPAQRL Anfrage, welche die Daten f�r das Widget festlegt.
Nachdem Sie die n�tigen Einstellungen vorgenommen haben, m�ssen Sie diese nur noch speichern. Klicken Sie dazu auf den Save Button.

Plugin-Pfad:
RDF2WP/Widget/

3.	Package Output

Inhalt:
Das Output-Package sorgt f�r drei Dinge. Daf�r, dass RDF Daten welche sich in einem Post befinden, besucherfreundlich angezeigt werden, es stellt eine Schnittstelle f�r den Export von RDF Daten bereit. Und es bringt einen RDF Parser mit sich, welcher die Daten validiert und dem Verfasser bei Fehlern hilfreiche Hinweise auf die Ursache liefert.

Anzeige von RDF Daten:
In einem Post werden die RDF Daten zwischen den �semantics� Tags gespeichert:
[semantics format=��] Hier RDF Daten [/semantics].
Zu beachten ist das Richtige Format der Daten. Neben den Werten "turtle", "rdfxml" und "json" sind noch folgende Werte f�r das Format vorgesehen:
"infobox" � von dem Klappstuhlclub verwendete Syntax
"prof" � ein Alias f�r die Turtle Syntax, wird f�r den Professorenkatalog verwendet.
Bei der Anzeige des Posts werden diese Daten automatisch in Tabellenform dargestellt.
Verwendete Pr�fixe f�r neue RDF-Daten in einem Post k�nnen �ber das Men� Settings, RDF Eintr�ge hinzugef�gt werden.

Export von RDF Daten:
Die RDF Daten k�nnen aus jedem Post als Linked Data in verschiedenen Formaten angefragt werden. Dazu wird einfach der gew�nschte Typ im HTTP Accept Header angegeben. Folgende Datentypen werden unterst�tzt: application/rdf+xml, application/json+rdf, text/plain, text/rdf+n3, text/turtle.

Plugin-Pfad:
RDF2WP/Output/

4.	Package Editor

Inhalt:
Das Editor-Package bringt ein bequemes Template System mit sich. F�r eine schnelle  Eingabe von semantischen Daten in einen Post, werden zwei Buttons dem Editor hinzugef�gt. Diese sind f�r die Klappstuhlclub Mitglieder interessant. Allerdings k�nnen die Templates auch angepasst werden.
Das Anpassen eines Templates:
Um z.B. das Meeting-Template anzupassen, m�ssen Sie eine kleine Ver�nderung der Datei MeetingTemplateDialog.php vornehmen. Dazu �ffnen Sie bitte diese Datei in einem Texteditor Ihrer Wahl. In den Zeilen 21 bis 28 sehen Sie schon alles was Sie brauchen.
Bsp. Zeile 21:
$template->addEntry('| nummer = "300"', true);
Der erste Parameter '| nummer = "300" ist eine Textzeile, welche sp�ter beim anklicken des Buttons dem Editor hinzugef�gt werden soll.
Der zweite Parameter gibt an, ob diese Zeile  in der Checkbox des Templates vorab ausgew�hlt werden soll. true bedeutet 
Sie wird ausgew�hlt, false hingegen hei�t bei dieser Zeile wird das H�kchen nicht gesetzt.
Wollen Sie eine neue Zeile hinzuf�gen, so kopieren Sie eine der Zeilen 21 bis 28 und f�gen Sie diese an.
So kann z.B. Ihre neue Zeile aussehen:
$template->addEntry('| essen = "altes Br�tchen", "Pflaume"', false);

Plugin-Pfad:
RDF2WP/Editor/

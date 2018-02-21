<?php

require 'helper.php';

function processArray($s) {
    $out=''; // Ortsteile sind irrelevant, da den Adressen zugeordnet. 
  foreach ($s as $v) {
      $w=explode("\t",$v);
      $strasse=$w[0];
      $id=fixURI($strasse);
      $out.=' <http://leipzig-data.de/Data/Strasse/'.$id.'>
    a ld:Strasse ;
    rdfs:label "'.$strasse.'" .'."\n\n";
  }
  return TurtlePrefix().$out ; 
}

// --- main ----

$a=explode("\n",'Aachener Straße	Zentrum-West
Abrahamstraße	Neulindenau
Abtnaundorfer Straße	Schönefeld-Abtnaundorf
Achatstraße	Engelsdorf
Ackerweg	Plaußig-Portitz
Adamsweg	Probstheida
Addis-Abeba-Platz	Zentrum-Südost
Adelgunde-Gottsched-Weg	Engelsdorf
Adenauerallee	Schönefeld-Abtnaundorf, Schönefeld-Ost
Adlershelmstraße	Anger-Crottendorf
Adolf-Damaschke-Straße	Engelsdorf
Adolf-Koppe-Straße	Mölkau
Adolph-Menzel-Straße	Gohlis-Mitte
Agnesstraße	Möckern
Agricolastraße	Schleußig
Ahlfeldstraße	Altlindenau
Ahorngasse	Seehausen
Ahornstraße	Paunsdorf
Ahornweg	Connewitz
Akazienweg	Wiederitzsch
Akeleiweg	Engelsdorf
Albersdorfer Straße	Großzschocher, Knautkleeberg-Knauthain
Albersdorfer Weg	Hartmannsdorf-Knautnaundorf
Albert-Schweitzer-Straße	Reudnitz-Thonberg
Albert-Vollsack-Straße	Großzschocher
Albrecht-Dürer-Platz	Südvorstadt
Albrecht-Dürer-Weg	Paunsdorf
Albrechtshainer Straße	Mölkau, Stötteritz
Alemannenweg	Möckern
Alexander-Alesius-Straße	Mölkau
Alexanderstraße	Zentrum-West
Alexis-Schumann-Platz	Südvorstadt
Alfred-Frank-Platz	Reudnitz-Thonberg
Alfred-Frank-Straße	Schleußig
Alfred-Kästner-Straße	Südvorstadt
Alfred-Schurig-Straße	Sellerhausen-Stünz
Altdorferweg	Meusdorf
Alte Baumschule	Liebertwolkwitz
Alte Burghausener Straße	Grünau-Nord, Miltitz
Alte Dorfstraße	Burghausen-Rückmarsdorf
Alte Dübener Landstraße	Seehausen, Wiederitzsch
Alte Gärtnerei	Liebertwolkwitz
Alte Hohe Straße	Mockau-Nord
Alte Holzhausener Straße	Liebertwolkwitz
Alte Landsberger Straße	Lindenthal
Alte Messe	Zentrum-Südost
Alte Parkstraße	Miltitz
Alte Salzstraße	Grünau-Mitte, Grünau-Ost, Grünau-Siedlung, Lausen-Grünau, Neulindenau
Alte Seehausener Straße	Seehausen
Alte Straße	Plagwitz
Alte Tauchaer Straße	Holzhausen, Liebertwolkwitz
Alte Theklaer Straße	Plaußig-Portitz
Altenburger Straße	Südvorstadt
Alter Amtshof	Zentrum-West
Alter Kirchweg	Lützschena-Stahmeln
Alter Marktweg	Engelsdorf
Altes Dorf	Plaußig-Portitz
Althener Anger	Althen-Kleinpösna
Althener Straße	Althen-Kleinpösna, Engelsdorf
Altranstädter Straße	Kleinzschocher
Am Alten Bahnhof	Lausen-Grünau
Am Alten Flugfeld	Lindenthal
Am alten Flughafen	Mockau-Nord
Am alten Gasthof	Wahren
Am Alten Mühlgraben	Böhlitz-Ehrenberg
Am Anger	Seehausen
Am Angerteich	Liebertwolkwitz
Am Bahndamm	Mölkau
Am Bahngraben	Lützschena-Stahmeln
Am Bahnhof	Miltitz
Am Barnecker Gut	Böhlitz-Ehrenberg
Am Bauernsteg	Lützschena-Stahmeln
Am Bauernteich	Paunsdorf
Am Bildersaal	Lützschena-Stahmeln
Am Bischofsholz	Liebertwolkwitz
Am Bogen	Marienbrunn
Am Börnchen	Lützschena-Stahmeln, Wahren
Am Brunnen	Lützschena-Stahmeln
Am Doppeladler	Holzhausen
Am Dorfplatz	Burghausen-Rückmarsdorf
Am Dorfteich	Althen-Kleinpösna
Am Eichberg	Thekla
Am Eichenbogen	Connewitz
Am Eichwinkel	Dölitz-Dösen
Am Elsterbogen	Hartmannsdorf-Knautnaundorf, Knautkleeberg-Knauthain
Am Elsterwehr	Lindenau, Zentrum-West
Am Eselshaus	Lützschena-Stahmeln
Am Eulengraben	Liebertwolkwitz
Am Exer	Lindenthal, Lützschena-Stahmeln
Am Exerzierplatz	Lützschena-Stahmeln
Am Feld	Seehausen
Am Feldrain	Althen-Kleinpösna
Am Fischerhaus	Wahren
Am Flößgen	Burghausen-Rückmarsdorf
Am Flügelrad	Eutritzsch
Am Freibad	Lindenthal
Am Fuchsbau	Connewitz
Am Gänseanger	Liebertwolkwitz
Am Gartenverein	Wiederitzsch
Am Geleinholz	Meusdorf
Am Gothischen Bad	Schönefeld-Abtnaundorf, Zentrum-Ost
Am Grund	Lausen-Grünau
Am Gundorfer Teich	Böhlitz-Ehrenberg
Am Güterring	Anger-Crottendorf
Am Gutspark	Mölkau
Am Hallischen Tor	Zentrum
Am Hasenberg	Mölkau
Am Hasengraben	Seehausen
Am Hegeanger	Lausen-Grünau
Am Hirtenhaus	Wahren
Am Hohen Graben	Baalsdorf
Am Hohlweg	Lützschena-Stahmeln
Am Hufeisen	Burghausen-Rückmarsdorf
Am Jägerhaus	Lützschena-Stahmeln
Am Kanal	Neulindenau
Am Kellerberg	Plaußig-Portitz
Am Keulenberg	Thekla
Am Kirschberg	Grünau-Mitte
Am kleinen Feld	Grünau-Nord, Lausen-Grünau
Am Klosterfeld	Mölkau
Am Klucksgraben	Knautkleeberg-Knauthain
Am krummen Graben	Knautkleeberg-Knauthain
Am Künstlerbogen	Plaußig-Portitz
Am langen Felde	Leutzsch
Am langen Teiche	Plaußig-Portitz
Am Lindeneck	Lausen-Grünau
Am Lindenhof	Connewitz
Am Lösegraben	Plaußig-Portitz
Am Luppedeich	Möckern
Am Markt	Böhlitz-Ehrenberg
Am Meilenstein	Wahren
Am Mückenschlößchen	Zentrum-Nordwest
Am Mühlengrund	Lausen-Grünau
Am Mühlgraben	Knautkleeberg-Knauthain
Am Niederholz	Liebertwolkwitz
Am Ochsenwinkel	Althen-Kleinpösna
Am Osthang	Burghausen-Rückmarsdorf
Am Park	Seehausen
Am Parkteich	Gohlis-Mitte
Am Pfarrfelde	Wahren
Am Pfefferbrückchen	Möckern
Am Pfingstanger	Lützschena-Stahmeln
Am Pösgraben	Althen-Kleinpösna
Am Rain	Burghausen-Rückmarsdorf
Am Rennsteig	Burghausen-Rückmarsdorf
Am Ring	Seehausen
Am Ritterschlößchen	Böhlitz-Ehrenberg, Leutzsch
Am Rodeland	Liebertwolkwitz
Am Röschenhof	Paunsdorf
Am Russischen Garten	Lützschena-Stahmeln
Am Sandberg	Wiederitzsch
Am Schäferhügel	Mölkau
Am Schaukelgraben	Liebertwolkwitz
Am Schenkberg	Plaußig-Portitz, Thekla
Am Schwalbennest	Schönau
Am Silo	Lausen-Grünau
Am Sommerfeld	Engelsdorf, Paunsdorf
Am Sonneneck	Lausen-Grünau
Am Sonnenwinkel	Lindenthal
Am Sperrtor	Burghausen-Rückmarsdorf
Am Sportforum	Zentrum-Nordwest
Am Sportpark	Böhlitz-Ehrenberg, Leutzsch
Am Sportplatz	Hartmannsdorf-Knautnaundorf
Am Stausee	Hartmannsdorf-Knautnaundorf, Knautkleeberg-Knauthain
Am Tanzplan	Leutzsch
Am Teich	Lausen-Grünau
Am Teilungswehr	Connewitz, Großzschocher
Am Tore	Mockau-Süd
Am Turnplatz	Burghausen-Rückmarsdorf
Am Übergang	Grünau-Ost
Am Viadukt	Möckern
Am Volksgut	Engelsdorf
Am Vorwerk	Paunsdorf
Am Wassergraben	Lützschena-Stahmeln
Am Wasserschloß	Leutzsch
Am Wasserturm	Burghausen-Rückmarsdorf
Am Wasserwerk	Stötteritz
Am Wegekreuz	Thekla
Am Weiher	Knautkleeberg-Knauthain
Am Wiesenblick	Althen-Kleinpösna
Am Wiesengrund	Lausen-Grünau
Am Wolfswinkel	Connewitz
Am Zuckmantel	Wahren
Amalienstraße	Plagwitz
Amalie-Winter-Platz	Zentrum-Südost
Amazonstraße	Heiterblick
Amboldweg	Burghausen-Rückmarsdorf
Ambrosius-Barth-Platz	Stötteritz
Ameisenstraße	Großzschocher
Ammernplatz	Böhlitz-Ehrenberg
Ammernweg	Böhlitz-Ehrenberg
Amorbacher Straße	Grünau-Siedlung
Ampèreweg	Stötteritz
Amselgrund	Wiederitzsch
Amselhöhe	Liebertwolkwitz
Amselnest	Holzhausen
Amselstraße	Böhlitz-Ehrenberg
Amselweg	Seehausen
Amstetter Weg	Plaußig-Portitz
An den Birken	Burghausen-Rückmarsdorf
An den Krutschen	Burghausen-Rückmarsdorf
An den Linden	Burghausen-Rückmarsdorf
An den Pferdnerkabeln	Thekla
An den Platanen	Mölkau
An den Theklafeldern	Heiterblick, Paunsdorf
An den Tierkliniken	Zentrum-Südost
An der Alten Mühle	Seehausen
An der Alten Post	Miltitz
An der Autobahn	Seehausen
An der Badeanlage	Liebertwolkwitz
An der Bahn	Engelsdorf
An der Brauerei	Liebertwolkwitz
An der Brücke	Burghausen-Rückmarsdorf
An der Burgaue	Böhlitz-Ehrenberg
An der Eisenbahn	Liebertwolkwitz
An der Elster	Wahren
An der Fasanerie	Plaußig-Portitz
An der Feuerwache	Böhlitz-Ehrenberg
An der Feuerwehr	Lützschena-Stahmeln
An der Friedenseiche	Burghausen-Rückmarsdorf
An der Gänseweide	Holzhausen
An der Gärtnerei	Miltitz
An der Grundschule	Engelsdorf
An der Hainkirche	Lützschena-Stahmeln
An der Hauptstraße	Seehausen
An der Hebemärchte	Baalsdorf
An der Hufschmiede	Lindenthal
An der Kaninchenfarm	Burghausen-Rückmarsdorf
An der Kegelbahn	Burghausen-Rückmarsdorf
An der Kirche	Holzhausen
An der Kirchgasse	Miltitz
An der Kirschallee	Lützschena-Stahmeln
An der Kotsche	Lausen-Grünau
An der Lautsche	Lausen-Grünau
An der Lehde	Leutzsch
An der Luppe	Böhlitz-Ehrenberg, Leutzsch
An der Märchenwiese	Marienbrunn
An der Merseburger Straße	Burghausen-Rückmarsdorf
An der Meusdorfer Höhe	Holzhausen
An der Milchinsel	Zentrum-Ost
An der Mühle	Holzhausen
An der Mühlpleiße	Dölitz-Dösen
An der Parthe	Mockau-Nord, Mockau-Süd, Schönefeld-Abtnaundorf
An der Passage	Seehausen
An der Querbreite	Eutritzsch
An der Rehwiese	Burghausen-Rückmarsdorf
An der Rietzschke	Holzhausen
An der Salzstraße	Lützschena-Stahmeln
An der Sandgrube	Burghausen-Rückmarsdorf
An der Schäferei	Lützschena-Stahmeln
An der Schule	Lindenthal
An der Siedlung	Liebertwolkwitz
An der Spitze	Liebertwolkwitz
An der Streuobstwiese	Leutzsch
An der Tabaksmühle	Marienbrunn, Probstheida
An der Teichmühle	Burghausen-Rückmarsdorf
An der Telle	Wahren
An der Trift	Liebertwolkwitz
An der Verfassungslinde	Zentrum-Südost
An der Vogelweide	Burghausen-Rückmarsdorf
An der Weide	Althen-Kleinpösna
An der Wendeschleife	Hartmannsdorf-Knautnaundorf
An der Windmühle	Lindenthal
Andersenweg	Marienbrunn
Andreasstraße	Südvorstadt
Andromedaweg	Grünau-Nord
Anemonenweg	Mölkau
Angerstraße	Altlindenau
Anhalter Straße	Eutritzsch
Annaberger Straße	Möckern
Anna-Kuhnow-Straße	Reudnitz-Thonberg
Annenstraße	Volkmarsdorf
Ansbacher Straße	Grünau-Siedlung
Anton-Bruckner-Allee	Schleußig, Zentrum-Süd, Zentrum-West
Antonienstraße	Kleinzschocher, Neulindenau, Plagwitz
Anton-Zickmantel-Straße	Großzschocher
Anzengruberstraße	Probstheida
Apels Garten	Zentrum-West
Apelsteinweg	Baalsdorf
Apelstraße	Eutritzsch
Apitzschgasse	Connewitz
Apoldaer Weg	Schönau
Apostelstraße	Altlindenau
Aprikosenweg	Mölkau
Ariostiweg	Baalsdorf
Arlandbogen	Probstheida
Arminiushof	Marienbrunn
Arndts Hufen	Thekla
Arndtstraße	Südvorstadt
Arnikaweg	Lützschena-Stahmeln
Arno-Bruchardt-Straße	Wiederitzsch
Arnoldplatz	Engelsdorf
Arnoldstraße	Stötteritz
Arno-Nitzsche-Straße	Connewitz, Marienbrunn
Arnstädter Kehre	Schönau
Arthur-Hausmann-Straße	Eutritzsch
Arthur-Heidrich-Platz	Burghausen-Rückmarsdorf
Arthur-Hoffmann-Straße	Connewitz, Südvorstadt, Zentrum-Süd
Arthur-Nagel-Straße	Großzschocher
Arthur-Polenz-Straße	Holzhausen
Arthur-Thiele-Weg	Engelsdorf
Arthur-Winkler-Straße	Engelsdorf
Aschaffenburger Straße	Grünau-Siedlung
Aschenbrödelweg	Marienbrunn
Asternweg	Grünau-Ost
Atriumstraße	Neustadt-Neuschönefeld
Audorfstraße	Zentrum-Süd
Aue	Lützschena-Stahmeln, Wahren
Auenblick	Burghausen-Rückmarsdorf
Auenblickstraße	Lützschena-Stahmeln
Auengrund	Lützschena-Stahmeln
Auenhainer Straße	Dölitz-Dösen
Auenseestraße	Wahren
Auenstraße	Böhlitz-Ehrenberg
Auenweg	Miltitz
Auerbachplatz	Gohlis-Süd
Auerbachstraße	Connewitz
Auerhahnsteig	Knautkleeberg-Knauthain
Auf dem Colmberg	Holzhausen
Auf der Höhe	Lützschena-Stahmeln
August-Bebel-Platz	Engelsdorf
August-Bebel-Siedlung	Holzhausen
August-Bebel-Straße	Südvorstadt
Auguste-Hennig-Straße	Mölkau
Augustenstraße	Reudnitz-Thonberg
Auguste-Schmidt-Straße	Zentrum-Südost
Auguste-Schulze-Straße	Liebertwolkwitz
Augustinerstraße	Probstheida, Stötteritz
August-Knauer-Straße	Mölkau
August-Scheibe-Straße	Liebertwolkwitz
Augustusplatz	Zentrum, Zentrum-Ost, Zentrum-Südost
Aurelienstraße	Lindenau
Auschwitzer Straße	Wiederitzsch
Außenring	Wiederitzsch
Äußere Auenblickstraße	Lützschena-Stahmeln
Äußere Friedrich-Naumann-Straße	Lindenthal
Äußere Mühlenstraße	Lützschena-Stahmeln
Äußere Raustraße	Lindenthal
Äußerer Zeisigweg	Lindenthal
Azaleenstraße	Hartmannsdorf-Knautnaundorf
Azaleenweg	Holzhausen
Baaderstraße	Gohlis-Mitte, Gohlis-Nord
Baalsdorfer Anger	Baalsdorf
Baalsdorfer Straße	Baalsdorf, Engelsdorf, Holzhausen
Bachenpfad	Knautkleeberg-Knauthain
Bäckergasse	Seehausen
Badergasse	Liebertwolkwitz
Badeweg	Großzschocher
Baedekerstraße	Reudnitz-Thonberg
Bahnhofsallee	Liebertwolkwitz
Bahnhofstraße	Wiederitzsch
Bahnstraße	Lützschena-Stahmeln
Bahnweg	Hartmannsdorf-Knautnaundorf
Balderstraße	Thekla
Balzacstraße	Zentrum-Nord
Bamberger Straße	Grünau-Siedlung
Barbarastraße	Paunsdorf
Barbussestraße	Großzschocher
Barclayweg	Meusdorf
Bärenfelser Weg	Grünau-Siedlung
Barfußgäßchen	Zentrum
Bärlauchweg	Connewitz
Barnecker Straße	Böhlitz-Ehrenberg
Barnet-Licht-Platz	Reudnitz-Thonberg
Basedowstraße	Connewitz
Basilikumweg	Wiederitzsch
Basteistraße	Lausen-Grünau
Bästleinstraße	Schönefeld-Ost
Bauerngrabenstraße	Leutzsch
Bauernwinkel	Kleinzschocher
Bauhofstraße	Zentrum-Südost
Baumannstraße	Kleinzschocher
Baumeister-Günther-Straße	Engelsdorf
Baumeyerstraße	Stötteritz
Baumgarten-Crusius-Straße	Leutzsch
Baumschulenweg	Holzhausen
Baunackstraße	Schönefeld-Abtnaundorf
Bausestraße	Neulindenau
Bautzmannstraße	Volkmarsdorf
Bautzner Straße	Schönefeld-Ost
Bayreuther Straße	Grünau-Mitte
Bayrischer Platz	Zentrum-Süd, Zentrum-Südost
Bechsteinweg	Marienbrunn
Beckerstraße	Neulindenau
Beethovenstraße	Zentrum-Süd
Begonienweg	Engelsdorf
Bei der Krähenhütte	Dölitz-Dösen
Beipertstraße	Schleußig
Belterstraße	Schönefeld-Ost
Benedekring	Möckern
Benediktusstraße	Leutzsch
Benedixstraße	Gohlis-Mitte
Bennigsenstraße	Volkmarsdorf
Berberitzenstraße	Paunsdorf
Bergahornstraße	Engelsdorf
Bergerstraße	Schönefeld-Abtnaundorf
Berggartenstraße	Gohlis-Süd
Berggartenweg	Lützschena-Stahmeln
Bergstraße	Neustadt-Neuschönefeld
Bergweg	Seehausen
Berkaer Weg	Grünau-Siedlung
Berlichingenweg	Knautkleeberg-Knauthain
Berliner Straße	Eutritzsch, Zentrum-Nord, Zentrum-Ost
Bernadotteweg	Meusdorf
Bernburger Straße	Eutritzsch
Bernhard-Göring-Straße	Connewitz, Südvorstadt, Zentrum-Süd
Bernhardiplatz	Neustadt-Neuschönefeld
Bernhard-Kellermann-Straße	Lößnig
Bernhardstraße	Anger-Crottendorf, Sellerhausen-Stünz, Volkmarsdorf
Bernsteinstraße	Engelsdorf
Bertha-Beckmann-Weg	Engelsdorf
Berthastraße	Mockau-Süd
Bertolt-Brecht-Straße	Schönefeld-Ost
Beuchaer Straße	Anger-Crottendorf
Beuthstraße	Mockau-Nord, Mockau-Süd
Beyerleinstraße	Gohlis-Nord
Biberpfad	Knautkleeberg-Knauthain
Bibraer Weg	Grünau-Siedlung
Biedermannstraße	Connewitz
Bielastraße	Böhlitz-Ehrenberg
Bienenweg	Seehausen
Bienenwinkel	Heiterblick
Bienerstraße	Neulindenau
Bienitzblick	Burghausen-Rückmarsdorf
Bienitzstraße	Burghausen-Rückmarsdorf
Binsengrund	Thekla
Binzer Straße	Lausen-Grünau
Birkengasse	Seehausen
Birkenpilzweg	Knautkleeberg-Knauthain
Birkenring	Wiederitzsch
Birkenstraße	Lindenau
Birkenweg	Hartmannsdorf-Knautnaundorf
Birkhahnsteig	Knautkleeberg-Knauthain
Bisamstraße	Heiterblick
Bischofstraße	Leutzsch
Bismarckstraße	Großzschocher
Bistumsweg	Knautkleeberg-Knauthain
Bitterfelder Straße	Eutritzsch
Björneborgstraße	Lindenthal
Blanchardweg	Großzschocher
Blankenburger Straße	Grünau-Siedlung
Blaufichtenweg	Grünau-Siedlung
Blausternweg	Engelsdorf
Bleichertstraße	Gohlis-Süd
Blochmannstraße	Gohlis-Süd, Zentrum-Nord
Blochstraße	Heiterblick
Blücherstraße	Möckern
Blumenbogen	Liebertwolkwitz
Blumenstraße	Gohlis-Süd, Zentrum-Nord
Blumenweg	Wiederitzsch
Blümnerstraße	Schleußig
Blüthnerstraße	Leutzsch
BMW-Allee	Plaußig-Portitz, Seehausen, Thekla
Bochumer Straße	Mockau-Nord
Böcklinweg	Paunsdorf
Bockstraße	Probstheida
Bodenreformweg	Schönefeld-Ost
Bogenweg	Plaußig-Portitz
Bogislawstraße	Volkmarsdorf
Böhlitzer Mühle	Böhlitz-Ehrenberg
Böhmestraße	Gohlis-Süd
Bonhoefferstraße	Eutritzsch
Bontjes-van-Beek-Straße	Thekla
Borkumer Weg	Gohlis-Nord
Bormannstraße	Reudnitz-Thonberg
Bornaer Straße	Liebertwolkwitz
Bornaische Straße	Connewitz, Dölitz-Dösen, Lößnig
Borngasse	Anger-Crottendorf, Sellerhausen-Stünz
Borsdorfer Straße	Anger-Crottendorf
Bösdorfer Ring	Hartmannsdorf-Knautnaundorf
Bösdorfer Straße	Knautkleeberg-Knauthain
Bösenbergstraße	Miltitz
Bosestraße	Zentrum-West
Bothestraße	Gohlis-Süd
Böttchergäßchen	Zentrum
Böttcherweg	Lützschena-Stahmeln
Böttgerstraße	Paunsdorf
Bowmanstraße	Altlindenau, Lindenau
Brackestraße	Lausen-Grünau
Brahestraße	Schönefeld-Ost
Brahmsplatz	Zentrum-Süd
Brambacher Straße	Grünau-Siedlung
Brandenburger Straße	Schönefeld-Abtnaundorf, Zentrum-Ost
Brandensteinstraße	Burghausen-Rückmarsdorf
Brandesweg	Lausen-Grünau
Brandiser Straße	Baalsdorf, Engelsdorf
Brandstraße	Connewitz
Brandvorwerkstraße	Südvorstadt
Brauereistraße	Großzschocher
Braunschweiger Straße	Gohlis-Nord
Braunstraße	Schönefeld-Ost
Braustraße	Zentrum-Süd
Brehmestraße	Leutzsch
Breisgaustraße	Grünau-Mitte
Breite Allee	Zentrum-Nordwest
Breite Straße	Anger-Crottendorf, Reudnitz-Thonberg
Breitenfelder Straße	Gohlis-Mitte, Gohlis-Süd
Breiteweg	Holzhausen
Breitkopfstraße	Reudnitz-Thonberg
Breitschuhstraße	Großzschocher
Bremer Straße	Gohlis-Nord
Bremer Weg	Wiederitzsch
Brentanostraße	Wiederitzsch
Breslauer Straße	Stötteritz
Bretschneiderstraße	Schleußig
Breunsdorffstraße	Thekla
Brockhausstraße	Schleußig
Brodauer Weg	Eutritzsch
Brombeerweg	Knautkleeberg-Knauthain
Brommeweg	Reudnitz-Thonberg
Brösigkestraße	Wiederitzsch
Brückenstraße	Großzschocher
Brückwaldstraße	Sellerhausen-Stünz
Brüderstraße	Zentrum-Süd, Zentrum-Südost
Brühl	Zentrum
Bruhnsstraße	Sellerhausen-Stünz
Brunhildstraße	Lößnig
Brunnenstraße	Liebertwolkwitz
Brunnenweg	Plaußig-Portitz
Brünner Straße	Grünau-Ost, Kleinzschocher, Neulindenau
Brunsweg	Probstheida
Buchener Straße	Böhlitz-Ehrenberg
Buchengasse	Seehausen
Buchenwaldstraße	Wiederitzsch
Buchenweg	Mölkau
Bücherstraße	Heiterblick
Buchfinkenweg	Wahren
Bucksdorffstraße	Möckern
Buckyweg	Probstheida
Bühringstraße	Anger-Crottendorf
Bülowstraße	Volkmarsdorf
Bünaustraße	Eutritzsch
Burgauenstraße	Böhlitz-Ehrenberg
Bürgerstraße	Dölitz-Dösen
Burghausener Straße	Böhlitz-Ehrenberg
Burgplatz	Zentrum
Burgstädter Straße	Connewitz
Burgstraße	Zentrum
Burgundenstraße	Stötteritz
Buschenaustraße	Eutritzsch
Bussardweg	Burghausen-Rückmarsdorf
Bussestraße	Neustadt-Neuschönefeld
Buttergasse	Großzschocher
Büttnerstraße	Zentrum-Ost
Büttnerweg	Knautkleeberg-Knauthain
Cäcilienstraße	Reudnitz-Thonberg
Calaustraße	Schleußig
Calderónweg	Meusdorf
Calvisiusstraße	Altlindenau
Campestraße	Kleinzschocher
Capastraße	Altlindenau
Carlebachstraße	Mockau-Nord
Carl-Hampel-Platz	Probstheida
Carl-Hinné-Straße	Böhlitz-Ehrenberg
Carl-Maria-von-Weber-Straße	Zentrum-West
Carl-Meyer-Straße	Böhlitz-Ehrenberg
Carl-Munde-Straße	Liebertwolkwitz
Carl-Weichelt-Straße	Großzschocher
Carpzovstraße	Reudnitz-Thonberg
Carusstraße	Plaußig-Portitz
Cervantesweg	Meusdorf
Cézanneweg	Meusdorf
Chamissoweg	Möckern
Charlottenstraße	Reudnitz-Thonberg
Charlottenweg	Lützschena-Stahmeln
Chemnitzer Straße	Meusdorf, Probstheida
Cheruskerstraße	Stötteritz
Chopinstraße	Zentrum-Ost
Christian-Ferkel-Straße	Möckern
Christian-Grunert-Straße	Holzhausen
Christian-Schmid-Straße	Engelsdorf
Christianstraße	Zentrum-Nordwest
Christian-Wille-Weg	Baalsdorf
Christoph-Probst-Straße	Möckern
Christoph-Schubert-Straße	Lindenthal
Cichoriusstraße	Anger-Crottendorf
Clara-Wieck-Straße	Schönefeld-Abtnaundorf
Clara-Zetkin-Straße	Burghausen-Rückmarsdorf
Claudiusstraße	Gohlis-Mitte
Clausewitzstraße	Möckern
Claußbruchstraße	Wahren
Clemens-Thieme-Straße	Liebertwolkwitz
Cletzener Weg	Eutritzsch
Cleudner Straße	Thekla
Coblenzer Straße	Zentrum-West
Cocciusstraße	Knautkleeberg-Knauthain
Cohnheimstraße	Probstheida
Colberger Weg	Grünau-Siedlung
Colmbergsiedlung	Holzhausen
Colmblick	Holzhausen
Comeniusstraße	Neustadt-Neuschönefeld
Connewitzer Straße	Probstheida
Coppiplatz	Gohlis-Mitte
Coppistraße	Eutritzsch, Gohlis-Mitte
Corinthstraße	Gohlis-Mitte
Corneliusweg	Paunsdorf
Corotweg	Meusdorf
Cöthner Straße	Gohlis-Süd
Cottaweg	Altlindenau
Cradefelder Straße	Plaußig-Portitz
Cranachstraße	Altlindenau
Credéstraße	Neulindenau
Crednerstraße	Probstheida
Crensitzer Weg	Eutritzsch
Creuzigerstraße	Kleinzschocher
Cröberner Straße	Dölitz-Dösen
Crottendorfer Straße	Reudnitz-Thonberg
Crusiusstraße	Reudnitz-Thonberg
Cunnersdorfer Straße	Sellerhausen-Stünz
Curiestraße	Zentrum-Südost
Curschmannstraße	Probstheida
Czermaks Garten	Zentrum-Ost
Dachauer Straße	Wiederitzsch
Dachsstraße	Heiterblick, Paunsdorf
Dahlienstraße	Grünau-Ost
Dähnhardtstraße	Wahren
Damaschkebogen	Liebertwolkwitz
Damaschkestraße	Wahren
Dammstraße	Schleußig
Dammteichweg	Mölkau
Dankwartstraße	Lößnig
Dantestraße	Möckern
Darwinstraße	Thekla
Daumierstraße	Gohlis-Mitte
Däumlingsweg	Marienbrunn
Dauthestraße	Reudnitz-Thonberg
Dautheweg	Reudnitz-Thonberg
Davidstraße	Zentrum-West
Debyestraße	Heiterblick
Defoestraße	Möckern
Defreggerweg	Paunsdorf
Deiwitzweg	Lausen-Grünau
Delitzscher Landstraße	Lindenthal, Wiederitzsch
Delitzscher Straße	Eutritzsch, Zentrum-Nord
Demetriusweg	Plaußig-Portitz
Demmeringstraße	Altlindenau, Neulindenau
Denkmalsallee	Lindenthal
Denkmalsblick	Marienbrunn
Dennewitzer Straße	Lindenthal
Dessauer Straße	Eutritzsch
Deutsche Einheit	Liebertwolkwitz
Deutscher Platz	Zentrum-Südost
Deutsches Heim	Mölkau
Diakonissenstraße	Altlindenau
Diamantstraße	Engelsdorf
Diderotstraße	Möckern
Die Linie	Connewitz
Diebitschweg	Meusdorf
Dieselstraße	Eutritzsch
Dieskaustraße	Großzschocher, Kleinzschocher, Knautkleeberg-Knauthain
Diesterwegstraße	Eutritzsch
Dietzgenstraße	Gohlis-Mitte
Diezmannstraße	Kleinzschocher
Dimitroffstraße	Zentrum-Süd
Dimpfelstraße	Schönefeld-Abtnaundorf
Dingolfinger Straße	Seehausen, Thekla
Dinkelweg	Lausen-Grünau
Dinterstraße	Eutritzsch, Gohlis-Mitte
Dittrichring	Zentrum, Zentrum-West
Dittrichstraße	Liebertwolkwitz
Döbelner Straße	Stötteritz
Dochturowweg	Meusdorf
Dohlenweg	Seehausen
Dohnanyistraße	Zentrum-Ost
Dohnaweg	Marienbrunn
Dölitzer Straße	Connewitz
Döllingstraße	Paunsdorf
Dölziger Straße	Böhlitz-Ehrenberg, Burghausen-Rückmarsdorf
Dölziger Weg	Schönau
Dombrowskistraße	Wiederitzsch
Donarstraße	Thekla
Don-Carlos-Straße	Plaußig-Portitz
Dorettenring	Lützschena-Stahmeln
Dorfplatz	Miltitz
Dorfstraße	Althen-Kleinpösna
Döringstraße	Mockau-Süd
Dornbergerstraße	Volkmarsdorf
Dornburger Weg	Schönau
Dornröschenweg	Marienbrunn
Dorotheenplatz	Zentrum-West
Dorotheenring	Liebertwolkwitz
Dörrienstraße	Zentrum-Ost
Dorstigstraße	Stötteritz
Dortmunder Straße	Mockau-Nord, Mockau-Süd
Dösner Straße	Dölitz-Dösen, Probstheida
Dösner Weg	Zentrum-Südost
Dostojewskistraße	Mockau-Nord
Dr.-Hermann-Duncker-Straße	Neulindenau
Dr.-Margarete-Blank-Straße	Engelsdorf
Dr.-Wilhelm-Külz-Straße	Mölkau
Dreiecksweg	Großzschocher
Dreilindenstraße	Altlindenau
Drescherweg	Lindenthal
Dresdner Straße	Neustadt-Neuschönefeld, Reudnitz-Thonberg, Zentrum-Ost, Zentrum-Südost
Drosselgrund	Wiederitzsch
Drosselhang	Mölkau
Drosselnest	Holzhausen
Drosselweg	Seehausen
Druckereistraße	Lützschena-Stahmeln
Dübener Landstraße	Eutritzsch
Dudweiler Straße	Anger-Crottendorf
Dufourstraße	Zentrum-Süd
Durch die Felder	Althen-Kleinpösna
Dürnsteiner Weg	Plaußig-Portitz
Dürrenberger Straße	Altlindenau
Dürrplatz	Südvorstadt
Dürrstraße	Lößnig
Dybwadstraße	Sellerhausen-Stünz
Ebenholzweg	Böhlitz-Ehrenberg
Ebereschenweg	Wiederitzsch
Eberlestraße	Engelsdorf
Eberpfad	Knautkleeberg-Knauthain
Ecksteinstraße	Connewitz
Edisonstraße	Engelsdorf
Edlichstraße	Volkmarsdorf
Edmond-Kaiser-Straße	Lindenthal, Wahren
Eduardstraße	Plagwitz
Eduard-von-Hartmann-Straße	Gohlis-Mitte, Gohlis-Nord
Edvard-Grieg-Allee	Zentrum-West
Eferdinger Straße	Plaußig-Portitz
Egelstraße	Zentrum-Ost
Eggebrechtstraße	Zentrum-Südost
Egon-Erwin-Kisch-Weg	Stötteritz
Ehrenberger Straße	Burghausen-Rückmarsdorf
Ehrensteinstraße	Gohlis-Süd, Zentrum-Nord
Eibenweg	Mölkau
Eichbergstraße	Thekla
Eichelbaumstraße	Großzschocher
Eichendorffstraße	Connewitz
Eichenweg	Wiederitzsch
Eichhörnchenweg	Heiterblick, Paunsdorf
Eichlerstraße	Reudnitz-Thonberg
Eidechsenweg	Heiterblick
Eigene Scholle	Burghausen-Rückmarsdorf
Eigenheimstraße	Dölitz-Dösen
Eilenburger Straße	Reudnitz-Thonberg
Einertstraße	Neustadt-Neuschönefeld
Einsteinstraße	Plagwitz
Eisenacher Straße	Gohlis-Süd
Eisenbahnstraße	Neustadt-Neuschönefeld, Sellerhausen-Stünz, Volkmarsdorf
Eisenberger Ring	Schönau
Eisenschmidtplatz	Holzhausen
Eitingonstraße	Zentrum-Nordwest
Elchweg	Knautkleeberg-Knauthain
Elfenweg	Marienbrunn
Elisabeth-Schumacher-Straße	Paunsdorf, Sellerhausen-Stünz
Elisabethstraße	Volkmarsdorf
Ellernweg	Leutzsch
Elli-Voigt-Straße	Möckern
Elsa-Brändström-Straße	Schönefeld-Abtnaundorf
Elsastraße	Neustadt-Neuschönefeld
Elsbethstraße	Gohlis-Süd
Elsteraue	Lützschena-Stahmeln
Elsterberg	Lützschena-Stahmeln
Elsterblick	Möckern
Elstergarten	Lützschena-Stahmeln
Elstermühlweg	Lützschena-Stahmeln
Elsterstraße	Zentrum-West
Elsterweg	Mölkau
Emil-Altner-Weg	Holzhausen
Emil-Fuchs-Straße	Zentrum-Nordwest
Emilienstraße	Zentrum-Süd
Emil-Kluge-Straße	Liebertwolkwitz
Emil-März-Straße	Wiederitzsch
Emil-Schubert-Straße	Schönefeld-Abtnaundorf
Emil-Teich-Straße	Knautkleeberg-Knauthain
Emmausstraße	Sellerhausen-Stünz
Endersstraße	Lindenau
Endnerstraße	Gohlis-Süd
Engelmannstraße	Sellerhausen-Stünz
Engelsdorfer Park	Engelsdorf
Engelsdorfer Straße	Engelsdorf, Mölkau
Engelsdorfer Weg	Mölkau
Engertstraße	Lindenau, Plagwitz
Entsbergerstraße	Böhlitz-Ehrenberg
Enzianweg	Wiederitzsch
Erdmannstraße	Plagwitz
Erfurter Straße	Gohlis-Süd
Erhardstraße	Schleußig
Erich-Köhn-Straße	Altlindenau
Erich-Mühsam-Weg	Meusdorf
Erich-Thiele-Straße	Lindenthal
Erich-Weinert-Straße	Zentrum-Nord
Erich-Zeigner-Allee	Lindenau, Plagwitz
Erika-von-Brockdorff-Straße	Möckern
Erikenstraße	Hartmannsdorf-Knautnaundorf
Erkerhof	Mockau-Süd
Erlanger Straße	Grünau-Siedlung
Erlenstraße	Zentrum-Nord
Erlenweg	Wiederitzsch
Erlenzeisigweg	Böhlitz-Ehrenberg
Erlkönigweg	Marienbrunn
Ernestistraße	Connewitz
Ernst-Guhr-Straße	Engelsdorf
Ernst-Haeckel-Straße	Wiederitzsch
Ernst-Hasse-Straße	Wahren
Ernst-Keil-Straße	Neulindenau
Ernst-Kießig-Straße	Wiederitzsch
Ernst-Meier-Straße	Großzschocher
Ernst-Mey-Straße	Plagwitz
Ernst-Pinkert-Straße	Zentrum-Nord
Ernst-Schneller-Straße	Zentrum-Süd
Ernst-Sommerlath-Weg	Connewitz
Ernst-Toller-Straße	Lößnig
Eschenweg	Burghausen-Rückmarsdorf
Espenhainer Straße	Dölitz-Dösen
Espenweg	Miltitz
Essener Straße	Eutritzsch, Mockau-Nord
Etkar-André-Straße	Gohlis-Mitte
Etzelstraße	Lößnig
Eutritzscher Markt	Eutritzsch
Eutritzscher Straße	Zentrum-Nord
Eva-Maria-Buch-Straße	Thekla
Eythraer Straße	Kleinzschocher
Eythraer Weg	Hartmannsdorf-Knautnaundorf
Eythstraße	Eutritzsch
Fabrikstraße	Böhlitz-Ehrenberg
Falkensteinstraße	Großzschocher
Falkenweg	Burghausen-Rückmarsdorf
Falladastraße	Möckern
Falterstraße	Heiterblick
Faradaystraße	Möckern
Färberstraße	Zentrum-Nordwest
Farnweg	Mockau-Süd
Fasanenhöhe	Liebertwolkwitz
Fasanenhügel	Baalsdorf
Fasanenpfad	Knautkleeberg-Knauthain
Fasanenweg	Mölkau
Fechnerstraße	Gohlis-Süd
Fehmarner Straße	Möckern
Feldahornweg	Wiederitzsch
Feldblumenweg	Lausen-Grünau
Feldhasenweg	Heiterblick
Feldlerchenweg	Böhlitz-Ehrenberg
Feldstraße	Holzhausen, Probstheida
Feldweg	Anger-Crottendorf
Felsenbirnenstraße	Paunsdorf
Felsenkellerstraße	Lindenau
Fenchelweg	Wiederitzsch
Ferdinand-Freiligrath-Straße	Wiederitzsch
Ferdinand-Gruner-Straße	Lindenthal
Ferdinand-Jost-Straße	Stötteritz
Ferdinand-Lassalle-Straße	Zentrum-West
Ferdinand-Rhode-Straße	Zentrum-Süd
Feuerbachstraße	Zentrum-Nordwest
Feuerbachweg	Paunsdorf
Fichtenstraße	Mölkau
Fichtesiedlung	Wiederitzsch
Fichtestraße	Südvorstadt
Finkengrund	Wiederitzsch
Finkensteig	Wahren
Finkenweg	Holzhausen
Fleckensteiner Weg	Möckern
Fleißnerstraße	Gohlis-Mitte
Flemmingstraße	Altlindenau
Fliederhof	Schönefeld-Abtnaundorf
Fliederweg	Liebertwolkwitz
Flinzerstraße	Stötteritz
Flöhaer Straße	Thekla
Floraweg	Dölitz-Dösen
Florian-Geyer-Platz	Knautkleeberg-Knauthain
Flößenstraße	Wahren
Floßplatz	Zentrum-Süd
Fockestraße	Connewitz, Südvorstadt
Fontanestraße	Probstheida
Föpplstraße	Schönefeld-Ost
Forchheimer Straße	Grünau-Siedlung
Forsetistraße	Thekla
Forststraße	Plagwitz
Forstweg	Böhlitz-Ehrenberg
Fortunabadstraße	Knautkleeberg-Knauthain
Franckestraße	Anger-Crottendorf
Frankenheimer Weg	Schönau
Frankenweg	Böhlitz-Ehrenberg
Franz-Flemming-Straße	Altlindenau, Leutzsch
Franz-Mehring-Straße	Gohlis-Mitte, Gohlis-Nord
Franzosenallee	Probstheida
Franzosenfeld	Burghausen-Rückmarsdorf
Franz-Schlobach-Straße	Böhlitz-Ehrenberg
Franz-Schubert-Platz	Zentrum-West
Franz-Schubert-Weg	Holzhausen
Frau-Holle-Weg	Marienbrunn
Fraunhoferstraße	Böhlitz-Ehrenberg
Freesienweg	Hartmannsdorf-Knautnaundorf
Fregestraße	Zentrum-Nordwest
Freiberger Straße	Thekla
Freiligrathplatz	Gohlis-Mitte
Freirodaer Straße	Möckern
Freirodaer Weg	Lützschena-Stahmeln
Freisinger Weg	Miltitz
Frettchenweg	Knautkleeberg-Knauthain
Freundschaftsring	Althen-Kleinpösna
Frickestraße	Zentrum-Nord
Fridtjof-Nansen-Straße	Schönefeld-Abtnaundorf
Friedensstraße	Gohlis-Süd
Friederikenstraße	Dölitz-Dösen
Friedhofstraße	Liebertwolkwitz
Friedhofsweg	Probstheida
Friedrich-Bosse-Straße	Möckern, Wahren
Friedrich-Dittes-Straße	Anger-Crottendorf
Friedrich-Ebert-Straße	Zentrum-Nordwest, Zentrum-West
Friedrich-Kram-Weg	Schönefeld-Abtnaundorf
Friedrich-List-Platz	Zentrum-Ost
Friedrich-List-Straße	Althen-Kleinpösna
Friedrich-Ludwig-Jahn-Straße	Miltitz
Friedrich-Naumann-Straße	Wahren
Friedrich-Schmidt-Straße	Großzschocher
Friedrichshafner Straße	Mockau-Nord, Mockau-Süd
Friedrichstraße	Zentrum-Südost
Friedrich-Wolf-Straße	Schönefeld-Ost
Friesenstraße	Altlindenau, Leutzsch
Friesenweg	Engelsdorf
Fritz-Hanschmann-Straße	Reudnitz-Thonberg
Fritz-Krebs-Straße	Liebertwolkwitz
Fritz-Reuter-Straße	Wiederitzsch
Fritz-Schmenkel-Straße	Gohlis-Nord
Fritz-Seger-Straße	Gohlis-Süd
Fritz-Siemon-Straße	Schönefeld-Ost
Fritz-Simonis-Straße	Möckern
Fritz-Zalisz-Straße	Holzhausen
Fröbelstraße	Wiederitzsch
Frohburger Straße	Connewitz
Frommannstraße	Reudnitz-Thonberg
Fröschelstraße	Reudnitz-Thonberg
Froschkönigweg	Marienbrunn
Froschweg	Heiterblick
Fuchshainer Straße	Reudnitz-Thonberg
Fuchspfad	Knautkleeberg-Knauthain
Fucikstraße	Lindenthal, Möckern
Fuggerstraße	Wiederitzsch
Fullaweg	Thekla
Funkenburgstraße	Zentrum-Nordwest
Furnierweg	Böhlitz-Ehrenberg
Fürther Straße	Grünau-Siedlung
Gabelsbergerstraße	Neustadt-Neuschönefeld
Galileistraße	Möckern
Gambrinusstraße	Großzschocher
Ganghoferstraße	Probstheida
Gänseblümchenweg	Wiederitzsch
Garskestraße	Schönau
Gartenbogen	Liebertwolkwitz
Gartengrund	Böhlitz-Ehrenberg
Gartenstraße	Engelsdorf
Gartenweg	Hartmannsdorf-Knautnaundorf
Gartenwinkel	Lindenthal
Gärtnereiweg	Lindenthal
Gärtnergasse	Liebertwolkwitz
Gärtnerstraße	Grünau-Ost, Kleinzschocher
Gärtnerweg	Wiederitzsch
Gaschwitzer Straße	Connewitz
Gaswerksweg	Engelsdorf
Gaudigplatz	Zentrum-Süd
Gaußstraße	Leutzsch
Gebrüder-Weber-Weg	Probstheida
Gedikestraße	Eutritzsch
Geibelstraße	Eutritzsch, Gohlis-Mitte, Gohlis-Süd, Zentrum-Nord
Geißblattstraße	Paunsdorf
Geißlerstraße	Volkmarsdorf
Geithainer Straße	Engelsdorf, Paunsdorf, Sellerhausen-Stünz
Gellertplatz	Altlindenau
Gellertstraße	Burghausen-Rückmarsdorf
Gemeindeamtsstraße	Altlindenau
George-Bähr-Straße	Sellerhausen-Stünz
Georg-Fischer-Straße	Großzschocher
Georg-Große-Straße	Engelsdorf
Georg-Herwegh-Straße	Wiederitzsch
Georgiring	Zentrum, Zentrum-Ost
Georg-Maurer-Straße	Dölitz-Dösen, Lößnig
Georgplatz	Altlindenau
Georg-Reichardt-Straße	Miltitz
Georg-Schumann-Straße	Gohlis-Süd, Lützschena-Stahmeln, Möckern, Wahren, Zentrum-Nord
Georg-Schwarz-Straße	Altlindenau, Leutzsch
Geraer Straße	Altlindenau
Geranienweg	Holzhausen
Gerberstraße	Zentrum-Nord
Gerhard-Ellrodt-Straße	Großzschocher, Lausen-Grünau
Gerhard-Langner-Weg	Probstheida, Stötteritz
Gerhardstraße	Plagwitz
Gerichtsweg	Reudnitz-Thonberg, Zentrum-Südost
Gerlindeweg	Lößnig
Germannstraße	Mölkau
Gerstäckerstraße	Möckern
Gerstenweg	Wiederitzsch
Gersterstraße	Dölitz-Dösen, Lößnig
Gerte	Althen-Kleinpösna
Geschwister-Scholl-Straße	Miltitz
Gesnerstraße	Lützschena-Stahmeln
Getreidegasse	Liebertwolkwitz
Getzelauer Straße	Dölitz-Dösen
Geutebrückstraße	Sellerhausen-Stünz
Gewandgäßchen	Zentrum
Geyerstraße	Reudnitz-Thonberg
Giebnerstraße	Dölitz-Dösen
Gießerstraße	Kleinzschocher, Lindenau, Plagwitz
Gildemeisterring	Probstheida
Ginsterstraße	Paunsdorf
Giordano-Bruno-Straße	Großzschocher
Giselherstraße	Lößnig
Gittelstraße	Schönefeld-Ost
Gladiolenweg	Engelsdorf
Glafeystraße	Stötteritz
Gleisstraße	Plagwitz
Gleitsmannstraße	Knautkleeberg-Knauthain
Glesiener Straße	Möckern
Gletschersteinstraße	Stötteritz
Glockenstraße	Zentrum-Südost
Gmundener Weg	Plaußig-Portitz
Gneisenaustraße	Zentrum-Nord
Göbschelwitzer Straße	Seehausen
Göbschelwitzer Weg	Plaußig-Portitz
Goerdelerring	Zentrum, Zentrum-Nordwest, Zentrum-West
Goetheplatz	Böhlitz-Ehrenberg
Goethesteig	Dölitz-Dösen
Goethestraße	Zentrum
Goetheweg	Mölkau
Goetzstraße	Altlindenau
Gogolstraße	Mockau-Nord
Gohliser Straße	Gohlis-Süd, Zentrum-Nord
Göhrenzer Straße	Knautkleeberg-Knauthain
Göhrenzer Weg	Lausen-Grünau
Goldacher Straße	Miltitz
Goldammerweg	Wahren
Goldene Hufe	Heiterblick
Goldglöckchenstraße	Paunsdorf
Goldoniweg	Meusdorf
Goldrutenweg	Großzschocher
Goldschmidtstraße	Zentrum-Südost
Goldsternstraße	Paunsdorf
Goldulmenweg	Miltitz
Gontardweg	Mockau-Süd
Gontscharowstraße	Mockau-Nord
Gorbitzer Straße	Dölitz-Dösen, Meusdorf, Probstheida
Gorkistraße	Schönefeld-Abtnaundorf, Schönefeld-Ost
Görlitzer Straße	Eutritzsch
Gortschakoffweg	Meusdorf
Göschenstraße	Reudnitz-Thonberg
Goslarer Straße	Gohlis-Nord
Göteborger Straße	Thekla
Gotenstraße	Stötteritz
Gothaer Straße	Gohlis-Süd
Gottfried-Jähnichen-Weg	Baalsdorf
Gottfried-Keller-Straße	Probstheida
Gottfried-Rentzsch-Weg	Baalsdorf
Gotthelfstraße	Probstheida
Gottlaßstraße	Wahren
Gottleubaer Straße	Thekla
Gottlieb-Schöne-Weg	Baalsdorf
Gottschalkstraße	Mölkau
Gottschallstraße	Eutritzsch, Gohlis-Mitte
Gottschedstraße	Zentrum-West
Gottscheinaer Weg	Plaußig-Portitz
Gotzkowskystraße	Neulindenau
Goyastraße	Zentrum-Nordwest
Grabaustraße	Leutzsch
Grabenweg	Liebertwolkwitz
Gräfestraße	Eutritzsch
Graffstraße	Neulindenau
Graf-Zeppelin-Ring	Mockau-Nord, Seehausen
Graßdorfer Straße	Volkmarsdorf
Grassistraße	Zentrum-Süd
Grasweg	Burghausen-Rückmarsdorf
Grauwackeweg	Großzschocher
Gregor-Fuchs-Straße	Anger-Crottendorf
Gregoriusstraße	Wahren
Gregoryplatz	Stötteritz
Greinerweg	Zentrum-Süd
Grenzstraße	Holzhausen
Grenzweg	Holzhausen, Liebertwolkwitz
Gretelweg	Marienbrunn
Gretschelstraße	Volkmarsdorf
Grillenstraße	Großzschocher
Grimmaische Straße	Zentrum
Grimmaischer Steinweg	Zentrum-Ost, Zentrum-Südost
Grimmweg	Marienbrunn
Groitzscher Straße	Neulindenau
Gröpplerstraße	Neulindenau
Großbeerener Straße	Lindenthal
Große Fleischergasse	Zentrum
Große Gartensiedlung	Engelsdorf
Großer Brockhaus	Zentrum-Ost
Großer Marktweg	Burghausen-Rückmarsdorf
Großmannstraße	Altlindenau
Großmiltitzer Straße	Grünau-Nord, Miltitz
Großpösnaer Straße	Liebertwolkwitz
Großsteinberger Straße	Stötteritz
Grünauer Allee	Grünau-Ost
Grünauer Blick	Burghausen-Rückmarsdorf
Grünbacher Weg	Grünau-Siedlung
Grundmannstraße	Eutritzsch
Grundstraße	Plaußig-Portitz
Grüne Gasse	Anger-Crottendorf
Grüner Bogen	Burghausen-Rückmarsdorf
Grüner Weg	Eutritzsch
Grüner Winkel	Lützschena-Stahmeln
Grunertstraße	Mockau-Süd
Grünewaldstraße	Zentrum-Süd, Zentrum-Südost
Grünfinkenweg	Böhlitz-Ehrenberg
Grunickestraße	Schönefeld-Ost
Gudrunstraße	Lößnig
Güldengossaer Straße	Liebertwolkwitz
Gundermannstraße	Paunsdorf
Gundorfer Kirchweg	Böhlitz-Ehrenberg
Gundorfer Straße	Burghausen-Rückmarsdorf
Gundoweg	Böhlitz-Ehrenberg
Günselstraße	Paunsdorf
Güntheritzer Weg	Eutritzsch
Güntherstraße	Altlindenau
Güntzstraße	Stötteritz
Gustav-Adolf-Allee	Lindenthal
Gustav-Adolf-Straße	Zentrum-Nordwest
Gustav-Esche-Straße	Leutzsch, Wahren
Gustav-Feilotter-Straße	Mölkau
Gustav-Freytag-Straße	Connewitz
Gustav-Kühn-Straße	Möckern
Gustav-Mahler-Straße	Zentrum-West
Gustav-Scheibe-Straße	Mölkau
Gustav-Schmoller-Straße	Wahren
Gustav-Schwabe-Platz	Stötteritz
Gutberletstraße	Mölkau
Gutenbergplatz	Zentrum-Südost
Gutenbergstraße	Böhlitz-Ehrenberg
Güterbahnhofstraße	Engelsdorf
Gutshofstraße	Böhlitz-Ehrenberg
GutsMuthsstraße	Lindenau
Gutsparkstraße	Paunsdorf
Gutsweg	Seehausen
Gypsbergstraße	Mockau-Nord
Hafenstraße	Schönau
Hafentor	Schönau
Haferkornstraße	Eutritzsch
Haferring	Wiederitzsch
Hafisweg	Meusdorf
Hagebuttenweg	Knautkleeberg-Knauthain
Hahnekamm	Zentrum-Ost
Hähnelstraße	Lindenau
Hahnemannstraße	Altlindenau
Hainbuchenstraße	Paunsdorf
Hainburger Weg	Plaußig-Portitz
Hainstraße	Zentrum
Hainveilchenweg	Paunsdorf
Halberstädter Straße	Gohlis-Mitte
Hallbergmooser Straße	Miltitz
Hallesche Straße	Lützschena-Stahmeln
Hamburger Straße	Eutritzsch
Hammerstraße	Connewitz
Hammstraße	Eutritzsch
Handelsplatz	Engelsdorf
Handelsring	Mockau-Nord, Seehausen
Handelsstraße	Seehausen
Händelstraße	Holzhausen
Handwerkerhof	Mölkau, Stötteritz
Hänicher Mühle	Lützschena-Stahmeln
Hänischstraße	Schönefeld-Ost
Hannoversche Straße	Gohlis-Nord
Hanns-Eisler-Straße	Anger-Crottendorf
Hans-Beimler-Straße	Möckern
Hans-Driesch-Straße	Altlindenau, Leutzsch, Zentrum-Nordwest
Hänselweg	Marienbrunn
Hans-Grade-Straße	Lützschena-Stahmeln
Hans-Marchwitza-Straße	Lößnig
Hans-Oster-Straße	Gohlis-Mitte, Gohlis-Nord
Hans-Otto-Straße	Lößnig
Hans-Poeche-Straße	Zentrum-Ost
Hans-Sachs-Straße	Anger-Crottendorf
Hans-Scholl-Straße	Holzhausen
Hans-Weigel-Straße	Engelsdorf
Happweg	Lindenthal
Harbigweg	Engelsdorf
Hardenbergstraße	Südvorstadt
Harkortstraße	Zentrum-Süd
Harnackstraße	Reudnitz-Thonberg
Harnischstraße	Probstheida
Harpstedter Straße	Engelsdorf
Härtelstraße	Zentrum-Süd
Hartmannsdorfer Straße	Kleinzschocher
Hartmannweg	Probstheida
Hartriegelstraße	Paunsdorf
Hartungstraße	Plaußig-Portitz
Hartzstraße	Eutritzsch
Haselnussweg	Mölkau
Haselstraße	Paunsdorf
Haselweg	Liebertwolkwitz
Hasenheide	Mölkau
Hasenholzweg	Leutzsch
Hasenpfad	Knautkleeberg-Knauthain
Hauckstraße	Sellerhausen-Stünz
Hauffweg	Marienbrunn
Hauptmannstraße	Zentrum-West
Hauptstraße	Holzhausen
Hauschildstraße	Altlindenau
Hausdorffweg	Gohlis-Mitte
Häuslergasse	Paunsdorf
Häußerstraße	Großzschocher
Haußmannstraße	Schleußig
Haydnstraße	Zentrum-Süd
Haynaer Weg	Lindenthal
Hebelstraße	Altlindenau
Heckenweg	Plaußig-Portitz
Hedwig-Burgheim-Straße	Gohlis-Nord
Hedwigstraße	Neustadt-Neuschönefeld
Hegelstraße	Gohlis-Mitte
Heidegraben	Lützschena-Stahmeln
Heidelbeerweg	Knautkleeberg-Knauthain
Heidelberger Straße	Grünau-Mitte
Heideweg	Hartmannsdorf-Knautnaundorf
Heilbronner Straße	Grünau-Mitte
Heilemannstraße	Connewitz
Heimdallstraße	Thekla
Heimteichstraße	Leutzsch
Heinickestraße	Eutritzsch
Heinkstraße	Schönefeld-Abtnaundorf
Heinrich-Büchner-Straße	Schönefeld-Ost
Heinrich-Budde-Straße	Gohlis-Mitte
Heinrich-Heine-Straße	Böhlitz-Ehrenberg
Heinrich-Kaps-Straße	Wiederitzsch
Heinrich-Mann-Straße	Gohlis-Nord
Heinrich-Mann-Weg	Meusdorf
Heinrich-Oelerich-Straße	Lützschena-Stahmeln
Heinrich-Schmidt-Straße	Schönefeld-Abtnaundorf
Heinrich-Schütz-Platz	Südvorstadt
Heinrichstraße	Reudnitz-Thonberg
Heinrich-Zille-Weg	Meusdorf
Heinrothstraße	Gohlis-Süd
Heinzelmannweg	Marienbrunn
Heinz-Kapelle-Straße	Eutritzsch
Heisenbergstraße	Heiterblick
Heiterblickallee	Heiterblick, Paunsdorf
Heiterblickstraße	Schönefeld-Abtnaundorf, Schönefeld-Ost
Helenenstraße	Dölitz-Dösen
Helgoländer Weg	Gohlis-Nord
Hellerstraße	Leutzsch
Hellriegelstraße	Böhlitz-Ehrenberg
Helmholtzstraße	Lindenau
Hempelstraße	Altlindenau
Hendelweg	Wahren
Henricistraße	Altlindenau
Henriettenstraße	Lindenau
Hentschelweg	Dölitz-Dösen
Herbartstraße	Anger-Crottendorf
Herbert-Bochow-Straße	Probstheida
Herbert-Thiele-Straße	Plaußig-Portitz
Herbstweg	Probstheida
Herderstraße	Connewitz
Herloßsohnstraße	Gohlis-Süd
Hermann-Brade-Straße	Mölkau
Hermann-Dorner-Straße	Lützschena-Stahmeln
Hermann-Keller-Straße	Wiederitzsch
Hermann-Liebmann-Straße	Neustadt-Neuschönefeld, Schönefeld-Abtnaundorf, Volkmarsdorf, Zentrum-Ost
Hermann-Löns-Straße	Mölkau
Hermann-Sander-Straße	Mölkau
Hermann-Schein-Straße	Dölitz-Dösen
Hermannstraße	Connewitz
Hermelinplatz	Heiterblick
Hermelinstraße	Heiterblick
Hermundurenstraße	Wahren
Herrenallee	Zentrum-Nordwest
Herrmann-Meyer-Straße	Kleinzschocher
Herrnhuter Straße	Anger-Crottendorf
Hersvelder Straße	Althen-Kleinpösna
Hertzstraße	Heiterblick
Herwigstraße	Lößnig
Herzberger Straße	Engelsdorf, Heiterblick
Herzenstraße	Mockau-Nord
Herzliyaplatz	Zentrum-Süd
Hessenstraße	Stötteritz
Hettelweg	Lößnig
Heubnerweg	Probstheida
Heuweg	Möckern
Hickmannstraße	Böhlitz-Ehrenberg
Hildburgstraße	Lößnig
Hildebrandstraße	Connewitz
Hildegardstraße	Volkmarsdorf
Hildeweg	Lößnig
Hillerstraße	Zentrum-West
Hilligerstraße	Mockau-Nord
Himbeerweg	Knautkleeberg-Knauthain
Hinrichsenstraße	Zentrum-Nordwest
Hinter dem Dorf	Plaußig-Portitz
Hinter dem Zuckelhausener Ring	Holzhausen
Hinter den Gärten	Lützschena-Stahmeln
Hinter der Kirche	Seehausen
Hirschfelder Flur	Althen-Kleinpösna
Hirschfelder Straße	Althen-Kleinpösna, Engelsdorf
Hirschsprung	Knautkleeberg-Knauthain
Hirseweg	Wiederitzsch
Hirtenholzstraße	Wahren
Hirtenweg	Marienbrunn
Hirzelstraße	Kleinzschocher
Hoepnerstraße	Gohlis-Mitte
Hofer Straße	Reudnitz-Thonberg
Hoffmannstraße	Sellerhausen-Stünz
Hofmeisterstraße	Zentrum-Ost
Hohe Heide	Seehausen
Hohe Straße	Zentrum-Süd
Hohenheidaer Straße	Plaußig-Portitz
Hohenheidaer Weg	Plaußig-Portitz
Hohenossiger Weg	Eutritzsch
Hohenrodaer Weg	Eutritzsch
Hohenthalstraße	Knautkleeberg-Knauthain
Hohentichelnstraße	Paunsdorf
Hohle Gasse	Lützschena-Stahmeln
Hohmannstraße	Eutritzsch
Holbeinstraße	Schleußig
Holbergstraße	Neulindenau
Hölderlinstraße	Gohlis-Mitte
Holsteinstraße	Reudnitz-Thonberg
Holteistraße	Altlindenau
Höltystraße	Meusdorf, Probstheida
Holunderbogen	Wiederitzsch
Holunderweg	Knautkleeberg-Knauthain
Holzhausener Straße	Liebertwolkwitz
Holzhäuser Straße	Stötteritz
Hommelweg	Mölkau
Hopfenbergstraße	Wahren
Hopfengarten	Stötteritz
Hopfenweg	Paunsdorf
Horburger Straße	Schönau
Hornissenwinkel	Heiterblick
Hornstraße	Großzschocher
Horst-Fritsche-Weg	Baalsdorf
Horst-Heilmann-Straße	Möckern
Hortensienweg	Holzhausen
Hotherstraße	Thekla
Hoyerstraße	Schleußig
Huberstraße	Schleußig
Hubertusstraße	Knautkleeberg-Knauthain
Hubmaierweg	Knautkleeberg-Knauthain
Hüfferstraße	Schleußig
Hüfnerstraße	Wahren
Hügelweg	Plaußig-Portitz
Hugo-Aurig-Straße	Engelsdorf
Hugo-Junkers-Straße	Lützschena-Stahmeln
Hugo-Krone-Platz	Wiederitzsch
Hugo-Licht-Straße	Zentrum
Humboldtstraße	Zentrum-Nord, Zentrum-Nordwest
Hummelstraße	Heiterblick
Humperdinckstraße	Engelsdorf
Hünerfeldstraße	Holzhausen
Husemannstraße	Neustadt-Neuschönefeld
Hussitenstraße	Engelsdorf
Huttenstraße	Großzschocher
Huygensstraße	Möckern
Idastraße	Volkmarsdorf
Idunweg	Thekla
Igelstraße	Heiterblick
Ihmelsstraße	Volkmarsdorf
Ilmenauer Weg	Schönau
Ilse-Decho-Weg	Engelsdorf
Iltispfad	Knautkleeberg-Knauthain
Im Birkengrund	Liebertwolkwitz
Im Blumengrund	Engelsdorf
Im Dölitzer Holz	Dölitz-Dösen
Im Grunde	Baalsdorf
Im Limburgerpark	Lößnig
Im Lindengrund	Liebertwolkwitz
Im Tannengrund	Liebertwolkwitz
Im Weidengrund	Liebertwolkwitz
Im Winkel	Burghausen-Rückmarsdorf
Im Zipfel	Lützschena-Stahmeln
Immenstraße	Großzschocher
Immischweg	Dölitz-Dösen
Industriestraße	Plagwitz, Schleußig
Ingwerweg	Wiederitzsch
Innenring	Wiederitzsch
Inselstraße	Zentrum-Ost
Italiaanderstraße	Plaußig-Portitz
J.-C.-Hinrichs-Straße	Neustadt-Neuschönefeld
Jablonowskistraße	Zentrum-Südost
Jack-London-Weg	Meusdorf
Jacobstraße	Zentrum-Nordwest
Jadassohnstraße	Neulindenau
Jadebogen	Engelsdorf
Jägerstraße	Gohlis-Mitte
Jahnallee	Altlindenau, Lindenau, Zentrum-Nordwest, Zentrum-West
Jahnstraße	Liebertwolkwitz
Jahnweg	Engelsdorf
Jakobiwinkel	Böhlitz-Ehrenberg
Jaspisstraße	Engelsdorf
Jenaer Straße	Schönau
Joachim-Gottschalk-Weg	Meusdorf
Jöcherstraße	Anger-Crottendorf
Jochmontagestraße	Wahren
Johann-Adolf-Straße	Dölitz-Dösen
Johannaparkweg	Zentrum-West
Johannastraße	Dölitz-Dösen
Johann-Eck-Straße	Neustadt-Neuschönefeld
Johannes-Kärner-Straße	Paunsdorf
Johannes-R.-Becher-Straße	Lößnig
Johannes-Weyrauch-Platz	Böhlitz-Ehrenberg
Johannisallee	Reudnitz-Thonberg, Zentrum-Südost
Johannisgasse	Zentrum-Südost
Johannishöhe	Dölitz-Dösen
Johannisplatz	Zentrum-Ost, Zentrum-Südost
Johann-Jakob-Weber-Platz	Stötteritz
Johnsonweg	Probstheida
Jöhstädter Straße	Thekla
Jonasstraße	Neustadt-Neuschönefeld
Jonsdorfer Straße	Grünau-Siedlung
Jordanstraße	Lindenau
Jörgen-Schmidtchen-Weg	Gohlis-Nord
Josephinenstraße	Reudnitz-Thonberg
Josephstraße	Lindenau
Jouleweg	Stötteritz
Judith-Auer-Straße	Reudnitz-Thonberg
Juister Weg	Gohlis-Nord
Julian-Marchlewski-Straße	Schönefeld-Ost
Julius-Krause-Straße	Sellerhausen-Stünz
Juliusstraße	Volkmarsdorf
Jungfernstiege	Lützschena-Stahmeln
Junghanßstraße	Leutzsch
Jungmannstraße	Wahren
Jupiterstraße	Grünau-Nord
Jupp-Müller-Straße	Möckern
Jutta-Hipp-Weg	Meusdorf
Kahlhoffweg	Dölitz-Dösen
Kamelienweg	Hartmannsdorf-Knautnaundorf
Kamenzer Straße	Schönefeld-Ost
Kamillenweg	Wiederitzsch
Kanalstraße	Gohlis-Süd, Zentrum-Nord
Kändlerstraße	Lausen-Grünau
Kaninchensteig	Knautkleeberg-Knauthain
Kantatenweg	Kleinzschocher
Kantor-Andrä-Straße	Böhlitz-Ehrenberg
Kantor-Hase-Straße	Lindenthal
Kantor-Schmidt-Weg	Mölkau
Kantstraße	Südvorstadt
Kapellenstraße	Neustadt-Neuschönefeld
Karl-Blechen-Straße	Sellerhausen-Stünz
Karl-Bücher-Straße	Paunsdorf
Karl-Ferlemann-Straße	Altlindenau
Karl-Friedrich-Straße	Mölkau
Karl-Härting-Straße	Sellerhausen-Stünz
Karl-Heft-Straße	Großzschocher
Karl-Heine-Platz	Lindenau
Karl-Heine-Straße	Lindenau, Neulindenau, Plagwitz
Karl-Helbig-Straße	Möckern
Karl-Jungbluth-Straße	Lößnig
Karl-Liebknecht-Straße	Connewitz, Südvorstadt, Zentrum-Süd
Karl-Mannsfeld-Straße	Lindenthal
Karl-Marx-Platz	Lindenthal
Karl-Marx-Straße	Wiederitzsch
Karl-Moor-Weg	Plaußig-Portitz
Karl-Rothe-Straße	Zentrum-Nord
Karl-Schurz-Straße	Leutzsch
Karl-Siegismund-Straße	Reudnitz-Thonberg, Zentrum-Südost
Karlsruher Straße	Grünau-Mitte
Karlstädter Straße	Grünau-Siedlung
Karlstraße	Mölkau
Karl-Tauchnitz-Straße	Südvorstadt, Zentrum-Süd, Zentrum-West
Karl-Vogel-Straße	Anger-Crottendorf
Karl-Winkler-Straße	Lindenthal
Karolusstraße	Heiterblick
Kärrnerstraße	Holzhausen
Kärrnerweg	Stötteritz
Kasseler Straße	Gohlis-Süd
Kastanienallee	Böhlitz-Ehrenberg
Kastanienring	Mölkau
Kastanienstraße	Seehausen
Kastanienweg	Burghausen-Rückmarsdorf
Kästnerbogen	Plaußig-Portitz
Kastorweg	Burghausen-Rückmarsdorf
Katharinenstraße	Zentrum
Käthe-Kollwitz-Straße	Lindenau, Schleußig, Zentrum-West
Katzmannstraße	Mockau-Nord
Katzstraße	Probstheida
Kaulbachweg	Paunsdorf
Kegelweg	Probstheida
Kehrwieder	Marienbrunn
Keilstraße	Zentrum-Nord
Kelbestraße	Mölkau
Keplerstraße	Möckern
Kerbelweg	Wiederitzsch
Kernstraße	Möckern
Kesselgrund	Holzhausen
Kickerlingsberg	Gohlis-Süd, Zentrum-Nord, Zentrum-Nordwest
Kiebitzstraße	Thekla
Kiefernweg	Holzhausen
Kieler Straße	Mockau-Nord
Kiesgrubenstraße	Althen-Kleinpösna
Kiesweg	Lindenthal
Kietzstraße	Leutzsch
Kiewer Straße	Grünau-Mitte, Grünau-Nord, Grünau-Siedlung, Schönau
Kilometerweg	Wahren
Kindstraße	Lindenau
Kippenbergstraße	Reudnitz-Thonberg
Kipsdorfer Weg	Grünau-Siedlung
Kirchplatz	Gohlis-Süd
Kirchstraße	Liebertwolkwitz
Kirchweg	Baalsdorf, Engelsdorf
Kirschbergstraße	Gohlis-Süd, Möckern
Kissinger Straße	Grünau-Siedlung
Klabundweg	Meusdorf
Klarastraße	Kleinzschocher, Plagwitz
Klasingstraße	Neustadt-Neuschönefeld
Klausenerstraße	Anger-Crottendorf
Kleeweg	Mockau-Süd
Kleine Bergstraße	Mölkau
Kleine Fleischergasse	Zentrum
Kleine Gartensiedlung	Engelsdorf
Kleine Gartenstraße	Wiederitzsch
Kleine Promenade	Engelsdorf
Kleiner Poetenweg	Lützschena-Stahmeln
Kleiner Zipfel	Lützschena-Stahmeln
Kleinmesseplatz	Altlindenau
Kleinpösnaer Anger	Althen-Kleinpösna
Kleinpösnaer Straße	Holzhausen
Kleiststraße	Eutritzsch, Gohlis-Mitte, Gohlis-Nord
Klemmstraße	Connewitz
Klempererstraße	Engelsdorf
Klenaustraße	Liebertwolkwitz
Klettenstraße	Paunsdorf
Klingenstraße	Kleinzschocher, Plagwitz
Klingenthaler Straße	Thekla
Klingerplatz	Engelsdorf
Klingerstraße	Engelsdorf
Klingerweg	Schleußig
Klipphausenstraße	Liebertwolkwitz
Klopstockstraße	Altlindenau
Kloßstraße	Großzschocher
Klostergasse	Zentrum
Klosterneuburger Weg	Plaußig-Portitz
Knaurstraße	Gohlis-Süd
Knauthainer Straße	Kleinzschocher
Knautnaundorfer Anger	Hartmannsdorf-Knautnaundorf
Knautnaundorfer Straße	Hartmannsdorf-Knautnaundorf, Knautkleeberg-Knauthain
Knesebeckstraße	Liebertwolkwitz
Knöflerstraße	Gohlis-Nord
Knopstraße	Möckern
Knorrstraße	Engelsdorf
Knuthstraße	Knautkleeberg-Knauthain
Köbisstraße	Reudnitz-Thonberg
Koburger Straße	Connewitz
Kochstraße	Connewitz, Südvorstadt
Koehlerstraße	Neustadt-Neuschönefeld
Kohlenstraße	Südvorstadt, Zentrum-Süd, Zentrum-Südost
Kohlgartenstraße	Neustadt-Neuschönefeld, Zentrum-Ost
Kohlgartenweg	Anger-Crottendorf
Kohlweg	Schönefeld-Abtnaundorf, Schönefeld-Ost, Volkmarsdorf
Köhraer Straße	Connewitz
Kohrener Straße	Connewitz
Kolbestraße	Plagwitz
Kolmstraße	Stötteritz
Koloniestraße	Wahren
Kolonnadenstraße	Zentrum-West
Kolpingweg	Grünau-Siedlung
Komarowstraße	Mockau-Nord
Kometenweg	Grünau-Nord
Kommandant-Prendel-Allee	Stötteritz
Kömmlitzer Weg	Lindenthal
Königsteinstraße	Lausen-Grünau
Könneritzstraße	Schleußig
Konrad-Hagen-Platz	Marienbrunn
Konradstraße	Neustadt-Neuschönefeld, Volkmarsdorf
Konstantinstraße	Neustadt-Neuschönefeld
Kopernikusstraße	Mockau-Nord
Kornblumenweg	Wiederitzsch
Körnerplatz	Zentrum-Süd
Körnerstraße	Südvorstadt, Zentrum-Süd
Körnerweg	Mölkau
Kornweg	Seehausen
Korolenkostraße	Mockau-Nord
Kosakenweg	Meusdorf
Kösner Straße	Lindenau
Kossaer Straße	Wiederitzsch
Köstritzer Straße	Grünau-Siedlung
Kötzschauer Straße	Kleinzschocher
Kötzschkestraße	Sellerhausen-Stünz
Krakauer Straße	Grünau-Siedlung, Lausen-Grünau
Kranichweg	Seehausen
Krätzbergstraße	Plaußig-Portitz
Krautbreite	Burghausen-Rückmarsdorf
Krautgartenweg	Hartmannsdorf-Knautnaundorf
Kregelstraße	Reudnitz-Thonberg
Kremser Weg	Plaußig-Portitz
Kresseweg	Wiederitzsch
Kreuzdornstraße	Paunsdorf
Kreuzstraße	Neustadt-Neuschönefeld, Zentrum-Ost
Kriemhildstraße	Lößnig
Kröbelstraße	Reudnitz-Thonberg
Krokerstraße	Gohlis-Mitte
Krokusweg	Holzhausen
Krönerstraße	Anger-Crottendorf, Volkmarsdorf
Krostitzer Weg	Eutritzsch
Krugstraße	Reudnitz-Thonberg
Kuchengartenstraße	Neustadt-Neuschönefeld
Küchenholzallee	Großzschocher, Kleinzschocher
Kuckhoffstraße	Mockau-Nord
Kuckucksweg	Seehausen
Kuhnaustraße	Dölitz-Dösen
Kuhturmallee	Zentrum-Nordwest
Kuhturmstraße	Altlindenau
Kulkwitzer Straße	Kleinzschocher
Kulmbacher Straße	Grünau-Siedlung
Kümmelweg	Wiederitzsch
Kunadstraße	Eutritzsch
Kuntzschmannstraße	Schönefeld-Abtnaundorf
Kunzestraße	Großzschocher
Kupfergasse	Zentrum
Kursdorfer Weg	Schönau
Kurt-Eisner-Straße	Südvorstadt
Kurt-Günther-Straße	Reudnitz-Thonberg
Kurt-Hänselmann-Weg	Baalsdorf
Kurt-Huber-Weg	Stötteritz
Kurt-Krah-Straße	Engelsdorf
Kurt-Kresse-Straße	Großzschocher, Kleinzschocher
Kurt-Masur-Platz	Zentrum
Kurt-Reinicke-Platz	Knautkleeberg-Knauthain
Kurt-Schumacher-Straße	Zentrum-Nord, Zentrum-Ost
Kurt-Tucholsky-Straße	Lößnig
Kurt-Weill-Straße	Schönefeld-Ost
Kurze Straße	Lindenthal
Kutschbachweg	Altlindenau
Kutscherweg	Lindenthal
Kutschweg	Thekla
Lagerhofstraße	Zentrum-Ost
Lähnestraße	Neulindenau
Lammertweg	Lausen-Grünau
Lampestraße	Zentrum-Süd
Lamprechtstraße	Sellerhausen-Stünz
Landhausstraße	Wahren
Landsberger Straße	Gohlis-Mitte, Gohlis-Nord, Lindenthal, Möckern
Landsteinerstraße	Zentrum-Südost
Landwaisenhausstraße	Leutzsch
Lange Reihe	Stötteritz
Lange Straße	Zentrum-Ost
Lange Trift	Lindenthal
Langhansstraße	Sellerhausen-Stünz
Lärchenweg	Holzhausen
Laubestraße	Möckern
Lauchstädter Straße	Plagwitz
Lauerscher Weg	Großzschocher, Knautkleeberg-Knauthain
Laurentiusstraße	Leutzsch
Lauschaer Weg	Schönau
Lausener Bogen	Lausen-Grünau
Lausener Dorfplatz	Lausen-Grünau
Lausener Straße	Hartmannsdorf-Knautnaundorf, Lausen-Grünau
Lausicker Straße	Stötteritz
Lausner Weg	Großzschocher, Grünau-Siedlung
Lavendelweg	Wiederitzsch
Lazarusstraße	Schönefeld-Abtnaundorf
Leanderweg	Marienbrunn
Lehdenweg	Paunsdorf
Leiblweg	Paunsdorf
Leibnitzstraße	Liebertwolkwitz
Leibnizstraße	Zentrum-Nordwest
Leibnizweg	Zentrum-Nordwest
Leidholdstraße	Neulindenau
Leinestraße	Dölitz-Dösen, Meusdorf
Leinewinkel	Dölitz-Dösen
Leipziger Straße	Böhlitz-Ehrenberg
Leisniger Straße	Lößnig
Lemseler Weg	Eutritzsch
Lenaustraße	Gohlis-Mitte
Lene-Voigt-Straße	Probstheida
Lengefelder Straße	Thekla
Lenzstraße	Sellerhausen-Stünz
Leonhard-Frank-Straße	Sellerhausen-Stünz
Leonhardtstraße	Mockau-Süd
Leopoldstraße	Connewitz
Leostraße	Schönefeld-Abtnaundorf
Leo-Tolstoi-Straße	Mockau-Nord
Leplaystraße	Zentrum-Südost
Lerchengrund	Wiederitzsch
Lercheninsel	Mölkau
Lerchenrain	Marienbrunn
Lerchenweg	Plaußig-Portitz
Lermastraße	Plaußig-Portitz
Lermontowstraße	Mockau-Nord
Les-Epesses-Straße	Liebertwolkwitz
Lessingplatz	Böhlitz-Ehrenberg
Lessingstraße	Zentrum-West
Lessingweg	Mölkau
Leuckartstraße	Probstheida
Leunaer Weg	Neulindenau
Leupoldstraße	Heiterblick, Schönefeld-Ost
Leutzscher Allee	Zentrum-Nordwest
Leutzscher Straße	Burghausen-Rückmarsdorf
Lewienstraße	Lindenthal
Libellenstraße	Großzschocher
Libertastraße	Dölitz-Dösen
Lichtenbergweg	Stötteritz
Lichtenfelser Straße	Grünau-Siedlung
Lidicestraße	Thekla
Liebensteiner Weg	Schönau
Liebertwolkwitzer Markt	Liebertwolkwitz
Liebertwolkwitzer Straße	Holzhausen
Liebfrauenstraße	Marienbrunn
Liebigstraße	Zentrum-Südost
Liechtensteinstraße	Lößnig
Ligusterweg	Plaußig-Portitz
Liliensteinstraße	Lausen-Grünau
Lilienstraße	Neustadt-Neuschönefeld
Lilienthalstraße	Mockau-Nord
Lilienweg	Mölkau
Limburgerstraße	Plagwitz
Lindenallee	Lindenthal
Lindenauer Markt	Altlindenau
Lindenauer Straße	Burghausen-Rückmarsdorf
Lindengasse	Seehausen
Lindennaundorfer Weg	Schönau
Lindenpark	Burghausen-Rückmarsdorf
Lindenstraße	Wiederitzsch
Lindenthaler Hauptstraße	Lindenthal
Lindenthaler Straße	Gohlis-Mitte, Gohlis-Süd
Linkelstraße	Wahren
Linnéstraße	Zentrum-Südost
Lintacherstraße	Mölkau
Lionstraße	Lindenau
Lipinskistraße	Großzschocher
Lippendorfer Straße	Connewitz
Liprandisdorfer Straße	Liebertwolkwitz
Lipsiusstraße	Reudnitz-Thonberg
Liselotte-Herrmann-Straße	Anger-Crottendorf
Lise-Meitner-Straße	Böhlitz-Ehrenberg
Littstraße	Zentrum-Ost
Liviastraße	Zentrum-Nordwest
Löbauer Straße	Schönefeld-Abtnaundorf, Schönefeld-Ost
Lobelienweg	Holzhausen
Lobensteiner Straße	Grünau-Siedlung
Lobstädter Straße	Lößnig
Lochmannstraße	Stötteritz
Logauweg	Meusdorf
Löhrstraße	Zentrum-Nord
Lomonossowstraße	Mockau-Nord
Lönsstraße	Wiederitzsch
Lorenzstraße	Neustadt-Neuschönefeld
Lortzingstraße	Zentrum-Nordwest
Losinskiweg	Schönefeld-Ost
Lößniger Straße	Südvorstadt, Zentrum-Süd
Lotterstraße	Zentrum
Lotzestraße	Gohlis-Nord
Louise-Otto-Peters-Allee	Lindenthal, Lützschena-Stahmeln, Möckern
Louise-Otto-Peters-Platz	Zentrum-Nordwest
Louis-Fürnberg-Straße	Sellerhausen-Stünz
Löwenzahnweg	Wiederitzsch
Luchspfad	Knautkleeberg-Knauthain
Luckaer Straße	Kleinzschocher
Lucknerstraße	Wahren
Lüderstraße	Gohlis-Süd
Ludolf-Colditz-Straße	Stötteritz
Ludwig-Beck-Straße	Gohlis-Mitte
Ludwig-Erhard-Straße	Neustadt-Neuschönefeld, Zentrum-Ost
Ludwig-Hupfeld-Straße	Böhlitz-Ehrenberg, Leutzsch
Ludwig-Jahn-Straße	Böhlitz-Ehrenberg
Ludwigsburger Straße	Grünau-Mitte
Ludwigstraße	Neustadt-Neuschönefeld, Volkmarsdorf
Ludwig-Thoma-Weg	Probstheida
Luftschiffstraße	Mockau-Nord
Lukasstraße	Volkmarsdorf
Lumumbastraße	Gohlis-Süd, Zentrum-Nord
Lupinenweg	Engelsdorf
Luppenaue	Böhlitz-Ehrenberg
Luppenstraße	Altlindenau
Lurgensteins Steg	Zentrum-West
Lutherstraße	Neustadt-Neuschönefeld
Lützner Plan	Neulindenau
Lützner Straße	Altlindenau, Grünau-Mitte, Grünau-Nord, Grünau-Ost, Grünau-Siedlung, Lausen-Grünau, Lindenau, Miltitz, Neulindenau, Schönau
Lützowstraße	Gohlis-Mitte, Gohlis-Süd
Lützschenaer Straße	Böhlitz-Ehrenberg
Luz-Long-Weg	Zentrum-West
Lyoner Straße	Schönau
Macherner Straße	Sellerhausen-Stünz
Magazingasse	Zentrum
Magdalenenstraße	Eutritzsch
Magdeborner Straße	Dölitz-Dösen
Magdeburger Straße	Gohlis-Süd
Magnusstraße	Eutritzsch
Mahlmannstraße	Südvorstadt, Zentrum-Süd
Maienweg	Holzhausen
Maiglöckchenweg	Lützschena-Stahmeln
Maikäferweg	Heiterblick
Mainzer Straße	Zentrum-West
Majakowskistraße	Mockau-Nord
Malachitstraße	Engelsdorf
Malteserstraße	Eutritzsch
Malvenweg	Mölkau
Manetstraße	Zentrum-West
Mannheimer Straße	Grünau-Mitte
Mansfelder Weg	Neulindenau
Marbachstraße	Gohlis-Süd
Marcher Straße	Holzhausen
Marchlewskiweg	Meusdorf
Marcusgasse	Neustadt-Neuschönefeld
Margaretenstraße	Neustadt-Neuschönefeld
Margeritenweg	Neulindenau
Maria-Grollmuß-Straße	Gohlis-Nord
Mariannenpark	Schönefeld-Abtnaundorf
Mariannenstraße	Neustadt-Neuschönefeld, Volkmarsdorf
Marienberger Straße	Thekla
Marienbrunnenstraße	Stötteritz
Marienplatz	Zentrum-Ost
Marienweg	Möckern, Zentrum-Nordwest
Markgrafenstraße	Zentrum
Markkleeberger Straße	Dölitz-Dösen
Markranstädter Straße	Plagwitz
Markt	Zentrum
Markthallenstraße	Zentrum-Süd
Marktstraße	Altlindenau
Marmontstraße	Wiederitzsch
Marpergerstraße	Schleußig
Marschnerstraße	Zentrum-West
Marsweg	Grünau-Nord
Martin-Drucker-Straße	Gohlis-Mitte
Martin-Herrmann-Straße	Großzschocher
Martin-Luther-Ring	Zentrum, Zentrum-Süd, Zentrum-West
Martinsbogen	Wiederitzsch
Martinshöhe	Wiederitzsch
Martinsplatz	Kleinzschocher
Martinstraße	Anger-Crottendorf, Reudnitz-Thonberg
Mascovstraße	Anger-Crottendorf
Mathiesenstraße	Leutzsch
Mathildenstraße	Connewitz
Matthäikirchhof	Zentrum
Mattheuerbogen	Probstheida
Matthias-Erzberger-Straße	Engelsdorf
Matthissonstraße	Gohlis-Mitte
Matzelstraße	Dölitz-Dösen
Mauersbergerstraße	Stötteritz
Maulbeerweg	Knautkleeberg-Knauthain
Maulwurfweg	Heiterblick
Max-Beckmann-Straße	Zentrum-West
Max-Borsdorf-Straße	Sellerhausen-Stünz
Maximilianallee	Eutritzsch, Mockau-Nord, Seehausen, Wiederitzsch
Maximilian-Kolbe-Weg	Engelsdorf
Max-Liebermann-Straße	Eutritzsch, Gohlis-Nord, Möckern
Max-Lingner-Straße	Schönefeld-Ost
Max-Metzger-Straße	Gohlis-Mitte
Max-Planck-Straße	Zentrum-Nordwest
Max-Pommer-Straße	Reudnitz-Thonberg
Max-Reger-Allee	Zentrum-Süd, Zentrum-West
Max-Reger-Straße	Engelsdorf
Max-Seyfert-Straße	Baalsdorf
Mechlerstraße	Zentrum-Nord
Mecklenburger Straße	Zentrum-Ost
Meininger Ring	Schönau
Meisenweg	Plaußig-Portitz
Meißner Straße	Neustadt-Neuschönefeld
Melanchthonstraße	Neustadt-Neuschönefeld
Melchthalweg	Eutritzsch
Melissenweg	Wiederitzsch
Melker Weg	Plaußig-Portitz
Melscher Straße	Stötteritz
Menckestraße	Gohlis-Süd
Mendelejewstraße	Mockau-Nord
Mendelssohnstraße	Zentrum-West
Menzingenweg	Knautkleeberg-Knauthain
Merkurpromenade	Seehausen, Wiederitzsch
Merkwitzer Landstraße	Plaußig-Portitz
Merkwitzer Straße	Seehausen
Merseburger Straße	Altlindenau, Böhlitz-Ehrenberg, Burghausen-Rückmarsdorf, Leutzsch, Lindenau, Neulindenau, Plagwitz
Messe-Allee	Mockau-Nord, Seehausen, Thekla, Wiederitzsch
Meusdorfer Straße	Connewitz
Michaelisstraße	Zentrum-Nord
Michael-Kazmierczak-Straße	Gohlis-Mitte
Miekeweg	Kleinzschocher
Mierendorffstraße	Anger-Crottendorf
Milanweg	Burghausen-Rückmarsdorf
Miltenberger Straße	Grünau-Siedlung
Miltitzer Allee	Grünau-Nord, Grünau-Siedlung, Lausen-Grünau
Miltitzer Dorfstraße	Miltitz
Miltitzer Straße	Burghausen-Rückmarsdorf, Grünau-Nord, Miltitz
Miltitzer Weg	Grünau-Nord
Mistelbacher Weg	Plaußig-Portitz
Mistelbogen	Wiederitzsch
Mitschurinring	Böhlitz-Ehrenberg
Mitschurinstraße	Mockau-Nord
Mittelgasse	Liebertwolkwitz
Mittelring	Wiederitzsch
Mittelstraße	Miltitz
Mittelweg	Baalsdorf
Möbiusplatz	Reudnitz-Thonberg
Möbiusstraße	Reudnitz-Thonberg
Mockauer Ring	Mockau-Nord
Mockauer Straße	Mockau-Nord, Mockau-Süd, Schönefeld-Abtnaundorf
Möckernsche Allee	Zentrum-Nordwest
Möckernsche Straße	Gohlis-Süd
Möckernscher Weg	Möckern, Wiederitzsch
Mohnweg	Wiederitzsch
Molitorstraße	Plaußig-Portitz
Mölkauer Dorfplatz	Mölkau
Mölkauer Straße	Holzhausen
Moltkestraße	Böhlitz-Ehrenberg
Moltrechtstraße	Mölkau
Mommsenstraße	Heiterblick
Monarchenhügel	Holzhausen, Liebertwolkwitz
Moosbeerweg	Knautkleeberg-Knauthain
Moränenweg	Plaußig-Portitz
Morawitzstraße	Probstheida
Morellenweg	Mölkau
Morgensternstraße	Neulindenau
Mörikestraße	Eutritzsch
Morungenstraße	Knautkleeberg-Knauthain
Moschelesstraße	Zentrum-West
Mosenthinstraße	Eutritzsch
Mothesstraße	Eutritzsch
Mottelerstraße	Gohlis-Süd
Möwenweg	Burghausen-Rückmarsdorf
Mozartstraße	Zentrum-Süd
Mückenhainer Weg	Hartmannsdorf-Knautnaundorf, Knautkleeberg-Knauthain
Mühlbergsiedlung	Holzhausen
Mühlenplatz	Böhlitz-Ehrenberg
Mühlenstraße	Lützschena-Stahmeln
Mühlenweg	Hartmannsdorf-Knautnaundorf
Mühlgrabenweg	Seehausen
Mühlhäuser Ring	Schönau
Mühlholzgasse	Connewitz
Mühligstraße	Altlindenau
Mühlparkweg	Großzschocher
Mühlstraße	Reudnitz-Thonberg
Mühlweg	Engelsdorf, Mölkau
Muldentalstraße	Liebertwolkwitz
Müllerring	Lindenthal
Münzgasse	Zentrum-Süd
Nachtigallenhain	Holzhausen
Nachtigallenweg	Seehausen
Nagelstraße	Lindenthal
Narsdorfer Straße	Connewitz
Narzissenweg	Lützschena-Stahmeln
Naschmarkt	Zentrum
Natalienstraße	Volkmarsdorf
Nathanaelstraße	Altlindenau
Nathusiusstraße	Eutritzsch
Natonekstraße	Gohlis-Süd
Naumburger Straße	Plagwitz
Naundörfchen	Zentrum-West
Naunhofer Landstraße	Holzhausen, Liebertwolkwitz
Naunhofer Straße	Stötteritz
Nelkenweg	Grünau-Ost
Neptunweg	Grünau-Nord
Nerchauer Straße	Reudnitz-Thonberg
Nernststraße	Möckern
Neubauernstraße	Großzschocher
Neuberinstraße	Plaußig-Portitz
Neuburghausener Weg	Burghausen-Rückmarsdorf
Neudorfgasse	Connewitz
Neue Gutenbergstraße	Böhlitz-Ehrenberg
Neue Hallesche Straße	Lützschena-Stahmeln, Wahren
Neue Leipziger Straße	Grünau-Nord, Miltitz
Neue Linie	Connewitz
Neue Straße	Kleinzschocher
Neuenburger Weg	Mockau-Nord
Neuer Ring	Lützschena-Stahmeln
Neuer Weg	Wiederitzsch
Neumannstraße	Anger-Crottendorf
Neumarkt	Zentrum
Neunkirchener Straße	Anger-Crottendorf
Neuscherbitzer Gasse	Böhlitz-Ehrenberg
Neustädter Markt	Neustadt-Neuschönefeld
Neustädter Straße	Neustadt-Neuschönefeld
Neutzscher Straße	Thekla
Newtonstraße	Dölitz-Dösen
Nibelungenring	Lößnig
Nickelmannweg	Marienbrunn
Niederkirchnerstraße	Zentrum-Süd
Nieritzstraße	Probstheida
Nietzschestraße	Gohlis-Nord
Nikischplatz	Zentrum-West
Nikischstraße	Böhlitz-Ehrenberg
Nikolaikirchhof	Zentrum
Nikolai-Rumjanzew-Straße	Grünau-Ost, Kleinzschocher
Nikolaistraße	Zentrum
Nimrodstraße	Knautkleeberg-Knauthain
Nixenweg	Marienbrunn
Nobbeweg	Reudnitz-Thonberg
Nollendorfstraße	Burghausen-Rückmarsdorf
Nonnenmühlgasse	Zentrum-Süd
Nonnenstraße	Plagwitz
Nonnenweg	Schleußig
Norderneyer Weg	Gohlis-Nord
Nordhäuser Weg	Schönau
Nordplatz	Zentrum-Nord
Nordstraße	Zentrum-Nord
Nordweg	Wiederitzsch
Nürnberger Straße	Zentrum-Südost
Nußbaumallee	Holzhausen
Nußbaumweg	Böhlitz-Ehrenberg
Oberdorfstraße	Stötteritz
Obere Eichstädtstraße	Stötteritz
Obere Mühlenstraße	Böhlitz-Ehrenberg
Obere Nordstraße	Holzhausen
Oberhofer Weg	Schönau
Oberholzstraße	Liebertwolkwitz
Oberläuterstraße	Mockau-Süd
Obernaundorfer Straße	Mölkau
Obludastraße	Schönefeld-Ost
Ochsenweg	Burghausen-Rückmarsdorf
Odermannstraße	Altlindenau
Oelsnitzer Straße	Thekla
Oelßnerstraße	Mockau-Süd
Oertgering	Althen-Kleinpösna
Oeserstraße	Schleußig
Offenbachweg	Meusdorf
Offenburger Straße	Grünau-Mitte
Ohmweg	Stötteritz
Olbernhauer Straße	Thekla
Olbrichtstraße	Gohlis-Mitte, Gohlis-Nord, Möckern
Olchinger Straße	Wiederitzsch
Oldenburger Straße	Gohlis-Nord
Oleanderweg	Liebertwolkwitz
Ölhafenstraße	Wahren
Onckenstraße	Wahren
Opalstraße	Engelsdorf
Opferweg	Wahren
Orchideenweg	Holzhausen
Orenburger Weg	Grünau-Siedlung
Ortrunweg	Lößnig
Oschatzer Straße	Stötteritz
Oskar-Calov-Straße	Liebertwolkwitz
Ossietzkystraße	Schönefeld-Abtnaundorf
Ostende	Liebertwolkwitz
Osten-Sacken-Weg	Meusdorf
Österreicherweg	Probstheida
Ostheimstraße	Sellerhausen-Stünz
Osthöhe	Mölkau
Ostplatz	Reudnitz-Thonberg, Zentrum-Südost
Ostrowskistraße	Mockau-Nord
Oststraße	Anger-Crottendorf, Reudnitz-Thonberg, Stötteritz
Ostwaldstraße	Heiterblick
Oswald-Kahnt-Ring	Lindenthal
Oswaldstraße	Reudnitz-Thonberg
Otterstraße	Heiterblick
Otto-Adam-Straße	Gohlis-Mitte
Otto-Engert-Straße	Mölkau
Otto-Heinze-Straße	Mockau-Nord
Otto-Michael-Straße	Mockau-Nord
Otto-Militzer-Straße	Großzschocher
Otto-Runki-Platz	Neustadt-Neuschönefeld
Otto-Schill-Straße	Zentrum-West
Otto-Schmiedt-Straße	Leutzsch
Ottostraße	Zentrum-Südost
Otto-Thiele-Straße	Burghausen-Rückmarsdorf
Packhofstraße	Zentrum-Nord
Pahlenweg	Meusdorf
Palmstraße	Reudnitz-Thonberg
Panitzstraße	Kleinzschocher
Pansastraße	Neulindenau
Papiermühlstraße	Reudnitz-Thonberg, Stötteritz
Papitzer Straße	Möckern
Pappelblick	Plaußig-Portitz
Pappelhof	Mockau-Süd
Pappelweg	Burghausen-Rückmarsdorf
Parkallee	Grünau-Ost
Parkring	Lindenthal
Parkstraße	Holzhausen
Parkweg	Böhlitz-Ehrenberg
Parthenstraße	Zentrum-Nord
Pater-Aurelius-Platz	Wahren
Pater-Gordian-Straße	Lindenthal, Wahren
Paul-Ernst-Straße	Wahren
Paul-Flechsig-Straße	Meusdorf
Paul-Gerhardt-Weg	Zentrum-West
Paul-Gruner-Straße	Zentrum-Süd
Paul-Heyse-Straße	Schönefeld-Abtnaundorf
Paulinengrund	Lützschena-Stahmeln
Paulinenstraße	Volkmarsdorf
Paulinerweg	Stötteritz
Paul-Klöpsch-Straße	Mölkau
Paul-Küstner-Straße	Altlindenau
Paul-Langheinrich-Straße	Böhlitz-Ehrenberg, Leutzsch
Paul-List-Straße	Zentrum-Südost
Paul-Michael-Straße	Leutzsch
Paul-Schneider-Straße	Eutritzsch
Paunsdorfer Allee	Engelsdorf, Heiterblick, Paunsdorf
Paunsdorfer Straße	Mölkau, Sellerhausen-Stünz
Paußnitzstraße	Schleußig
Payrstraße	Probstheida
Peilickestraße	Anger-Crottendorf
Pelzgasse	Wiederitzsch
Penckstraße	Paunsdorf
Perlickstraße	Zentrum-Südost
Perlpilzweg	Knautkleeberg-Knauthain
Permoserstraße	Engelsdorf, Heiterblick, Paunsdorf, Schönefeld-Ost, Sellerhausen-Stünz
Perrestraße	Schleußig
Perthesstraße	Reudnitz-Thonberg
Pestalozzistraße	Böhlitz-Ehrenberg
Peter-Breuer-Weg	Paunsdorf
Peterskirchhof	Zentrum
Peterssteinweg	Zentrum-Süd
Petersstraße	Zentrum
Pettenkoferstraße	Böhlitz-Ehrenberg, Leutzsch
Petzscher Straße	Eutritzsch
Pfaffendorfer Straße	Zentrum-Nord, Zentrum-Nordwest
Pfaffensteinstraße	Lausen-Grünau
Pfaffenweg	Althen-Kleinpösna
Pfarrer-Paul-Straße	Engelsdorf
Pfarrholzstraße	Wahren
Pfarrweg	Holzhausen
Pfeffingerstraße	Connewitz
Pfeilstraße	Großzschocher
Pferdnerstraße	Wahren
Pfingstweide	Leutzsch
Pflaumenallee	Anger-Crottendorf
Pflaumestraße	Böhlitz-Ehrenberg
Pflugkstraße	Mölkau
Philippine-Arndt-Weg	Engelsdorf
Philipp-Reis-Straße	Leutzsch
Philipp-Rosenthal-Straße	Reudnitz-Thonberg, Zentrum-Südost
Phoenixweg	Althen-Kleinpösna
Pilzanger	Knautkleeberg-Knauthain
Pirolweg	Lindenthal, Wahren
Pistorisstraße	Schleußig
Pitschkestraße	Lindenthal
Pittlerstraße	Wahren
Plantagenweg	Burghausen-Rückmarsdorf
Platanenstraße	Paunsdorf
Platanenweg	Wiederitzsch
Platnerstraße	Gohlis-Süd
Platostraße	Zentrum-Südost
Platz des 20. Juli 1944	Gohlis-Mitte
Plauensche Straße	Zentrum
Plaußiger Dorfstraße	Plaußig-Portitz
Plaußiger Straße	Sellerhausen-Stünz
Plaußiger Weg	Seehausen
Plautstraße	Burghausen-Rückmarsdorf, Neulindenau, Schönau
Plösener Straße	Thekla
Ploßstraße	Schönefeld-Abtnaundorf
Plovdiver Straße	Grünau-Nord
Podelwitzer Straße	Wiederitzsch
Podelwitzer Weg	Seehausen
Poetenweg	Gohlis-Süd
Pögnerstraße	Schönefeld-Abtnaundorf
Pohlentzstraße	Lößnig
Pohlestraße	Möckern
Polenweg	Probstheida
Pölitzstraße	Gohlis-Süd
Polluxweg	Burghausen-Rückmarsdorf
Pommernstraße	Anger-Crottendorf, Mölkau, Stötteritz
Poniatowskiplan	Zentrum-West
Ponickaustraße	Großzschocher
Popitzweg	Gohlis-Mitte
Pöppelmannstraße	Sellerhausen-Stünz
Pöppigstraße	Thekla
Porschestraße	Lützschena-Stahmeln
Pörstener Straße	Kleinzschocher
Portitzer Allee	Heiterblick
Portitzer Straße	Sellerhausen-Stünz
Portitzer Winkel	Plaußig-Portitz
Portitzmühlweg	Plaußig-Portitz
Porzcikstraße	Thekla
Posadowskyanlagen	Reudnitz-Thonberg
Posastraße	Plaußig-Portitz
Poserstraße	Schönefeld-Ost
Pösgrabenweg	Holzhausen
Pösnaer Straße	Stötteritz
Postreitergasse	Sellerhausen-Stünz
Poststraße	Lützschena-Stahmeln
Potschkaustraße	Grünau-Mitte
Pötzschker Weg	Neulindenau
Prager Straße	Holzhausen, Liebertwolkwitz, Meusdorf, Probstheida, Reudnitz-Thonberg, Stötteritz, Zentrum-Südost
Preiselbeerweg	Knautkleeberg-Knauthain
Prellerstraße	Gohlis-Süd, Zentrum-Nordwest
Preußenseite	Zentrum-Ost
Preußenstraße	Probstheida
Preußergäßchen	Zentrum
Prießnitzstraße	Altlindenau, Leutzsch
Primavesistraße	Gohlis-Süd
Primelweg	Mölkau
Prinzenweg	Marienbrunn
Prinz-Eugen-Straße	Connewitz
Probsteistraße	Schleußig
Probstheidaer Straße	Connewitz, Lößnig, Marienbrunn
Prof.-Andreas-Schubert-Straße	Althen-Kleinpösna
Prof.-Dr.-Koch-Straße	Wiederitzsch
Pröttitzer Weg	Eutritzsch
Prünstraße	Thekla
Püchauer Straße	Sellerhausen-Stünz
Pufendorfstraße	Altlindenau, Leutzsch
Puschkinstraße	Mockau-Nord
Puschstraße	Zentrum-Südost
Quasnitzer Höhe	Lützschena-Stahmeln
Quasnitzer Weg	Lützschena-Stahmeln
Queckstraße	Altlindenau
Quedlinburger Straße	Gohlis-Nord
Quermaße	Liebertwolkwitz
Querstraße	Zentrum-Ost
Querweg	Lützschena-Stahmeln
Quittenweg	Mölkau
Rabenerstraße	Altlindenau
Rabensteinplatz	Zentrum-Südost
Rabenweg	Wiederitzsch
Rabet	Neustadt-Neuschönefeld
Rackwitzer Straße	Eutritzsch, Schönefeld-Abtnaundorf, Zentrum-Ost
Radefelder Allee	Lützschena-Stahmeln
Radefelder Straße	Möckern
Radefelder Weg	Lützschena-Stahmeln
Radiusstraße	Neulindenau
Raiffeisenstraße	Großzschocher
Raimundstraße	Altlindenau
Ranftsche Gasse	Neustadt-Neuschönefeld, Zentrum-Ost
Rankestraße	Sellerhausen-Stünz
Ranstädter Steinweg	Zentrum-Nordwest, Zentrum-West
Räpitzer Straße	Hartmannsdorf-Knautnaundorf
Rapsweg	Großzschocher
Rapunzelweg	Marienbrunn
Raschwitzer Straße	Dölitz-Dösen, Lößnig
Rasenweg	Holzhausen
Rathausring	Miltitz
Rathausstraße	Burghausen-Rückmarsdorf
Rathenaustraße	Leutzsch
Ratsfreischulstraße	Zentrum
Ratzelstraße	Grünau-Mitte, Grünau-Siedlung, Kleinzschocher, Lausen-Grünau
Rauchfussweg	Engelsdorf
Raustraße	Wahren
Rebhuhnsteig	Knautkleeberg-Knauthain
Reclamstraße	Neustadt-Neuschönefeld
Regenbogen	Lausen-Grünau
Regensburger Straße	Seehausen
Reginenstraße	Gohlis-Süd
Rehbacher Anger	Hartmannsdorf-Knautnaundorf
Rehbacher Straße	Hartmannsdorf-Knautnaundorf, Knautkleeberg-Knauthain
Rehpfad	Knautkleeberg-Knauthain
Rehwagenstraße	Holzhausen
Reichelstraße	Zentrum-West
Reichenberger Straße	Burghausen-Rückmarsdorf
Reichpietschstraße	Anger-Crottendorf, Reudnitz-Thonberg
Reichsbahnerstraße	Engelsdorf
Reichsstraße	Zentrum
Reiherweg	Burghausen-Rückmarsdorf
Reineckestraße	Neulindenau
Reinhardtstraße	Sellerhausen-Stünz
Reinhold-Krüger-Straße	Reudnitz-Thonberg
Reinhold-Schulze-Straße	Liebertwolkwitz
Reinmuthweg	Gohlis-Mitte
Reiskestraße	Reudnitz-Thonberg
Reiterallee	Schönefeld-Abtnaundorf
Rembrandtplatz	Lößnig
Rembrandtstraße	Lößnig
Renftstraße	Möckern
Renkwitzstraße	Gohlis-Mitte
Rennbahnweg	Südvorstadt, Zentrum-Süd
Renoirstraße	Gohlis-Nord
Resedaweg	Sellerhausen-Stünz
Residenzstraße	Seehausen
Reudnitzer Straße	Zentrum-Ost
Reuningstraße	Möckern
Richard-Dittrich-Straße	Wiederitzsch
Richard-Lehmann-Straße	Connewitz, Marienbrunn, Probstheida, Südvorstadt, Zentrum-Südost
Richard-Leisebein-Straße	Burghausen-Rückmarsdorf
Richard-Springer-Weg	Holzhausen
Richard-Strauss-Platz	Zentrum-Süd
Richard-Wagner-Platz	Zentrum
Richard-Wagner-Straße	Zentrum
Richterstraße	Gohlis-Süd, Zentrum-Nord
Riebeckstraße	Anger-Crottendorf, Reudnitz-Thonberg
Riedelstraße	Reudnitz-Thonberg
Riemannstraße	Zentrum-Süd
Riesaer Straße	Althen-Kleinpösna, Engelsdorf, Paunsdorf, Sellerhausen-Stünz
Riesenweg	Marienbrunn
Rietschelstraße	Altlindenau, Leutzsch
Rietzschkebogen	Wiederitzsch
Rietzschkegrund	Wiederitzsch
Rietzschkeweg	Probstheida
Rietzschkewiesen	Mölkau
Rinckartstraße	Altlindenau
Ringelnatzweg	Probstheida
Ringstraße	Grünau-Mitte
Ringweg	Hartmannsdorf-Knautnaundorf
Rippachtalstraße	Großzschocher, Hartmannsdorf-Knautnaundorf, Knautkleeberg-Knauthain
Rittergutsstraße	Wahren
Ritterlingsweg	Knautkleeberg-Knauthain
Ritter-Pflugk-Straße	Knautkleeberg-Knauthain
Ritterspornweg	Engelsdorf
Ritterstraße	Zentrum
Robert-Blum-Platz	Wiederitzsch
Robert-Blum-Straße	Schönefeld-Abtnaundorf
Robert-Hanf-Weg	Böhlitz-Ehrenberg
Robert-Koch-Platz	Zentrum-Nordwest
Robert-Koch-Straße	Böhlitz-Ehrenberg
Robert-Koch-Weg	Engelsdorf
Robert-Mayer-Straße	Sellerhausen-Stünz
Robert-Schumann-Straße	Zentrum-Süd
Robert-Volkmann-Straße	Reudnitz-Thonberg
Robinienweg	Wiederitzsch
Rochlitzstraße	Schleußig
Röckener Straße	Plagwitz
Rodelandstraße	Wahren
Rodelbahn	Lützschena-Stahmeln
Rödelstraße	Schleußig
Rodinweg	Möckern
Roggenring	Wiederitzsch
Rohrteichstraße	Schönefeld-Abtnaundorf
Rolf-Axen-Straße	Kleinzschocher
Rollerweg	Plaußig-Portitz
Romain-Rolland-Weg	Meusdorf
Römhilder Weg	Schönau
Röntgenstraße	Altlindenau
Rosa-Luxemburg-Straße	Neustadt-Neuschönefeld, Zentrum-Ost
Roscherstraße	Zentrum-Nord
Roseggerstraße	Probstheida
Roseggerweg	Holzhausen
Rosenbaumstraße	Mölkau
Rosenholzweg	Böhlitz-Ehrenberg
Rosenmüllerstraße	Altlindenau, Leutzsch
Rosenowstraße	Mockau-Nord, Mockau-Süd
Rosenstraße	Miltitz
Rosentalgasse	Zentrum-Nordwest
Rosenweg	Grünau-Ost
Rosestraße	Lindenthal
Rosmarinweg	Sellerhausen-Stünz
Roßbachstraße	Anger-Crottendorf, Volkmarsdorf
Roßlauer Straße	Gohlis-Mitte
Roßmarkt	Liebertwolkwitz
Roßmarktstraße	Altlindenau
Roßmäßlerstraße	Connewitz
Roßplatz	Zentrum, Zentrum-Süd, Zentrum-Südost
Roßstraße	Liebertwolkwitz
Rostocker Straße	Heiterblick, Thekla
Rotbuchenweg	Wiederitzsch
Rotdornstraße	Paunsdorf
Rotfuchsstraße	Heiterblick
Rothenburger Straße	Grünau-Siedlung
Rotheplatz	Schönefeld-Abtnaundorf
Röthische Straße	Lößnig
Rotkäppchenweg	Marienbrunn
Rotkehlchenweg	Wahren
Rousseaustraße	Möckern
Rubensstraße	Reudnitz-Thonberg
Rübezahlweg	Marienbrunn
Rubinstraße	Engelsdorf
Rückertstraße	Gohlis-Mitte
Rückmarsdorfer Straße	Leutzsch
Rüdigerstraße	Sellerhausen-Stünz
Rudi-Opitz-Straße	Gohlis-Mitte
Rudolf-Breitscheid-Hof	Böhlitz-Ehrenberg
Rudolf-Breitscheid-Straße	Lindenthal
Rudolph-Herrmann-Straße	Stötteritz
Rudolph-Sack-Straße	Plagwitz
Rudolphstraße	Zentrum-West
Rügener Straße	Möckern
Rundkapellenweg	Hartmannsdorf-Knautnaundorf
Russenstraße	Holzhausen, Probstheida
Ruststraße	Kleinzschocher
Saalecker Straße	Plagwitz
Saalfelder Straße	Neulindenau
Saarbrückenstraße	Anger-Crottendorf
Saarländer Straße	Neulindenau
Saarlouiser Straße	Anger-Crottendorf
Sabinenstraße	Engelsdorf
Sachsenhöhe	Burghausen-Rückmarsdorf
Sachsenlinie	Burghausen-Rückmarsdorf
Sachsenseite	Zentrum-Ost
Sachsenstraße	Paunsdorf
Sackestraße	Schönefeld-Ost
Safranweg	Wiederitzsch
Salamanderstraße	Heiterblick
Salbeiweg	Wiederitzsch
Salomonstraße	Zentrum-Ost
Salzgäßchen	Zentrum
Salzhandelsstraße	Wiederitzsch
Salzmannstraße	Eutritzsch
Salzstraße	Lindenthal
Salzweg	Lausen-Grünau
Samuel-Lampel-Straße	Mockau-Nord
Sandberg	Burghausen-Rückmarsdorf
Sanddornweg	Knautkleeberg-Knauthain
Sandgrubenweg	Plaußig-Portitz
Sandmännchenweg	Marienbrunn
Sandweg	Lindenthal
Saphirstraße	Engelsdorf
Sasstraße	Gohlis-Mitte, Gohlis-Süd
Sattelhofstraße	Leutzsch
Sattlerweg	Lützschena-Stahmeln
Saturnstraße	Grünau-Nord
Saxoniastraße	Althen-Kleinpösna
Schacherstraße	Anger-Crottendorf
Schachtstraße	Gohlis-Süd
Schadowstraße	Lindenau
Schäferweg	Liebertwolkwitz
Schäferwinkel	Burghausen-Rückmarsdorf
Schandauer Weg	Grünau-Siedlung
Scharnhorststraße	Südvorstadt
Schatzweg	Knautkleeberg-Knauthain
Schauerstraße	Schönefeld-Abtnaundorf
Scheffelstraße	Connewitz
Scheibenholzweg	Zentrum-Süd
Schellingstraße	Gohlis-Mitte
Schenderleinstraße	Miltitz
Schenkendorfstraße	Südvorstadt
Scherlstraße	Zentrum-Ost
Scheumannstraße	Schönefeld-Abtnaundorf
Schiebestraße	Eutritzsch
Schildberger Weg	Mockau-Nord
Schillerplatz	Wahren
Schillerstraße	Zentrum
Schillerweg	Gohlis-Süd
Schillingstraße	Lindenau
Schimmelstraße	Miltitz
Schinkelstraße	Eutritzsch
Schirmerstraße	Anger-Crottendorf
Schkeitbarer Weg	Hartmannsdorf-Knautnaundorf
Schkeuditzer Straße	Burghausen-Rückmarsdorf
Schkorlopper Straße	Hartmannsdorf-Knautnaundorf
Schladitzer Straße	Eutritzsch
Schlegelstraße	Südvorstadt
Schlehdornweg	Engelsdorf
Schlehenweg	Paunsdorf
Schlesierstraße	Stötteritz
Schletterstraße	Zentrum-Süd
Schleußiger Weg	Connewitz, Schleußig, Südvorstadt
Schlippe	Schönefeld-Abtnaundorf
Schlößchenweg	Gohlis-Süd
Schloßgasse	Zentrum
Schloßweg	Lützschena-Stahmeln
Schlotterbeckstraße	Gohlis-Mitte
Schmalkaldener Weg	Schönau
Schmetterlingsweg	Großzschocher
Schmidstraße	Wiederitzsch
Schmidt-Rühl-Straße	Schönefeld-Abtnaundorf
Schmiedeberger Straße	Grünau-Siedlung
Schmiedegasse	Wiederitzsch
Schmiedestraße	Plagwitz
Schmitzstraße	Sellerhausen-Stünz
Schmutzlerstraße	Gohlis-Süd
Schneeballweg	Engelsdorf
Schneeberger Straße	Thekla
Schneewittchenweg	Marienbrunn
Schneiderstraße	Mockau-Süd
Schnittergasse	Lindenthal
Schnorrstraße	Schleußig
Schöfflerweg	Engelsdorf
Schomburgkstraße	Neulindenau
Schönauer Allee	Zentrum-Nordwest
Schönauer Lachen	Schönau
Schönauer Landstraße	Böhlitz-Ehrenberg, Burghausen-Rückmarsdorf
Schönauer Ring	Schönau
Schönauer Straße	Großzschocher, Grünau-Mitte, Grünau-Ost, Grünau-Siedlung, Kleinzschocher, Schönau
Schönauer Weg	Kleinzschocher
Schönbachstraße	Stötteritz
Schönbergstraße	Knautkleeberg-Knauthain
Schönefelder Allee	Schönefeld-Abtnaundorf
Schönefelder Straße	Eutritzsch
Schongauerstraße	Paunsdorf
Schopenhauerstraße	Gohlis-Mitte
Schorlemmerstraße	Gohlis-Süd
Schorndorfer Weg	Böhlitz-Ehrenberg
Schrägweg	Lützschena-Stahmeln
Schrammsteinstraße	Lausen-Grünau
Schrebergäßchen	Zentrum-West
Schreberstraße	Zentrum-West
Schreiberstraße	Schönefeld-Abtnaundorf
Schreinerweg	Lützschena-Stahmeln
Schröderstraße	Burghausen-Rückmarsdorf
Schröterstraße	Plaußig-Portitz
Schubarthstraße	Mölkau
Schubertstraße	Möckern
Schuhmachergäßchen	Zentrum
Schulgasse	Seehausen
Schulstraße	Mölkau
Schulweg	Engelsdorf
Schulze-Boysen-Straße	Reudnitz-Thonberg
Schulze-Delitzsch-Straße	Neustadt-Neuschönefeld, Volkmarsdorf
Schulzeweg	Schönefeld-Ost
Schützenhausstraße	Volkmarsdorf
Schützenstraße	Zentrum-Ost
Schützstraße	Leutzsch
Schwabacher Straße	Grünau-Siedlung
Schwägrichenstraße	Zentrum-Süd
Schwalbenweg	Seehausen
Schwanenweg	Burghausen-Rückmarsdorf
Schwantesstraße	Schönefeld-Ost
Schwartzestraße	Kleinzschocher
Schwarzackerstraße	Stötteritz
Schwarzdornweg	Knautkleeberg-Knauthain
Schwarzenbergweg	Meusdorf
Schwarzer Weg	Miltitz
Schwedenstraße	Lindenthal
Schweinfurter Straße	Grünau-Siedlung
Schweizerbogen	Probstheida
Schwimmerstraße	Plaußig-Portitz
Schwindstraße	Paunsdorf
Schwylststraße	Leutzsch
Scipiostraße	Mölkau
Sebastian-Bach-Straße	Zentrum-West
Seebenischer Straße	Großzschocher
Seebogen	Lausen-Grünau
Seeburgstraße	Zentrum-Südost
Seegeritzer Straße	Paunsdorf
Seegeritzer Weg	Plaußig-Portitz
Seehausener Allee	Seehausen, Wiederitzsch
Seehausener Straße	Wiederitzsch
Seelenbinderstraße	Möckern
Seelestraße	Thekla
Seemannstraße	Reudnitz-Thonberg
Seestraße	Lausen-Grünau, Miltitz
Seeweg	Seehausen
Seffnerstraße	Lausen-Grünau
Segerstraße	Anger-Crottendorf
Seidelstraße	Probstheida
Seidengasse	Wiederitzsch
Seifertshainer Straße	Holzhausen
Seiffener Straße	Thekla
Seilerweg	Lützschena-Stahmeln
Seipelweg	Schönefeld-Ost
Seitengasse	Eutritzsch
Seitenstraße	Liebertwolkwitz
Seitenweg	Althen-Kleinpösna
Sellerhäuser Straße	Anger-Crottendorf
Selliner Straße	Lausen-Grünau
Selneckerstraße	Connewitz
Semmelweisstraße	Reudnitz-Thonberg, Zentrum-Südost
Semperstraße	Sellerhausen-Stünz
Senefelderstraße	Neustadt-Neuschönefeld
Sesenheimer Straße	Möckern
Seumestraße	Knautkleeberg-Knauthain
Shakespeareplatz	Zentrum-Süd
Shakespearestraße	Zentrum-Süd
Shukowstraße	Schönefeld-Ost
Siedlereck	Liebertwolkwitz
Siedlerweg	Wiederitzsch
Siegfriedplatz	Lößnig
Siegfriedstraße	Lößnig
Siemensstraße	Plagwitz
Siemeringstraße	Lindenau
Sigebandweg	Lößnig
Sigismundstraße	Reudnitz-Thonberg
Silbermannstraße	Schleußig
Silcherstraße	Leutzsch
Simildenstraße	Connewitz
Simón-Bolívar-Straße	Mockau-Nord
Simonsplatz	Reudnitz-Thonberg
Simsonplatz	Zentrum-Süd
Simsonstraße	Zentrum-Süd
Singdrosselweg	Böhlitz-Ehrenberg
Siriusweg	Grünau-Nord
Slevogtstraße	Möckern
Smaragdstraße	Engelsdorf
Söllichauer Straße	Wiederitzsch
Sommerfelder Straße	Mölkau, Stötteritz
Sommerfelder Weg	Paunsdorf
Sommerlindenstraße	Engelsdorf
Sonneberger Weg	Schönau
Sonnenblumenweg	Großzschocher
Sonnengasse	Althen-Kleinpösna
Sonnenweg	Holzhausen
Sonnenwinkel	Stötteritz
Sophienstraße	Lindenthal
Sophie-Scholl-Straße	Mölkau
Sorbenstraße	Wahren
Sorbenweg	Burghausen-Rückmarsdorf
Sosaer Straße	Thekla
Spalierweg	Marienbrunn
Spatzenweg	Lindenthal
Spechtweg	Holzhausen
Spendegasse	Burghausen-Rückmarsdorf
Sperlingsgasse	Wahren
Sperlingsgrund	Wiederitzsch
Sperontesstraße	Knautkleeberg-Knauthain
Spetlakstraße	Mockau-Süd
Spinnereistraße	Neulindenau
Spittastraße	Altlindenau
Spitzwegstraße	Paunsdorf
Spohrstraße	Zentrum-Südost
Sporergäßchen	Zentrum
Sportplatzstraße	Wiederitzsch
Sportplatzweg	Burghausen-Rückmarsdorf
Sprikkenweg	Böhlitz-Ehrenberg
Sprikkenwinkel	Burghausen-Rückmarsdorf
Springerstraße	Zentrum-Nord
Staffelsteinstraße	Lausen-Grünau
Stahmelner Allee	Lützschena-Stahmeln
Stahmelner Anger	Lützschena-Stahmeln
Stahmelner Höhe	Lützschena-Stahmeln
Stahmelner Straße	Lützschena-Stahmeln, Wahren
Stallbaumstraße	Gohlis-Süd
Stammerstraße	Wahren
Stammstraße	Reudnitz-Thonberg
Stannebeinplatz	Schönefeld-Abtnaundorf
Stauffacherweg	Eutritzsch
Stauffenbergstraße	Gohlis-Mitte
Stefan-Zweig-Straße	Böhlitz-Ehrenberg
Steffensstraße	Gohlis-Mitte
Stegerwaldstraße	Anger-Crottendorf
Steinbachweg	Lützschena-Stahmeln
Steinberger Straße	Reudnitz-Thonberg
Steinbergstraße	Holzhausen
Steinpilzweg	Knautkleeberg-Knauthain
Steinstraße	Südvorstadt
Steinweg	Wiederitzsch
Stentzlerstraße	Wiederitzsch
Stephaniplatz	Reudnitz-Thonberg
Stephanstraße	Zentrum-Südost
Sternbachstraße	Schönefeld-Abtnaundorf
Sternenstraße	Engelsdorf
Sternenwinkel	Lindenthal
Sternheimstraße	Plaußig-Portitz
Sterntalerweg	Marienbrunn
Sternwartenstraße	Zentrum-Südost
Sternwartenweg	Zentrum-Südost
Steyberweg	Eutritzsch
Stieglitzstraße	Schleußig
Stieglitzweg	Böhlitz-Ehrenberg
Stifterstraße	Probstheida
Stiftsstraße	Reudnitz-Thonberg
Stockartstraße	Connewitz
Stöckelplatz	Schönefeld-Abtnaundorf
Stöckelstraße	Schönefeld-Abtnaundorf
Stockmannstraße	Neulindenau
Stockstraße	Gohlis-Süd
Stöhrerstraße	Schönefeld-Ost, Thekla
Stollberger Straße	Thekla
Stollestraße	Gohlis-Süd
Storchenweg	Seehausen
Stormstraße	Probstheida
Störmthaler Straße	Liebertwolkwitz
Stötteritzer Landstraße	Holzhausen, Probstheida
Stötteritzer Straße	Reudnitz-Thonberg
Stralsunder Straße	Mockau-Nord, Plaußig-Portitz, Thekla
Straßbergerstraße	Liebertwolkwitz
Straße am Park	Grünau-Ost, Kleinzschocher
Straße am See	Lausen-Grünau, Miltitz
Straße der 53	Lindenthal
Straße der Einheit	Burghausen-Rückmarsdorf
Straße des 17. Juni	Zentrum-Süd
Straße des 18. Oktober	Probstheida, Zentrum-Südost
Strelitzer Straße	Gohlis-Nord
Stresemannstraße	Engelsdorf
Stroganowweg	Meusdorf
Strümpellstraße	Probstheida
Stünzer Straße	Anger-Crottendorf
Stünzer Weg	Mölkau
Stünz-Mölkauer Weg	Sellerhausen-Stünz
Sturmweg	Sellerhausen-Stünz
Stuttgarter Allee	Grünau-Mitte, Schönau
Südblick	Paunsdorf
Südplatz	Südvorstadt
Südstraße	Böhlitz-Ehrenberg
Südtangente	Möckern, Wiederitzsch
Suhler Straße	Schönau
Sulzbacher Straße	Anger-Crottendorf
Swiftstraße	Möckern
Sybelstraße	Sellerhausen-Stünz
Sylter Straße	Gohlis-Nord
Syrakusweg	Knautkleeberg-Knauthain
Szendreistraße	Zentrum-Südost
Talstraße	Zentrum-Südost
Tannenwaldstraße	Wahren
Tannenweg	Holzhausen
Tarostraße	Zentrum-Südost
Täschners Garten	Holzhausen
Täschnerstraße	Probstheida
Täubchenweg	Reudnitz-Thonberg, Zentrum-Südost
Taubenbergweg	Hartmannsdorf-Knautnaundorf
Taubestraße	Schönefeld-Abtnaundorf
Tauchaer Straße	Mockau-Nord, Plaußig-Portitz, Thekla
Taurusweg	Grünau-Nord
Teerosenweg	Böhlitz-Ehrenberg
Teichgräberstraße	Lößnig
Teichmannstraße	Liebertwolkwitz
Teichstraße	Connewitz
Teichweg	Seehausen
Telemannstraße	Zentrum-Süd
Tellweg	Eutritzsch
Tennstedter Weg	Grünau-Siedlung
Teschstraße	Thekla
Teslastraße	Heiterblick, Thekla
Teubnerstraße	Reudnitz-Thonberg
Thaerstraße	Eutritzsch
Thärigenstraße	Möckern
Theklaer Straße	Schönefeld-Abtnaundorf, Schönefeld-Ost, Thekla
Theobald-Beer-Straße	Wiederitzsch
Theodor-Heuss-Straße	Paunsdorf, Sellerhausen-Stünz
Theodor-Kunz-Ring	Althen-Kleinpösna
Theodor-Neubauer-Straße	Anger-Crottendorf
Theodor-Voigt-Straße	Liebertwolkwitz
Theresienstraße	Eutritzsch, Zentrum-Nord
Thiemstraße	Stötteritz
Thierbacher Straße	Connewitz
Thieriotstraße	Schönefeld-Abtnaundorf
Thierschstraße	Probstheida
Thietmarstraße	Neulindenau
Thomasgasse	Zentrum
Thomasiusstraße	Zentrum-West
Thomaskirchhof	Zentrum
Thomas-Mann-Straße	Engelsdorf
Thomas-Müntzer-Straße	Lausen-Grünau
Thomas-Wagner-Straße	Mölkau
Thonberger Straße	Reudnitz-Thonberg
Threnaer Straße	Connewitz
Thünenstraße	Eutritzsch
Thüringer Straße	Neulindenau
Thymianweg	Wiederitzsch
Tieckstraße	Südvorstadt
Tiefe Straße	Anger-Crottendorf
Tiemannstraße	Plaußig-Portitz
Tilman-Riemenschneider-Weg	Paunsdorf
Tintlingsweg	Knautkleeberg-Knauthain
Tirolerweg	Probstheida
Tischbeinstraße	Schleußig
Titaniaweg	Grünau-Nord
Tollweg	Meusdorf
Topasstraße	Engelsdorf
Töpferstraße	Liebertwolkwitz
Töpferweg	Seehausen
Torgauer Platz	Volkmarsdorf
Torgauer Straße	Heiterblick, Paunsdorf, Plaußig-Portitz, Schönefeld-Ost, Sellerhausen-Stünz, Volkmarsdorf
Tornauer Straße	Wiederitzsch
Torstensonring	Lindenthal
Torweg	Marienbrunn
Toskastraße	Möckern
Tränkengraben	Probstheida
Trattendorfer Weg	Grünau-Siedlung
Traubengasse	Großzschocher
Travniker Straße	Möckern, Wahren
Trendelenburgstraße	Probstheida
Tresckowstraße	Gohlis-Mitte
Triftsiedlung	Lindenthal
Triftstraße	Miltitz
Triftweg	Marienbrunn
Trinitatisstraße	Anger-Crottendorf
Trögelweg	Probstheida
Tröndlinring	Zentrum, Zentrum-Nord
Trötzschelstraße	Schönefeld-Abtnaundorf
Trufanowstraße	Zentrum-Nord
Trusetaler Weg	Schönau
Tschaikowskistraße	Zentrum-Nordwest
Tschammerstraße	Anger-Crottendorf
Tschechenbogen	Probstheida
Tschernyschewskistraße	Mockau-Nord
Tübkebogen	Probstheida
Tucholskystraße	Burghausen-Rückmarsdorf
Tulpenweg	Sellerhausen-Stünz
Turgenjewstraße	Mockau-Nord
Türkisstraße	Engelsdorf
Turmalinstraße	Engelsdorf
Turmgutstraße	Gohlis-Süd
Turmweg	Marienbrunn
Turnerstraße	Zentrum-Südost
Uferstraße	Zentrum-Nord
Ugiwinkel	Probstheida
Uhlandstraße	Altlindenau
Uhlandweg	Mölkau
Uhrigstraße	Möckern
Ulmenweg	Mölkau
Ulmer Straße	Grünau-Mitte
Ulrichstraße	Gohlis-Süd
Undinenweg	Marienbrunn
Ungerstraße	Anger-Crottendorf
Universitätsstraße	Zentrum
Untere Eichstädtstraße	Stötteritz
Untere Mühlenstraße	Böhlitz-Ehrenberg
Untere Nordstraße	Holzhausen
Unterer Sandweg	Lindenthal
Uranusstraße	Grünau-Nord
Ursula-Götze-Straße	Thekla
Usedomer Straße	Möckern
Václav-Neumann-Straße	Stötteritz
Vater-Jahn-Straße	Lindenthal
Veilchenweg	Miltitz
Verdistraße	Engelsdorf
Verlängerte Max-Liebermann-Straße	Möckern
Verlängerte Schwedenstraße	Lindenthal
Verlängerte Wilhelmstraße	Lindenthal
Verrinaweg	Thekla
Viaduktweg	Wiederitzsch
Vierackerwiesen	Leutzsch
Viertelsweg	Gohlis-Mitte, Gohlis-Nord
Vierzehn-Bäume-Weg	Mockau-Nord
Viktoriastraße	Reudnitz-Thonberg
Virchowstraße	Eutritzsch, Gohlis-Mitte, Gohlis-Nord
Vivaldistraße	Engelsdorf
Vlamenstraße	Wahren
Voigtstraße	Neulindenau
Volbedingstraße	Mockau-Süd, Schönefeld-Abtnaundorf
Volckmarstraße	Reudnitz-Thonberg
Volkmarsdorfer Markt	Volkmarsdorf
Volksgartenstraße	Schönefeld-Ost
Vollhardtstraße	Dölitz-Dösen
Voltairestraße	Möckern
Voltaweg	Stötteritz
Vor dem Hospitaltore	Reudnitz-Thonberg, Zentrum-Südost
Vordere Schlobachstraße	Böhlitz-Ehrenberg
Wachauer Straße	Stötteritz
Wachberg	Burghausen-Rückmarsdorf
Wachbergallee	Burghausen-Rückmarsdorf
Wacholderweg	Liebertwolkwitz
Wachsmuthstraße	Plagwitz
Wachtelsteig	Knautkleeberg-Knauthain
Wächterstraße	Zentrum-Süd
Wahrener Straße	Lindenthal, Wahren
Waldbaurstraße	Schönefeld-Abtnaundorf
Waldblick	Böhlitz-Ehrenberg
Waldemar-Götze-Straße	Thekla
Waldkerbelstraße	Paunsdorf
Waldmeisterweg	Böhlitz-Ehrenberg
Waldplatz	Zentrum-Nordwest
Waldrebenweg	Engelsdorf
Waldstraße	Zentrum-Nordwest
Waldweg	Connewitz
Waldwinkel	Burghausen-Rückmarsdorf
Waldzieststraße	Paunsdorf
Walnußweg	Knautkleeberg-Knauthain
Walter-Albrecht-Weg	Mockau-Nord
Walter-Barth-Straße	Sellerhausen-Stünz
Walter-Cramer-Straße	Gohlis-Mitte
Walter-Günther-Weg	Baalsdorf
Walter-Heinze-Straße	Plagwitz
Walter-Heise-Straße	Holzhausen
Walter-Köhn-Straße	Seehausen
Walter-Markov-Ring	Holzhausen
Walterweg	Probstheida
Walther-Rathenau-Straße	Liebertwolkwitz
Wangerooger Weg	Gohlis-Nord
Wartenburgstraße	Wahren
Wasserstraße	Altlindenau
Wasserturmstraße	Engelsdorf
Wasserturmweg	Großzschocher
Wasserwerkstraße	Engelsdorf
Wasserwerksweg	Seehausen
Wasunger Straße	Schönau
Watestraße	Lößnig
Watzdorfstraße	Sellerhausen-Stünz
Weberknechtstraße	Heiterblick
Wegastraße	Grünau-Nord
Weheweg	Knautkleeberg-Knauthain
Wehrmannstraße	Gohlis-Nord
Weickmannweg	Lausen-Grünau
Weidenbachplan	Anger-Crottendorf
Weidenhof	Mockau-Süd
Weidenhofweg	Mockau-Süd
Weidenweg	Großzschocher
Weidlichstraße	Sellerhausen-Stünz
Weidmannstraße	Neustadt-Neuschönefeld
Weidmannweg	Knautkleeberg-Knauthain
Weigandtweg	Knautkleeberg-Knauthain
Weigelienstraße	Paunsdorf
Weimarer Straße	Schönau
Weinberg	Burghausen-Rückmarsdorf
Weinbergstraße	Leutzsch
Weinbrennerstraße	Sellerhausen-Stünz
Weinligstraße	Gohlis-Süd
Weißdornstraße	Grünau-Ost
Weißdornweg	Holzhausen
Weißenfelser Straße	Plagwitz
Weißeplatz	Stötteritz
Weißestraße	Stötteritz
Weizenweg	Wiederitzsch
Wenckstraße	Schönefeld-Abtnaundorf
Wendelin-Hipler-Weg	Knautkleeberg-Knauthain
Wendenstraße	Wahren
Wendlerstraße	Plagwitz
Werfelstraße	Plaußig-Portitz
Werkstättenstraße	Engelsdorf, Paunsdorf
Werkstättenweg	Eutritzsch
Werkstraße	Hartmannsdorf-Knautnaundorf
Wermsdorfer Straße	Connewitz
Wernerstraße	Sellerhausen-Stünz
Wertheimer Straße	Grünau-Siedlung
Westplatz	Zentrum-West
Weststraße	Lindenthal
Wettiner Straße	Zentrum-Nordwest
Wetzelweg	Knautkleeberg-Knauthain
Wichernstraße	Anger-Crottendorf
Wiebelstraße	Anger-Crottendorf, Volkmarsdorf
Wiedebachplatz	Connewitz
Wiedebachstraße	Connewitz
Wiederitzscher Landstraße	Lindenthal, Wiederitzsch
Wiederitzscher Straße	Gohlis-Süd, Möckern
Wiederitzscher Weg	Möckern
Wielandstraße	Altlindenau
Wieselsteig	Knautkleeberg-Knauthain
Wieselstraße	Heiterblick
Wiesenblumenweg	Holzhausen
Wiesengrund	Liebertwolkwitz
Wiesenrain	Böhlitz-Ehrenberg, Burghausen-Rückmarsdorf
Wiesenring	Lützschena-Stahmeln
Wiesenstraße	Paunsdorf
Wiesenweg	Engelsdorf
Wiesenwinkel	Wiederitzsch
Wigandstraße	Kleinzschocher
Wigmanstraße	Plaußig-Portitz
Wildbuschweg	Engelsdorf
Wildentensteig	Knautkleeberg-Knauthain
Wildschweinpfad	Knautkleeberg-Knauthain
Wilhelm-Busch-Straße	Mockau-Nord, Mockau-Süd
Wilhelm-His-Straße	Probstheida
Wilhelminenstraße	Eutritzsch
Wilhelm-Leuschner-Platz	Zentrum, Zentrum-Süd
Wilhelm-Liebknecht-Platz	Zentrum-Nord
Wilhelm-Michel-Straße	Großzschocher
Wilhelm-Pfennig-Straße	Lindenthal
Wilhelm-Plesse-Straße	Gohlis-Mitte
Wilhelm-Sammet-Straße	Eutritzsch, Gohlis-Mitte
Wilhelm-Seyfferth-Straße	Zentrum-Süd
Wilhelmstraße	Lindenthal
Wilhelm-Wild-Straße	Schleußig
Wilhelm-Winkler-Straße	Böhlitz-Ehrenberg
Wilhelm-Wundt-Platz	Zentrum-Süd
William-Zipperer-Straße	Altlindenau, Leutzsch
Willi-Bredel-Straße	Lößnig
Willmar-Schwabe-Ring	Mölkau
Willmar-Schwabe-Straße	Zentrum-West
Willy-Brandt-Platz	Zentrum, Zentrum-Nord, Zentrum-Ost
Wilsnacker Straße	Grünau-Siedlung
Wincklerstraße	Dölitz-Dösen
Windmühlenstraße	Zentrum-Süd, Zentrum-Südost
Windmühlenweg	Lützschena-Stahmeln
Windorfer Straße	Kleinzschocher
Windscheidstraße	Connewitz
Windsheimer Straße	Grünau-Siedlung
Wingertgasse	Großzschocher
Winkelstraße	Gohlis-Süd
Wintergartenstraße	Zentrum-Ost
Wintzingerodeweg	Meusdorf
Winzerweg	Plaußig-Portitz
Wiprechtstraße	Neulindenau
Wiskenstraße	Lindenthal, Wahren
Witkowskistraße	Mockau-Nord
Wittenberger Straße	Eutritzsch
Wittestraße	Böhlitz-Ehrenberg
Wittgensteinweg	Meusdorf
Wittstockstraße	Reudnitz-Thonberg
Witzgallstraße	Reudnitz-Thonberg
Witzlebenstraße	Gohlis-Nord
Wöbbeliner Straße	Lindenthal, Wiederitzsch
Wodanstraße	Heiterblick, Thekla
Wognaundorfer Gasse	Schönefeld-Abtnaundorf
Wohlgemuthstraße	Leutzsch
Wolfener Straße	Gohlis-Süd
Wolffstraße	Möckern
Wolfgang-Heinze-Straße	Connewitz
Wolfshainer Straße	Reudnitz-Thonberg
Wölkauer Weg	Eutritzsch
Wolkenweg	Lausen-Grünau
Wollkämmereistraße	Schönefeld-Abtnaundorf
Wöllnerstraße	Großzschocher
Wolteritzer Weg	Eutritzsch
Wörlitzer Straße	Eutritzsch
Wunderlichstraße	Probstheida
Wundtstraße	Connewitz, Dölitz-Dösen, Südvorstadt, Zentrum-Süd
Würkertstraße	Gohlis-Mitte
Würzburger Straße	Grünau-Siedlung
Wurzner Straße	Anger-Crottendorf, Neustadt-Neuschönefeld, Sellerhausen-Stünz, Volkmarsdorf
Wustmannstraße	Gohlis-Mitte
Wuttkestraße	Schönefeld-Ost
Yorck-Diebitsch-Straße	Böhlitz-Ehrenberg
Yorckstraße	Möckern
Zadestraße	Probstheida
Zauberweg	Marienbrunn
Zaucheblick	Holzhausen
Zaucheweg	Baalsdorf
Zaunkönigweg	Seehausen
Zedernholzweg	Böhlitz-Ehrenberg
Zehmenstraße	Wahren
Zehmischstraße	Lößnig
Zeisigweg	Wahren
Zeitzer Straße	Hartmannsdorf-Knautnaundorf
Zentralstraße	Zentrum-West
Zerbster Straße	Eutritzsch
Zeumerstraße	Schönefeld-Abtnaundorf
Ziegeleiweg	Wiederitzsch
Ziegelstraße	Baalsdorf, Holzhausen
Zillerstraße	Reudnitz-Thonberg
Zillstraße	Gohlis-Nord
Zimmerstraße	Zentrum-West
Zingster Straße	Lausen-Grünau
Zinnienweg	Engelsdorf
Ziolkowskistraße	Mockau-Nord
Zirkonstraße	Engelsdorf
Zittauer Straße	Schönefeld-Abtnaundorf
Ziustraße	Thekla
Zolaweg	Meusdorf
Zollikoferstraße	Volkmarsdorf
Zöllnerweg	Zentrum-Nordwest
Zollschuppenstraße	Plagwitz
Zschampertaue	Lausen-Grünau
Zschochersche Allee	Lausen-Grünau
Zschochersche Straße	Altlindenau, Lindenau, Plagwitz
Zschölkauer Weg	Eutritzsch
Zschopauer Straße	Thekla
Zschortauer Straße	Eutritzsch, Wiederitzsch
Zu den Bruchwiesen	Burghausen-Rückmarsdorf
Zu den Drei Kugeln	Lindenthal
Zu den Gärten	Mockau-Süd
Zu den Wiesen	Mockau-Süd
Zuckelhausener Ring	Holzhausen
Zuckelhäuser Straße	Stötteritz
Zum Alten Seebad	Althen-Kleinpösna, Baalsdorf
Zum Alten Wasserwerk	Baalsdorf
Zum Althener Sportplatz	Althen-Kleinpösna
Zum Apelstein	Lindenthal
Zum Auwald	Lützschena-Stahmeln
Zum Bahnhof	Burghausen-Rückmarsdorf
Zum Birkenwäldchen	Plaußig-Portitz
Zum Denkmal	Liebertwolkwitz
Zum Dölitzer Schacht	Dölitz-Dösen
Zum Feld	Wiederitzsch
Zum Förderturm	Dölitz-Dösen, Lößnig, Probstheida
Zum Forstgut	Böhlitz-Ehrenberg
Zum Frischemarkt	Lützschena-Stahmeln
Zum Haksch	Lützschena-Stahmeln
Zum Harfenacker	Leutzsch
Zum Kalten Born	Lützschena-Stahmeln
Zum Kleewinkel	Burghausen-Rückmarsdorf
Zum Kleingartenpark	Sellerhausen-Stünz
Zum Leutzscher Holz	Böhlitz-Ehrenberg
Zum Lippenplan	Baalsdorf, Mölkau
Zum Rosengarten	Liebertwolkwitz
Zum Schwinderplan	Baalsdorf
Zum Sonnenblick	Engelsdorf
Zum Wald	Lindenthal
Zum Waldbad	Böhlitz-Ehrenberg
Zum Wäldchen	Paunsdorf
Zum Wasserturm	Liebertwolkwitz
Zum Winkel	Lützschena-Stahmeln
Zur Alten Bäckerei	Großzschocher
Zur Alten Brauerei	Lützschena-Stahmeln
Zur Alten Sandgrube	Liebertwolkwitz
Zur Alten Schmiede	Lindenthal
Zur Alten Weintraube	Liebertwolkwitz
Zur Bauernwiese	Lindenthal
Zur Grünen Ecke	Engelsdorf
Zur Heide	Lausen-Grünau
Zur Kuhweide	Liebertwolkwitz
Zur Lehmbahn	Böhlitz-Ehrenberg
Zur Lindenhöhe	Lindenthal
Zur Loberaue	Seehausen
Zur Rodelbahn	Burghausen-Rückmarsdorf
Zur Sägemühle	Böhlitz-Ehrenberg
Zur Schule	Wiederitzsch
Zur Weißen Mark	Hartmannsdorf-Knautnaundorf
Zur Ziegelei	Böhlitz-Ehrenberg
Zusestraße	Böhlitz-Ehrenberg
Zweenfurther Straße	Sellerhausen-Stünz
Zweifelstraße	Probstheida
Zweinaundorfer Straße	Anger-Crottendorf, Baalsdorf, Mölkau
Zwenkauer Straße	Connewitz
Zwergasternweg	Böhlitz-Ehrenberg
Zwergenweg	Marienbrunn
Zwergmispelstraße	Paunsdorf
Zwetschgenweg	Mölkau
Zwickauer Straße	Lößnig, Marienbrunn, Zentrum-Südost
Zwiebelweg	Wiederitzsch');

echo processArray($a); 

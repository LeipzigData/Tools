-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 07, 2016 at 10:45 PM
-- Server version: 5.1.73-log
-- PHP Version: 5.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `grinch_drupal_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `aae_data_adresse`
--

CREATE TABLE IF NOT EXISTS `aae_data_adresse` (
  `ADID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID für Adressen',
  `strasse` varchar(100) DEFAULT '' COMMENT 'Straßenname',
  `adresszusatz` varchar(100) DEFAULT '' COMMENT 'Adresszusatz wie Hinterhof oder a',
  `bezirk` int(10) unsigned DEFAULT '0' COMMENT 'Bezirk',
  `nr` varchar(100) DEFAULT '' COMMENT 'Hausnummer',
  `plz` varchar(100) DEFAULT '' COMMENT 'Postleitzahl',
  `gps` varchar(100) DEFAULT '' COMMENT 'GPS-Koordinaten für Karte',
  PRIMARY KEY (`ADID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabelle für Adressen' AUTO_INCREMENT=81 ;

--
-- Dumping data for table `aae_data_adresse`
--

INSERT INTO `aae_data_adresse` (`ADID`, `strasse`, `adresszusatz`, `bezirk`, `nr`, `plz`, `gps`) VALUES
(1, '', '', 1, '', '', ''),
(2, 'Hildegardstraße', 'Zugang über 49', 21, '49/51', '04315', ''),
(3, '', '', 2, '', '', ''),
(4, 'Hildegardstraße', '', 21, '49', '04315', ''),
(5, 'Hildegardstraße', '', 21, '51', '04315', ''),
(6, 'Hildegardstraße', '', 21, '01', '04315', ''),
(7, 'Konradstraße', '(über ALDI)', 20, '27', '04315', ''),
(8, 'Eisenbahnstraße', 'c/o InfoCenter Eisenbahnstraße', 20, '49', '04315', '51.342,12.375'),
(9, '', '', 41, '', '', ''),
(10, 'Hildegardstraße', 'Hinterhof', 21, '49', '04315', ''),
(11, 'Teststraße', '', 1, '1', '04567', ''),
(12, 'Laden auf Zeit, Kohlgartenstr.', '', 2, '51', '04315', ''),
(13, 'Kohlgartenstrasse', '', 2, '51', '04315', '51.3423112,12.3992969'),
(14, 'Hedwigstraße', '', 20, '20', '04315', '51.346596,12.403096'),
(15, 'wer', 'werq', 16, 'wer', 'werwer', ''),
(16, 'Ossietzkystr.', '', 2, '19', '04347', ''),
(17, 'Muusteralle', '', 30, '19', '04317', ''),
(18, '', '', 7, '', '', ''),
(19, 'stststs', '', 15, '4', '1234', ''),
(20, '', '', 19, '', '', ''),
(21, 'haus', 'hinten', 19, '1', '12345', ''),
(22, 'straße', 'vorn', 4, '5', '12345', ''),
(23, '', '', 13, '', '', ''),
(24, 'straße', 'hinterhof', 17, '12', '12345', ''),
(25, '', '', 3, '', '', ''),
(26, '', '', 15, '', '', ''),
(27, 'Hildegardstraße', 'Helden wider Willen e.V.', 21, '49', '04315', '52.161542,8.0490356'),
(28, 'Kochstraße', 'Cammerspiele Leipzig', 37, '132', '04277', ''),
(29, 'Ossietzkystr.', '', 15, '19', '04347', ''),
(30, 'Ossietzkystr.', '', 3, '19', '04347', ''),
(31, 'Ossietzkystr.', ',', 16, '19', '04347', ''),
(32, 'qwe', 'adressz', 12, 'nr', 'plz', '14.946207,101.992222'),
(33, 'qwe', 'adressz', 12, 'nr', 'plz', '14.946207,101.992222'),
(34, 'wer', 'wer', 2, 'wer', 'wer', '-6.711,108.5037'),
(35, 'wer', 'wer', 2, 'wer', 'wer', '-6.711,108.5037'),
(36, 'wer', 'wer', 2, 'wer', 'wer', '-6.711,108.5037'),
(37, 'wer', 'wer', 2, 'wer', 'wer', '-6.711,108.5037'),
(38, '@', '', 12, '', '', ''),
(39, '@', '', 12, '', '', ''),
(40, '@', '', 12, '', '', ''),
(41, 'Eisenbahnstraße', 'im OFT Rabet', 20, '54', '04315', ''),
(42, 'Torgauer Platz', 'Tonne', 21, '2', '04315', ''),
(43, 'Ossietzkystr.', '', 9, '19', '04347', '52.573086,13.407617'),
(44, 'Ossietzkystr.', '', 9, '19', '04347', '52.573086,13.407617'),
(45, 'Ossietzkystr.', '', 9, '19', '04347', '52.573086,13.407617'),
(46, '', '', 3, '', '', ''),
(47, '', '', 3, '', '', ''),
(48, '', '', 3, '', '', ''),
(49, '', '', 16, '', '', ''),
(50, '', '', 16, '', '', ''),
(51, '', '', 16, '', '', ''),
(52, '', '', 16, '', '', ''),
(53, '', '', 17, '', '', ''),
(54, '', '', 18, '', '', ''),
(55, '', '', 12, '', '', ''),
(56, 'Hildergardstrassee', '49 über den Hinterhof', 21, '51', '04315', 'Ermittle Geo-Koordinaten...'),
(57, 'Hildegardstraße', '49 über den Hinterhof', 21, '51', '04315', '51.3431029,12.4070104'),
(58, '', '', 5, '', '', ''),
(59, '', '', 18, '', '', ''),
(60, '', '', 18, '', '', ''),
(61, 'Eisenbahnstraße', 'Café Caba', 21, '147', '04315', '48.719173,9.402638'),
(62, '', '', 21, '', '', ''),
(63, 'Ossietzkystrasse', '', 10, '19', '04347', '51.359697,12.409615'),
(64, 'Ossietzkystrasse', '', 16, '19', '04347', '51.359697,12.409615'),
(65, 'Hedwigstraße', 'Atelieretage', 20, '20', '04315', '51.346596,12.403096'),
(66, 'Hedwigstraße', 'Atelieretage', 20, '20', '04317', '51.346596,12.403096'),
(67, 'Dresdner Straße Hinterhof', 'Obere Etage', 30, '84', '04317', '51.3391931,12.3988189'),
(68, 'Hildegardstraße', '', 21, '49', '04315', '52.161542,8.0490356'),
(69, 'Eisenbahnstraße', '', 21, '113b', '04315', 'Ermittle Geo-Koordinaten...'),
(70, 'Eisenbahnstraße', '', 21, '113b', '04315', 'Ermittle Geo-Koordinaten...'),
(71, '', '', 15, '', '', ''),
(72, '', '', 16, '', '', ''),
(73, 'Hedwigstraße', '', 20, '7', '04315', '51.342,12.375'),
(74, 'Hediwgstr.', '', 20, '7', '04315', 'Ermittle Geo-Koordinaten...'),
(75, 'Hedwigstr.', '', 20, '7', '04315', '51.342,12.375'),
(76, 'Eisenbahnstraße', '', 21, '157', '04315', '51.345989,12.399316'),
(77, '', '', 20, '', '', ''),
(78, 'Gabelsbergerstr.', '', 20, '30', '04317', 'Ermittle Geo-Koordinaten...'),
(79, '', '', 22, '', '', ''),
(80, 'Dresdner Straße', '', 30, '59', '04317', '51.338952,12.402913');

-- --------------------------------------------------------

--
-- Table structure for table `aae_data_akteur`
--

CREATE TABLE IF NOT EXISTS `aae_data_akteur` (
  `AID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID für Akteur',
  `name` varchar(100) NOT NULL COMMENT 'Name des Akteurs/der Organisation',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT 'Email Adresse zur Kontaktaufnahme',
  `telefon` varchar(100) DEFAULT '' COMMENT 'Telefonnummer zur Kontaktaufnahme',
  `url` varchar(100) DEFAULT '' COMMENT 'Link zur eigenen Homepage',
  `ansprechpartner` varchar(100) DEFAULT '' COMMENT 'Öffentlicher Ansprechpartner',
  `funktion` varchar(100) DEFAULT '' COMMENT 'Funktion des Ansprechpartners',
  `bild` varchar(400) DEFAULT '' COMMENT 'Pfad zum hinterlegten Bild',
  `beschreibung` text COMMENT 'Kurzbeschreibung für Übersicht',
  `oeffnungszeiten` varchar(200) DEFAULT '' COMMENT 'Wann der Akteur erreichbar ist',
  `adresse` int(10) unsigned DEFAULT '0' COMMENT 'Verweis auf Adresse',
  `ersteller` int(10) unsigned DEFAULT '0' COMMENT 'ID von User, der Akteur angelegt hat',
  `created` datetime DEFAULT NULL COMMENT 'Created als Timestamp',
  `modified` datetime DEFAULT NULL COMMENT 'Modified als Timestamp',
  PRIMARY KEY (`AID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabelle für Akteure' AUTO_INCREMENT=50 ;

--
-- Dumping data for table `aae_data_akteur`
--

INSERT INTO `aae_data_akteur` (`AID`, `name`, `email`, `telefon`, `url`, `ansprechpartner`, `funktion`, `bild`, `beschreibung`, `oeffnungszeiten`, `adresse`, `ersteller`, `created`, `modified`) VALUES
(2, 'Helden wider Willen e.V.', 'ariane@eexistence.de', '0178/475 466 9', 'baumit.weebly.com', 'Ariane Jedlitschka', 'Vorstand', '/sites/default/files/styles/large/public/field/image/leipziger_ecken.jpg', 'Verein für Stadtteilkultur und Nachbarschaften.', 'jeden Donnerstag von 10:00 - 17:00', 2, 0, NULL, NULL),
(5, 'Initiative Ost-Passage Theater', 'Daniel.Schade@ost-passage-theater.de', '---', 'ost-passage-theater.de', 'Daniel Schade', 'Organisation, Dramaturgie und Pressearbeit', '/sites/default/files/pictures/aae/OstPT_LOGO_FINALE.gif', 'Als Ort des sozialen, gemeinwohlorientierten und kreativen Miteinanders &uuml;ber die Schichten und Milieus hinweg soll das Ost-Passage Theater gleichzeitig Sprachrohr und Impulsgeber sein f&uuml;r die Ideen, W&uuml;nsche und Utopien derjenigen, die sich diesen Freiraum mit uns erobern und beleben.', '(in Sanierung)', 7, 0, NULL, NULL),
(6, 'Quartiers-management Leipziger Osten', 'qm@leipziger-osten.de', '0341 3513 7913', 'http://www.leipziger-osten.de', 'Matthias Schirmer', 'Stadtteilmoderator', '/sites/default/files/pictures/aae/05aa66aa125a8b6ac3.jpg', 'Das Quartiersmanagement (QM) versteht sich als Mittler zwischen den verschiedenen Akteuren im Stadtteil (Bewohner, Vereine/Initiativen, Einrichtungen) untereinander sowie zwischen Stadtteilakteuren und Stadtverwaltung. Das Quartiersmanagement ist ein Projekt der Stadt Leipzig und wird gef&ouml;rdert aus dem Bund-L&auml;nder-Programm &quot;Soziale Stadt&quot; im Leipziger Osten. Projekttr&auml;ger: CivixX - Werkstatt f&uuml;r Zivilgesellschaft.', '', 8, 0, NULL, NULL),
(10, 'Jazzkollektiv Leipzig', 'luisevolkmann@gmx.de', '', 'http://jazzkollektiv-leipzig.de/', 'Luise Volkmann', '', '', 'Das Jazzkollektiv hat es sich zum Ziel gesetzt die Leipziger Jazzszene zu featuren und gleichzeitig zeitgen&ouml;ssichen Jazz in der Stadt zu pr&auml;sentieren und ein Publikum daf&uuml;r zu generieren. Au&szlig;erdem geh&ouml;ren sozialpolitische Bereiche wie Arbeit mit Kindern und Jugendlichen dazu.', 'Jeden erster Montag im Monat', 13, 31, NULL, NULL),
(11, 'Pöge-Haus e.V.', 'kontakt@verein.poege-haus.de', '', 'verein.poege-haus.de', 'Stefan Kausch', 'Vorsitzender Pöge-Haus e.V.', '/sites/default/files/styles/large/public/field/image/Logo PHeV.jpg', '', '', 14, 32, NULL, NULL),
(16, 'IG FORTUNA | Kino der Jugend', 'Daniel.Schade@ost-passage-theater.de', '', 'http://ig-fortuna.de', 'Daniel Schade', 'Pressesprecher', '/sites/default/files/pictures/aae/LOGO IG Fortuna.jpg', 'Die Interessensgemeinschaft FORTUNA | Kino der Jugend versammelt Organisationen, Gruppen und Einzelpersonen in nachbarschaftlich gleichberechtigter Runde zu dem Zweck, das ehemalige &quot;Kino der Jugend&quot; (Eisenbahnstra&szlig;e 162) vor dem fortschreitenden baulichen Verfall und den st&auml;dtischen Abrisspl&auml;nen zu retten sowie einer &ouml;ffentlichen kulturellen Nutzung in historischer Kontinuit&auml;t zuzuf&uuml;hren.', '', 27, NULL, NULL, NULL),
(33, 'FabLab Leipzig', 'contact@fablab-leipzig.de', '01633149507', 'www.fablab-leipzig.de', 'Matthias Petzold', 'Labmanager', '/sites/default/files/pictures/aae/fablab_logo_le.png', 'Ein FabLab f&uuml;r alle!Wir m&ouml;chten euch eine offene digitale Werkstatt mit laborcharakter bieten. Einen Ort an dem ihr eure Ideen in einem iterativen Prozess ausprobieren k&ouml;nnt. Wo ihr auf gleichgesinnte trefft und Kooperationen bildet, um gemeinsam an der Entwicklung von Produkten teilzuhaben.Wir versuchen euch eine FabLab Infrastruktur zur Verf&uuml;gung zustellen.Eine Kooperative, welche sich gegenseitig bei der Entwicklung von Ideen, Produkten und Konzepten weiterhilft.', '', 57, 10, NULL, NULL),
(37, 'KollektivArtesMobiles', 'contact@kollektivartesmobiles.com', '', 'www.kollektivartesmobiles.com', 'Nina Maria Stemberger', '', '/sites/default/files/pictures/aae/SquareLand.jpg', 'Wir entwickeln verschiedene Formate, in denen wir unser individuelles Kunstverst&auml;ndnis ausleben und neue Wege der Beziehung zwischen Publikum und Akteur_Innen erforschen. In dem Versuch die klassische Abgrenzung zwischen Theater, bildender Kunst und Musik aufzubrechen, kombinieren wir in unseren Performances diese Kunstformen mit den Technologien der zeitgen&ouml;ssischen Medien in einem neuen Format: augmented theatre.', '', 62, 58, NULL, NULL),
(39, 'Kerstin Köppen', 'kontakt@meinholzhandwerk.de', '01733160186', 'www.meinholzhandwerk.de', 'Kerstin Köppen', 'Kursleitung', '/sites/default/files/pictures/aae/ProfilbildKerKoe.jpg', 'Kursangebote im Bereich der Bildenden Kunst, Bildhauerei, offene Grafikwerkstatt. Workshopangebot an Samstagen und zu speziellen Veranstaltungen des P&ouml;ge-Haus e.V. Gern Kursangebot in Kooperation mit Akteuren des Leipziger Ostens, wie z.B. Freien Tr&auml;gern, Schulen oder Vereinen.', 'ab März 2016 auf Anfrage und an Samstagen', 65, 63, NULL, NULL),
(40, 'Zündkerzenwerkstatt KUNST|KULTUR|HANDWERK', 'zuendkerzenwerkstatt@gmx.de', '', 'https://www.facebook.com/zuendkerzenwerkstatt/', 'Kerstin Köppen', 'Vermietung und Veranstaltung', '/sites/default/files/pictures/aae/ZueKeWe hanging.jpg', 'Wir sind eine k&uuml;nstlerisch-handwerkliche Ansammlung kreativer K&ouml;pfe,die den Leipziger Osten mit Kultur, Handwerk und Kunst bereichern wollen.ateliergemeinschaft/werkst&auml;tten/kunst/kultur/veranstaltungsort', 'nach Absprache', 67, 63, NULL, NULL),
(41, 'Grüne Liga Kohrener Land e:V.', 'kohrenerland@grueneliga.de', '0163/3149507', '', 'Tomas Brückmann', 'Vorstand', '/sites/default/files/pictures/aae/18e9409fc8463bc4b7.jpg', '', '', 68, 74, NULL, NULL),
(44, 'Offener Treff für Kinder und Jugendliche »Tante Hedwig«', 'Tante-Hedwig.Leipzig@internationaler-bund.de', '03417 6884696', 'https://www.facebook.com/IB-Offener-Treff-Tante-Hedwig-339073406217093/?fref=ts', 'Herr Schmidt, Frau Franke', 'Mitarbeiter im Treff', '/sites/default/files/pictures/aae/a4cc71f2e622fbc731.jpg', 'Die &quot;Tante Hedwig&quot; ist ein Kinder- und Jugendtreff f&uuml;r die Zielgruppe 6-27 Jahren.Hier kann man:Dart, * Kicker, Playstation, Wii spielenan * an der Cluliga teilnehmen * im Internet surfen * neue Leute kennenlernengemeinsam * Musik h&ouml;ren &amp; Filme anschauen * mit uns kochen, backen, basteln * Ferienangebote nutzen * an gr&ouml;&szlig;eren Workshops teilnehmen (Hiphop, Pakour, Graffitti, Sportangebote, etc.) * Unterst&uuml;tzung bei euren&nbsp;Hausaufgaben bekommen * mit uns zusammen Bewerbungen erstellen, f&uuml;r Einstellungstests trainieren, f&uuml;r Vorstellungsgespr&auml;che &uuml;ben * an euren eigenen Fahrr&auml;dern schrauen und vieles mehr ..', 'Mo-Do 14-20 / Fr 14-19', 73, 77, NULL, NULL),
(45, 'Förderverein Bülowgärten', 'foerderverein@buelowviertel-ev.de', '', 'http://www.buelowviertel-leipzig.de/foerderverein-buelowgaerten-e-v/', 'Paula Hofmann', 'Vorstand', '/sites/default/files/pictures/aae/4c6025fcf27227a2bf.jpg', '', '', 76, 82, NULL, NULL),
(46, 'Die Wunderfinder - Bildungspatenprojekt im Leipziger Osten', 'post@buergerfuerleipzig.de', '0341/960 15 30', 'http://www.diewunderfinder.de', 'Stiftung Bürger für Leipzig', 'Projektkoordination', '/sites/default/files/pictures/aae/af1478b111f56898db.jpg', '', '', 77, 83, NULL, NULL),
(47, 'Kinder- und Jugendkulturzentrum O.S.K.A.R.', 'jkz_oskar@t-online.de', '0341-6865680', 'oskarinleipzig.de', 'Ellen Heising', 'Leiterin', '/sites/default/files/pictures/aae/4efdd2f969559e8b1c.jpg', '', '', 78, 84, NULL, NULL),
(48, 'Bürgerverein Anger-Crottendorf', 'info@koenigreich-crottendorf.de', '', 'http://koenigreich-crottendorf.de/', '', '', '/sites/default/files/pictures/aae/462bd9c5416245b918.jpg', '', '', 79, 86, NULL, NULL),
(49, 'Dresdner59', 'stadtteilprojekt@dresdner59.de', '0341/12591579', 'www.dresdner59.de', 'Johanna Pahl', 'Projektkoordination', '/sites/default/files/pictures/aae/0e8c934e881021b692.jpg', '', 'Dienstag, Mittwoch, Donnerstag 15 - 18 Uhr, sowie zu den einzelnen Veranstaltungen', 80, 30, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aae_data_akteur_hat_event`
--

CREATE TABLE IF NOT EXISTS `aae_data_akteur_hat_event` (
  `EID` int(10) unsigned NOT NULL COMMENT 'ID für Event',
  `AID` int(10) unsigned NOT NULL COMMENT 'ID für Akteur',
  PRIMARY KEY (`EID`,`AID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabelle fuer Zuordnung aller Akteure zu einem Event';

--
-- Dumping data for table `aae_data_akteur_hat_event`
--

INSERT INTO `aae_data_akteur_hat_event` (`EID`, `AID`) VALUES
(11, 2),
(15, 0),
(16, 6),
(17, 0),
(22, 16),
(23, 16),
(25, 39),
(27, 33),
(29, 44),
(30, 6),
(31, 49),
(32, 0);

-- --------------------------------------------------------

--
-- Table structure for table `aae_data_akteur_hat_sparte`
--

CREATE TABLE IF NOT EXISTS `aae_data_akteur_hat_sparte` (
  `hat_AID` int(10) unsigned NOT NULL COMMENT 'ID für Akteur',
  `hat_KID` int(10) unsigned NOT NULL COMMENT 'ID für Kategorien',
  PRIMARY KEY (`hat_AID`,`hat_KID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Hilfstabelle für Sparten/Zielgruppen';

--
-- Dumping data for table `aae_data_akteur_hat_sparte`
--

INSERT INTO `aae_data_akteur_hat_sparte` (`hat_AID`, `hat_KID`) VALUES
(5, 155),
(5, 156),
(5, 157),
(6, 200),
(6, 201),
(6, 202),
(6, 203),
(6, 204),
(6, 205),
(9, 1),
(10, 5),
(16, 158),
(16, 159),
(16, 160),
(16, 161),
(16, 162),
(21, 6),
(21, 7),
(21, 8),
(21, 9),
(21, 10),
(21, 11),
(22, 19),
(22, 20),
(22, 21),
(22, 22),
(23, 12),
(23, 13),
(23, 14),
(25, 15),
(25, 16),
(25, 17),
(28, 6),
(28, 15),
(28, 18),
(29, 20),
(30, 23),
(30, 24),
(31, 20),
(31, 25),
(32, 5),
(32, 26),
(32, 27),
(32, 28),
(33, 52),
(33, 53),
(33, 54),
(33, 55),
(33, 56),
(33, 57),
(33, 58),
(33, 59),
(33, 60),
(33, 61),
(33, 62),
(33, 63),
(33, 64),
(39, 173),
(39, 174),
(40, 177),
(40, 178),
(40, 179),
(40, 180),
(40, 181),
(41, 182),
(41, 183),
(41, 184),
(41, 185),
(41, 186),
(41, 187),
(41, 188),
(44, 41),
(44, 189),
(44, 190),
(44, 191),
(44, 192),
(44, 193),
(44, 194),
(44, 195),
(44, 196),
(45, 197),
(45, 198),
(45, 199);

-- --------------------------------------------------------

--
-- Table structure for table `aae_data_akteur_hat_user`
--

CREATE TABLE IF NOT EXISTS `aae_data_akteur_hat_user` (
  `hat_UID` int(10) unsigned NOT NULL COMMENT 'ID für User',
  `hat_AID` int(10) unsigned NOT NULL COMMENT 'ID für Akteure',
  PRIMARY KEY (`hat_AID`,`hat_UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Hilfstabelle für Schreibrechte auf Akteursseiten';

--
-- Dumping data for table `aae_data_akteur_hat_user`
--

INSERT INTO `aae_data_akteur_hat_user` (`hat_UID`, `hat_AID`) VALUES
(13, 2),
(21, 5),
(22, 6),
(31, 10),
(32, 11),
(21, 16),
(10, 33),
(58, 37),
(63, 39),
(63, 40),
(74, 41),
(77, 44),
(82, 45),
(83, 46),
(84, 47),
(86, 48),
(30, 49);

-- --------------------------------------------------------

--
-- Table structure for table `aae_data_bezirke`
--

CREATE TABLE IF NOT EXISTS `aae_data_bezirke` (
  `BID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID für Bezirke',
  `bezirksname` varchar(100) NOT NULL COMMENT 'Bezirksname',
  PRIMARY KEY (`BID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabelle fuer Leipziger Bezirke' AUTO_INCREMENT=72 ;

--
-- Dumping data for table `aae_data_bezirke`
--

INSERT INTO `aae_data_bezirke` (`BID`, `bezirksname`) VALUES
(1, 'Zentrum (Mitte)'),
(2, 'Zentrum-Ost (Mitte)'),
(3, 'Zentrum-Südost (Mitte)'),
(4, 'Seeburgviertel (Mitte)'),
(5, 'Zentrum-Süd (Mitte)'),
(6, 'Musikviertel (Mitte)'),
(7, 'Zentrum-West (Mitte)'),
(8, 'Bachviertel (Mitte)'),
(9, 'Zentrum-Nordwest (Mitte)'),
(10, 'Waldstraßenviertel (Mitte)'),
(11, 'Zentrum-Nord (Mitte)'),
(12, 'Schönefeld-Abtnaundorf (Nordost)'),
(13, 'Schönefeld-Ost (Nordost)'),
(14, 'Schönefeld (Nordost)'),
(15, 'Mockau-Süd (Nordost)'),
(16, 'Mockau-Nord (Nordost)'),
(17, 'Mockau (Nordost)'),
(18, 'Thekla (Nordost)'),
(19, 'Plaußig-Portitz (Nordost)'),
(20, 'Neustadt-Neuschönefeld (Ost)'),
(21, 'Volkmarsdorf (Ost)'),
(22, 'Anger-Crottendorf (Ost)'),
(23, 'Sellerhausen-Stünz (Ost)'),
(24, 'Paunsdorf (Ost)'),
(25, 'Heiterblick (Ost)'),
(26, 'Mölkau (Ost)'),
(27, 'Engelsdorf (Ost)'),
(28, 'Baalsdorf (Ost)'),
(29, 'Althen-Kleinpösna (Ost)'),
(30, 'Reudnitz-Thonberg (Südost)'),
(31, 'Stötteritz (Südost)'),
(32, 'Probstheida (Südost)'),
(33, 'Meusdorf (Südost)'),
(34, 'Liebertwolkwitz (Südost)'),
(35, 'Holzhausen (Südost)'),
(36, 'Südvorstadt (Süd)'),
(37, 'Connewitz (Süd)'),
(38, 'Marienbrunn (Süd)'),
(39, 'Lößnig (Süd)'),
(40, 'Dölitz-Dösen (Süd)'),
(41, 'Schleußig (Südwest)'),
(42, 'Plagwitz (Südwest)'),
(43, 'Kleinzschocher (Südwest)'),
(44, 'Großzschocher (Südwest)'),
(45, 'Knautkleeberg-Knauthain (Südwest)'),
(46, 'Hartmannsdorf-Knautnaundorf (Südwest)'),
(47, 'Schönau (West)'),
(48, 'Grünau-Ost (West)'),
(49, 'Grünau-Mitte (West)'),
(50, 'Grünau-Siedlung (West)'),
(51, 'Lausen-Grünau (West)'),
(52, 'Grünau-Nord (West)'),
(53, 'Grünau (West)'),
(54, 'Miltitz (West)'),
(55, 'Lindenau (Alt-West)'),
(56, 'Altlindenau (Alt-West)'),
(57, 'Neulindenau (Alt-West)'),
(58, 'Leutzsch (Alt-West)'),
(59, 'Böhlitz-Ehrenberg (Alt-West)'),
(60, 'Burghausen-Rückmarsdorf (Alt-West)'),
(61, 'Möckern (Nordwest)'),
(62, 'Wahren (Nordwest)'),
(63, 'Lützschena-Stahmeln (Nordwest)'),
(64, 'Lindenthal (Nordwest)'),
(65, 'Gohlis-Süd (Nord)'),
(66, 'Gohlis-Mitte (Nord)'),
(67, 'Gohlis-Nord (Nord)'),
(68, 'Gohlis (Nord)'),
(69, 'Eutritzsch (Nord)'),
(70, 'Seehausen (Nord)'),
(71, 'Wiederitzsch (Nord)');

-- --------------------------------------------------------

--
-- Table structure for table `aae_data_event`
--

CREATE TABLE IF NOT EXISTS `aae_data_event` (
  `EID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID für Events',
  `name` varchar(100) NOT NULL COMMENT 'Eventname',
  `kurzbeschreibung` varchar(500) DEFAULT '0' COMMENT 'Kurze inhaltliche Erläuterung',
  `bild` varchar(500) DEFAULT '' COMMENT 'Pfad zum Foto',
  `ort` int(10) unsigned DEFAULT '0' COMMENT 'Verweis auf Adresse',
  `url` varchar(200) DEFAULT '' COMMENT 'Link zur eigenen Homepage',
  `ersteller` int(10) unsigned DEFAULT '0' COMMENT 'ID von User, der Event angelegt hat',
  `start_ts` datetime DEFAULT NULL COMMENT 'Startzeit des Events als Timestamp',
  `ende_ts` datetime DEFAULT NULL COMMENT 'Endzeit des Events als Timestamp',
  `created` datetime DEFAULT NULL COMMENT 'Created als Timestamp',
  `modified` datetime DEFAULT NULL COMMENT 'Modified als Timestamp',
  PRIMARY KEY (`EID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabelle für Events' AUTO_INCREMENT=33 ;

--
-- Dumping data for table `aae_data_event`
--

INSERT INTO `aae_data_event` (`EID`, `name`, `kurzbeschreibung`, `bild`, `ort`, `url`, `ersteller`, `start_ts`, `ende_ts`, `created`, `modified`) VALUES
(4, 'Honorary Kitchen', '', '/~swp15-aae/drupal/sites/default/files/styles/large/public/field/image/honorarykitch_bild.jpg', 10, '', 10, '2015-08-06 11:00:01', '1000-01-01 00:00:00', '2016-02-07 22:44:37', NULL),
(10, 'ANNA WEBBER Large Ensemble', 'Nach der Sommerpause eröfnnet das Jazzkollektiv Leipzig die zweite Jahreshälfte mti einem Extrakonzert der New Yorker Saxophonistin und Komponistin Anna Webber. Mit anderen Berliner MusikerInnen bildet sie das Large Ensemble "Percussive Mechanics".\r\nDie Musik dieses Ensemble bewegt sich zwischen Klangtepichen, rhythmischen Finessen und monderner Improvisation.', '/~swp15-aae/drupal/sites/default/files/styles/large/public/field/image/AnnaWebberHarmonieHIRES.jpg', 12, 'http://jazzkollektiv-leipzig.de/', 31, '2015-09-12 19:30:01', '2015-09-12 22:00:01', '2016-02-07 22:44:37', NULL),
(11, 'help* Festival 2015', '1. help* Festival - HAL Atelierhaus in der Hildegardstra&szlig;e 49. Ganz praktisch werden interdisziplin&auml;re Teams help* Aktionen durchf&uuml;hren und in der Nachbarschaft Hilfestellungen geben. Dienstag bis Donnerstag - Honorary Kitchen; mittwochs - offenes Fr&uuml;hst&uuml;ck + abendlichen Ausklang; Wochenenden - vielf&auml;ltiges Kulturprogramm mit den help* Residenten Lucy Steggals, Johannes Maria Schmit, Inga Gerner Nielsen, Victor Maz&oacute;n Gardoqui', '', 10, 'http://baumit.weebly.com/festival.html', 13, '1000-01-01 00:00:00', '2015-10-10 00:00:01', '2016-02-07 22:44:37', NULL),
(15, 'L.E.dreams - Ein episches Schauspiel aus dem Herzen einer Stadt | Ohne Helden', 'Mit k&uuml;hl distanziertem Blick erz&auml;hlt das freie Ensemble der gruppe tag die Kurzgeschichte der Autorin Kohl-Eppelt &#39;Ein kleines Blatt vom Baum der Geschichte&#39;, die vor gut 25 Jahren in Leipzig spielt, und setzt sie analogisch in Beziehung zu einer B&uuml;hnenhandlung in der Jetztzeit. Das &#39;Prinzip Hoffnung&#39; des Philosophen und Leipzigers Ernst Bloch steht zur Diskussion. 100 Minuten, ohne Pause. In Welt-Urauff&uuml;hrung.', '', 28, 'http://ost-passage-theater.de/projekte/leipzig-die-utopische-kommune', 21, '2015-10-10 20:00:01', '2015-10-10 22:00:01', '2016-02-07 22:44:37', NULL),
(16, 'Dialog im Stadtteil', 'Das Quartiersmanagement Leipziger Osten und das Amt f&uuml;r Stadterneuerung und Wohnungsbauf&ouml;rderung laden ein zum&bdquo;Dialog im Stadtteil&ldquo;Diskussion zu aktuellen F&ouml;rderstrategien f&uuml;r den Leipziger OstenDonnerstag, 12. November, 18:00 Uhr &ndash; 20:00 Uhrim Freizeittreff Rabet', '/sites/default/files/styles/large/public/field/image/151030#2_plakat_002-2.jpg', 41, 'http://www.leipziger-osten.de/nc/content/aktuelles/news/newsdetails/archive/2015/november/02/article/332/', 22, '2015-11-12 18:00:01', '2015-11-12 20:00:01', '2016-02-07 22:44:37', NULL),
(17, 'Gesprächskreis', 'Der ArbeitsladenPlus im Leipziger Osten m&ouml;chte mit Ihnen ins Gespr&auml;ch kommen. Wir bieten Ihnen die M&ouml;glichkeit, in einer freien Gespr&auml;chsrunde Ihre Erfahrungen, W&uuml;nsche und Assoziationen zu diesem wichtigen Lebensbereich auszutauschen. Ansprechpartner: Bruno Lejsek, Tel.: 0341.2466415', '', 42, '', 56, '2015-11-26 15:00:01', '1000-01-01 00:00:00', '2016-02-07 22:44:37', NULL),
(22, 'IG FORTUNA | Kino der Jugend', 'Regelm&auml;&szlig;iges, offenes Treffen der IG FORTUNA | Kino der Jugend jeden zweiten Donnerstag zur Rettung des ehemaligen Kinos in der Eisenbahnstra&szlig;e 162.', '/sites/default/files/pictures/aae/LOGO IG Fortuna.jpg', 61, 'https://www.facebook.com/igfortuna', 21, '2015-12-10 19:00:01', '1000-01-01 00:00:00', '2016-02-07 22:44:37', NULL),
(23, 'IG FORTUNA | Kino der Jugend', 'Regelm&auml;&szlig;iges, offenes Treffen der IG FORTUNA | Kino der Jugend jeden zweiten Donnerstag zur Rettung des ehemaligen Kinos in der Eisenbahnstra&szlig;e 162.', '/sites/default/files/pictures/aae/LOGO IG Fortuna.jpg', 61, 'https://www.facebook.com/igfortuna', 21, '2016-01-07 19:00:01', '1000-01-01 00:00:00', '2016-02-07 22:44:37', NULL),
(25, 'offene Grafikwerkstatt im Pöge-Haus', 'Offene Grafikwerkstatt zum Ausprobieren von Linol- und Holzschnitt, einfachen Hochdruckverfahren und kleinen Buchbindeprojekten. F&uuml;r Gro&szlig; &amp; Klein, Jung &amp; jung Gebliebene. Die erste Stunde darf geschnuppert werden, danach nehme ich gern eine Werkstattpauschale von 5 &euro; pro Samstag entgegen, damit die Werkstatt jeden ersten und dritten Samstag eines Monats &quot;rund&quot; laufen kann. Vereinsmitglieder des P&ouml;ge-Haus e. V. haben freien Zutritt.', '/sites/default/files/pictures/aae/Holzschnittkalender_kategoriebild.jpg', 66, 'http://www.meinholzhandwerk.de', 63, '2016-03-05 14:00:01', '1000-01-01 00:00:00', '2016-02-07 22:44:37', NULL),
(27, 'Raspberry your Life', 'In den kommenden Winterferien vom 15.02. bis 18.02.2016 laden wir Euch zu einem Programmierworkshop f&uuml;r Einsteiger &ldquo;RASPBERRY your life&rdquo; ins FabLab Leipzig ein. Der Workshop dauert 4 Tage und kostet 60&euro; pro Teilnehmer. Ihr solltet zwischen 9 und 15 Jahre alt sein, um teil zu nehmen.Bitte meldet euch bis 15.01.2016 unter matthias[at]fablab-leipzig[dot]de an.', '/sites/default/files/pictures/aae/creative-technologists.png', 57, 'http://fablab-leipzig.de/raspberry-life/', 10, '2016-02-15 10:00:01', '2016-02-18 16:00:01', '2016-02-07 22:44:37', NULL),
(29, 'S T O P M O T I O N - W O R K S H O P', 'Durch die Stopmotion-Technik lassen wir leblose Gegenst&auml;nde mit einfachen Tricks zum Leben erwachen und machen so unseren eigenen Animationsfilm!Daf&uuml;r werden wir gemeinsam basteln, malen und uns Geschichten ausdenken.Du brauchst nur Neugierde und Ideen. Alles andere haben wir da. Der Workshop ist gratis und Vorkenntnisse werden nicht ben&ouml;tigt.. Am besten bist du zwischen 5 und 15 Jahren. Wir wollen an den oben genannten Tagen immer von 9 bis 16 Uhr.', '/sites/default/files/pictures/aae/8b045b1ed0ee62623e.jpg', 75, 'https://www.facebook.com/events/1500259133616801/', 77, '2016-02-08 09:00:01', '2016-02-12 16:00:01', '2016-02-07 22:44:37', NULL),
(30, 'Frühjahrsputz', 'Wenn wir den Dreck nicht wegr&auml;umen, wird es niemand tun! - Beim Fr&uuml;hjahrsputz k&ouml;nnen die Dreckecken im &ouml;ffentlichen Raum ber&auml;umt werden, um die sich sonst niemand k&uuml;mmert. Hierf&uuml;r werden viele Helfer gesucht.An welcher Ecke m&uuml;sste schon lange mal aufger&auml;umt werden? - Wo w&uuml;rden Sie mit f&uuml;r Sauberkeit sorgen? - Bitte wenden Sie sich an das Quartiersmanagement, das die Aktion der Vereine, Initiativen und Anwohner vor Ort koordiniert.', '/sites/default/files/pictures/aae/a5e2d0dd94c01a2101.jpg', 79, '', 22, '2016-04-09 09:00:01', '1000-01-01 00:00:00', '2016-02-07 22:44:37', NULL),
(31, 'Brot & Butter - Mitbring Abendessen', 'Beim Mitbring-Abendessen stehen Brot und Butter f&uuml;r Alle bereit und JedeR kann noch etwas mit bringen. Wir teilen und es reicht f&uuml;r alle! :)Jeden 1. und 3. Mittwoch im Monat in der Dresdner59.', '/sites/default/files/pictures/aae/09a290492fd88faf9e.jpg', 80, 'http://www.dresdner59.de/brot-butter-offenes-mitbring-abendbrot/', 30, '2016-02-17 19:00:01', '2016-02-17 21:00:01', '2016-02-07 22:44:37', NULL),
(32, 'Winterspielplatz', 'Der Saal ist jeden Dienstagnachmittag f&uuml;r Eltern mit Kindern offen....so lange das Wetter uns nach Drinnen treibt.', '', 80, 'http://dresdner59.de', 30, '2016-02-09 15:00:01', '2016-02-09 18:00:01', '2016-02-07 22:44:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aae_data_event_hat_sparte`
--

CREATE TABLE IF NOT EXISTS `aae_data_event_hat_sparte` (
  `hat_EID` int(10) unsigned NOT NULL COMMENT 'ID für Event',
  `hat_KID` int(10) unsigned NOT NULL COMMENT 'ID für Kategorien',
  PRIMARY KEY (`hat_EID`,`hat_KID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Hilfstabelle für Sparten/Zielgruppen';

--
-- Dumping data for table `aae_data_event_hat_sparte`
--

INSERT INTO `aae_data_event_hat_sparte` (`hat_EID`, `hat_KID`) VALUES
(9, 3),
(9, 4),
(10, 5),
(22, 163),
(22, 164),
(22, 165),
(22, 166),
(23, 167),
(23, 168),
(23, 169),
(23, 170),
(25, 175),
(25, 176),
(27, 32),
(27, 33),
(27, 34),
(27, 35),
(27, 36),
(27, 37),
(27, 39),
(27, 41),
(30, 206),
(30, 208),
(30, 209),
(30, 210),
(30, 211),
(30, 212),
(32, 213),
(32, 214);

-- --------------------------------------------------------

--
-- Table structure for table `aae_data_sparte`
--

CREATE TABLE IF NOT EXISTS `aae_data_sparte` (
  `KID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID für Kategorien',
  `kategorie` varchar(100) NOT NULL COMMENT 'Kategorie für Sparte oder Zielgruppe',
  PRIMARY KEY (`KID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabelle für Sparten/Zielgruppen' AUTO_INCREMENT=215 ;

--
-- Dumping data for table `aae_data_sparte`
--

INSERT INTO `aae_data_sparte` (`KID`, `kategorie`) VALUES
(1, 'spiel'),
(2, 'donnerstags'),
(5, 'jazz'),
(32, 'workshop'),
(33, 'raspberry'),
(34, 'fablab'),
(35, 'technik'),
(36, 'bastler'),
(37, 'code'),
(38, 'löten'),
(39, 'opensource'),
(40, 'hildegardstasse'),
(41, 'kinder'),
(42, 'workshop'),
(43, 'raspberry'),
(44, 'fablab'),
(45, 'technik'),
(46, 'bastler'),
(47, 'code'),
(48, 'löten'),
(49, 'opensource'),
(50, 'hildegardstasse'),
(51, 'kinder'),
(52, 'offene werkstatt'),
(53, 'fablab'),
(54, 'leipzig'),
(55, 'volkmarsdorf'),
(56, 'elektronik'),
(57, 'opensource'),
(58, 'löten'),
(59, 'basteln'),
(60, 'coden'),
(61, 'kreativ'),
(62, 'ideen'),
(63, 'prototypen'),
(64, 'helden wider willen e.v.'),
(155, 'theater'),
(156, 'soziokultur'),
(157, 'nachbarschaft'),
(158, 'kulturraum'),
(159, 'soziokultur'),
(160, 'nachbarschaft'),
(161, 'kino'),
(162, 'theater'),
(163, 'kulturraum'),
(164, 'nachbarschaft'),
(165, 'soziokultur'),
(166, 'kino'),
(167, 'kulturraum'),
(168, 'soziokultur'),
(169, 'nachbarschaft'),
(170, 'kino'),
(172, 'multikulti'),
(173, 'künstlerische projekte'),
(174, 'offene grafikwerkstatt'),
(175, 'offene grafikwerkstatt'),
(176, 'bildende kunst'),
(177, 'veranstaltungsort'),
(178, 'kunst und kultur'),
(179, 'handwerk'),
(180, 'lesungen'),
(181, 'ateliers'),
(182, 'natur'),
(183, 'kohrener land'),
(184, 'apfelsaft'),
(185, 'bio'),
(186, 'nachhaltigkeit'),
(187, 'ausflugsziel'),
(188, 'gemeinützig'),
(189, 'jugendclub'),
(190, 'offener treff'),
(191, 'oft'),
(192, 'jugendliche'),
(193, 'offenes angebot'),
(194, 'jugendtreff'),
(195, 'hedwig'),
(196, 'tante hedwig'),
(197, 'straßenmusik'),
(198, 'spielplatz'),
(199, 'bülowviertel'),
(200, 'stadtteil'),
(201, 'quartiersmangaement'),
(202, 'integration'),
(203, 'kommunikation'),
(204, 'leipziger osten'),
(205, 'netzwerke'),
(206, 'frühjahrsputz'),
(207, 'müll'),
(208, 'engagement'),
(209, 'brachflächen'),
(210, 'dreck'),
(211, 'sauberkeit'),
(212, 'müll'),
(213, 'spiel'),
(214, 'kinder');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

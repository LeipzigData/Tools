<?php

include_once("helper.php");

function displayChanges() {
    $a=array();
    $nr=10000;
    foreach (preg_split("/\n/",getData()) as $row) {
        if (preg_match("/Akteur deaktiviert/", $row)) {
            $a[]=akteurDeaktiviert($row,$nr++);
            }
        else if (preg_match("/Akteur hat sich registriert/", $row)) {
                $a[]=akteurRegistriert($row,$nr++);
            }
        else if (preg_match("/Neue.*eingetragen/", $row)) {
                $a[]=neueAktivitaet($row,$nr++);
            }
        else { $a[]=processLine($row,$nr++); }
    }
    return TurtlePrefix().'
<http://nachhaltiges-leipzig.de/Data/Changes/> a owl:Ontology ;
    rdfs:comment "Changes zur Datenbank";
    rdfs:label "Nachhaltiges Leipzig - Changes" .

'.join("\n\n",$a);
}

function akteurDeaktiviert($row,$nr) {
    preg_match('|Akteur deaktiviert:\s+(.+)\s*\((.*),\s*(.*)\)\s*\s*\.\s*(.+)$|',$row,$matches);
    // print_r($matches);
    $akteur=$matches[1]; $ort=$matches[2]; $user=$matches[3]; $date=$matches[4];
    $a=array();
    $a[]='<http://nachhaltiges-leipzig.de/Data/Activity'.$nr.'> a nl:Activity';
    $a[]='nl:Akteur "'.$akteur.'"';
    $a[]='nl:Kontakt "'.$user.'"';
    $a[]='nl:Aktivitaet "deactivated"';
    $a[]='dct:created "'.$date.'"';
    return join(" ;\n ",$a)." . ";
}

function akteurRegistriert($row,$nr) {
    preg_match('/Akteur hat sich registriert. Name:\s+(.+)\s*\.\s*(.+)$/',$row,$matches);
    // print_r($matches);
    $user=$matches[1]; $date=$matches[2];
    $a=array();
    $a[]='<http://nachhaltiges-leipzig.de/Data/Activity'.$nr.'> a nl:Activity';
    $a[]='nl:Akteur "'.$user.'"';
    $a[]='nl:Aktivitaet "registered"';
    $a[]='dct:created "'.$date.'"';
    return join(" ;\n ",$a)." . ";
}

function neueAktivitaet($row,$nr) {
    preg_match('|Neue Aktivität von\s*(.*)\s*eingetragen.\s*(.*)\s*(admin/users/.+)\.\s*(.+)\.\s*(.+)$|',$row,$matches);
    // print_r($matches);
    $akteur=$matches[1]; $rest=$matches[2]; $user=$matches[3]; $action=$matches[4]; $date=$matches[5];
    $action=str_replace('actions/','http://nachhaltiges-leipzig.de/Data/Action/A',$action);
    $action=str_replace('events/','http://nachhaltiges-leipzig.de/Data/Event/E',$action);
    $user=str_replace('admin/users/','http://nachhaltiges-leipzig.de/Data/Akteur/A',$user);
    $a=array();
    $a[]='<http://nachhaltiges-leipzig.de/Data/Activity'.$nr.'> a nl:Activity';
    $a[]='nl:User <'.$user.'>';
    $a[]='nl:Akteur "'.$akteur.'"';
    $a[]='nl:linksTo <'.$action.'>';
    $a[]='dct:created "'.$date.'"';
    if (!empty($rest)) { $a[]='rdfs:comment "'.$rest.'"'; }
    return join(" ;\n ",$a)." . ";
}

function processLine($row,$nr) {
    preg_match('|(.*)(admin/users/.+)\.\s*(.+)\.\s*(.+)$|',$row,$matches);
    // print_r($matches);
    $rest=$matches[1]; $user=$matches[2]; $action=$matches[3]; $date=$matches[4];
    $a=array();
    $a[]='<http://nachhaltiges-leipzig.de/Data/Activity'.$nr.'> a nl:Activity';
    $a[]='nl:Akteur "'.$user.'"';
    $a[]='nl:Aktivitaet "'.$action.'"';
    $a[]='dct:created "'.$date.'"';
    if (!empty($rest)) { $a[]='rdfs:comment "'.$rest.'"'; }
    return join(" ;\n ",$a)." . ";
}

function getData() {
    // Data extracted from email notifications
    return 
'Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/625. 2018-01-27
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/624. 2018-01-27
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/623. 2018-01-27
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/622. 2018-01-27
Akteur hat sich registriert. Name: Stadt Leipzig Umweltinformationszentrum . 2018-01-25
Neue Aktivität von Lebendige Luppe eingetragen. admin/users/78. events/621. 2018-01-24
Neue Aktivität von Lebendige Luppe eingetragen. admin/users/78. events/620. 2018-01-24
Neue Aktivität von Lebendige Luppe eingetragen. admin/users/78. events/619. 2018-01-24
Neue Aktivität von Lebendige Luppe eingetragen. admin/users/78. events/618. 2018-01-24
Neue Aktivität von Lebendige Luppe eingetragen. admin/users/78. events/617. 2018-01-24
Neue Aktivität von Fanö-Mode eingetragen. admin/users/178. stores/317. 2018-01-22
Neue Aktivität von Gartenfreunde Süd e.V. eingetragen. admin/users/184. events/616. 2018-01-21
Akteur hat sich registriert. Name: Gartenfreunde Süd e.V. . 2018-01-21
Neue Aktivität von Araki Verlag eingetragen. admin/users/86. actions/23. 2018-01-18
Akteur hat sich registriert. Name: Luise Neugebauer Schmuck . 2018-01-17
Akteur hat sich registriert. Name: Matthias Schmidt . 2018-01-15
Akteur hat sich registriert. Name: Orang-Utans in Not . 2018-01-15
Neue Aktivität von Stefan Härtel eingetragen. admin/users/180. events/615. 2018-01-11
Neue Aktivität von Stefan Härtel eingetragen. admin/users/180. events/614. 2018-01-11
Akteur hat sich registriert. Name: Stefan Härtel . 2018-01-11
Neue Aktivität von Leipzig Grün eingetragen. admin/users/179. events/613. 2018-01-08
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/612. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/611. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/610. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/609. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/608. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/607. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/606. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/605. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/604. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/603. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/602. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/601. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/600. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/599. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/598. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/597. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/596. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/595. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/594. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/593. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/592. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/591. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/590. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/589. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/588. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/587. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/586. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/585. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/584. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/583. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/582. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/581. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/580. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/579. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/578. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/577. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/576. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/575. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/574. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/573. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/572. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/571. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/570. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/569. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/568. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/567. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/566. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/565. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/564. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/563. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/562. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/561. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/560. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/559. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/558. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/557. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/556. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/555. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/554. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/553. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/552. 2018-01-06
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/551. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/550. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/549. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/548. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/547. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/546. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/545. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/544. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/543. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/542. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/541. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/540. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/539. 2018-01-05
Neue Aktivität von Auwaldstation eingetragen. admin/users/15. events/538. 2018-01-05
Akteur hat sich registriert. Name: DGGL Sachsen . 2018-01-05
Neue Aktivität von Fanö-Mode eingetragen. admin/users/178. events/537. 2018-01-05
Neue Aktivität von Vier Fährten eingetragen. Mit Tieren verbunden. admin/users/176. actions/22. 2018-01-05
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/536. 2018-01-05
Akteur deaktiviert: Kollektiv Lastenrad Leipzig (Leipzig, Juliana Klengel) . 2017-12-30
Akteur hat sich registriert. Name: Fanö-Mode . 2017-12-26
Akteur deaktiviert: Sylke Nissen (Leipzig, Sylke Nissen) . 2017-12-22
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/535. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/534. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/533. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/532. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/531. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/530. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/529. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/528. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/527. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/526. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/525. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/524. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/523. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/522. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/521. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/520. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/519. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/518. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/517. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/516. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/515. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/514. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/513. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/512. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/511. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/510. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/509. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/508. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. Kindergruppe Waldgeister. admin/users/73. services/66. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. Kindergruppe BUNDspechte. admin/users/73. services/65. 2017-12-19
Akteur deaktiviert: Kati Magyar (Leipzig, Kati Magyar) . 2017-12-18
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/507. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/506. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/505. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/504. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. Die Baumkinder im Winter. admin/users/176. actions/21. 2017-12-10
Akteur deaktiviert: Batzentauschring e.V. (Schkeuditz, Jürgen Weidemann) . 2017-11-28
Neue Aktivität von oikos Leipzig e.V. eingetragen. admin/users/21. events/503. 2017-11-13
Neue Aktivität von LUXAA eingetragen. LUXAA. admin/users/177. stores/316. 2017-11-13
Akteur hat sich registriert. Name: LUXAA . 2017-11-13
Akteur deaktiviert: Social Impact Lab (Leipzig, Jennifer Pauli) . 2017-11-10
Akteur deaktiviert: Querbeet (Leipzig, Marius Brauer) . 2017-11-01
Akteur deaktiviert: about source UG (Leipzig, Maria Hunger) . 2017-10-28
Neue Aktivität von BUND Leipzig eingetragen. Grünes Klassenzimmer. admin/users/73. services/64. 2017-10-26
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/502. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/501. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/500. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/499. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/498. 2017-10-23
Akteur hat sich registriert. Name: Vier Fährten . 2017-10-15
Akteur deaktiviert: Familienbüro Leipzig (Leipzig, Thomas Kujawa) . 2017-10-14
Neue Aktivität von Freiwilligen-Agentur Leipzig e. V. eingetragen. admin/users/87. events/498. 2017-10-11
Akteur deaktiviert: kunZstoffe – urbane Ideenwerkstatt e.V. (Leipzig, Christin Bauer) . 2017-10-05';
}

// zum Testen
// echo displayChanges();


?>

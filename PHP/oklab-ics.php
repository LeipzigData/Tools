<?php 

// Übernahme der ics-Anwendung vom NEU e.V.

/* 

   Vorher muss die Datei oklab.ics ausgelesen werden

   wget -O oklab.ics http://www.meetup.com/OK-Lab-Leipzig/events/ical/

Probleme:
   Zeitzone wird noch nicht richtig dargestellt. 
   LOCATION wird nicht mit ausgelesen.

 */

require_once "class.iCalReader.php"; 

error_reporting(E_ALL);
ini_set("display_errors", 1);

function delnl($text)
{
  $a=array("/\\\\n/s","/\\\\,/s","/\.\.\.\\\\/s");
  $b=array("<br/>",',','mmen.');
  return preg_replace($a,$b, $text);
} 

function addEvent($event) {
  $begin=new DateTime($event['DTSTART']);
  $end=new DateTime($event['DTEND']);
  $summary=$event['SUMMARY'];
  $description=delnl($event['DESCRIPTION']);
  $url=$event['URL'];
  $dtstart=$begin->format('Y-m-d').'T'.$begin->format('H:i:s');
  $dtend=$end->format('Y-m-d').'T'.$end->format('H:i:s');
  $id=$begin->format('Y-m-d');

  return "<http://leipzig-data.de/Data/Event/OKLab.$id> a ical:Event ; 
  rdfs:label \"$summary\" ;
  ical:dtstart \"$dtstart\" ;
  ical:dtend \"$dtend\" ;
  ical:summary \"$summary\" ;
  ical:description \"$description\" ;
  ical:url <$url> ;
  ical:location <http://leipzig-data.de/Data/Ort/BIC> .

";

}

function createEventList() {
  $ical   = new ICal('oklab.ics');
  $out='';
  foreach ($ical->events() as $event) {
    $out.=addEvent($event);
  }
  return $out;
}

function turtlePrefix () {
  return "
@prefix ical: <http://www.w3.org/2002/12/cal/ical#> .
@prefix ld: <http://leipzig-data.de/Data/Model/> .
@prefix ldo: <http://leipzig-data.de/Data/Ort/> .
@prefix ldp: <http://leipzig-data.de/Data/Person/> .
@prefix ldt: <http://leipzig-data.de/Data/Traeger/> .
@prefix ldtag: <http://leipzig-data.de/Data/Tag/> .
@prefix owl: <http://www.w3.org/2002/07/owl#> .
@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .

";
}

// print_r();
echo turtlePrefix().createEventList(); 


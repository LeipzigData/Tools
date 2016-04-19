# 2016-04-03: Auf Sommerzeit umgestellt.
# 2015-12-29: Hashtags entfernt, wurden eh nicht genutzt
# 2015-05-22: Neu angelegt
# 2015-10-23: Auf Winterzeit umgestellt.

use SparqlQuery;
use strict;

my $outfile="oklab.ics"; 
system("wget http://www.meetup.com/OK-Lab-Leipzig/events/ical/ -O- | tr -d '\r' >$outfile");
print TurtleEnvelope(getEvents($outfile));

## end main ##

sub getEvents {
  my $fn=shift;
  local $/; 
  open(FH,$fn) or die;
  local $_=<FH>;
  my @l;
  while (s/BEGIN:VEVENT(.*?)END:VEVENT/push(@l,getEvent($1))/egs) {} ; 
  return join("\n\n",@l);
}

sub getEvent {
  local $_=shift;
  m|DTSTART;TZID=Europe/Berlin:(\d\d\d\d)(\d\d)(\d\d)T|s;
  my $date="$1-$2-$3";
  m|URL:([^\n]+)\n|s;
  my $url=$1; 
  return createEntry($date,$url);
}

sub createEntry{
  my ($date,$url)=@_;
  my $end=$date."T22:00:00";
  my $begin=$date."T19:00:00";
  return <<EOT;
<http://leipzig-data.de/Data/Event/OKLab.$date> 
ld:Tag ldtag:CodeForLeipzig ;
a ld:Event ;
rdfs:label "OK Lab Leipzig Treffen" ;
ical:description "OK Lab Leipzig. Wir treffen uns, um gemeinsam an Civic Apps für Leipzig zu arbeiten. Für alle die Interesse haben, findet jeden 2. Mittwoch im Monat eine kleine Vorstellungsrunde statt." ;
ical:dtend "$end+02:00"^^xsd:dateTime ;
ical:dtstart "$begin+02:00"^^xsd:dateTime ;
ical:location ldo:BasislagerCoworkingLeipzig ;
ical:organizer ldt:CodeForLeipzig ;
ical:summary "OK Lab Leipzig Treffen" ;
ical:url <$url> .
EOT
}

sub TurtleEnvelope {
  my $out=shift;

  return <<EOT
\@prefix ical: <http://www.w3.org/2002/12/cal/ical#> .
\@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
\@prefix ld: <http://leipzig-data.de/Data/Model/> .
\@prefix ldo: <http://leipzig-data.de/Data/Ort/> .
\@prefix ldt: <http://leipzig-data.de/Data/Traeger/> .
\@prefix ldtag: <http://leipzig-data.de/Data/Tag/> .
\@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .

$out
EOT
}


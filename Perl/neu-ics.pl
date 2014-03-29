# Aenderung 29.03.2014: time offset auf Sommerzeit gesetzt, Events ohne
# Zeitangabe rausgeworfen
# Aenderung 29.10.2013: time offset auf Winterzeit gesetzt 
# Nächste Sommerzeit 30.3.-26.10.2014 +02:00, Winter +01:00
# Aenderung 12.10.2013: fixTime added
# Aenderung 04.05.2013: MD5 Checksumme über String ohne white spaces gebildet
# Aenderung 03.04.2013: MD5 Checksumme hinzugefügt und danach bereits
# aufgenommene Events ausgefiltert.
# Aenderung 23.03.2013: URI ist nun NEU.<Datum>, keine NEUId mehr.

use Digest::MD5;
use SparqlQuery;
use strict;

my $startdate="2014-03-01";
undef $/;
system("wget -O uhu.ics www.energiemetropole-leipzig.de/energiemetropole-leipzig.ics");
open(FH,"uhu.ics") or die;
$_=<FH>;
s/\n\s//gs; # mache Zeilenumbrüche rückgängig
close FH;

my $hash;
my $hashtags;
getHashTags();
getEvents($_);
my $out;
map $out.=printHash($_), (keys %$hash);
print TurtleEnvelope(fixTime($out));

## end main ##

sub TurtleEnvelope {
  my $out=shift;

  return <<EOT
\@prefix ical: <http://www.w3.org/2002/12/cal/ical#> .
\@prefix ld: <http://leipzig-data.de/Data/Model/> .
\@prefix ldo: <http://leipzig-data.de/Data/Ort/> .
\@prefix ldp: <http://leipzig-data.de/Data/Person/> .
\@prefix ldt: <http://leipzig-data.de/Data/Traeger/> .
\@prefix ldtag: <http://leipzig-data.de/Data/Tag/> .
\@prefix owl: <http://www.w3.org/2002/07/owl#> .
\@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
\@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
\@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .

$out
EOT
}

sub getHashTags {
  my $query = <<EOT;
PREFIX ld: <http://leipzig-data.de/Data/Model/>
SELECT distinct ?s WHERE {
  ?a a ld:Event . 
  ?a ld:hasMD5Sum ?s .
} 
EOT
  my $u=SparqlQuery::query($query);
  my $res=SparqlQuery::parseResult($u);
  map $hashtags->{$_->{"s"}}=1, (@$res);
  # print join(", ",(sort keys %$hashtags))."\n\n";
}

sub getEvents {
  local $_=shift;
  my @l;
  my $cnt=100;
  while (m/BEGIN:VEVENT\s*(.*?)\s*END:VEVENT/gs) {
    $hash->{$cnt++}=getEvent($1);
  }
}

sub getEvent {
  my $s=shift;
  my $h;
  map {
    my ($a,$b)=split(/:/,$_,2);
    $h->{$a}=fix($b);
  } split(/\n/,$s);
  return $h;
}

sub printHash {
  my $id=shift;
  my $h=$hash->{$id};
  my @l; 
  my ($date,$md);
  push(@l,addEntry("rdfs:label",$h->{"SUMMARY"}));
  for my $a (sort keys %$h) {
    my $predicate=fixpredicate($a);
    next if $predicate=~/DTSTAMP/;
    next if $predicate=~/UID/;
    $date=fixDate($h->{$a}) if $predicate=~/dtstart/;
    push(@l,addEntry($predicate,$h->{$a}));
    $md.=$h->{$a} if $predicate=~/dtstart/;
    $md.=$h->{$a} if $predicate=~/summary/;
    $md.=$h->{$a} if $predicate=~/description/;
  } 
  #return unless $h->{"location"}=~/Leipzig/;
  return unless $h->{"DTSTART"}=~/T/;
  push(@l,"ical:organizer ldo:NetzwerkEnergieUmwelt");
  push(@l,"ical:sentBy <http://leipzig-data.de/Data/Agent/NEU.Events>");
  push(@l,"ld:hasTag ldtag:Energie");
  $md=~s/\s//gs;
  my $hashvalue=Digest::MD5::md5_base64($md);
  return if exists $hashtags->{$hashvalue};  
  return unless $date gt $startdate;
  my $out=join(";\n",@l);
  return <<EOT;
<http://leipzig-data.de/Data/Event/NEU.$date.$id> a ld:Event ;
ld:hasMD5Sum "$hashvalue" ;
$out  .

EOT
}

sub addEntry {
  my ($a,$b)=@_;
  return "$a \"$b\"";
}

sub fixDate {
  local $_=shift;
  s/(\d\d\d\d)(\d\d)(\d\d).*/$1-$2-$3/;
  return $_;
}

sub fix {
  local $_=shift;
  s/\\,/,/gs;
  s/\\;/;/gs;
  s/\&\#40\\;/(/gs;
  s/\&\#41\\;/)/gs;
  s/\[\&\]/ und /gs;
  s/\[nbsp\]/ /gs;
  s|\\n|<br/>|gs;
  return $_;
}

sub fixpredicate {
  local $_=shift;
  return "ical:description" if /DESCRIPTION/;
  return "ical:summary" if /SUMMARY/;
  return "ical:dtstart" if /DTSTART/;
  return "ical:dtend" if /DTEND/;
  return "ical:contact" if /CONTACT/;
  return "ical:location" if /LOCATION/;
  return $_;
}

sub fixTime {
  local $_=shift;
  s/ical:dtstart\s+"(\d\d\d\d)(\d\d)(\d\d)T(\d\d)(\d\d)(\d\d)"/ical:dtstart "$1-$2-$3T$4:$5:$6+02:00"^^xsd:datetime/gs;
  s/ical:dtend\s+"(\d\d\d\d)(\d\d)(\d\d)T(\d\d)(\d\d)(\d\d)"/ical:dtend "$1-$2-$3T$4:$5:$6+02:00"^^xsd:datetime/gs;
  s/ical:dtstart\s+"(\d\d\d\d)(\d\d)(\d\d)"/ical:dtstart "$1-$2-$3"^^xsd:date/gs;
  s/ical:dtend\s+"(\d\d\d\d)(\d\d)(\d\d)"/ical:dtend "$1-$2-$3"^^xsd:date/gs;
  s/(T\d\d:\d\d:\d\d)"/$1+02:00"/gs;
  s/\+\d\d:\d\d"/+02:00"/;
  return $_;
}



__END__


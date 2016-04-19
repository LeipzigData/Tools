# Aenderung 03.04.2016: time offset in fixTime auf Sommerzeit gesetzt
# Aenderung 23.12.2015: time offset in fixTime auf Winterzeit gesetzt
# Aenderung 28.03.2015: time offset in fixTime auf Sommerzeit gesetzt
# Aenderung 28.10.2014: time offset in fixTime auf Winterzeit gesetzt
# Aenderung 06.08.2014: ld:hasURL zu ical:url
# Aenderung 29.03.2014: time offset in fixTime auf Sommerzeit gesetzt
# Aenderung 19.03.2014: xsd:dateTime gefixt
# Aenderung 09.02.2014: ld:contactPerson entfernt
# Aenderung 29.10.2013: time offset in fixTime auf Winterzeit gesetzt
# Aenderung 12.10.2013: time offset gefixt und Typangabe ergänzt
# Aenderung 24.03.2013: ical:sentBy ergänzt

use strict;
use APILeipzig;

my $hash=APILeipzig::getTranslationHash();
# map print("$_ -> $hash->{$_}\n"), (sort keys %$hash);
print getEvents("2016-04-01");

## end main ##

sub getEvents {
  my $startdate=shift;
  my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/calendar/events");
  my $out;
  map $out.=processEvent($_,$startdate), @{$u->{data}};
  return TurtleEnvelope($out);
}

sub TurtleEnvelope {
  my $out=shift;

  return <<EOT
\@prefix ical: <http://www.w3.org/2002/12/cal/ical#> .
\@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
\@prefix ld: <http://leipzig-data.de/Data/Model/> .
\@prefix ldtag: <http://leipzig-data.de/Data/Tag/> .
\@prefix owl: <http://www.w3.org/2002/07/owl#> .
\@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .

$out
EOT
}

# process data types

sub processEvent {
  my ($a,$d)=@_; 
  my $id=$a->{"id"};
  return "" if $hash->{"http://leipzig-data.de/Data/APIId/Event.$id"};
  # return "" if $hash->{"http://leipzig-data.de/Data/APILeipzig/Event.$id"}; 
  # letzte Zeile ist nur, um einen früheren Bug in Daten zu fixen.
  my $hid=translate("http://leipzig-data.de/Data/APIId/Host.".$a->{"host_id"});
  my $vid=translate("http://leipzig-data.de/Data/APIId/Venue.".$a->{"venue_id"});
  my $owner=$a->{"owner_id"};
  my $title=fix($a->{"name"});
  my $df=$a->{"date_from"};
  return "" unless $df gt $d;
  my $dt=$a->{"date_to"};
  my $tf=fixTime($a->{"time_from"});
  $df=$df.$tf if $tf;
  my $tt=fixTime($a->{"time_to"});
  $dt=$dt.$tt if $tt;
  my $url=$a->{"url"};
  my $description=fix($a->{"description"});
  my $out="<http://leipzig-data.de/Data/Event/APILeipzig.$id> a ld:Event";
  $out.=addReference("ld:hasAPIRef","<http://leipzig-data.de/Data/APIId/Event.$id>");
  $out.=addReference("ical:organizer","<$hid>");
  $out.=addReference("ical:location","<$vid>");
  $out.=addReference("ical:sentBy","<http://leipzig-data.de/Data/Agent/APILeipzig.Events>");
  $out.=addReference("ld:hasTag","ldtag:KreativesLeipzig");
  $out.=addLiteral("rdfs:label",$title);
  $out.=addLiteral("ical:summary",$title);
  $out.=addDateTime("ical:dtstart",$df) if $df;
  $out.=addDateTime("ical:dtend",$dt) if $dt;
  $out.=addLiteral("ical:description",$description) if $description;
  $out.=addReference("ical:url","<$url>") if $url;
  return "$out .\n\n";
}

# helpers

sub translate { my $a=shift; return $hash->{$a} if $hash->{$a}; return $a; }
sub addLiteral { my ($a,$b)=@_; return " ;\n\t$a \"$b\""; }
sub addDateTime { my ($a,$b)=@_; return " ;\n\t$a \"$b\"^^xsd:dateTime"; }
sub addReference { my ($a,$b)=@_; return " ;\n\t$a $b"; }

sub fix {
  local $_=shift;
  return unless $_;
  s/%([0-9A-Fa-f]{2})/chr(hex($1))/eg; # unescape chars
  s/\"/\\"/gs;
  s/\+/ /gs;
  s/\n/ <br\/> /gs;
  s/\s+/ /gs;
  return $_;
}

sub fixTime {
  local $_=shift;
  return unless $_;
  s/2000-01-01//gs;
  s/:00:42/:00:00/gs;
  if (/T/) {
    s/\+\d\d:\d\d/+02:00/;
    $_.="+02:00" unless /\+/;
  }
  return $_;
}

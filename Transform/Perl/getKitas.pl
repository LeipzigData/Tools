binmode STDOUT, ":utf8";
use utf8;
use JSON;
use Helper;
use strict;

undef $/;
open(FH,shift) or die;
# ~/git/LD/ld-workbench/kidsle-Daten/kitas.json
$_=<FH>;
close FH;
my $a=decode_json($_);
my $out;
map { $out.=getKita($_);} (@$a);
print TurtleEnvelope($out);

## end main ##

sub fixURI {
  local $_=Helper::proposeURI(shift);
  s|Alt-West|AltWest|g;
  s/Kita//s;
  return $_;
}

sub fixStrasse {
  local $_=shift;
  s/str\./straße/g;
  s/Str\./Straße/g;
  return $_;
}
  
sub getKita {
  my $a=shift;
  return unless $a->{"type"} eq "Kindertagesstätte";
  my $address=getAddress($a->{"address"});
  my $district=fixURI($a->{"district"});
  my $lat=$a->{"lat"};
  my $long=$a->{"lng"};
  my $title=fixStrasse($a->{"name"});
  my $id=$a->{"id"};
  my $proposedURI=fixURI($title);
  $title=~s/\s+/ /g;
  my $out=<<EOT;
<http://leipzig-data.de/Data/Kita/$proposedURI> 
rdfs:label "$title" ;
rdfs:seeAlso <http://leipzig-data.de/Data/KidsLE/Kita.$id> ;
EOT
  $out.=<<EOT if $address;
ld:hasAddress <http://leipzig-data.de/Data/$address> ;
EOT
  $out.=<<EOT if $district;
ld:inDistrict <http://leipzig-data.de/Data/Stadtbezirk/$district> ;
EOT
  $out.=<<EOT if $lat;
gsp:asWKT "Point($long $lat)"; 
EOT
  $out.=<<EOT;
a ld:Kita .

EOT
  return $out;
}

sub getAddress {
  my $h=shift;
  my ($a,$ort)=split(/\s*,\s*/,$h->{"full"});
  $a=~m|([^\d]*)\s*(\d+)\s*(.*)$|;
  my $strasse=fixURI(fixStrasse($1)); my $nr=$2.$3;
  my $zipcode=$h->{"zipcode"};
  local $_="$zipcode.$ort.$strasse";
  return "$zipcode.$ort.$strasse.$nr";
}

sub TurtleEnvelope {
  my $out=shift;
  return <<EOT;
\@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
\@prefix owl: <http://www.w3.org/2002/07/owl#> .
\@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
\@prefix ld: <http://leipzig-data.de/Data/Model/> .
\@prefix cc: <http://creativecommons.org/ns#> .
\@prefix dct: <http://purl.org/dc/terms/> .
\@prefix gsp: <http://www.opengis.net/ont/geosparql#> .

<http://leipzig-data.de/Data/Kitas/> a owl:Ontology ;
 rdfs:label "Kindertagesstätten der Stadt Leipzig" ;
 dct:source <https://github.com/CodeforLeipzig/kidsle> ;
 rdfs:comment "Daten aus Primärquelle wurden weiter angereichert" ;  
 dct:created "2014-08-18" .

$out
EOT
}

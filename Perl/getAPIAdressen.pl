use open qw/:std :utf8/;
use utf8;
use strict;
use APILeipzig;

my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/district/streets");
my $streetHash;
my $out;
#$out=getBasicData();
map $out.=addOrtsteil($_), @{$u->{data}};
print TurtleEnvelope($out);

## end main ##

sub getBasicData {
  my $out=StreetsPrefix(); 
  map $out.=processStreets($_), @{$u->{data}};
  map {
    $out.=<<EOT;
<http://leipzig-data.de/Data/Strasse/$_> a ld:Strasse;
  rdfs:label "$streetHash->{$_}{'label'}";
  ld:hasStreetKey "$streetHash->{$_}{'key'}" . 

EOT
  } (keys %$streetHash);
  return $out;
}

sub StreetsPrefix {
  return <<EOT;
<http://leipzig-data.de/Data/Adresse/>
    a owl:Ontology ;
    rdfs:label "Adressen der Stadt Leipzig" ;
    owl:imports <http://leipzig-data.de/Data/Stadtbezirk/>  .

ld:Adresse a owl:Class ;
         rdfs:label "Adresse in der Stadt Leipzig" .

ld:Strasse a owl:Class ;
         rdfs:label "Straﬂe in der Stadt Leipzig" .

ld:hasAPIId a rdf:Property; 
         rdfs:comment "Id in den Daten von API Leipzig" .

EOT
}

sub TurtleEnvelope {
  my $out=shift;

  return <<EOT
\@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
\@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
\@prefix ld: <http://leipzig-data.de/Data/Model/> .
\@prefix lds: <http://leipzig-data.de/Data/Strasse/> .
\@prefix owl: <http://www.w3.org/2002/07/owl#> .

$out
EOT
}

# process data types

sub processStreets {
  my $a=shift;
  my $id=$a->{"id"};
  my $streetName=$a->{"name"};
  my $streetId=APILeipzig::fixId($streetName);
  my $plz=$a->{"postcode"};
  my $streetKey=$a->{"internal_key"};
  my $nr=$a->{"housenumber"};
  my $nra=$a->{"housenumber_additional"};
  $nr=$nr.$nra if $nra;
  my $out=<<EOT;
<http://leipzig-data.de/Data/$plz.Leipzig.$streetId.$nr> a ld:Adresse
EOT
  $out.=addLiteral("rdfs:label","$streetName $nr");
  $out.=addReference("ld:inStreet","lds:$streetId") if $streetId;
  $out.=addLiteral("ld:hasPostCode",$plz) if $plz;
  $out.=addLiteral("ld:hasAPIId","district/streets/$id") if $id;
  $out.=addLiteral("ld:hasHouseNumber",$nr) if $nr;
  $streetHash->{$streetId}{"label"}=$streetName;
  $streetHash->{$streetId}{"key"}=$streetKey;
  return "$out .\n\n";
}

sub addOrtsteil {
  my $a=shift;
  my $id=$a->{"id"};
  my $streetName=$a->{"name"};
  my $plz=$a->{"postcode"};
  my $streetId=APILeipzig::fixId($streetName);
  my $district=$a->{"district_id"};
  my $nr=$a->{"housenumber"};
  my $nra=$a->{"housenumber_additional"};
  $nr=$nr.$nra if $nra;
  return <<EOT;
<http://leipzig-data.de/Data/$plz.Leipzig.$streetId.$nr> 
ld:im Ortsteil <http://leipzig-data.de/Data/Ortsteil/$district> .
EOT
}

# helpers

sub addLiteral {
  my ($a,$b)=@_;
  return " ;\n\t$a \"$b\"";
}

sub addReference {
  my ($a,$b)=@_;
  return " ;\n\t$a $b";
}

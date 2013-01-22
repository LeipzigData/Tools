use strict;
use APILeipzig;

my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/district/streets");
my $streetHash;
my $out=StreetsPrefix(); map $out.=processStreets($_), @{$u->{data}};
map {
  $out.=<<EOT;
<http://leipzig-data.de/Data/Strasse/$_> a ld:Strasse;
  rdfs:label "$streetHash->{$_}{'label'}";
  ld:hasStreetKey "$streetHash->{$_}{'key'}" . 

EOT
} (keys %$streetHash);

print TurtleEnvelope($out);

## end main ##

sub StreetsPrefix {
  return <<EOT;
<http://leipzig-data.de/Data/Adresse/>
    a owl:Ontology ;
    rdfs:label "Adressen der Stadt Leipzig" ;
    owl:imports <http://leipzig-data.de/Data/Stadtbezirk/>  .

ld:Adresse a owl:Class ;
         rdfs:label "Adresse in der Stadt Leipzig" .

ld:Strasse a owl:Class ;
         rdfs:label "Straße in der Stadt Leipzig" .

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
  my $streetId=fixId($streetName);
  my $plz=$a->{"postcode"};
  my $streetKey=$a->{"internal_key"};
  my $nr=$a->{"housenumber"};
  my $nra=$a->{"housenumber_additional"};
  $nr=$nr.$nra if $nra;
  my $out=<<EOT;
<http://leipzig-data.de/Data/Adresse/$plz.$streetId.$nr> a ld:Adresse
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

# helpers

sub addLiteral {
  my ($a,$b)=@_;
  return " ;\n\t$a \"$b\"";
}

sub addReference {
  my ($a,$b)=@_;
  return " ;\n\t$a $b";
}

sub fixId {
  local $_=shift;
  s/Ä/Ae/g; 
  s/Ö/Oe/g; 
  s/Ü/Ue/g;
  s/ä/ae/g; 
  s/ö/oe/g; 
  s/ü/ue/g;
  s/ß/ss/g; 
  s/\.//g; 
  s/\s+//g;  
  return $_;
}

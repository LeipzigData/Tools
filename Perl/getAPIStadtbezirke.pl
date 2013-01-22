use strict;
use APILeipzig;

my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/district/districts");

my $out=DistrictsPrefix(); map $out.=processDistricts($_), @{$u->{data}};
print TurtleEnvelope($out);

## end main ##

sub DistrictsPrefix {
  return <<EOT;
<http://leipzig-data.de/Data/Stadtbezirk/>
    a owl:Ontology ;
    rdfs:label "Stadtbezirke der Stadt Leipzig"  .

ld:Stadtbezirk a owl:Class ;
         rdfs:label "Stadtbezirk der Stadt Leipzig" .

ld:hasStadtId a rdf:Property; 
         rdfs:comment "Id in den Daten der Stadtverwaltung" .

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
\@prefix owl: <http://www.w3.org/2002/07/owl#> .

$out
EOT
}

# process data types

sub processDistricts {
  my $a=shift;
  my $id=$a->{"id"};
  my $sid=fixId($a->{"name"});
  my $number=$a->{"number"};  
  my $out="<http://leipzig-data.de/Data/Stadtbezirk/$sid> a ld:Stadtbezirk";
  $out.=addLiteral("rdfs:label",$a->{"name"});
  $out.=addLiteral("ld:hasStadtId",$number);
  $out.=addLiteral("ld:hasAPIId","district/districts/$id");
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
  s/ä/ae/g; 
  s/ö/oe/g; 
  s/ü/ue/g;
  s/ß/ss/g; 
  return $_;
}

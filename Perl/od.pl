use SparqlQuery;
use XML::DOM;
use strict;

my $query = <<EOT;
SELECT distinct ?o ?ol WHERE {
  ?e a ld:Event .
  ?e ld:contactPerson ?o .
  optional { ?o rdfs:label ?ol . }
} 
EOT

my $query2 = <<EOT;
SELECT distinct ?a ?o WHERE {
  ?a a ld:Ort .      
  ?a ld:hasAPIId ?o  .
} 
EOT

my $hash;
my $u=SparqlQuery::query(prefix().$query);
my $res=SparqlQuery::parseResult($u);
#my $out;
SparqlQuery::printResultSet($res);
#map $out.=erzeugeSatz($_), (@$res);
#print TurtleEnvelope($out);

## end main ##

sub prefix { 
  return <<EOT;
PREFIX ld: <http://leipzig-data.de/Data/Model/>
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX cal: <http://www.w3.org/2002/12/cal/ical#> 
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

sub erzeugeSatz {
  my $a=shift;
  return<<EOT;
<$a->{"a"}> ld:hasAPIId <http://leipzig-data.de/Data/APIId/$a->{"o"}> .
EOT
}

use SparqlQuery;
use strict;

my $query = <<EOT;
select ?a ?lat ?long
from <http://leipzig-data.de/Data/GeoDaten/>
where {
?a geo:lat ?lat ; geo:long ?long . 
}
EOT

my $u=SparqlQuery::query(prefix().$query);
my $res=SparqlQuery::parseResult($u);
my $out;
#SparqlQuery::printResultSet($res);
map $out.=erzeugeSatz($_), (@$res);

print TurtleEnvelope($out);

## end main ##

sub prefix { 
  return <<EOT;
PREFIX ld: <http://leipzig-data.de/Data/Model/>
PREFIX ldtag: <http://leipzig-data.de/Data/Tag/>
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX cal: <http://www.w3.org/2002/12/cal/ical#> 
PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#> 
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
<$a->{"a"}> ld:geoJSONObject "type: Point, coordinates: [$a->{"lat"}, $a->{"long"}]" .
EOT
}

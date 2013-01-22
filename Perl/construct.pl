

use SparqlQuery;
use XML::DOM;
use strict;

my $query = <<EOT;
Construct { 
  ?a ?ap ?ao .
}
Where { 
  ?a ?ap ?ao .
  ?a cal:dtstart ?as .
  ?a a ld:Event .
FILTER ( xsd:dateTime(?as) > xsd:dateTime("2012-11-01T00:00:00Z") )
} 
EOT

print testQuery($query);

## end main ##

sub testQuery {
  my $query=shift;
  my $u=SparqlQuery::query(prefix().$query); 
  return $u;
}

sub prefix { 
  return <<EOT;
PREFIX ld: <http://leipzig-data.de/Data/Model/>
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX cal: <http://www.w3.org/2002/12/cal/ical#> 
EOT
}

__END__

Verarbeitung:

perl construct.pl >a.ttl

rapper -g a.ttl >b.ttl  # mache daraus ntriples

cat EventPrefix.ttl >a.ttl 
rapper -g b.ttl -o turtle >> a.ttl # mache daraus turtle ohne namespace kuerzel

rapper -g a.ttl -o turtle > b.ttl # mache daraus unser Format

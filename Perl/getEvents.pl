# Purpose: Query for complete Event Data

use SparqlQuery;
use strict;

my $query = <<EOT;
construct { 
  ?a ?ap ?ao .
  ?ao ?bp ?bo .
  ?bo ?cp ?co .
  ?co ?dp ?do .
}
Where { 
  ?a ?ap ?ao .
  ?a a ld:Event .
  optional { ?ao ?bp ?bo .  }
  optional { ?bo ?cp ?co .  }
  optional { ?co ?dp ?do .  }
} 
EOT

print testQuery($query);
#print dumpAdressen();

## end main ##

sub testQuery {
  my $query=shift;
  my $u=SparqlQuery::query(prefix().$query); 
  return $u;
}

sub dumpAdressen {
  my $query = <<EOT;
construct { ?s ?p ?o .} 
from <http://leipzig-data.de/Data/Stadtbezirke/> 
Where { ?s ?p ?o . } 
EOT
  return directQuery(prefix().$query);
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

perl getEvents.pl >a.ttl

rapper -g a.ttl >b.ttl  # mache daraus ntriples

cat EventPrefix.ttl >c.ttl 
rapper -g b.ttl -o turtle >> c.ttl # mache daraus turtle ohne namespace kuerzel

rapper -g c.ttl -o turtle > d.ttl # mache daraus unser Format

mv d.ttl ~/git/LD/Webseiten/Services/widget/EventsDump.ttl 

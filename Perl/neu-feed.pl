# NEU Event-Feed auslesen

use XML::DOM;
use HTML::Entities;
use Time::ParseDate;
use Date::Format;
use strict;

my $outfile="neu.xml"; 
#system("wget -O $outfile http://www.energiemetropole-leipzig.de/energiemetropole-leipzig.xml");
my $parser=new XML::DOM::Parser;
my $dom=$parser->parsefile($outfile) or die;
my $doc;
map { $doc.=getItem($_) } $dom->getElementsByTagName("item"); 
print TurtleEnvelope($doc);
#print $doc;

## end main ##

sub getFullItem { my $node=shift; return $node->toString(); }

sub getItem {
  my $node=shift;
  my $title=getValue($node,"title");
  $title=~s/(\S+)\s+//;
  my $startdate=getDate($1);
  my $link=getValue($node,"link");
  my $pubDate=getDateTime(getValue($node,"pubDate"));
  my $description=fixContent(decode_entities(getValue($node,"description")));
  return <<EOT;
<http://leipzig-data.de/Data/Event/NEU.$startdate> a ld:Event;
rdfs:label "$title" ; 
ical:dtstart "$startdate"^^xsd:datetime ; 
ical:dtend "$startdate"^^xsd:datetime ; 
ical:dtstamp "$pubDate" ;
ld:hasTag ldtag:Energie ;
ld:hasURL <$link> ; 
ical:description "$description" .

EOT
}

sub TurtleEnvelope {
  my $out=shift;

  return <<EOT
\@prefix ical: <http://www.w3.org/2002/12/cal/ical#> .
\@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
\@prefix ld: <http://leipzig-data.de/Data/Model/> .
\@prefix ldtag: <http://leipzig-data.de/Data/Tag/> .
\@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .

$out
EOT
}

sub fixContent {
  # remove links, images and leerzeilen
  local $_=shift;
  s|<a href[^>]*>||gs;
  s|</a>||gs;
  s|<img[^>]*>||gs;
  s|<div class='leerzeile'></div>||gs;
  return $_;
}

sub getValue {
  my ($node,$tag)=@_;
  map {
    my $s=$_->toString();
    $s=~s/<[^>]*>\s*//gs;
    $s=~s/\s*<\/[^>]*>//gs;
    $s=~s/\n/ /gs;
    return $s;
  } $node->getElementsByTagName($tag,0);
}

sub getDateTime { return time2str("%Y-%m-%dT%T%z",parsedate(shift)); } 
sub getDate { return time2str("%Y-%m-%d",parsedate(shift)); }

__END__


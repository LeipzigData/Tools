# 2013-10-20: Update auf neue Adress-URIs 

use strict;
use APILeipzig;

my $hash=APILeipzig::getTranslationHash();
# map print("$_ -> $hash->{$_}\n"), (sort keys %$hash);
print getVenues();

## end main ##

sub getVenues {
  my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/calendar/venues");
  my $out;
  map $out.=processVenue($_), @{$u->{data}};
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

$out
EOT
}

# process data types

sub processVenue {
  my $a=shift;
  my $id=$a->{id};
  return "" if $hash->{"http://leipzig-data.de/Data/APIId/Venue.$id"};
  my $name=fix($a->{name});
  my $street=fix($a->{street});
  my $hn=fix($a->{housenumber});
  my $hn1=fix($a->{housenumber_addition});
  $hn=$hn.$hn1 if $hn1;
  my $description=fix($a->{description});
  my $city=fix($a->{city});
  my $postcode=fix($a->{postcode});
  my $ort=$postcode.".Leipzig.".$street.".".$hn;
  my $out="<http://leipzig-data.de/Data/Ort/$name> a ld:Ort";
  $out.=addLiteral("rdfs:label",$name);
  $out.=addReference("ld:hasAPIRef","<http://leipzig-data.de/Data/APIId/Venue.$id>");
  $out.=addReference("ld:hasAddress","<http://leipzig-data.de/Data/$ort>");
  $out.=addLiteral("rdfs:comment",$description) if $description;
  return "$out .\n\n";
}

# helpers

sub translate { my $a=shift; return $hash->{$a} if $hash->{$a}; return $a; }
sub addLiteral { my ($a,$b)=@_; return " ;\n\t$a \"$b\""; }
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
  return $_;
}

use strict;
use APILeipzig;
use SparqlQuery;

my $hash;
getTranslationHash();
# map print("$_ -> $hash->{$_}\n"), (sort keys %$hash);
print getEvents("2013-01");
# print getHosts();
# print getVenues();

## end main ##

sub getEvents {
  my $startdate=shift;
  my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/calendar/events");
  my $out;
  map $out.=processEvent($_,$startdate), @{$u->{data}};
  return TurtleEnvelope($out);
}

sub getHosts {
  my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/calendar/hosts");
  my $out;
  map $out.=processHost($_), @{$u->{data}};
  return TurtleEnvelope($out);
}

sub getVenues {
  my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/calendar/venues");
  my $out;
  map $out.=processVenue($_), @{$u->{data}};
  return TurtleEnvelope($out);
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

sub TurtleEnvelope {
  my $out=shift;

  return <<EOT
\@prefix cal: <http://www.w3.org/2002/12/cal/ical#> .
\@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
\@prefix ld: <http://leipzig-data.de/Data/Model/> .
\@prefix ldtag: <http://leipzig-data.de/Data/Tag/> .
\@prefix owl: <http://www.w3.org/2002/07/owl#> .

$out
EOT
}

# process data types

sub getTranslationHash {
  my $query = <<EOT;
SELECT distinct ?l ?ln WHERE {
  ?ln ld:hasAPIRef ?l .
} 
EOT
  my $u=SparqlQuery::query(prefix().$query);
  my $res=SparqlQuery::parseResult($u);
  map { $hash->{$_->{"l"}}=$_->{"ln"}; } (@$res);
}

sub processEvent {
  my ($a,$d)=@_; 
  my $id=$a->{"id"};
  my $hid=translate("http://leipzig-data.de/Data/APIId/Host.".$a->{"host_id"});
  my $vid=translate("http://leipzig-data.de/Data/APIId/Venue.".$a->{"venue_id"});
  my $owner=$a->{"owner_id"};
  my $title=fix($a->{"name"});
  my $df=$a->{"date_from"};
  return "" unless $df gt $d;
  my $dt=$a->{"date_to"};
  my $tf=fixTime($a->{"time_from"});
  $df=$df.$tf if $tf;
  my $tt=fixTime($a->{"time_to"});
  $dt=$dt.$tt if $tt;
  my $url=$a->{"url"};
  my $description=fix($a->{"description"});
  my $out="<http://leipzig-data.de/Data/Event/APILeipzig.$id> a ld:Event";
  $out.=addReference("ld:hasAPIRef","<http://leipzig-data.de/Data/APILeipzig/Event.$id>");
  $out.=addReference("ld:contactPerson","<$hid>");
  $out.=addReference("cal:organizer","<$hid>");
  $out.=addReference("cal:location","<$vid>");
  $out.=addReference("ld:hasTag","ldtag:KreativesLeipzig");
  #$out.=addLiteral("ld:hasOwner",$owner);
  $out.=addLiteral("rdfs:label",$title);
  $out.=addLiteral("cal:dtstart",$df) if $df;
  $out.=addLiteral("cal:dtend",$dt) if $dt;
  $out.=addLiteral("cal:description",$description) if $description;
  $out.=addReference("ld:hasURL","<$url>") if $url;
  return "$out .\n\n";
}

sub processHost {
  my $a=shift;
  my $id=$a->{id};
  my $lname=fix($a->{last_name});
  my $vname=fix($a->{first_name});
  my $ldID=$lname."_".$vname;
  my $url=$a->{url};
  my $company=fix($a->{company});
  my $phone=fix($a->{phone});
  my $out="<http://leipzig-data.de/Data/Person/$lname"."_"."$vname> a ld:NatuerlichePerson";
  $out.=addLiteral("rdfs:label","$vname $lname");
  $out.=addLiteral("ld:hasAPIId","Host.$id");
  $out.=addLiteral("ld:relatedTo","$company") if $company;
  $out.=addLiteral("ld:hasTelefon","$phone") if $phone;
  $out.=addLiteral("ld:hasURL","$url") if $url;
  return "$out .\n\n";
}

sub processVenue {
  my $a=shift;
  my $id=$a->{id};
  my $name=fix($a->{name});
  my $street=fix($a->{street});
  my $hn=fix($a->{housenumber});
  my $hn1=fix($a->{housenumber_addition});
  $hn=$hn.$hn1 if $hn1;
  my $description=fix($a->{description});
  my $city=fix($a->{city});
  my $postcode=fix($a->{postcode});
  my $ort=$postcode.".".$street.".".$hn;
  my $out="<http://leipzig-data.de/Data/Ort/$name> a ld:Ort";
  $out.=addLiteral("rdfs:label",$name);
  $out.=addLiteral("ld:hasAPIId","Venue.$id");
  $out.=addReference("ld:hasAddress","<http://leipzig-data.de/Data/Adresse/$ort>");
  $out.=addLiteral("rdfs:comment",$description) if $description;
  return "$out .\n\n";
}

# helpers

sub translate {
  my $a=shift;
  return $hash->{$a} if $hash->{$a};
  return $a;
}

sub addLiteral {
  my ($a,$b)=@_;
  return " ;\n\t$a \"$b\"";
}

sub addReference {
  my ($a,$b)=@_;
  return " ;\n\t$a $b";
}

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

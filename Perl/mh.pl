use utf8;      # so literals and identifiers can be in UTF-8
use open      qw(:std :utf8);    # undeclared streams in UTF-8
use strict;
use APILeipzig;
use JSON;

#getRawData("people","mh1.txt"); # arg.1 \in {people, branches, companies}
my $out=processData(decodeJSONFile(shift)); 
print TurtleEnvelope($out);

## end main ##

# Save raw data from apileipzig.de/api/v1/mediahandbook to local JSON files

sub readRawData {
  my $uri=shift;
  my $u=APILeipzig::rawQuery($uri);
  my $json=JSON->new->allow_nonref;
  return $json->pretty->encode($json->decode($u)); 
}

sub getRawData {
  my ($what,$where)=@_;
  open(FH,">$where");
  print FH readRawData("http://www.apileipzig.de/api/v1/mediahandbook/$what");
  close FH;
  print "$what written to $where\n";
}

# Analyse data from local JSON files 

sub decodeJSONFile {
  open(FH,shift) or die;
  undef $/;
  local $_=<FH>;
  return JSON->new->decode( $_ );
}

sub processData {
  my $u=shift;
  my $out;
#  map $out.=process($_), @{$u->{data}};
#  map $out.=processBranches($_), @{$u->{data}};
#  map $out.=processCompanies($_), @{$u->{data}};
  map $out.=processPeople($_), @{$u->{data}};
  return $out;
}

sub TurtleEnvelope {
  my $out=shift;

  return <<EOT
\@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
\@prefix ld: <http://leipzig-data.de/Data/Model/> .
\@prefix owl: <http://www.w3.org/2002/07/owl#> .
\@prefix org: <http://www.w3.org/ns/org#> .
\@prefix foaf:	<http://xmlns.com/foaf/0.1/> .
\@prefix skos:	<http://www.w3.org/2004/02/skos/core#> .

$out
EOT
}

# process data types

# generic processing, prints out all fields

sub process {
  my $a=shift;
  my $id=$a->{id};
  my $out;
  map { $out.=" :$_ \"$a->{$_}\" ;\n"; } (sort keys %$a);
  return "<http://leipzig-data.de/Data/$id> $out a ld:Uhu .\n\n";
}

# processing for branches

sub processBranches {
  my $a=shift;
  my $id=$a->{id};
  my $uid="<http://leipzig-data.de/Data/MediaBranch/$id>";
  my ($out,$u);
  map { 
    $out.=" ld:$_ \"$a->{$_}\" ;\n" unless /description|companies/; 
  } (sort keys %$a);
  $out="$uid $out a ld:MediaBranch .\n";
  map { 
    $out.="<http://leipzig-data.de/Data/MediaCompany/$_> ld:toMediaBranch $uid .\n ";
  } (@{$a->{"companies"}});
  return $out;
}

# processing for companies

sub processCompanies {
  my $a=shift;
  my $id=$a->{id};
  my $uid="<http://leipzig-data.de/Data/MediaCompany/$id>";
  my ($out,$u);
  map { 
    unless (/people|sub_branches|housenumber|housenumber_additional|street|city|postcode/) {
      $out.=" ld:$_ \"$a->{$_}\" ;\n" if $a->{$_}; 
    }
  } (sort keys %$a);
  $out.=" ld:hasAddress ".addAddress($a)." ;\n" if $a->{"postcode"};
  $out="$uid $out a org:Organization .\n";
  map { 
    $out.="<http://leipzig-data.de/Data/APIPerson/$_> org:memberOf $uid .\n ";
  } (@{$a->{"people"}});
  map { 
    $out.="$uid ld:toMediaBranch <http://leipzig-data.de/Data/MediaBranch/$_> .\n ";
  } (@{$a->{"sub_branches"}});
  return postProcessCompanies($out);
}

sub addAddress {
  my $a=shift;
  my $city=APILeipzig::fixId($a->{"city"});
  my $postcode=$a->{"postcode"};
  my $street=APILeipzig::fixId($a->{"street"});
  my $housenumber=$a->{"housenumber"}.$a->{"housenumber_additional"};
  $housenumber=~s/\s//g;
  return "<http://leipzig-data.de/Data/Adresse/$postcode.$street.$housenumber>" 
    if $city=~/Leipzig/i;
  return "<http://leipzig-data.de/Data/WeitereAdresse/$postcode.$city.$street.$housenumber>";
}

sub postProcessCompanies {
  local $_=shift;
  s|ld:url_primary|ld:hasURL|gs;
  s|ld:url_secondary|ld:hasURL|gs;
  s|ld:hasURL\s*"([^"]*?)"|fixURL($1)|egs;
  s|ld:phone_primary|foaf:phone|gs;
  s|ld:phone_secondary|foaf:phone|gs;
  s|ld:mobile_primary|foaf:phone|gs;
  s|ld:mobile_secondary|foaf:phone|gs;
  s|ld:email_primary|foaf:mbox|gs;
  s|ld:email_secondary|foaf:mbox|gs;
  s|ld:name|skos:prefLabel|gs;
  return $_;
}

sub fixURL {
  local $_=shift;
  $_="http://".$_ unless /^http:/;
  return " ld:hasURL <$_>";
}

# processing for people
 
sub processPeople {
  my $a=shift;
  my $id=$a->{id};
  my $fname=$a->{"first_name"};
  my $lname=$a->{"last_name"};
  my $ldid=APILeipzig::fixId($lname."_".$fname);
  $ldid=~s/-//g;
  my $uid="<http://leipzig-data.de/Data/Person/$ldid>";
  my $out=" foaf:name \"$fname $lname\" ; \n";
  $out.=" owl:sameAs <http://leipzig-data.de/Data/APIPerson/$id> ; \n";
  map { 
    unless (/company|occupation/) {
      $out.=" ld:$_ \"$a->{$_}\" ;\n" if $a->{$_}; 
    }
  } (sort keys %$a);
  $out.=getCompany($a) if $a->{"company_id"};
  $out="$uid $out a foaf:Person .\n";
  return postProcessPeople($out);
}

sub getCompany {
  my $a=shift;
  my $id=$a->{"company_id"};
  my $occupation=$a->{"occupation"};
  return " org:headOf <http://leipzig-data.de/Data/MediaCompany/$id> ;\n " 
    if $occupation=~/manager/;
  return " org:memberOf <http://leipzig-data.de/Data/MediaCompany/$id> ;\n "; 
}

sub postProcessPeople {
  local $_=shift;
  s|ld:last_name|foaf:familyName|gs;
  s|ld:first_name|foaf:givenName|gs;
  s|ld:title|foaf:title|gs;
  return $_;
}

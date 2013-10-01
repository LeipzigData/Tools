use strict;
use APILeipzig;

my $out=getPeople();
#$out.=getBranches();
#$out.=getCompanies();

print TurtleEnvelope($out);

## end main ##

sub getPeople {
  my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/mediahandbook/people");
  my $out;
  map $out.=processPeople($_), @{$u->{data}};
  return $out;
}

sub getBranches {
  my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/mediahandbook/branches");
  my $out;
  map $out.=process($_), @{$u->{data}};
  return $out;
}

sub getCompanies {
  my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/mediahandbook/companies");
  my $out;
  map $out.=process($_), @{$u->{data}};
  return $out;
}

sub TurtleEnvelope {
  my $out=shift;

  return <<EOT
\@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
\@prefix ld: <http://leipzig-data.de/Data/Model/> .
\@prefix owl: <http://www.w3.org/2002/07/owl#> .
\@prefix foaf: <http://xmlns.com/foaf/0.1/> .


$out
EOT
}

# process data types

sub processPeople {
  my $a=shift;
  my $id=$a->{id};
  my $gname=$a->{first_name};
  my $fname=$a->{last_name};
  my $title=$a->{title};
  my $occupation=$a->{occupation};
  my $company=$a->{company_id};
  my $uri=fixId($fname."_".$gname);
  my $out;
  $out.=addLiteral("foaf:givenName",$gname);
  $out.=addLiteral("foaf:familyName",$fname);
  $out.=addReference("ld:APIRef","<http://leipzig-data.de/Data/APIId/Person/$id>");
  $out.=addLiteral("foaf:title",$title) if $title;
  return<<EOT;
<http://leipzig-data.de/Data/Person/$uri> a foaf:Person $out . 
EOT
}

sub process {
  my $a=shift;
  my $id=$a->{id};
  my $out;
  map { $out.=" ld:$_ \"$a->{$_}\" ;\n" if $a->{$_}; } (sort keys %$a);
  return "<http://leipzig-data.de/Data/$id> $out a ld:Uhu .\n\n";
}

# helpers

sub addLiteral { my ($a,$b)=@_; return " ;\n\t$a \"$b\""; }
sub addReference { my ($a,$b)=@_; return " ;\n\t$a $b"; }

sub fix {
  local $_=shift;
  return unless $_;
  s/ld:first_name/foaf:givenName/gs;
  s/ld:last_name/foaf:familyName/gs;
  s/ld:title/foaf:title/gs;
  return $_;
}

sub fixId {
  local $_=shift;
  s|\s||g;
  s|-||g;
  s|ä|ae|g;
  s|ö|oe|g;
  s|ü|ue|g;
  s|ß|ss|g;
  return $_;
}

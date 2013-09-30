use strict;
use APILeipzig;

my $out=getPeople();
$out.=getBranches();
$out.=getCompanies();
print TurtleEnvelope($out);

## end main ##

sub getPeople {
  my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/mediahandbook/people");
  my $out;
  map $out.=process($_), @{$u->{data}};
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

$out
EOT
}

# process data types

sub process {
  my $a=shift;
  my $id=$a->{id};
  my $out;
  map { $out.=" $_ \"$a->{$_} \" ;\n"; } (sort keys %$a);
  return "<http://leipzig-data.de/Data/$id> $out a ld:Uhu .\n\n";
}

# helpers

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

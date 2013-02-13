use strict;
use APILeipzig;

my $hash=APILeipzig::getTranslationHash();
# map print("$_ -> $hash->{$_}\n"), (sort keys %$hash);
print getHosts();

## end main ##

sub getHosts {
  my $u=APILeipzig::Query("http://www.apileipzig.de/api/v1/calendar/hosts");
  my $out;
  map $out.=processHost($_), @{$u->{data}};
  return TurtleEnvelope($out);
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

sub processHost {
  my $a=shift;
  my $id=$a->{id};
  return "" if $hash->{"http://leipzig-data.de/Data/APIId/Host.$id"};
  my $lname=fix($a->{last_name});
  my $vname=fix($a->{first_name});
  my $ldID=$lname."_".$vname;
  my $url=$a->{url};
  my $company=fix($a->{company});
  my $phone=fix($a->{phone});
  my $out="<http://leipzig-data.de/Data/Person/$lname"."_"."$vname> a ld:NatuerlichePerson";
  $out.=addLiteral("rdfs:label","$vname $lname");
  $out.=addReference("ld:hasAPIId","<http://leipzig-data.de/Data/APIId/Host.$id>");
  $out.=addLiteral("ld:relatedTo","$company") if $company;
  $out.=addLiteral("ld:hasTelefon","$phone") if $phone;
  $out.=addLiteral("ld:hasURL","$url") if $url;
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

package APILeipzig;

use strict;
use warnings;
use WWW::Curl::Easy;
# needs apt-get install libcurl4-openssl-dev (HGG 2012-06-08)
use JSON;
use SparqlQuery;

## process curl query 

sub Query {
  my $url=shift;
  my $curl = WWW::Curl::Easy->new;
  my $response_body;
  $curl->setopt(CURLOPT_HEADER,1);
  $curl->setopt(CURLOPT_WRITEDATA,\$response_body);
  my $apiKey = 'LWoUkVkp0Zky43uamlp';
  # URL mit Api-Key angeben
  $curl->setopt(CURLOPT_URL, "$url?api_key=".$apiKey);
  # Abfrage ausführen
  my $retcode = $curl->perform;
  # Looking at the results...
  die ("An error happened: $retcode ".$curl->strerror($retcode).
       " ".$curl->errbuf."\n") unless ($retcode == 0);
  my $response_code = $curl->getinfo(CURLINFO_HTTP_CODE);
  # judge result and next action based on $response_code
  #print("Received response: $response_body\n");
  $_=$response_body;
  #print $_;
  s/.*\{"data":\[/\{"data":\[/s; # remove HEADER;
  my $json = JSON->new->allow_nonref;
  #my $pretty_printed = $json->pretty->encode( $_ ); 
  #print $pretty_printed; 
  return $json->decode( $_ );
}


sub prefix { 
  return <<EOT;
PREFIX ld: <http://leipzig-data.de/Data/Model/>
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX ical: <http://www.w3.org/2002/12/cal/ical#> 
EOT
}

sub getTranslationHash {
  my $hash;
  my $query = <<EOT;
SELECT distinct ?l ?ln WHERE {
  ?ln ld:hasAPIRef ?l .
} 
EOT
  my $u=SparqlQuery::query(prefix().$query);
  my $res=SparqlQuery::parseResult($u);
  map { $hash->{$_->{"l"}}=$_->{"ln"}; } (@$res);
  return $hash;
}


1;

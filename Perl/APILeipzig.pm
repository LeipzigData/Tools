package APILeipzig;

use strict;
use warnings;
use WWW::Curl::Easy;
# needs apt-get install libcurl4-openssl-dev (HGG 2012-06-08)
use JSON;

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

1;

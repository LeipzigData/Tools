package Helper;
binmode STDOUT, ":utf8";
use utf8;

sub proposeURI {
  local $_=shift;
  s/ä/ae/gs;
  s/ö/oe/gs;
  s/ü/ue/gs;
  s/Ä/Ae/gs;
  s/Ö/Oe/gs;
  s/Ü/Ue/gs;
  s/ß/ss/gs;
  s|é|e|g;
  s|/|_|g;
  s/\s+//gs;
  return $_;
}

1;

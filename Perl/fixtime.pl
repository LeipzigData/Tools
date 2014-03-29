undef $/;
open(FH,shift) or die;
$_=<FH>;
s/"(\d\d\d\d-\d\d-\d\d)"/"$1"^^xsd:date/gs;
s/"(\d\d\d\d-\d\d-\d\dT\d\d:\d\d:\d\d)"/"$1+02:00"/gs;
s/\+\d\d:\d\d"/+02:00"/gs;
s/\+02:00"/\+02:00"^^xsd:dateTime/gs;

print;

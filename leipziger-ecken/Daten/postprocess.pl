undef $/;
process("Dump-Akteure.ttl");
process("Dump-Adressen.ttl");
process("Dump-Events.ttl");
process("Dump-Sparten.ttl");

sub process {
  my $file=shift;
  open(FH,$file) or die;
  local $_=<FH>;
  close(FH);
  s|<pre>||s;
  s|</pre>||s;
  s|&lt;|<|gs;
  s|&gt;|>|gs;
  s|&quot;|"|gs;
  open(FH,">$file") or die;
  print FH;
  close FH;
}

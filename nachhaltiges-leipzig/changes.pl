my $out;
map {
  if (/Akteur deaktiviert/) { $out.=akteurDeaktiviert($_); }
  elsif (/Akteur hat sich registriert/) { $out.=akteurRegistriert($_); }
  else { $out.=processLine($_); }
} split(/\n/,getData());
print $out;

## end main ##

sub akteurRegistriert {
  local $_=shift;
  s|Akteur hat sich registriert. Name:\s+(.+)\s*\.\s*(.+)$||;
  my $user=$1; my $date=$2; 
  my $out=<<EOT;
Akteur: $user
Action: registered
Date: $date
Rest: $_
------------------
EOT
  return $out;
}

sub akteurDeaktiviert {
  local $_=shift;
  s|Akteur deaktiviert:\s+(.+)\s*\.\s*(.+)$||;
  my $user=$1; my $date=$2; 
  my $out=<<EOT;
Akteur: $user
Action: deactivated
Date: $date
Rest: $_
------------------
EOT
  return $out;
}

sub processLine {
  local $_=shift;
  s|(admin/users/.+)\.\s*(.+)\.\s*(.+)$||;
  my $user=$1; my $action=$2; my $date=$3; 
  my $out=<<EOT;
User: $user
Action: $action
Date: $date
Rest: $_
------------------
EOT
  return $out;
}

sub getData {
  # Data extracted from email notifications
  return <<EOT;
Akteur deaktiviert: Kollektiv Lastenrad Leipzig (Leipzig, Juliana Klengel) . 2017-12-30
Akteur hat sich registriert. Name: Fanö-Mode . 2017-12-26
Akteur deaktiviert: Sylke Nissen (Leipzig, Sylke Nissen) . 2017-12-22
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/535. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/534. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/533. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/532. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/531. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/530. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/529. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/528. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/527. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/526. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/525. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/524. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/523. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/522. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/521. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/520. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/519. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/518. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/517. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/516. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/515. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/514. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/513. 2017-12-20
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/512. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/511. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/510. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/509. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. admin/users/73. events/508. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. Kindergruppe Waldgeister. admin/users/73. services/66. 2017-12-19
Neue Aktivität von BUND Leipzig eingetragen. Kindergruppe BUNDspechte. admin/users/73. services/65. 2017-12-19
Akteur deaktiviert: Kati Magyar (Leipzig, Kati Magyar) . 2017-12-18
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/507. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/506. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/505. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. admin/users/176. events/504. 2017-12-10
Neue Aktivität von Vier Fährten eingetragen. Die Baumkinder im Winter. admin/users/176. actions/21. 2017-12-10
Akteur deaktiviert: Batzentauschring e.V. (Schkeuditz, Jürgen Weidemann) . 2017-11-28
Neue Aktivität von oikos Leipzig e.V. eingetragen. admin/users/21. events/503. 2017-11-13
Neue Aktivität von LUXAA eingetragen. LUXAA. admin/users/177. stores/316. 2017-11-13
Akteur hat sich registriert. Name: LUXAA . 2017-11-13
Akteur deaktiviert: Social Impact Lab (Leipzig, Jennifer Pauli) . 2017-11-10
Akteur deaktiviert: Querbeet (Leipzig, Marius Brauer) . 2017-11-01
Akteur deaktiviert: about source UG (Leipzig, Maria Hunger) . 2017-10-28
Neue Aktivität von BUND Leipzig eingetragen. Grünes Klassenzimmer. admin/users/73. services/64. 2017-10-26
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/502. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/501. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/500. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/499. 2017-10-23
Neue Aktivität von kunZstoffe eingetragen. admin/users/64. events/498. 2017-10-23
Akteur hat sich registriert. Name: Vier Fährten . 2017-10-15
Akteur deaktiviert: Familienbüro Leipzig (Leipzig, Thomas Kujawa) . 2017-10-14
Neue Aktivität von Freiwilligen-Agentur Leipzig e. V. eingetragen. admin/users/87. events/498. 2017-10-11
Akteur deaktiviert: kunZstoffe – urbane Ideenwerkstatt e.V. (Leipzig, Christin Bauer) . 2017-10-05
EOT
}

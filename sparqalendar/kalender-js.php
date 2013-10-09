<?php 

  /* Die Seite /lehrer-infos/anmeldungen lädt zwei Short Code Bestandteile:

   Short Code, mit dem der Kalender [buchungskalender] mit einem der Handler
   displayKalender in die Seite /lehrer-infos/anmeldungen eingebunden ist. 

  */

$backlink=1;
function getEvents($datum) { // $datum ist yyyy-mm-dd
  // to do: get array of events for that date
  return 0 ;
}

function getDatum($datum) {
  /* Macht aus Datum yyyy-mm-dd einen String dd.mm.yyy */
  $uhu=explode("-",$datum);
  return $uhu[2].".".$uhu[1].".".$uhu[0];  
}

function getEventUebersicht($datum) {
  $datstring=getDatum($datum);
  $events=getEvents($datum);
  $out='<div id="buchungsinfo">
  <p>Hier sind die Events vom <b>'.$datstring.'</b> auszugeben.</div>';
  return $out;
}

function displayKalenderGet($atts) {
  $action=$atts['action'];

  /* GET Parameter auslesen, wenn vorhanden. Diese werden innerhalb des Short
   Code in verschiedenen Links verwendet, um den Kalenderteil in einem anderen
   Zustand neu aufzurufen.  */

  $tag   = (empty($_GET['tag']))   ?   0       : $_GET['tag'] ; 
  $monat = (empty($_GET['monat'])) ? date('n') : $_GET['monat'] ;
  $jahr  = (empty($_GET['jahr']))  ? date('Y') : $_GET['jahr'] ;

  $link_alt_monat=$monat-1;
  $link_alt_jahr=$jahr;
  $link_neu_monat=$monat+1;
  $link_neu_jahr=$jahr;

  if($monat==1){ $link_alt_monat=12; $link_alt_jahr=$jahr-1; }
  if($monat==12){ $link_neu_monat=1; $link_neu_jahr=$jahr+1; }

  $namen=array("0", "Januar", "Februar", "März", "April", "Mai", "Juni", 
	       "Juli", "August", "September", "Oktober", "November",
	       "Dezember");

  global $backlink; $GLOBALS["backlink"]=13;
  $backlink=$action.'?jahr='.$link_alt_jahr.'&amp;monat='.$link_alt_monat;
  $nextlink=$action.'?jahr='.$link_neu_jahr.'&amp;monat='.$link_neu_monat;
  $out= '<div id="buchungstabelle">
   <table cellspacing="0">
     <tr>
       <th class="termin" id="lastMonth">
	 <a href="'.$backlink.'">&larr;</a></th>
       <th colspan="5" align="center">'.$namen[$monat].' '.$jahr.'</th>
       <th class="termin" id="nextMonth">
	 <a href="'.$nextlink.'">&rarr;</a></th>
     </tr>

     <tr> <th>Mo</th> <th>Di</th> <th>Mi</th> <th>Do</th> <th>Fr</th>
       <th>Sa</th> <th>So</th> 
     </tr>
';

  // Tagzählung erfolgt nach Julian Days
  $erster_tag = gregoriantojd($monat,date('j'),$jahr)-date('j')+1;
  $tage=cal_days_in_month(CAL_GREGORIAN, $monat, $jahr); 
  $letzter_tag=$erster_tag+$tage-1;

  $out.= "<tr>";
  for($i=0;$i<$erster_tag%7;$i++){ $out.="<td>&nbsp;</td>"; }

  for($i=$erster_tag;$i<=$letzter_tag;$i++){
    $date = cal_from_jd($i, CAL_GREGORIAN);
    $events=getEvents($date['year'].'-'.$date['month'].'-'.$date['day']);
		
    /* Trage nun den Tag in den Kalender ein */
    if($i%7==6 or $i==2454953 or $i>2454902 and $i<2454941){
      // Tage, an denen die Inspirata geschlossen ist
      $out.='<td class="zu">'.$date['day'].'</td>';
    }
    else{
      // Events zu diesem Tag liegen vor. GET-Parameter, um im nächsten
      // Schritt die Events für dieses $datum listen zu lassen.
      if($anmeldungen){
	$out.='
    <td class="teilfrei">
      <a class="tabelle" href="'.$action.'?jahr='.$date['year']
	  .'&amp;monat='.$date['month'].'&amp;tag='.$date['day'].'">'
	  .$date['day'].'</a></td>';
      }
      else { $out.='<td class="frei">'.$date['day'].'</td>'; }
    }

    if($i%7==6){ $out.='</tr><tr>'; }
  }

  for($i=6;$i>$letzter_tag%7;$i--){ $out.='<td>&nbsp;</td>'; }
  $out.='</tr></table></div>'; // Ende buchungstabelle linke Seite

  if ($tag) { $out.=getEventsUebersicht("$jahr-$monat-$tag"); }
  
  $ou.='<script type="text/javascript">

        // Wait for the page to load first
        window.onload = function() {

          //Get a reference to the link on the page
          // with an id of "mylink"
          var last = document.getElementById("lastMonth");
		  var next = document.getElementById("nextMonth");

          //Set code to run when the link is clicked
          // by assigning a function to "onclick"
          last.onclick = function() {

            // Your code here...

            //If you dont want the link to actually 
            // redirect the browser to another page,
            // "google.com" in our example here, then
            // return false at the end of this block.
            // Note that this also prevents event bubbling,
            // which is probably what we want here, but wont 
            // always be the case.
			$("#test").load("'.$backlink.'");
            return false;
          }
		  next.onclick = function() {

            // Your code here...

            //If you dont want the link to actually 
            // redirect the browser to another page,
            // "google.com" in our example here, then
            // return false at the end of this block.
            // Note that this also prevents event bubbling,
            // which is probably what we want here, but wont 
            // always be the case.
			$("#test").load("'.$nextlink.'");
            return false;
          }
        }
	</script><div id="test"></div>';
	

  return "<div>$out</div>";

  }



?>

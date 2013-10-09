<?php
/*
Plugin Name: SPARQalendar - A SPARQL driven Calendar
Version: 0.0.1
Description: display Date Entities (like Events) on a Calendar using a dynamic SPARQL query to retrieve them
Author: leipzig-data.de
Author URI: http://leipzig-data.de
*/

include_once("kalender.php");
add_shortcode( 'sparqalendar', 'displayKalenderGet' );


?>
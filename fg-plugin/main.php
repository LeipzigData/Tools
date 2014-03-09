<?php
/*
Plugin Name: fg-plugin - A plugin for rendering results of SPARQL queries
Version: 0.0.1
Description: display results of dynamic SPARQL queries
Author: leipzig-data.de
Author URI: http://leipzig-data.de
*/

function get_store() {
  return 'http://symbolicdata.org:8891/sparql';
}

include_once("fachgruppenleitung.php");
include_once("carbeitraege.php");
include_once("tagungsankuendigungen.php");
include_once("arbeitsgruppen.php");

add_action( 'init', 'register_this_style' );
add_action( 'wp_enqueue_scripts', 'enqueue_this_style' );

/**
 * Register style sheet.
 */
function register_this_style() {
  wp_register_style( 'fg-plugin', plugins_url( 'fg-plugin/styles.css' ) );
}

/**
 * enqueue style sheet.
 */
function enqueue_this_style() {
  wp_enqueue_style( 'fg-plugin' );
  //echo plugins_url( 'fg-plugin/styles.css' );
}

?>

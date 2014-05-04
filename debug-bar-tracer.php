<?php
/*
Plugin Name: Debug Bar Tracer
Plugin URI: http://www.ryanwelcher.com
Description: Gives developers the ability to "trace" messages from their themes/plugins to a window in debug bar. Requires the debug bar plugin.
Author: Ryan Welcher
Version: 1.0
*/

/**
 * Adds panel, as defined in the included class, to Debug Bar.
 *
 * @param $panels array
 * @return array
 */
function rw_add_debug_output_tracer_panel( $panels ) {
	if ( ! class_exists( 'Debug_Bar_Tracer' ) ) {
		include ( 'class-debug-bar-tracer.php' );
		$panels[] = new Debug_Bar_Tracer();
	}
	return $panels;
}
add_filter( 'debug_bar_panels', 'rw_add_debug_output_tracer_panel' );



/**
 * adds a new item to be traces
 * @param  mixes $trace_args 
 * @return void
 */
function debug_trace( $trace_args  ) {

	//check to be sure we are logged in and Debug_Bar_Panel exists
	if(is_user_logged_in() && class_exists( 'Debug_Bar_Panel' ) ) {
		$file_details = debug_backtrace();

		//default values
		$defaults = array(
			'data' => 'Not Set',
			'location' => basename($file_details[0]['file']).' at line '.$file_details[0]['line'],
		);

		$array_to_parse = ( 'array' == gettype($trace_args) && ( array_key_exists('data', $trace_args) || array_key_exists('key', $trace_args) ) ) ? $trace_args : array( 'data' => $trace_args );
		$trace = wp_parse_args( $array_to_parse, $defaults ) ;

		//add to the static var of the class
		Debug_Bar_Tracer::$traces[] = $trace;
	}
}
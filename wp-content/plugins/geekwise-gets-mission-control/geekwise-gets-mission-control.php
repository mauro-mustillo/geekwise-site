<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Geekwise_Gets_Mission_Control
 *
 * @wordpress-plugin
 * Plugin Name:       Geekwise Gets Mission Control
 * Description:       Grabs info from Bitwise Mission Control to display on site.
 * Version:           1.0.0
 * Author:            Bitwise Industries 
 * Author URI:        http://bitwiseindustries.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       geekwise-gets-mission-control
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	//die;///////////////////////////////////////////////////
}


require_once('config.php');



// function to calculate rounds
// this is hacky and should eventually rely on 
// mission control to get the round start and end dates.
// for now, we KNOW that June 27th, 2016  was the start of
// round number 24. We'll start with that for the new
// geekwise website
function geekwise_get_round_as_of( $__date = '' )  {

	// get the round we're in as of today? Or some other day?
	if ( empty( $__date ) ) {
		$as_of_date = strtotime( 'today' );
	} else {
		$as_of_date = strtotime( $__date );
	}

	$rounds = unserialize( GEEKWISE_ROUNDS );


	// now which of those are we in as of $__date?
	// "Old come down after the first week in the current round, 
	// new goes up the first week in the current round." - BEM
	$requested_round = '';

	foreach ($rounds as $start => $round ) {

		$start_of_round = strtotime( $start );
		$one_week =  60*60*24*7;
		$one_week_after_start_of_round =  $start_of_round + $one_week;
		
		if( $as_of_date <  $one_week_after_start_of_round ) {

			$requested_round = $round;
			break;

		}

	}

	return $requested_round;

}


//
function geekwise_get_start_date_of_round ( $__requested_round = 'current') {

	if( $__requested_round == 'current' ) {

		$round = geekwise_get_round_as_of( 'today' );

	} elseif (is_numeric( $__requested_round) ) {

		$round = $__requested_round;

	} else {

		$round = false;

	}



	$rounds = unserialize( GEEKWISE_ROUNDS );

	if( $round === false ) {
	
		$requested_start_date_of_round = false;
	
	} else {

		$requested_start_date_of_round = array_search( $round, $rounds );

		if( empty($requested_start_date_of_round) ) {

			$requested_start_date_of_round = false;

		}

	}

	return $requested_start_date_of_round;

}


// function to get grab class data from mission control
function geekwise_get_classes( $__round = 'current') {
	
	$api_request    = GEEKWISE_API_BASE_URL . 'courses/' . $__round . '/?is_displayed=1';
	$api_response = wp_remote_get( $api_request, $args = array( 'timeout' => 30 ) );
	//echo '<pre>' . var_dump($api_response) . '</pre>';
	return $api_data = json_decode( wp_remote_retrieve_body( $api_response ), true );

}


// function to grab all class details from mission control
function geekwise_get_class( $__class_id ) {

	$api_request    = GEEKWISE_API_BASE_URL . 'course/' . $__class_id . '/data';
	$api_response = wp_remote_get( $api_request, $args = array( 'timeout' => 30 ) );
	return $api_data = json_decode( wp_remote_retrieve_body( $api_response ), true );

}


function geekwise_class_start_end_by_round_per_class( $__round, $__class_arr ) {

	// get the actual start date of the round
	$start_date_of_round = geekwise_get_start_date_of_round( $__round );
			
	// determine m/w or t/r start and end dates for six week courses
	$monday_start_date = date( 'F j',  strtotime($start_date_of_round) );
		$monday_start_end_date = date('F j', strtotime($monday_start_date. ' + 37 days') );
	$tuesday_start_date = date('F j', strtotime($monday_start_date. ' + 1 days') );
		$tuesday_start_end_date = date('F j', strtotime($tuesday_start_date. ' + 37 days') );




		if( stristr($__class_arr['class_day_1'], 'Mon' ) ){
			$round_dates = array(
				'start'	=> $monday_start_date,
				'end'	=> $monday_start_end_date
			);
		} else {
			$round_dates = array(
				'start'	=> $tuesday_start_date,
				'end'	=> $tuesday_start_end_date
			);			
		}


		return $round_dates;

}



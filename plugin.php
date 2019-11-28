<?php

/*
	Plugin Name: Redlum Contactbox
	Description: Contactbox
	Version: 1.0
	Author: Erik Mulder
	Author URI: http://www.redlum-media.com
	License: GPL3
	License URI: https://www.gnu.org/licenses/gpl-3.0.txt
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include(plugin_dir_path( __FILE__ ) . 'includes/cpt.php');
include(plugin_dir_path( __FILE__ ) . 'includes/options.php');
include(plugin_dir_path( __FILE__ ) . 'includes/metaboxes.php');
include(plugin_dir_path( __FILE__ ) . 'includes/render.php');

// Includes styles & scripts

add_action( 'wp_enqueue_scripts', 'redlum_contact_box_scripts' );

function redlum_contact_box_scripts() {
	wp_enqueue_style( 'redlum_contact_box_style', plugin_dir_url( __FILE__ ) .'style/style.css', array(), filemtime(plugin_dir_path( __FILE__ )	 .'/style/style.css'), 'all' );
	wp_enqueue_script( 'redlum_contact_box_script', plugin_dir_url( __FILE__ ) . 'scripts/script.js', filemtime(plugin_dir_path( __FILE__ ) .'/scripts/script.js'), true );

	wp_register_script( 'redlum_font_awesome_cdn',  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.js','','','true');
	wp_register_style( 'redlum_font_awesome_css', 'https://use.fontawesome.com/releases/v5.11.2/css/all.css');

	wp_enqueue_script( 'redlum_font_awesome_cdn' );
	wp_enqueue_style( 'redlum_font_awesome_css' );

}

add_action( 'rest_api_init', 'my_register_route' );

function my_register_route() {
	register_rest_route( 'redlum_contact_box', 'settings', array(
			'methods' => WP_REST_SERVER::READABLE,
			'callback' => 'get_options',
		)
	);
}

function get_options() {
	$redlum_cb_settings = get_option( 'redlum_contact_box' );
	return $redlum_cb_settings;
}


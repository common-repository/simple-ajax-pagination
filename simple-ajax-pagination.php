<?php
/**
 * Contributors: milanhirapra1
 * Plugin Name: Simple Ajax Pagination
 * Plugin URI: https://wordpress.org/plugins/simple-ajax-pagination
 * Tags: ajax, ajax pagination, wp ajax, ajax wordpress plugin
 * Description: Simple ajax pagination without any hard code
 * Version: 0.2
 * Author: Milan Hirapra
 * Author URI: https://milan-hirapra.firebaseapp.com
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'SAP_PLUGIN_FILE' ) ) {
	define( 'SAP_PLUGIN_FILE', __FILE__ );
}

// Include the main Simple_Ajax_Pagination class.
if ( ! class_exists( 'Simple_Ajax_Pagination' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-simple-ajax-pagination.php';
}

function SAP() {
	return new Simple_Ajax_Pagination;
}

// Global for backwards compatibility.
$GLOBALS['sap'] = SAP();

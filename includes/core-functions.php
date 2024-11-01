<?php defined( 'ABSPATH' ) || exit;

function pre($data){
	echo '<PRE>';
	print_r($data);
	echo '</PRE>';
}

function rm_maybe_define_constant( $name, $value ) {
	if ( ! defined( $name ) ) {
		define( $name, $value );
	}
}

function clean_title($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

function get_administrator_id(){
	$administrator_id = 1;

	$available_users = get_users(
	    array(
	        'role' => 'administrator'
	    )
	);

	if( !empty( $available_users ) && count( $available_users ) > 0 ){
		$administrator_id = $available_users[0]->ID;
	}

	return $administrator_id;
}

function is_active_multilingual(){

	if( check_polylang_activate() ){
		return true;
	} else if( check_wpml_activate() ){
		return true;
	} else {
		return false;
	}
}

function check_polylang_activate(){
	return check_plugin_activate( 'polylang-pro/polylang.php' );
}

function check_wpml_activate(){
	return check_plugin_activate( 'sitepress-multilingual-cms/sitepress.php' );
}

function check_plugin_activate( $path ){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );	

	if ( is_plugin_active( $path ) ) {
	    return true;
	}

	return false;
}
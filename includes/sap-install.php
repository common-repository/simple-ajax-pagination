<?php defined( 'ABSPATH' ) || exit;
final class SAP_Install {

	public function __construct() {
		register_activation_hook( SAP_PLUGIN_FILE, array( __CLASS__, 'install' ) );
		register_deactivation_hook( SAP_PLUGIN_FILE, array( __CLASS__, 'uninstall' ) );
	}

	public static function install() {

		// Check if we are not already running this routine.
		if ( 'yes' === get_transient( 'sap_installing' ) ) {
			return;
		}

		// If we made it till here nothing is running yet, lets set the transient now.
		set_transient( 'sap_installing', 'yes', MINUTE_IN_SECONDS * 10 );
		rm_maybe_define_constant( 'SAP_INSTALLING', true );
		
		delete_transient( 'sap_installing' );
	}

	public static function uninstall() {

		// If we made it till here nothing is running yet, lets set the transient now.
		set_transient( 'sap_installing', 'yes', MINUTE_IN_SECONDS * 10 );
		rm_maybe_define_constant( 'SAP_INSTALLING', true );

		delete_transient( 'sap_installing' );
	}
}
return new SAP_Install();
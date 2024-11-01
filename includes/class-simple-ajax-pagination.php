<?php defined( 'ABSPATH' ) || exit;

final class Simple_Ajax_Pagination {

	public $version = '0.1';

	public $properties = null;
	public $query = null;
	public $rm_logs = null;

	public function __construct() {
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		$this->define_constants();
		$this->includes();
	}

	private function define_constants() {
		global $wpdb;
		$upload_dir = wp_upload_dir( null, false );

		$this->define( 'SAP_ABSPATH', dirname( SAP_PLUGIN_FILE ) . '/' );
		$this->define( 'SAP_PLUGIN_BASENAME', plugin_basename( SAP_PLUGIN_FILE ) );
		$this->define( 'SAP_VERSION', $this->version );
		$this->define( 'SAP_AJAX_URL', $this->ajax_url() );
		$this->define( 'SAP_PLUGIN_URL', $this->plugin_url() );
		$this->define( 'SAP_PLUGIN_PATH', $this->plugin_path() );
		$this->define( 'SAP_PLUGIN_DOMAIN', 'simple-ajax-pagination' );
		$this->define( 'SAP_OPTION_KEY', '_sap_settings' );
		$this->define( 'SAP_ARCHIVE_PAGE_KEY', 'archive' );

		add_action( 'init', array( $this, 'init_sap_plugin_textdomain' ) );
	}

	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	public function init_sap_plugin_textdomain(){
		load_plugin_textdomain( SAP_PLUGIN_DOMAIN, false, SAP_ABSPATH . '/languages' );
	}

	public function includes() {
		
		include_once SAP_ABSPATH . 'includes/core-functions.php';
		include_once SAP_ABSPATH . 'includes/sap-install.php';
		include_once SAP_ABSPATH . 'includes/sap-pagination.php';

		if ( is_admin() ) {			
		    include_once SAP_ABSPATH . 'includes/admin/sap-admin-notice.php';
		    include_once SAP_ABSPATH . 'includes/admin/sap-pagination-option.php';
		}
	}

	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', SAP_PLUGIN_FILE ) ) . '/';
	}

	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( SAP_PLUGIN_FILE ) );
	}

	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}
}
<?php defined( 'ABSPATH' ) || exit;

class SAP_Admin_Pagination_Options {

	protected $sap_options = [];

	public function __construct() {

		$this->set_sap_option();

		add_action( 'admin_enqueue_scripts', [ $this, 'admin_custom_style' ] );

		add_action( 'admin_menu', [ $this, 'sap_admin_menu' ] );
		
		add_action( 'admin_notices', [ new SapAdminNotice(), 'displayAdminNotice' ] );
	}

	public function admin_custom_style() {
		wp_enqueue_style('admin-pagination-styles', SAP_PLUGIN_URL . 'assets/css/sap-settings.css' );
	}

	public function set_sap_option(){
		$this->sap_options = get_option( SAP_OPTION_KEY );
	}

	public function sap_admin_menu() {

		add_options_page(
			'SA Pagination',
			'SA Pagination',
			'manage_options',
			'sap-pagination-settings',
			array(
				$this,
				'sap_settings_page'
			)
		);
	}

	public function  sap_settings_page() {
		
		$this->save_options();

		include_once SAP_ABSPATH . 'includes/admin/sap-settings.tpl.php';
	}

	public function get_all_pages( $value = '' ){
		$html = '<option value="">' . __( 'Select', SAP_PLUGIN_DOMAIN ) . '</option>';

		$get_pages = get_pages( 
			array( 
				'sort_column' => 'post_date', 
				'sort_order' => 'desc'  
			) 
		);

		if( $get_pages ){
			foreach ( $get_pages as $page ) {
				$html .= '<option value="' . $page->ID . '" ' . selected( $value, $page->ID, false ) . '>' . $page->post_title . '</option>';
			}
		}

		//Archive page
		$html .= '<option value="' . SAP_ARCHIVE_PAGE_KEY . '" ' . selected( $value, SAP_ARCHIVE_PAGE_KEY, false ) . '>Archive Page</option>';

		return $html;
	}

	public function save_options(){

		if( isset( $_REQUEST, $_REQUEST['sap-settings-nonce'] ) && wp_verify_nonce( $_POST['sap-settings-nonce'], 'allow-site-admin-sap-settings' ) ){

			$options = [];
			if( $_REQUEST['sap'] && count( $_REQUEST['sap']['pages'] ) > 0 ){

				foreach ( $_REQUEST['sap']['pages'] as $page_key => $pages ) {
					
					$options[] = [
						'pages' => sanitize_text_field( $pages ),
						'cdiv' => sanitize_text_field( $_REQUEST['sap']['cdiv'][$page_key] ),
						'pdiv' => sanitize_text_field( $_REQUEST['sap']['pdiv'][$page_key] ),
					];

				}

			}

			update_option( SAP_OPTION_KEY, $options );
			SapAdminNotice::displaySuccess(__( 'Setting Saved.', SAP_PLUGIN_DOMAIN ));
			$url = admin_url( "options-general.php?page=" . sanitize_text_field( $_GET["page"] ) );
			echo '<script type="text/javascript">window.location.href = "' . $url . '";</script>';
			exit();

		}

	}
}

new SAP_Admin_Pagination_Options();
?>
<?php defined( 'ABSPATH' ) || exit;

class SAP_FrontEnd_Pagination {

	protected $sap_options = [];

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'sap_pagination_scripts' ], 20 );
		add_action( 'wp_footer', [ $this, 'wp_footer' ], 20 );

		$this->sap_options = get_option( SAP_OPTION_KEY );
	}

	public function sap_pagination_scripts() {

		if ( ! wp_script_is( 'jquery', 'enqueued' )) {

	        wp_enqueue_script( 'jquery' );

	    }

		wp_localize_script(
			'jquery', 
			'sap_js_vars', 
			array(
				'site_url' => get_site_url()."/",
				'domain_url' => $_SERVER['HTTP_HOST']
			)
		);
	}

	function wp_footer() {

		$js_code = '';

		if ( !is_admin() && !is_feed() && !is_robots() && !is_trackback() ) {

			if( !empty( $this->sap_options ) ){

				foreach ( $this->sap_options as $keys => $options ) {

					$options['new_page_id'] = $this->get_actual_page_ID( $options['pages'] );

					if( 
						is_page( $options['new_page_id'] ) || 
						is_home( $options['new_page_id'] ) ||
						( $options['new_page_id'] == SAP_ARCHIVE_PAGE_KEY && is_archive() )
					){

						$pdiv 					= $this->get_pagination_id_or_class( $options );
						$cdiv 					= $this->get_container_id_or_class( $options );
						$sap_loader_text 		= $this->get_loader_text( $options );

						$js_code .= '$( document ).on( "click", "' . $pdiv . '[href^=\'"+domain_url+"\']", function(e){';

							$js_code .= 'e.preventDefault();';

							$js_code .= 'var $content' . $keys . ' = $("' . $cdiv . '");';
							$js_code .= 'var container_height' . $keys . ' = $content' . $keys . '.height();';

							$js_code .= 'if ( !this.pathname ) {';
								$js_code .= 'return false;';
							$js_code .= '}';

							$js_code .= '$content' . $keys . '.css(\'min-height\', container_height' . $keys . ' + \'px\');';
							$js_code .= '$content' . $keys . '.html(\'<div class="ajax-loader">' . $sap_loader_text . '</div>\');';

							$js_code .= '$("html, body").animate({';
						        $js_code .= 'scrollTop: $("' . $cdiv . '").offset().top - 100';
						    $js_code .= '}, 800);';

							$js_code .= 'var full_url' . $keys . ' = domain_url + this.pathname + " ' . $cdiv . '";';

							$js_code .= 'setTimeout(function(){';

								$js_code .= '$content' . $keys . '.load( full_url' . $keys . ' );';

								$js_code .= 'setTimeout(function(){';
									$js_code .= '$content' . $keys . '.css(\'min-height\', \'unset\');';
								$js_code .= '}, 500);';

							$js_code .= '}, 500);';
						
							$js_code .= 'return false;';

						$js_code .= '});';

					}


				}

			}
		
			$all_js_code = '<script type="text/javascript">';
		
				$all_js_code .= '(function($, undefined){';

					$all_js_code .= 'var domain_url = location.protocol+"//"+ top.location.host.toString();';

					$all_js_code .= $js_code;
		
				$all_js_code .= '})(jQuery);';

			$all_js_code .= '</script>';

			print $all_js_code;

		}

	}

	public function get_loader_text( $options = [] ){
		$sap_loader_text = __( 'Loading...', SAP_PLUGIN_DOMAIN );
		return apply_filters( "sap/loader_text", $sap_loader_text, $options['pages'] );
	}

	public function get_pagination_id_or_class( $options = [] ){
		$pdiv = $this->get_id_or_class( $options['pdiv'] );
		return apply_filters( "sap/pagination_div", $pdiv, $options['pages'] );
	}

	public function get_container_id_or_class( $options = [] ){
		$cdiv = $this->get_id_or_class( $options['cdiv'] );
		return apply_filters( "sap/container_div", $cdiv, $options['pages'] );
	}

	public function get_id_or_class( $id_or_class = '' ){

		$new_div = "";

		$id_or_class_tag = isset( $id_or_class ) ? substr( trim( $id_or_class ), 0, 1 ) : "";

		if( $id_or_class_tag == "#" || $id_or_class_tag == "." ){
			$new_div = $id_or_class;
		} else {
			$new_div = "#" . $id_or_class;
		}

		return $new_div;
	}

	public function get_site_current_language(){

		$curr_lang = "en";

		
		if( is_active_multilingual() ){

			if( check_polylang_activate() ){
				$curr_lang = pll_current_language();
			} else if( check_wpml_activate() ){
				$curr_lang = ICL_LANGUAGE_CODE;
			}
		}

		return $curr_lang;
	}

	public function get_actual_page_ID( $page_id ){

		if( $page_id == SAP_ARCHIVE_PAGE_KEY ){
			return $page_id;
		}
		
		$new_page_id = $page_id;
		$c_lang = $this->get_site_current_language();

		// Check site is multi language
		if( is_active_multilingual() ){

			if( check_polylang_activate() ){
				$new_page_id = pll_get_post( $page_id, $c_lang );
			} else if( check_wpml_activate() ){
				$new_page_id = icl_object_id( $page_id, 'page', false, $c_lang );
			}
		}

		return $new_page_id;
	}
}

new SAP_FrontEnd_Pagination();
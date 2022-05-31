<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://puredevs.com/
 * @since      1.0.0
 *
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/public
 * @author     PureDevs <admin@puredevs.com>
 */
class Pd_gdpr_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Active cookie categories set by admin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $cookie_categories    Active cookie categories.
	 */
    private $cookie_categories;

	/**
	 * 3rd party cookie data set by admin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $strictly_necessary_cookies_section    Holds content of strictly necessary cookies.
	 */
    private $strictly_necessary_cookies_section;

	/**
	 * 3rd party cookie data set by admin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $third_party_cookies_section    Holds content of 3rd party cookies.
	 */
    private $third_party_cookies_section;

	/**
	 * Additional cookie data set by admin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $additional_cookies_section    Holds content of additional cookies.
	 */
    private $additional_cookies_section;

	/**
	 * Required cookie data set by admin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $required_cookies_section    Holds content of required cookies.
	 */
    private $required_cookies_section;

	/**
	 * Functional cookie data set by admin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $functional_cookies_section    Holds content of functional cookies.
	 */
    private $functional_cookies_section;

    /**
     * Required public classes of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      array    $required_classes    Required public classes of this plugin.
     */
    private $required_classes = array(
        'shortcode',
    );

    public static $existing_classes = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->cookie_categories = Pd_gdpr::get_settings_by_section_and_fields( 'selected_cookie_categories', 'puredevs_general_settings' );
		$this->strictly_necessary_cookies_section = Pd_gdpr::get_settings_by_section( 'puredevs_strictly_necessary_cookie_settings' );
		$this->third_party_cookies_section = Pd_gdpr::get_settings_by_section( 'puredevs_3rd_party_cookie_settings' );
		$this->additional_cookies_section = Pd_gdpr::get_settings_by_section( 'puredevs_additional_cookie_settings' );
		$this->required_cookies_section = Pd_gdpr::get_settings_by_section( 'puredevs_required_cookies_settings' );
		$this->functional_cookies_section = Pd_gdpr::get_settings_by_section( 'puredevs_functional_cookie_settings' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pd_gdpr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pd_gdpr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'icofont', plugin_dir_url( __FILE__ ) . 'css/icofont.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pd_gdpr-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pd_gdpr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pd_gdpr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pd_gdpr-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( 'jquery', 'js_vars',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

    /**
    Required public classes: public
     */
    public function required_public_classes () {
        foreach ( $this->required_classes as $required_class ) {
            $class_file = plugin_dir_path( __FILE__ )."partials/$required_class.php";
            if ( file_exists( $class_file ) ) {
                self::$existing_classes[] = $required_class; //this is for module_exits checking
                require_once $class_file;
            }
        }
    }

    /**
    Check for class exist: public
     */
    public static function class_exists( $class ) {
        return in_array( $class, self::$existing_classes );
    }

    /**
    Outputs the cookie control script in the footer
    N.B. This script MUST be output in the footer.

    This function should be attached to the wp_footer action hook.
     */
    public function pd_gdpr_inject_cookie_bar() {
        $primary_status = Pd_gdpr::get_settings_by_section_and_fields( 'primary_status', 'puredevs_general_settings' );
        $geo_location_settings = Pd_gdpr::get_settings_by_section_and_fields( 'geo_location_settings', 'puredevs_geo_location_settings' );
        $geo_location_settings = ($geo_location_settings ? $geo_location_settings : 'all-users');
        if ( isset( $primary_status ) && $primary_status != 'off' ) {

            $show_gdpr = true;

            if ( $geo_location_settings === 'european-union-only' ) {
                $client_ip = Pd_gdpr::get_client_ip();
                //$client_ip = '27.147.204.41';//Our Ip
                //$client_ip = '188.166.107.188';//Netherlands
                //$client_ip = '54.37.136.46';//Poland
                if ( $client_ip !== 'UNKNOWN' ) {
                	$is_eu = $this->check_eu( $client_ip );
	                if ( !$is_eu ) {
                        $show_gdpr = false;
	                }

                }
            }

            if( $show_gdpr ){
                $show_cookie_bar = Pd_gdpr::get_settings_by_section_and_fields( 'show_cookie_bar', 'puredevs_general_settings' );
                $pd_general_settings = Pd_gdpr::get_settings_by_section( 'puredevs_general_settings' );
                if ( isset( $show_cookie_bar ) && $show_cookie_bar != 'off' ) {
                    $pd_banner_settings = Pd_gdpr::get_settings_by_section( 'puredevs_banner_settings' );
                    require_once self::pd_gdpr_locate_template('pd-gdpr-bar.php');
                };
                require_once self::pd_gdpr_locate_template('pd-gdpr-complience-modal.php');
                if ( isset( $show_cookie_bar ) && $show_cookie_bar != 'off' ) {
                    require_once self::pd_gdpr_locate_template('pd-gdpr-floating-button.php');
                }
            }
        }
    }

	/**
	 * Inject js scripts of cookie categories to header
     *
     * Should be attached to the wp_head action hook.
	 */
    public function pd_gdpr_inject_script_to_header() {
        if ( isset( $this->cookie_categories['3rd_party_cookie'] ) ) {
            ob_start();
            $third_party_cookie_head_section =  ! empty( $this->third_party_cookies_section['3rd_party_cookie_head_section'] ) ? $this->third_party_cookies_section['3rd_party_cookie_head_section'] : '' ;
            $third_party_cookie_head_section = apply_filters( 'pd_gdpr_3rd_party_header_assets', $third_party_cookie_head_section );
            echo $third_party_cookie_head_section;
            ob_end_flush();
        }
	    if ( isset( $this->cookie_categories['additional_cookie'] ) ) {
            ob_start();
            $additional_cookie_head_section = ! empty( $this->additional_cookies_section['additional_cookie_head_section'] ) ? $this->additional_cookies_section['additional_cookie_head_section'] : '';
            $additional_cookie_head_section = apply_filters( 'pd_gdpr_additional_cookie_header_assets', $additional_cookie_head_section );
            echo $additional_cookie_head_section;
            ob_end_flush();
	    }
	    if ( isset( $this->cookie_categories['required_cookies'] ) ) {
            ob_start();
	        $required_cookies_head_section = ! empty( $this->required_cookies_section['required_cookies_head_section'] ) ? $this->required_cookies_section['required_cookies_head_section'] : '';
            $required_cookies_head_section = apply_filters( 'pd_gdpr_required_cookie_header_assets', $required_cookies_head_section );
            echo $required_cookies_head_section;
            ob_end_flush();
	    }
	    if ( isset( $this->cookie_categories['functional_cookie'] ) ) {
            ob_start();
	        $functional_cookie_head_section = ! empty( $this->functional_cookies_section['functional_cookie_head_section'] ) ? $this->functional_cookies_section['functional_cookie_head_section'] : '';
            $functional_cookie_head_section = apply_filters( 'pd_gdpr_functional_cookie_header_assets', $functional_cookie_head_section );
            echo $functional_cookie_head_section;
            ob_end_flush();
	    }
    }

	/**
	 * Inject js scripts of cookie categories to HTML body
     *
     * Should be attached to the wp_footer action hook.
	 */
    public function pd_gdpr_inject_script_to_body() {
        if ( isset( $this->cookie_categories['3rd_party_cookie'] ) ) {
            ob_start();
            $third_party_cookie_body_section = ! empty( $this->third_party_cookies_section['3rd_party_cookie_body_section'] ) ? $this->third_party_cookies_section['3rd_party_cookie_body_section'] : '' ;
            $third_party_cookie_body_section = apply_filters( 'pd_gdpr_3rd_party_body_assets', $third_party_cookie_body_section );
            echo $third_party_cookie_body_section;
            ob_end_flush();
        }
	    if ( isset( $this->cookie_categories['additional_cookie'] ) ) {
            ob_start();
	        $additional_cookie_body_section = ! empty( $this->additional_cookies_section['additional_cookie_body_section'] ) ? $this->additional_cookies_section['additional_cookie_body_section'] : '';
            $additional_cookie_body_section = apply_filters( 'pd_gdpr_additional_cookie_body_assets', $additional_cookie_body_section );
            echo $additional_cookie_body_section;
            ob_end_flush();
	    }
	    if ( isset( $this->cookie_categories['required_cookies'] ) ) {
            ob_start();
	        $required_cookies_body_section = ! empty( $this->required_cookies_section['required_cookies_body_section'] ) ? $this->required_cookies_section['required_cookies_body_section'] : '';
            $required_cookies_body_section = apply_filters( 'pd_gdpr_required_cookie_body_assets', $required_cookies_body_section );
            echo $required_cookies_body_section;
            ob_end_flush();
	    }
	    if ( isset( $this->cookie_categories['functional_cookie'] ) ) {
            ob_start();
	        $functional_cookie_body_section = ! empty( $this->functional_cookies_section['functional_cookie_body_section'] ) ? $this->functional_cookies_section['functional_cookie_body_section'] : '';
            $functional_cookie_body_section = apply_filters( 'pd_gdpr_functional_cookie_body_assets', $functional_cookie_body_section );
            echo $functional_cookie_body_section;
            ob_end_flush();
	    }
    }

	/**
	 * Inject js scripts of cookie categories to HTML footer
     *
     * Should be attached to the wp_footer action hook.
	 */
    public function pd_gdpr_inject_script_to_footer() {
        if ( isset( $this->cookie_categories['3rd_party_cookie'] ) ) {
            ob_start();
            $third_party_cookie_footer_section = ! empty( $this->third_party_cookies_section['3rd_party_cookie_footer_section'] ) ? $this->third_party_cookies_section['3rd_party_cookie_footer_section'] : '' ;
            $third_party_cookie_footer_section = apply_filters( 'pd_gdpr_3rd_party_footer_assets', $third_party_cookie_footer_section );
            echo $third_party_cookie_footer_section;
            ob_end_flush();
        }
	    if ( isset( $this->cookie_categories['additional_cookie'] ) ) {
            ob_start();
	        $additional_cookie_footer_section = ! empty( $this->additional_cookies_section['additional_cookie_footer_section'] ) ? $this->additional_cookies_section['additional_cookie_footer_section'] : '';
            $additional_cookie_footer_section = apply_filters( 'pd_gdpr_additional_cookie_footer_assets', $additional_cookie_footer_section );
            echo $additional_cookie_footer_section;
            ob_end_flush();
	    }
	    if ( isset( $this->cookie_categories['required_cookies'] ) ) {
            ob_start();
	        $required_cookies_footer_section = ! empty( $this->required_cookies_section['required_cookies_footer_section'] ) ?
				    $this->required_cookies_section['required_cookies_footer_section'] : '';
            $required_cookies_footer_section = apply_filters( 'pd_gdpr_required_cookie_footer_assets', $required_cookies_footer_section );
            echo $required_cookies_footer_section;
            ob_end_flush();
	    }
	    if ( isset( $this->cookie_categories['functional_cookie'] ) ) {
            ob_start();
	        $functional_cookie_footer_section = ! empty( $this->functional_cookies_section['functional_cookie_footer_section'] ) ?
				    $this->functional_cookies_section['functional_cookie_footer_section'] : '';
            $functional_cookie_footer_section = apply_filters( 'pd_gdpr_functional_cookie_footer_assets', $functional_cookie_footer_section );
            echo $functional_cookie_footer_section;
            ob_end_flush();
	    }
    }

    /**
     * Set default cookie for non Europeans
     *
     * Should be saved in the browser cookies.
     */
    public function pd_gdpr_set_default_cookies_for_non_european() {
        $primary_status = Pd_gdpr::get_settings_by_section_and_fields( 'primary_status', 'puredevs_general_settings' );
        $geo_location_settings = Pd_gdpr::get_settings_by_section_and_fields( 'geo_location_settings', 'puredevs_geo_location_settings' );
        $geo_location_settings = ( $geo_location_settings ? $geo_location_settings : 'all-users' );
        if ( isset( $primary_status ) && $primary_status != 'off' ) {

	        if ( isset( $this->cookie_categories['strictly_necessary_cookie'] ) && ( isset( $this->strictly_necessary_cookies_section['snc_choose_functionality']) && ($this->strictly_necessary_cookies_section['snc_choose_functionality'] == 'always-enable-chfu' || $this->strictly_necessary_cookies_section['snc_choose_functionality'] == 'always-enable' ) ) ) {
		        setcookie( 'pd_strictly_necessary_cookie', 'true', time() + ( 86400 * 30 ), "/" );
	        }
            if ( $geo_location_settings === 'european-union-only' ) {
	            $client_ip = Pd_gdpr::get_client_ip();
                //$client_ip = '27.147.204.41';//Our Ip
                //$client_ip = '188.166.107.189';//Netherlands
                //$client_ip = '54.37.136.46';//Poland
                if ( $client_ip !== 'UNKNOWN' ) {
	                $is_eu = $this->check_eu( $client_ip );
	                if ( ! $is_eu ) {
		                setcookie( 'pd_reject_cookie_save', 'false', time() + ( 86400 * 30 ), "/" );
		                setcookie( 'pd_accept_cookie_save', 'true', time() + ( 86400 * 30 ), "/" );
		                if ( isset( $this->cookie_categories['3rd_party_cookie'] ) && $this->third_party_cookies_section['enable_disable_3rd_party_cookie'] == 'on' ) {
			                setcookie( 'pd_3rd_party_cookie', 'true', time() + ( 86400 * 30 ), "/" );
		                }
		                if ( isset( $this->cookie_categories['additional_cookie'] ) && $this->additional_cookies_section['enable_disable_additional_cookie'] == 'on' ) {
			                setcookie( 'pd_additional_cookie', 'true', time() + ( 86400 * 30 ), "/" );
		                }
		                if ( isset( $this->cookie_categories['required_cookies'] ) && $this->required_cookies_section['enable_disable_required_cookie'] == 'on' ) {
			                setcookie( 'pd_required_cookie', 'true', time() + ( 86400 * 30 ), "/" );
		                }
		                if ( isset( $this->cookie_categories['functional_cookie'] ) && $this->functional_cookies_section['enable_disable_functional_cookie'] == 'on' ) {
			                setcookie( 'pd_functional_cookie', 'true', time() + ( 86400 * 30 ), "/" );
		                }
	                }
                }
            }
        }
    }

	/**
	 * Check the ip is in European Union or not
	 * @param $client_ip
	 *
	 * @return bool
	 */
	function check_eu( $client_ip ) {
		$is_eu = false;
        $upload_dir = wp_get_upload_dir();
		if ( ! file_exists( $file_name = $upload_dir['basedir'] . '/ip.txt' ) ) {
			fopen( $file_name, "w+" );
		}
		$prevIPlist =  file_get_contents( $file_name );
		if ( ! empty( $prevIPlist ) ) {
			$prevIPlist = json_decode($prevIPlist, true);
			$found = current( array_filter( $prevIPlist, function ( $item ) use ( $client_ip ) {
				return isset( $item['ip'] ) && $client_ip == $item['ip'];
			} ) );
			if ( ! empty( $found ) ) {
				$is_eu = $found['is_eu'];
			} else {
				return $this->save_ip_to_file( $file_name, $prevIPlist, $client_ip );
			}
		} else {
			$prevIPlist = array();
			return $this->save_ip_to_file( $file_name, $prevIPlist, $client_ip );
		}

		return $is_eu;
	}

	/**
	 * Get geo location of the ip
	 * @param $ip
	 * @param string $lang
	 * @param string $fields
	 * @param string $excludes
	 *
	 * @return mixed
	 */
	function get_geolocation( $ip, $lang = "en", $fields = "*", $excludes = "" ) {
		$client_api_key = Pd_gdpr::get_settings_by_section_and_fields( 'geo_location_api', 'puredevs_geo_location_settings' );
		$default_api_key = Pd_gdpr::$GEOIP_API_KEY;
		$apiKey = ! empty( $client_api_key ) ? $client_api_key : $default_api_key[array_rand($default_api_key)];
		$url = "https://api.ipgeolocation.io/ipgeo?apiKey=".$apiKey."&ip=".$ip."&lang=".$lang."&fields=".$fields."&excludes=".$excludes;
        $args = array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            )
        );
        $response = wp_remote_get( $url, $args);
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            $body    = $response['body']; // use the content
            return $body;
        }
        return;
	}

	/**
	 * Save IP address to file if not exits
	 * @param $file_name
	 * @param $prevIPlist
	 * @param $client_ip
	 *
	 * @return bool
	 */
	function save_ip_to_file( $file_name, $prevIPlist, $client_ip ) {
		$location        = $this->get_geolocation( $client_ip );
		$decodedLocation = json_decode( $location, true );
		$is_eu           = ! empty( $decodedLocation['is_eu'] ) ? $decodedLocation['is_eu']: false;
		$newIP = array(
			'ip' => $client_ip,
			'is_eu' => $is_eu,
		);
		array_push( $prevIPlist, $newIP );
		file_put_contents( $file_name, json_encode($prevIPlist));
		return $is_eu;
	}

	public static function pd_gdpr_locate_template($file_name, $pos = 'public'){
        $theme_file = 'puredevs-gdpr-complience/' . $file_name;
        //if ( locate_template( $theme_file, true ) ) {
        if ( locate_template( $theme_file ) ) {
            $template = locate_template( $theme_file );
        } else {
            $template = PD_GDPR_PLUGIN_DIR;
            $template .= '/' . $pos . '/templates/' . $file_name;
        }
        return $template;
    }
}

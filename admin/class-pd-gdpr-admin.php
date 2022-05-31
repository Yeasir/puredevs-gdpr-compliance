<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://puredevs.com/
 * @since      1.0.0
 *
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/admin
 * @author     PureDevs <admin@puredevs.com>
 */
class Pd_gdpr_Admin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pd_gdpr-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pd_gdpr-admin.js', array( 'jquery' ), $this->version, false );
        $selected_cookie_categories = Pd_gdpr::get_settings_by_section_and_fields( 'selected_cookie_categories', 'puredevs_general_settings' );
        if ( empty( $selected_cookie_categories ) ) {
            $selected_cookie_categories = array(
                'strictly_necessary_cookie' => 'strictly_necessary_cookie',
                'additional_cookie' => 'additional_cookie',
                '3rd_party_cookie' => '3rd_party_cookie',
                'required_cookies' => 'required_cookies',
            );
        }
        wp_localize_script( 'jquery', 'js_admin_vars',array( 'selected_cookie_categories' => $selected_cookie_categories, 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

    public function pd_gdpr_import_plugin_settings_function( $upload, $context ) {
        if( $upload['type'] == 'text/csv' ){
            $meta_keys = ['puredevs_general_settings', 'puredevs_banner_settings', 'puredevs_button_settings', 'puredevs_privacy_overview_settings', 'puredevs_strictly_necessary_cookie_settings', 'puredevs_additional_cookie_settings', 'puredevs_3rd_party_cookie_settings', 'puredevs_functional_cookie_settings', 'puredevs_required_cookies_settings', 'puredevs_export_import_settings', 'puredevs_geo_location_settings', 'puredevs_analytics_settings', 'puredevs_privacy_and_policy_settings', 'puredevs_help_settings'];
            $file = fopen($upload['url'], "r");
            $new_array = [];
            while ( ( $getData = fgetcsv( $file, 0, "," ) ) !== FALSE ) {
                $new_array[] = $getData;
            }
            fclose($file);
            //$total_records = @count( $new_array[0] );
            $array_item_exists = array_intersect( $meta_keys, $new_array[0] );
            if ( !empty($array_item_exists) ) {
                for ( $i = 1; $i < count( $new_array ); $i++ ) {
                    $data_array = $new_array[$i];
                    foreach ( $data_array as $key => $value ) {
                        $value = unserialize($value);
                        //added after review
                        $option_key = sanitize_key($new_array[0][$key]);
                        //end
                        //update_option( $new_array[0][$key], $value );
                        update_option( $option_key, $value );
                    }
                }
            }
        }
        return $upload;
    }

    /**
     * The code that runs during init.
     */
    function pd_gdpr_setting_class_load() {

        require_once( PD_GDPR_PLUGIN_DIR. 'admin/ajax_functions.php' );

        if ( is_admin() ) {
            //Plugin settings class
            require_once(  PD_GDPR_PLUGIN_DIR. 'admin/partials/class-settings-api.php' );
            //Plugin settings fields
            require_once(  PD_GDPR_PLUGIN_DIR. 'admin/partials/plugin-settings.php' );
            new Pure_GDPR_API_Settings();
        }
    }

}

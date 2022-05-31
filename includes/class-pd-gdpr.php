<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://puredevs.com/
 * @since      1.0.0
 *
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/includes
 * @author     PureDevs <admin@puredevs.com>
 */
class Pd_gdpr {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Pd_gdpr_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	/**
	 * GeoIP API KEY array
	 */
	public static $GEOIP_API_KEY = array(
		'3610bf0e065348c797d5ec52f46e9916',
		'b4d3695270a442a2b4511bd01d1db329',
		'5d5fb85271b54437a66dfa03876b0286',
		'1e07858ab0d04f6691dcec51c621f881',
	);

    /**
     * Allowed html tags for settings section
     */
    public static $allowed_html = array(
        'a' => array(
            'class' => array(),
            'href'  => array(),
            'rel'   => array(),
            'title' => array(),
        ),
        'abbr' => array(
            'title' => array(),
        ),
        'b' => array(),
        'blockquote' => array(
            'cite'  => array(),
        ),
        'cite' => array(
            'title' => array(),
        ),
        'code' => array(),
        'del' => array(
            'datetime' => array(),
            'title' => array(),
        ),
        'dd' => array(),
        'div' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'dl' => array(),
        'dt' => array(),
        'em' => array(),
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array(),
        'i' => array(),
        'img' => array(
            'alt'    => array(),
            'class'  => array(),
            'height' => array(),
            'src'    => array(),
            'width'  => array(),
        ),
        'li' => array(
            'class' => array(),
        ),
        'ol' => array(
            'class' => array(),
        ),
        'p' => array(
            'class' => array(),
        ),
        'q' => array(
            'cite' => array(),
            'title' => array(),
        ),
        'span' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'strike' => array(),
        'strong' => array(),
        'ul' => array(
            'class' => array(),
        ),
    );

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PD_GDPR_VERSION' ) ) {
			$this->version = PD_GDPR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'pd_gdpr';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Pd_gdpr_Loader. Orchestrates the hooks of the plugin.
	 * - Pd_gdpr_i18n. Defines internationalization functionality.
	 * - Pd_gdpr_Admin. Defines all hooks for the admin area.
	 * - Pd_gdpr_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pd-gdpr-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pd-gdpr-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pd-gdpr-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pd-gdpr-public.php';

		$this->loader = new Pd_gdpr_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Pd_gdpr_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Pd_gdpr_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Pd_gdpr_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        $this->loader->add_action( 'init', $plugin_admin, 'pd_gdpr_setting_class_load' );

		$this->loader->add_filter( 'wp_handle_upload', $plugin_admin, 'pd_gdpr_import_plugin_settings_function', 10, 2 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Pd_gdpr_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $plugin_public->required_public_classes();
        $plugin_public->pd_gdpr_set_default_cookies_for_non_european();
        $this->loader->add_action( 'wp_head', $plugin_public, 'pd_gdpr_inject_script_to_header' );
        $this->loader->add_action( 'wp_footer', $plugin_public, 'pd_gdpr_inject_cookie_bar', 0 );
        $this->loader->add_action( 'wp_footer', $plugin_public, 'pd_gdpr_inject_script_to_body', 1 );
        $this->loader->add_action( 'wp_footer', $plugin_public, 'pd_gdpr_inject_script_to_footer', 110 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Pd_gdpr_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

    /**
     * Get section fields settings.
     *
     */
    public static function get_settings_by_section_and_fields( $option, $section, $default = '' ) {
        $options = get_option( $section );
        if ( isset( $options[$option] ) ) {
            return $options[$option];
        }
        return $default;
    }

    /**
     * Get section settings.
     *
     */
    public static function get_settings_by_section( $section, $default = '' ) {
        $options = get_option( $section );
        if ( isset( $options ) && ! empty( $options ) ) {
            return $options;
        }
        return $default;
    }

	/**
	 * Section fields enabled or disabled.
	 *
	 * @return boolean
	 *
	 */
	public static function section_settings_enabled_or_disabled( $option, $section ) {
		$options = get_option( $section );
		if ( isset( $options[$option] ) && $options[$option] == 'on' ) {
			return true;
		}
		return false;
	}

    public static function get_client_ip() {
        $ipaddress = '';
        if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) )
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        elseif ( isset( $_SERVER['HTTP_X_FORWARDED'] ) )
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        elseif ( isset( $_SERVER['HTTP_FORWARDED_FOR'] ) )
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        elseif ( isset( $_SERVER['HTTP_FORWARDED'] ) )
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        elseif ( isset( $_SERVER['REMOTE_ADDR'] ) )
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

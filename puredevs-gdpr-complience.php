<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://puredevs.com/
 * @since             1.0.0
 * @package           puredevs-gdpr-complience
 *
 * @wordpress-plugin
 * Plugin Name:       PureDevs GDPR Compliance
 * Plugin URI:        https://wordpress.org/plugins/puredevs-gdpr-complience
 * Description:       PureDevs GDPR compliance can minimize the risk of getting penalized by GDPR. It's packed with all the premium features of other plugins, but for free!
 * Version:           1.0.2
 * Author:            PureDevs
 * Author URI:        https://puredevs.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pd_gdpr
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PD_GDPR_VERSION', '1.0.2' );
define( 'PD_GDPR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PD_GDPR_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pd-gdpr-activator.php
 */
function activate_pd_gdpr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pd-gdpr-activator.php';
	Pd_gdpr_Activator::activate();
	Pd_gdpr_Activator::set_default_options();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pd-gdpr-deactivator.php
 */
function deactivate_pd_gdpr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pd-gdpr-deactivator.php';
	Pd_gdpr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pd_gdpr' );
register_deactivation_hook( __FILE__, 'deactivate_pd_gdpr' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pd-gdpr.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pd_gdpr() {

	$plugin = new Pd_gdpr();
	$plugin->run();

}

run_pd_gdpr();

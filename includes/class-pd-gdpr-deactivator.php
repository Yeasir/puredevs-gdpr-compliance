<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://puredevs.com/
 * @since      1.0.0
 *
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/includes
 * @author     PureDevs <admin@puredevs.com>
 */
class Pd_gdpr_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        $cookie_policy = get_page_by_title( 'Cookie Policy', OBJECT, 'page' );
        if ( !empty($cookie_policy) ) {
            // Update post status
            $cookie_policy_id = $cookie_policy->ID;
            wp_update_post( array(
                'ID'    =>  $cookie_policy_id,
                'post_status'   =>  'draft',
            ) );
        }
	}

}

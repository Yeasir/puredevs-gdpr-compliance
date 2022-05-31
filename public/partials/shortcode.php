<?php
/**
 * Provide a public functions for the plugin
 *
 * This file is used to markup the public functions aspects of the plugin.
 *
 * @link       https://puredevs.com/
 * @since      1.0.0
 *
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/public/partials
 */
class Pd_GDPR_Shortcode {

	public function __construct() {
        // Shortcodes:
        add_shortcode( 'cookie_subcategories', array( $this, 'cookie_subcategories_function' ) );
        add_shortcode( 'settings', array( $this, 'cookie_settings' ) );
	}

    public function cookie_subcategories_function( $atts ) {
        $atts = shortcode_atts( array(
            'category' => 'strictly_necessary',
        ), $atts );
        $output = '';
        if( $atts['category'] === 'strictly_necessary' ){
            $puredevs_strictly_necessary_cookie_settings = Pd_gdpr::get_settings_by_section( 'puredevs_strictly_necessary_cookie_settings' );
            $output = '<h4>'. ( $puredevs_strictly_necessary_cookie_settings['snec_tab_title'] ? $puredevs_strictly_necessary_cookie_settings['snec_tab_title'] : '' ) .'</h4>';
            $output .= ( $puredevs_strictly_necessary_cookie_settings['snec_content'] ? $puredevs_strictly_necessary_cookie_settings['snec_content'] : '' );
        } elseif ( $atts['category'] === 'additional_cookie' ) {
            $puredevs_additional_cookie_settings = Pd_gdpr::get_settings_by_section( 'puredevs_additional_cookie_settings' );
            if( isset( $puredevs_additional_cookie_settings['enable_disable_additional_cookie'] ) && ( $puredevs_additional_cookie_settings['enable_disable_additional_cookie'] == 'on' || $puredevs_additional_cookie_settings['enable_disable_additional_cookie'] == 1 ) ):
                $output = '<h4>'. ( $puredevs_additional_cookie_settings['additional_cookie_tab_title'] ? $puredevs_additional_cookie_settings['additional_cookie_tab_title'] : '' ) .'</h4>';
                $output .= ( $puredevs_additional_cookie_settings['additional_cookie_content'] ? $puredevs_additional_cookie_settings['additional_cookie_content'] : '' );
            endif;
        } elseif ( $atts['category'] === '3rd_party' ) {
            $puredevs_3rd_party_cookie_settings = Pd_gdpr::get_settings_by_section( 'puredevs_3rd_party_cookie_settings' );
            if( isset( $puredevs_3rd_party_cookie_settings['enable_disable_3rd_party_cookie'] ) && ( $puredevs_3rd_party_cookie_settings['enable_disable_3rd_party_cookie'] == 'on' || $puredevs_3rd_party_cookie_settings['enable_disable_3rd_party_cookie'] == 1 ) ):
                $output = '<h4>'. ( $puredevs_3rd_party_cookie_settings['3rd_party_cookie_tab_title'] ? $puredevs_3rd_party_cookie_settings['3rd_party_cookie_tab_title'] : '' ) .'</h4>';
                $output .= ( $puredevs_3rd_party_cookie_settings['3rd_party_cookie_content'] ? $puredevs_3rd_party_cookie_settings['3rd_party_cookie_content'] : '' );
            endif;
        } elseif ( $atts['category'] === 'functional_cookie' ) {
            $puredevs_functional_cookie_settings = Pd_gdpr::get_settings_by_section( 'puredevs_functional_cookie_settings' );
            if( isset( $puredevs_functional_cookie_settings['enable_disable_functional_cookie'] ) && ( $puredevs_functional_cookie_settings['enable_disable_functional_cookie'] == 'on' || $puredevs_functional_cookie_settings['enable_disable_functional_cookie'] == 1 ) ):
                $output = '<h4>'. ( $puredevs_functional_cookie_settings['functional_cookie_tab_title'] ? $puredevs_functional_cookie_settings['functional_cookie_tab_title'] : '' ) .'</h4>';
                $output .= ( $puredevs_functional_cookie_settings['functional_cookie_content'] ? $puredevs_functional_cookie_settings['functional_cookie_content'] : '' );
            endif;
        } elseif ( $atts['category'] === 'required_cookie' ) {
            $puredevs_required_cookies_settings = Pd_gdpr::get_settings_by_section( 'puredevs_required_cookies_settings' );
            if( isset( $puredevs_required_cookies_settings['enable_disable_required_cookies'] ) && ( $puredevs_required_cookies_settings['enable_disable_required_cookies'] == 'on' || $puredevs_required_cookies_settings['enable_disable_required_cookies'] == 1 ) ):
                $output = '<h4>'. ( $puredevs_required_cookies_settings['required_cookies_tab_title'] ? $puredevs_required_cookies_settings['required_cookies_tab_title'] : '' ) .'</h4>';
                $output .= ( $puredevs_required_cookies_settings['required_cookies_content'] ? $puredevs_required_cookies_settings['required_cookies_content'] : '' );
            endif;
        }
        return $output;
    }

    public function cookie_settings( $atts ) {
        $atts = shortcode_atts( array(
            'color' => '#0e6615',
        ), $atts );
        ob_start();
        ?> <a class="setting_btn" href="#" data-toggle="modal" data-target="#modal-notification" style="color: <?php echo $atts['color'];?>"><?php esc_html_e('Settings', 'pd_gdpr');?></a> <?php
        return ob_get_clean();
    }
}
new Pd_GDPR_Shortcode($this);
<?php

/**
 * Fired during plugin activation
 *
 * @link       https://puredevs.com/
 * @since      1.0.0
 *
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Pd_gdpr
 * @subpackage Pd_gdpr/includes
 * @author     PureDevs <admin@puredevs.com>
 */
class Pd_gdpr_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        $cookie_policy = get_page_by_title( 'Cookie Policy', OBJECT, 'page' );
        if ( ! empty( $cookie_policy ) ) {
            // Update post status
            $cookie_policy_id = $cookie_policy->ID;
            wp_update_post( array(
                'ID'    =>  $cookie_policy_id,
                'post_status'   =>  'publish',
            ) );
        } else {
            // Create post object
            $cookie_policy = array(
                'post_title' => wp_strip_all_tags( 'Cookie Policy' ),
                'post_content' => '<p class="policy-content pt-1">A cookie is a small piece of text thatallows a website to recognize your device and maimain a consistent, cohesive experience throughout
                        multiple sessions. This information is used m make the site work as you expect it m. it is not personally identiliable to you, but it can be

                        used to give you a more personalised web experience.<br>
                        If you want m learn more about the general uses of cookies, please visit <a href="#">cookiepedia — all about cookies.</a><br>
                        vou can choose to <a href="#">update cookie preferences</a>  to prevent nonessential cookies being set.</p>

                    <!-- ******start cookie list -->
                    <div class="cookie-list">
                        <h5>List of cookies</h5>

                        [cookie_subcategories category="strictly_necessary"]
                        [cookie_subcategories category="additional_cookie"]
                        [cookie_subcategories category="3rd_party"]
                        [cookie_subcategories category="functional_cookie"]
                        [cookie_subcategories category="required_cookie"]
                    </div>     <!-- ******end cookie list -->',
                'post_status' => 'publish',
                'post_author' => 1,
                'post_type' => 'page',
            );

            // Insert the post into the database
            wp_insert_post($cookie_policy);
        }
	}

	/**
	 * Set default options to DB
	 */
	public static function set_default_options() {
		$defaults = array(
			'puredevs_general_settings'                   => array(
				'primary_status'                => 'on',
				'show_cookie_bar'               => 'on',
				'cookie_bar_style'              => 'banner',
				'cookie_bar_position'           => 'footer',
				'barshowafter'                  => 'soe',
				'scroll_offset'                 => '120',
				'cookie_bar_time'               => '2000',
				'floating_button_status'        => 'on',
				'floating_button_position'      => 'bottom-left',
				'floating_button_color'         => '#0e6615',
				'floating_button_show_after'    => 'soe',
				'floating_button_scroll_offset' => '120',
				'floating_button_show_in_delay' => '5000',
				'selected_cookie_categories'    => array(
					'strictly_necessary_cookie' => 'strictly_necessary_cookie',
					'additional_cookie'         => 'additional_cookie',
					'3rd_party_cookie'          => '3rd_party_cookie',
					'required_cookies'          => 'required_cookies',
				),
			),
			'puredevs_banner_settings'                    => array(
				'banner_content'          => 'This website uses cookies to provide you with the best browsing experience. Find out more or adjust your [settings].',
				'banner_background_color' => '#172b4d',
				'banner_text_color'       => '#ffffff',
			),
			'puredevs_button_settings'                    => array(
				'accept_button_text'             => 'Accept',
				'accept_button_text_color'       => '',
				'accept_button_background_color' => '',
				'reject_button_text'             => 'Reject',
				'reject_button_text_color'       => '',
				'reject_button_background_color' => '',
				'show_reject_button'             => 'on',
			),
			'puredevs_privacy_overview_settings'          => array(
				'enable_disable_po_settings'   => '',
				'privacy_overview_tab_title'   => 'Privacy Overview',
				'privacy_overview_tab_content' => 'This website uses cookies so that we can provide you with the best user experience possible. Cookie information is stored in your browser and performs functions such as recognising you when you return to our website and helping our team to understand which sections of the website you find most interesting and useful.',
			),
			'puredevs_strictly_necessary_cookie_settings' => array(
				'snc_choose_functionality' => 'optional',
				'snec_tab_title'           => 'Strictly Necessary Cookies',
				'snec_tab_content'         => 'Strictly Necessary Cookie should be enabled at all times so that we can save your preferences for cookie settings.',
				'snec_content'             => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
			),
			'puredevs_additional_cookie_settings'         => array(
				'enable_disable_additional_cookie' => 'off',
				'additional_cookie_tab_title'      => 'Additional Cookie',
				'additional_cookie_tab_content'    => 'Additional Cookies should be enabled at all times so that we can save your preferences for cookie settings.',
				'additional_cookie_head_section'   => '',
				'additional_cookie_body_section'   => '',
				'additional_cookie_footer_section' => '',
				'additional_cookie_content'        => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
			),
			'puredevs_3rd_party_cookie_settings'          => array(
				'enable_disable_3rd_party_cookie' => 'off',
				'3rd_party_cookie_tab_title'      => '3rd party Cookie',
				'additional_cookie_tab_content'   => '3rd Party Cookies should be enabled at all times so that we can save your preferences for cookie settings.',
				'3rd_party_cookie_head_section'   => '',
				'3rd_party_cookie_body_section'   => '',
				'3rd_party_cookie_footer_section' => '',
				'3rd_party_cookie_content'        => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
			),
			'puredevs_functional_cookie_settings'         => array(
				'enable_disable_functional_cookie' => 'off',
				'functional_cookie_tab_title'      => 'Functional cookie',
				'functional_cookie_tab_content'    => 'Functional Cookies should be enabled at all times so that we can save your preferences for cookie settings.',
				'functional_cookie_head_section'   => '',
				'functional_cookie_body_section'   => '',
				'functional_cookie_footer_section' => '',
				'functional_cookie_content'        => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
			),
			'puredevs_required_cookies_settings'          => array(
				'enable_disable_required_cookies' => 'off',
				'required_cookies_tab_title'      => 'Required cookies',
				'required_cookies_tab_content'    => 'Required cookies should be enabled at all times so that we can save your preferences for cookie settings.',
				'required_cookies_head_section'   => '',
				'required_cookies_body_section'   => '',
				'required_cookies_footer_section' => '',
				'required_cookies_content'        => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
			),
			'puredevs_export_import_settings'             => array(
				'export_settings'        => 'all',
				'export_setting_options' => 'puredevs_general_settings',
				'file'                   => '',
			),
			'puredevs_geo_location_settings'              => array(
				'geo_location_settings' => 'all-users',
			),
			'puredevs_privacy_and_policy_settings'        => array(
				'enable_disable_privacy_and_policy' => 'on',
				'privacy_and_policy_tab_title'      => 'Cookie Policy',
				'privacy_and_policy_message'        => 'Raw denim you probably haven\'t heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Reprehenderit butcher retro keffiyeh dreamcatcher synth.',
				'cookie_policy_page_url'            => '',
			),
		);

		foreach ( $defaults as $key => $default ) {
            $key = sanitize_key( $key );
			if ( empty( get_option( $key ) ) ) {
				update_option( $key, $default );
			}
		}
	}
}

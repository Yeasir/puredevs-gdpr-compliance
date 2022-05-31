<?php

/**
 * WordPress settings API demo class
 *
 * @author PureDevs
 */
if ( !class_exists('Pure_GDPR_API_Settings' ) ):
class Pure_GDPR_API_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new Pure_GDPR_Settings_API_Class;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
	    add_action( 'admin_bar_menu', array($this,'pd_admin_bar_menu'), 2000 );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_options_page(
            esc_html__( 'PureDevs GDPR Compliance', 'pd_gdpr' ),
            esc_html__( 'PureDevs GDPR Compliance', 'pd_gdpr' ),
            'delete_posts',
            'pure_gdpr_cookie_settings',
            array($this, 'show_settings_panel')
        );
    }

	function pd_admin_bar_menu() {
		global $wp_admin_bar;

		$menu_id = 'pure_gdpr_cookie_settings';
		$wp_admin_bar->add_menu( array(
			'id'    => $menu_id,
			'title' => esc_html__( 'Pure GDPR Cookie Settings', 'pd_gdpr' ),
			'href'  => admin_url() . 'options-general.php?page=pure_gdpr_cookie_settings',
		) );
	}

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'puredevs_general_settings',
                'title' => esc_html__( 'General Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_banner_settings',
                'title' => esc_html__( 'Banner Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_button_settings',
                'title' => esc_html__( 'Button Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_privacy_overview_settings',
                'title' => esc_html__( 'Privacy Overview Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_strictly_necessary_cookie_settings',
                'title' => esc_html__( 'Strictly Necessary Cookie', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_additional_cookie_settings',
                'title' => esc_html__( 'Additional Cookie Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_3rd_party_cookie_settings',
                'title' => esc_html__( '3rd Party Cookie Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_functional_cookie_settings',
                'title' => esc_html__( 'Functional Cookies Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_required_cookies_settings',
                'title' => esc_html__( 'Required Cookies Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_export_import_settings',
                'title' => esc_html__( 'Export Import Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_geo_location_settings',
                'title' => esc_html__( 'Geo Location Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_privacy_and_policy_settings',
                'title' => esc_html__( 'Privacy and Policy Settings', 'pd_gdpr' ),
            ),
            array(
                'id'    => 'puredevs_help_settings',
                'title' => esc_html__( 'Help, Hooks, Shortcodes', 'pd_gdpr' ),
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'puredevs_general_settings' => array(
                array(
                    'name'  => 'primary_status',
                    'label' => esc_html__( 'Primary Status', 'pd_gdpr' ),
                    'desc'  => esc_html__( 'Allow you to turn on or off the plugin', 'pd_gdpr' ),
                    'type'  => 'checkbox',
                    'default'           => 'on',
                ),
                array(
                    'name'  => 'show_cookie_bar',
                    'label' => esc_html__( 'Cookie Bar', 'pd_gdpr' ),
                    'desc'  => esc_html__( 'Show cookie bar', 'pd_gdpr' ),
                    'type'  => 'checkbox',
                    'default'           => 'on',
                ),
                array(
                    'name'              => 'cookie_settings_heading',
                    'label'             => esc_html__( 'Cookie Settings Heading', 'pd_gdpr' ),
                    'desc'              => esc_html__( '', 'pd_gdpr' ),
                    'placeholder'       => esc_attr__( 'PureDevs GDPR Cookie Setting Options', 'pd_gdpr' ),
                    'type'              => 'text',
                    'default'           => esc_html__('PureDevs GDPR Cookie Setting Options', 'pd_gdpr'),
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'    => 'cookie_settings_logo',
                    'label'   => esc_html__( 'Cookie Settings Logo', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Recommended size:64 x 64 pixels', 'pd_gdpr' ),
                    'type'    => 'file',
                    'default' => '',
                    'options' => array(
                        'button_label' => esc_html__('Choose Logo','pd_gdpr'),
                    ),
                ),
                array(
                    'name'    => 'cookie_bar_style',
                    'label'   => esc_html__( 'Cookie Bar Style', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Allow you to show the cookie bar either as a banner or a popup', 'pd_gdpr' ),
                    'type'    => 'select',
                    'default' => 'banner',
                    'options' => array(
                        'banner' => esc_html__('Banner','pd_gdpr'),
                        'popup'  => esc_html__('Popup','pd_gdpr'),
                    ),
                    'class' => 'form-control bar-style border-primary mb-2',
                ),
                array(
                    'name'    => 'cookie_bar_position',
                    'label'   => esc_html__( 'Cookie Bar Position', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Allow you to choose the position where the cookie ber will be shown.', 'pd_gdpr' ),
                    'type'    => 'select',
                    'default' => esc_attr__('footer', 'pd_gdpr'),
                    'options' => array(
                        'header' => esc_html__('Header','pd_gdpr'),
                        'footer'  => esc_html__('Footer','pd_gdpr'),
                    ),
                    'class' => 'form-control  border-primary mb-2 bar-position-wrap',
                ),
                array(
                    'name'    => 'barshowafter',
                    'label'   => esc_html__( 'Cookie Alert Options', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Allow you to choose the style of cookie alert.', 'pd_gdpr' ),
                    'type'    => 'radio',
                    'default' => esc_attr__('soe', 'pd_gdpr'),
                    'options' => array(
                        'soe' => esc_html__('Scroll bound','pd_gdpr'),
                        'time'  => esc_html__('Time bound','pd_gdpr'),
                    ),
                    'class' => 'custom-control-input custom-radio show-cookie-bar',
                ),
                array(
                    'name'              => 'scroll_offset',
                    'label'             => esc_html__( 'Scroll Offset ', 'pd_gdpr' ),
                    'desc'              => esc_html__( 'Numbers are calculated in pixels', 'pd_gdpr' ),
                    'placeholder'       => esc_attr__( '120', 'pd_gdpr' ),
                    'type'              => 'number',
                    'default'           => esc_attr__('120', 'pd_gdpr'),
                    'sanitize_callback' => 'sanitize_text_field',
                    'class' => 'form-control border-primary rounded mb-2 bar-position-wrapper show-cookie-bar-option',
                ),
                array(
                    'name'              => 'cookie_bar_time',
                    'label'             => esc_html__( 'Cookie Bar Delay Time ', 'pd_gdpr' ),
                    'desc'              => esc_html__( 'Numbers are calculated in microseconds (ms)', 'pd_gdpr' ),
                    'placeholder'       => esc_attr__( '2000', 'pd_gdpr' ),
                    'type'              => 'number',
                    'default'           => esc_attr__('2000', 'pd_gdpr'),
                    'sanitize_callback' => 'sanitize_text_field',
                    'class' => 'form-control border-primary rounded mb-2 bar-time-wrapper show-cookie-bar-option',
                ),
                array(
                    'name'  => 'floating_button_heading',
                    'value' => esc_html__('Floating Button Settings', 'pd_gdpr'),
                    'type'  => 'heading',
                    'class' => 'heading',
                ),
                array(
                    'name'  => 'floating_button_status',
                    'label' => esc_html__( 'Show Floating Button', 'pd_gdpr' ),
                    'desc'  => esc_html__( '', 'pd_gdpr' ),
                    'type'  => 'checkbox',
                    'default' => '',
                ),
                array(
                    'name'    => 'floating_button_position',
                    'label'   => esc_html__( 'Floating Button Position', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Allow you set the position of the floating button', 'pd_gdpr' ),
                    'type'    => 'select',
                    'default' => 'bottom-left',
                    'options' => array(
                        'top-right' => esc_html__('Top Right', 'pd_gdpr'),
                        'top-left'  => esc_html__('Top Left', 'pd_gdpr'),
                        'bottom-right'  => esc_html__('Bottom Right', 'pd_gdpr'),
                        'bottom-left'  => esc_html__('Bottom Left', 'pd_gdpr'),
                    ),
                    'class' => 'form-control border-primary mb-2',
                ),
                array(
                    'name'    => 'floating_button_color',
                    'label'   => esc_html__( 'Floating Button Color', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Set the color of the floating button', 'pd_gdpr' ),
                    'type'    => 'color',
                    'default' => esc_attr__('#445454', 'pd_gdpr'),
                ),
                array(
                    'name'    => 'floating_button_show_after',
                    'label'   => esc_html__( 'Floating Button\'s Delay Options', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Allow you to choose when to show the floating button', 'pd_gdpr' ),
                    'type'    => 'radio',
                    'default' => esc_attr__('soe', 'pd_gdpr'),
                    'options' => array(
                        'soe' => esc_html__('Scroll bound', 'pd_gdpr'),
                        'time'  => esc_html__('Time bound', 'pd_gdpr'),
                    ),
                    'class' => 'custom-control-input custom-radio show-floating-button',
                ),
                array(
                    'name'              => 'floating_button_scroll_offset',
                    'label'             => esc_html__( 'Set Floating Button\'s Scroll Effect', 'pd_gdpr' ),
                    'desc'              => esc_html__( 'Numbers are calculated in pixels', 'pd_gdpr' ),
                    'placeholder'       => esc_attr__( '120', 'pd_gdpr' ),
                    'type'              => 'number',
                    'default'           => esc_attr__('120', 'pd_gdpr'),
                    'sanitize_callback' => 'sanitize_text_field',
                    'class' => 'form-control border-primary rounded mb-2 floating-bar-position-wrapper show-floating-bar-option',
                ),
                array(
                    'name'              => 'floating_button_show_in_delay',
                    'label'             => esc_html__( 'Set floating button\'s delay time', 'pd_gdpr' ),
                    'desc'              => esc_html__( 'Time is calculated in microseconds(ms) ', 'pd_gdpr' ),
                    'placeholder'       => esc_attr__( '5000', 'pd_gdpr' ),
                    'type'              => 'number',
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                    'class' => 'form-control border-primary rounded mb-2 floating-bar-time-wrapper show-floating-bar-option',
                ),
                array(
                    'name'    => 'selected_cookie_categories',
                    'label'   => esc_html__( 'Cookie Categories', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Cookie Categories', 'pd_gdpr' ),
                    'type'    => 'multicheck',
                    'default' => array(
                        'strictly_necessary_cookie' => esc_attr__('strictly_necessary_cookie','pd_gdpr'),
                        'additional_cookie' => esc_attr__('additional_cookie','pd_gdpr'),
                        '3rd_party_cookie' => esc_attr__('3rd_party_cookie','pd_gdpr'),
                        'required_cookies' => esc_attr__('required_cookies','pd_gdpr'),
                    ),
                    'options' => array(
                        'strictly_necessary_cookie'   => esc_html__('Strictly Necessary Cookie', 'pd_gdpr'),
                        'additional_cookie'   => esc_html__('Additional Cookie', 'pd_gdpr'),
                        '3rd_party_cookie' => esc_html__('3rd party Cookie', 'pd_gdpr'),
                        'functional_cookie'  => esc_html__('Functional Cookies', 'pd_gdpr'),
                        'required_cookies'  => esc_html__('Required Cookies', 'pd_gdpr'),
                    ),
                ),
            ),
            'puredevs_banner_settings' => array(
                array(
                    'name'    => 'banner_content',
                    'label'   => esc_html__( 'Banner Content', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Use the following shortcodes to link with setting section: [settings color="#fff"]', 'pd_gdpr' ),
                    'type'    => 'wysiwyg',
                    'default' => esc_attr__('This website uses cookies to provide you with the best browsing experience. Find out more or adjust your [settings].', 'pd_gdpr'),
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
                array(
                    'name'    => 'banner_background_color',
                    'label'   => esc_html__( 'Background Color', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Choose the background color of the banner', 'pd_gdpr' ),
                    'type'    => 'color',
                    'default' => esc_attr__('#172b4d', 'pd_gdpr'),
                ),
                array(
                    'name'    => 'banner_background_opacity',
                    'label'   => esc_html__( 'Background Opacity', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Background opacity ranges from 0 to 1. Where 1 is fully opaque and 0 is fully transparent.', 'pd_gdpr' ),
                    'type'    => 'text',
                    'placeholder'    => '0.8',
                ),
                array(
                    'name'    => 'banner_text_color',
                    'label'   => esc_html__( 'Text Color', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Choose the text color of the banner', 'pd_gdpr' ),
                    'type'    => 'color',
                    'default' => esc_attr__('#ffffff', 'pd_gdpr'),
                ),
                array(
                    'name'    => 'banner_text_font_size',
                    'label'   => esc_html__( 'Font Size', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Customize the font size of your banner text. Ex: 15px', 'pd_gdpr' ),
                    'type'    => 'text',
                    'placeholder'    => '15px',
                    'default' => '',
                ),
            ),
            'puredevs_button_settings' => array(
                array(
                    'name'  => 'accept_button_settings',
                    'value' => esc_html__('Accept Button Settings', 'pd_gdpr'),
                    'type'  => 'heading',
                    'class' => 'heading',
                ),
                array(
                    'name'    => 'accept_button_text',
                    'label'   => esc_html__( 'Button Text', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Accept Button Text', 'pd_gdpr' ),
                    'placeholder'       => __( 'Accept', 'pd_gdpr' ),
                    'type'              => 'text',
                    'default'           => esc_attr__('Accept', 'pd_gdpr'),
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'    => 'accept_button_text_color',
                    'label'   => esc_html__( 'Text Color', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Choose the text color of the accept button', 'pd_gdpr' ),
                    'type'    => 'color',
                    'default' => '',
                ),
                array(
                    'name'    => 'accept_button_background_color',
                    'label'   => esc_html__( 'Background Color', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Choose the background color of the accept button', 'pd_gdpr' ),
                    'type'    => 'color',
                    'default' => '',
                ),
                array(
                    'name'  => 'reject_button_settings',
                    'value' => esc_html__('Reject Button Settings', 'pd_gdpr'),
                    'type'  => 'heading',
                    'class' => 'heading',
                ),
                array(
                    'name'    => 'reject_button_text',
                    'label'   => esc_html__( 'Button Text', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Reject Button Text', 'pd_gdpr' ),
                    'placeholder'       => __( 'Reject', 'pd_gdpr' ),
                    'type'              => 'text',
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'    => 'reject_button_text_color',
                    'label'   => esc_html__( 'Text Color', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Choose the text color of the reject button', 'pd_gdpr' ),
                    'type'    => 'color',
                    'default' => '',
                ),
                array(
                    'name'    => 'reject_button_background_color',
                    'label'   => esc_html__( 'Background Color', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Choose the background color of the reject button', 'pd_gdpr' ),
                    'type'    => 'color',
                    'default' => '',
                ),
                array(
                    'name'  => 'show_reject_button',
                    'label' => esc_html__( 'Show Reject Button?', 'pd_gdpr' ),
                    'desc'  => esc_html__( 'Choose whether to show the reject button or not', 'pd_gdpr' ),
                    'type'  => 'checkbox',
                    'default'           => '',
                ),
            ),
            'puredevs_privacy_overview_settings' => array(
                array(
                    'name'    => 'privacy_overview_tab_title',
                    'label'   => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'type'              => 'text',
                    'default'           => esc_attr__('Privacy Overview', 'pd_gdpr'),
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'    => 'privacy_overview_tab_content',
                    'label'   => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'type'    => 'wysiwyg',
                    'default' => esc_attr__( 'This website uses cookies so that we can provide you with the best user experience possible. Cookie information is stored in your browser and performs functions such as recognising you when you return to our website and helping our team to understand which sections of the website you find most interesting and useful.', 'pd_gdpr' ),
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
            ),
            'puredevs_strictly_necessary_cookie_settings' => array(
                array(
                    'name'  => 'snc_choose_functionality',
                    'label' => esc_html__( 'Choose Functionality', 'pd_gdpr' ),
                    'desc'  => esc_html__( '', 'pd_gdpr' ),
                    'type'    => 'radio',
                    'default' => esc_attr__('always-enable', 'pd_gdpr'),
                    'options' => array(
                        'optional' => esc_html__('Optional (User select their preferences)', 'pd_gdpr'),
                        'always-enable' => esc_html__('Always enabled (User can not disable but can see the content)', 'pd_gdpr'),
                        'always-enable-chfu'  => esc_html__('Always enabled and content is hidden from the user', 'pd_gdpr')
                    ),
                ),
                array(
                    'name'    => 'snec_tab_title',
                    'label'   => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'default'           => esc_attr__( 'Strictly Necessary Cookies', 'pd_gdpr' ),
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'        => 'snec_tab_content',
                    'label'       => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'default' => esc_attr__( 'Strictly Necessary Cookie should be enabled at all times so that we can save your preferences for cookie settings.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
                array(
                    'name'        => 'snec_content',
                    'label'       => esc_html__( 'Strictly Necessary Sub Category Cookies', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'default' => esc_attr__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
            ),
            'puredevs_additional_cookie_settings' => array(
                array(
                    'name'  => 'enable_disable_additional_cookie',
                    'label' => esc_html__( 'ENABLE / DISABLE', 'pd_gdpr' ),
                    'desc'  => esc_html__( '', 'pd_gdpr' ),
                    'type'  => 'checkbox',
                    'default'           => '',
                ),
                array(
                    'name'    => 'additional_cookie_tab_title',
                    'label'   => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'default'       => esc_attr__( 'Additional Cookie', 'pd_gdpr' ),
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'        => 'additional_cookie_tab_content',
                    'label'       => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'default' => esc_attr__( 'Additional Cookies should be enabled at all times so that we can save your preferences for cookie settings.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
                array(
                    'name'  => 'additional_cookie_tabs_header_text',
                    'value' => esc_html__('Paste your codes and snippets below. They will be added to all pages if user enables these cookies:', 'pd_gdpr'),
                    'type'  => 'heading',
                    'class' => 'heading',
                ),
                array(
                    'name'        => 'additional_cookie_head_section',
                    'label'       => esc_html__( 'Head Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( 'Strictly necessary cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => 'additional_cookie_body_section',
                    'label'       => esc_html__( 'Body Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( 'Strictly necessary cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => 'additional_cookie_footer_section',
                    'label'       => esc_html__( 'Footer Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( 'Strictly necessary cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => 'additional_cookie_content',
                    'label'       => esc_html__( 'Additional Sub Category Cookies', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'default' => esc_attr__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
            ),
            'puredevs_3rd_party_cookie_settings' => array(
                array(
                    'name'  => 'enable_disable_3rd_party_cookie',
                    'label' => esc_html__( 'ENABLE / DISABLE', 'pd_gdpr' ),
                    'desc'  => esc_html__( '', 'pd_gdpr' ),
                    'type'  => 'checkbox',
                    'default'           => '',
                ),
                array(
                    'name'    => '3rd_party_cookie_tab_title',
                    'label'   => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'default'       => esc_attr__( '3rd party Cookie', 'pd_gdpr' ),
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'        => '3rd_party_cookie_tab_content',
                    'label'       => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'default' => esc_attr__( '3rd Party Cookies should be enabled at all times so that we can save your preferences for cookie settings.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
                array(
                    'name'  => '3rd_party_cookie_tabs_header_text',
                    'value' => esc_html__('Paste your codes and snippets below. They will be added to all pages if user enables these cookies:', 'pd_gdpr'),
                    'type'  => 'heading',
                    'class' => 'heading',
                ),
                array(
                    'name'        => '3rd_party_cookie_head_section',
                    'label'       => esc_html__( 'Head Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( '3rd party cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => '3rd_party_cookie_body_section',
                    'label'       => esc_html__( 'Body Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( '3rd party cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => '3rd_party_cookie_footer_section',
                    'label'       => esc_html__( 'Footer Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( '3rd party cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => '3rd_party_cookie_content',
                    'label'       => esc_html__( '3rd Party Sub Category Cookies', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'default' => esc_attr__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
            ),
            'puredevs_functional_cookie_settings' => array(
                array(
                    'name'  => 'enable_disable_functional_cookie',
                    'label' => esc_html__( 'ENABLE / DISABLE', 'pd_gdpr' ),
                    'desc'  => esc_html__( '', 'pd_gdpr' ),
                    'type'  => 'checkbox',
                    'default'           => '',
                ),
                array(
                    'name'    => 'functional_cookie_tab_title',
                    'label'   => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'default'       => esc_attr__( 'Functional cookie', 'pd_gdpr' ),
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'        => 'functional_cookie_tab_content',
                    'label'       => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'default' => esc_attr__( 'Functional Cookies should be enabled at all times so that we can save your preferences for cookie settings.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
                array(
                    'name'  => 'functional_cookie_tabs_header_text',
                    'value' => esc_html__('Paste your codes and snippets below. They will be added to all pages if user enables these cookies:', 'pd_gdpr'),
                    'type'  => 'heading',
                    'class' => 'heading',
                ),
                array(
                    'name'        => 'functional_cookie_head_section',
                    'label'       => esc_html__( 'Head Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( '3rd party cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => 'functional_cookie_body_section',
                    'label'       => esc_html__( 'Body Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( '3rd party cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => 'functional_cookie_footer_section',
                    'label'       => esc_html__( 'Footer Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( '3rd party cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => 'functional_cookie_content',
                    'label'       => esc_html__( 'Functional Cookie Sub Category Cookies', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'default' => esc_attr__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
            ),
            'puredevs_required_cookies_settings' => array(
                array(
                    'name'  => 'enable_disable_required_cookies',
                    'label' => esc_html__( 'ENABLE / DISABLE', 'pd_gdpr' ),
                    'desc'  => esc_html__( '', 'pd_gdpr' ),
                    'type'  => 'checkbox',
                    'default'           => '',
                ),
                array(
                    'name'    => 'required_cookies_tab_title',
                    'label'   => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'default'       => esc_attr__( 'Required cookies', 'pd_gdpr' ),
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                array(
                    'name'        => 'required_cookies_tab_content',
                    'label'       => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'default' => esc_attr__( 'Required cookies should be enabled at all times so that we can save your preferences for cookie settings.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
                array(
                    'name'  => 'required_cookies_tabs_header_text',
                    'value' => esc_html__('Paste your codes and snippets below. They will be added to all pages if user enables these cookies:', ''),
                    'type'  => 'heading',
                    'class' => 'heading',
                ),
                array(
                    'name'        => 'required_cookies_head_section',
                    'label'       => esc_html__( 'Head Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( '3rd party cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => 'required_cookies_body_section',
                    'label'       => esc_html__( 'Body Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( '3rd party cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => 'required_cookies_footer_section',
                    'label'       => esc_html__( 'Footer Section', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'pd_gdpr' ),
                    'placeholder' => esc_attr__( '3rd party cookies should be enabled at all times.', 'pd_gdpr' ),
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => 'required_cookies_content',
                    'label'       => esc_html__( 'Required Cookie Sub Category Cookies', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'Tab Content', 'pd_gdpr' ),
                    'default' => esc_attr__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
            ),
            'puredevs_export_import_settings' => array(
                array(
                    'name'  => 'export_settings',
                    'label' => esc_html__( 'Export Settings', 'pd_gdpr' ),
                    'desc'  => esc_html__( '', 'pd_gdpr' ),
                    'type'    => 'radio',
                    'default' => 'all',
                    'options' => array(
                        'all' => esc_html__('All', ''),
                        'custom' => esc_html__('Custom', ''),
                    ),
                    'class' => 'form-control border-primary w-98 rounded export-import-section',
                ),
                array(
                    'name'    => 'export_setting_options',
                    'type'    => 'select',
                    'default' => 'puredevs_general_settings',
                    'options' => array(
                        'puredevs_general_settings' => esc_html__('General Settings', ''),
                        'puredevs_banner_settings' => esc_html__('Banner Settings', ''),
                        'puredevs_button_settings' => esc_html__('Button Settings', ''),
                        'puredevs_privacy_overview_settings' => esc_html__('Privacy Overview Settings', ''),
                        'puredevs_strictly_necessary_cookie_settings'  => esc_html__('Strictly Necessary Cookie', ''),
                        'puredevs_additional_cookie_settings'  => esc_html__('Additional Cookie', ''),
                        'puredevs_3rd_party_cookie_settings'  => esc_html__('3rd party Cookie', ''),
                        'puredevs_functional_cookie_settings'  => esc_html__('Functional Cookies', ''),
                        'puredevs_required_cookies_settings'  => esc_html__('Required Cookies', ''),
                        'puredevs_geo_location_settings'  => esc_html__('Geo Location Settings', ''),
                        'puredevs_privacy_and_policy_settings'  => esc_html__('Privacy and Policy Settings', ''),
                    ),
                    'class' => 'ei-opt-wrap d-none',
                ),
                array(
                    'name'    => 'export_button',
                    'value'   => esc_html__('EXPORT', 'pd_gdpr'),
                    'type'    => 'button',
                    'class' => 'btn btn-primary float-right mr-3 export-btn',
                ),
                array(
                    'name'    => 'file',
                    'label'   => esc_html__( 'Import Settings', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Import Settings', 'pd_gdpr' ),
                    'type'    => 'file',
                    'default' => '',
                    'options' => array(
                        'button_label' => esc_html__('IMPORT', 'pd_gdpr'),
                    ),
                ),
            ),
            'puredevs_geo_location_settings' => array(
                array(
                    'name'  => 'geo_location_settings',
                    'label' => esc_html__( 'Show Cookie Banner', 'pd_gdpr' ),
                    'desc'  => '',
                    'type'    => 'radio',
                    'default' => 'all-users',
                    'options' => array(
                        'all-users' => esc_html__('Show to all users [default]', ''),
                        'european-union-only' => esc_html__("Show to European Union only<br/>(users from outside the EU won't see the Cookie Notice and will have all cookies enabled by default)", ''),
                    ),
                    'class' => 'form-control border-primary w-98 rounded geo_location-section',
                ),
	            array(
		            'name'    => 'geo_location_api',
		            'label'   => esc_html__( 'Your IP Geo Location API Key', 'pd_gdpr' ),
		            'desc'    => esc_html__( 'To get the most accurate performance from the geolocation feature, go to <a href="https://ipgeolocation.io/" target="_blank">ipgelocation.io</a>. Upon signup, they will provide a key. Put that in Your IP Geo Location API Key and you are good to go.', 'pd_gdpr' ),
		            'type'              => 'text',
		            'default'           => '',
		            'sanitize_callback' => 'sanitize_text_field'
	            ),
            ),
            'puredevs_privacy_and_policy_settings' => array(
                array(
                    'name'  => 'enable_disable_privacy_and_policy',
                    'label' => esc_html__( 'ENABLE / DISABLE', 'pd_gdpr' ),
                    'desc'  => esc_html__( '', 'pd_gdpr' ),
                    'type'  => 'checkbox',
                    'default'           => 'on',
                ),
                array(
                    'name'    => 'privacy_and_policy_tab_title',
                    'label'   => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'desc'    => esc_html__( 'Tab Title', 'pd_gdpr' ),
                    'default'       => esc_attr__( 'Cookie Policy', 'pd_gdpr' ),
                    'type'              => 'text',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'        => 'privacy_and_policy_message',
                    'label'       => esc_html__( 'Strictly Necessary Required Messages', 'pd_gdpr' ),
                    'desc'        => esc_html__( 'This warning message will be displayed if the strictly necessary cookies are not enabled and the user try to enable the "Third Party Cookies"', 'pd_gdpr' ),
                    'default' => esc_attr__( 'A cookie is a small piece of text that allows a website to recognize your device and maintain a consistent, cohesive experience throughout multiple sessions. This information is used to make the site work as you expect it to. It is not personally identifiable to you, but it can be used to give you a more personalised web experience.To know more about our cookie policy, press the button below.', 'pd_gdpr' ),
                    'type'        => 'wysiwyg',
                    'sanitize_callback' => 'pd_gdpr_sanitize_textarea_field',
                ),
                array(
                    'name'    => 'cookie_policy_page_url',
                    'label'   => esc_html__( 'Cookie Policy Page Url', 'pd_gdpr' ),
                    'desc'    => esc_html__( '', 'pd_gdpr' ),
                    'placeholder'       => esc_attr__( 'Cookie policy page url', 'pd_gdpr' ),
                    'type'              => 'text',
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
            ),
            'puredevs_help_settings' => array(
                array(
                    'name'        => 'html',
                    'desc'        => __( '<ul class="tab clearfix">
                        <li class="tab-item "><a class="active" href="javascript:void(0);" data-tag="faq">FAQ</a></li>
                        <li class="tab-item"><a href="javascript:void(0);" data-tag="hooks">Hooks</a></li>
                        <li class="tab-item"><a href="javascript:void(0);" data-tag="shortcodes">Shortcodes</a></li>
                    </ul>

                    <div class="tab-wrapper ">
                           <div class="list" id="faq">
                               <ul class="custom-accordian">
                                   <li>
                                       <a class="acc_trigger  ">
                                           How do I setup your plugin?
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <p class="font-weight-500"> To setup your plugin, first activate puredevs gdpr complience plugin. Then go to <span class="text-danger font-weight-500">Settings -> PureDevs GDPR Compliance </span>. In the general settings tab, you need to enable primary status.</p>
                                           </div>
                                       </div>
                                   </li>
                                   
                                   <li>
                                       <a class="  acc_trigger ">Can I use custom code or hooks with your plugin?               
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body">
                                               <p class="font-weight-500">Yes. We have implemented hooks that allow you to implement custom scripts, for some examples see the list of pre-defined hooks here: <strong> Hooks tab</strong></p>
                                           </div>
                                       </div>
                                   </li>
                                   
                                   <li>
                                       <a class="  acc_trigger ">Does the plugin support subdomains?            
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body">
                                               <p class="font-weight-500">Unfortunately not, subdomains are treated as separate domains by browsers and we’re unable to change the cookies stored by another domain. If your multisite setup use subdomain version, each subsite will be recognised as a separate domain by the browser and will create cookies for each subdomain.</p>
                                           </div>
                                       </div>
                                   </li>
                               </ul>
                           </div>
                           <div class="list hide" id="hooks">
                               <ul class="custom-accordian">
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom 3RD-PARTY script by php – HEAD
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_3rd_party_header_assets\',\'pd_gdpr_3rd_party_header_assets_function\');
                                                        <br>
                                                        function pd_gdpr_3rd_party_header_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("third-party-head");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom 3RD-PARTY script by php – BODY
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_3rd_party_body_assets\',\'pd_gdpr_3rd_party_body_assets_function\');
                                                        <br>
                                                        function pd_gdpr_3rd_party_body_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("third-party-body");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom 3RD-PARTY script by php – FOOTER
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_3rd_party_footer_assets\',\'pd_gdpr_3rd_party_footer_assets_function\');
                                                        <br>
                                                        function pd_gdpr_3rd_party_footer_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("third-party-footer");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom ADDITIONAL COOKIE script by php – HEAD
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_additional_cookie_header_assets\',\'pd_gdpr_additional_cookie_header_assets_function\');
                                                        <br>
                                                        function pd_gdpr_additional_cookie_header_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("additional-cookie-head");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom ADDITIONAL COOKIE script by php – BODY
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_additional_cookie_body_assets\',\'pd_gdpr_additional_cookie_body_assets_function\');
                                                        <br>
                                                        function pd_gdpr_additional_cookie_body_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("additional-cookie-body");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom ADDITIONAL COOKIE script by php – FOOTER
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_additional_cookie_footer_assets\',\'pd_gdpr_additional_cookie_footer_assets_function\');
                                                        <br>
                                                        function pd_gdpr_additional_cookie_footer_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("additional-cookie-footer");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom REQUIRED COOKIE  script by php – HEAD
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_required_cookie_header_assets\',\'pd_gdpr_required_cookie_header_assets_function\');
                                                        <br>
                                                        function pd_gdpr_required_cookie_header_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("required-cookie-head");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom REQUIRED COOKIE script by php – BODY
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_required_cookie_body_assets\',\'pd_gdpr_required_cookie_body_assets_function\');
                                                        <br>
                                                        function pd_gdpr_required_cookie_body_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("required-cookie-body");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom REQUIRED COOKIE script by php – FOOTER
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_required_cookie_footer_assets\',\'pd_gdpr_required_cookie_footer_assets_function\');
                                                        <br>
                                                        function pd_gdpr_required_cookie_footer_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("required-cookie-footer");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom FUNCTIONAL COOKIE script by php – HEAD
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_functional_cookie_header_assets\',\'pd_gdpr_functional_cookie_header_assets_function\');
                                                        <br>
                                                        function pd_gdpr_functional_cookie_header_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("functional-cookie-head");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom FUNCTIONAL COOKIE script by php – BODY
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_functional_cookie_body_assets\',\'pd_gdpr_functional_cookie_body_assets_function\');
                                                        <br>
                                                        function pd_gdpr_functional_cookie_body_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("functional-cookie-body");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                                   <li>
                                       <a class="acc_trigger  ">HOOK to GDPR custom FUNCTIONAL COOKIE script by php – FOOTER
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <div class="code-panel m-2">
                                                    <code>
                                                       add_filter(\'pd_gdpr_functional_cookie_footer_assets\',\'pd_gdpr_functional_cookie_footer_assets_function\');
                                                        <br>
                                                        function pd_gdpr_functional_cookie_footer_assets_function( $scripts ) {
                                                            $scripts .= \'<script>console.log("functional-cookie-footer");</script>\';
                                                            return $scripts;
                                                         }
                                                     </code>
                                                </div>
                                           </div>
                                       </div>
                                   </li>
                               </ul>
                           </div>
                           <div class="list hide" id="shortcodes">
                                <ul class="custom-accordian">
                                   <li>
                                       <a class="acc_trigger  ">
                                           How can I link setting popup with the banner message?
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body ">
                                               <p class="font-weight-500"> To link the setting popup with your banner message, add [settings color="#dd3333"] to your banner content under the <strong>Banner Setting</strong>.</p>
                                           </div>
                                       </div>
                                   </li>

                                   <li>
                                       <a class="  acc_trigger ">How can I change the color of the setting link?
                                            <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body">
                                               <p class="font-weight-500">To change the color of the setting link first find the hexadecimal version of your desired color and replace it with the default color, you can find the value of the default color within the quotation mark in the [settings color="#dd3333"].</p>
                                           </div>
                                       </div>
                                   </li>

                                   <li>
                                       <a class="  acc_trigger ">How can I add or remove subcategory cookie polices from my cookie policy page?
                                           <i class="angle-down"></i>
                                       </a>

                                       <div class="acc_container" >
                                           <div class="acc_card card-body">
                                               <p class="font-weight-500">To remove all or any of the default subcategories from the  cookie policy page, go to edit cookie policy page in wp-admin and remove the shortcode of the subcatagory that you want to get rid of.</p>
                                           </div>
                                       </div>
                                   </li>
                               </ul>
                           </div>
                       </div>', 'pd_gdpr' ),
                    'type'        => 'html'
                ),
            ),
        );

        return $settings_fields;
    }

    function show_settings_panel() {
        echo '<div class="wrap">';
	    echo '<h2 class="plugin-title">'.__( 'PureDevs GDPR Compliance', 'pd_gdpr' ).'</h2>';
	    echo '<div class="gdpr-wrapper">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;

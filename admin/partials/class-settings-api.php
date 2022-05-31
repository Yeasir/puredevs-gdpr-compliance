<?php

/**
 * pgc Settings API wrapper class
 *
 * @version 1.0 (09-Aug-2019)
 *
 * @author PureDevs <admin@puredevs.com>
 * @link https://puredevs.com/ PureDevs
 * @example include/plugin-settings.php How to use the class
 */
if ( !class_exists( 'Pure_GDPR_Settings_API_Class' ) ):
class Pure_GDPR_Settings_API_Class {

    /**
     * settings sections array
     *
     * @var array
     */
    protected $settings_sections = array();

    /**
     * Settings fields array
     *
     * @var array
     */
    protected $settings_fields = array();

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
    }

    /**
     * Enqueue scripts and styles
     */
    function admin_enqueue_scripts() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );
    }

    /**
     * Set settings sections
     *
     * @param array $sections setting sections array
     * @return $this
     */
    function set_sections( $sections ) {
        $this->settings_sections = $sections;
        return $this;
    }

    /**
     * Add a single section
     *
     * @param array $section
     * @return $this
     */
    function add_section( $section ) {
        $this->settings_sections[] = $section;
        return $this;
    }

    /**
     * Set settings fields
     *
     * @param array $fields settings fields array
     * @return $this
     */
    function set_fields( $fields ) {
        $this->settings_fields = $fields;
        return $this;
    }

    function add_field( $section, $field ) {
        $defaults = array(
            'name'  => '',
            'label' => '',
            'desc'  => '',
            'type'  => 'text'
        );
        $arg = wp_parse_args( $field, $defaults );
        $this->settings_fields[$section][] = $arg;
        return $this;
    }

    /**
     * Initialize and registers the settings sections and fileds to WordPress
     *
     * Usually this should be called at `admin_init` hook.
     *
     * This function gets the initiated settings sections and fields. Then
     * registers them to WordPress and ready for use.
     */
    function admin_init() {
        //register settings sections
        if ( !empty( $this->settings_sections ) ) {
            foreach ($this->settings_sections as $section) {
                if (false == get_option($section['id'])) {
                    add_option($section['id']);
                }
                if (isset($section['desc']) && !empty($section['desc'])) {
                    $section['desc'] = '<div class="inside">' . $section['desc'] . '</div>';
                    $callback = function () use ($section) {
                        echo str_replace('"', '\"', $section['desc']);
                    };
                } else if (isset($section['callback'])) {
                    $callback = $section['callback'];
                } else {
                    $callback = null;
                }
                add_settings_section($section['id'], $section['title'], $callback, $section['id']);
            }
        }

        //register settings fields
        if ( !empty( $this->settings_fields ) ) {
            foreach ($this->settings_fields as $section => $field) {
                foreach ($field as $option) {
                    $name = $option['name'];
                    $type = isset($option['type']) ? $option['type'] : 'text';
                    $label = isset($option['label']) ? $option['label'] : '';
                    $callback = isset($option['callback']) ? $option['callback'] : array($this, 'callback_' . $type);
                    $args = array(
                        'id' => $name,
                        'class' => isset($option['class']) ? $option['class'] : $name,
                        'label_for' => "{$section}[{$name}]",
                        'desc' => isset($option['desc']) ? $option['desc'] : '',
                        'name' => $label,
                        'section' => $section,
                        'size' => isset($option['size']) ? $option['size'] : null,
                        'options' => isset($option['options']) ? $option['options'] : '',
                        'std' => isset($option['default']) ? $option['default'] : '',
                        'sanitize_callback' => isset($option['sanitize_callback']) ? $option['sanitize_callback'] : '',
                        'type' => $type,
                        'placeholder' => isset($option['placeholder']) ? $option['placeholder'] : '',
                        'min' => isset($option['min']) ? $option['min'] : '',
                        'max' => isset($option['max']) ? $option['max'] : '',
                        'step' => isset($option['step']) ? $option['step'] : '',
                        //added by asad
                        'value' => isset($option['value']) ? $option['value'] : '',
                        'field_id' => isset($option['field_id']) ? $option['field_id'] : '',
                    );
                    add_settings_field("{$section}[{$name}]", $label, $callback, $section, $section, $args);
                }
            }
        }

        // creates our settings in the options table
        if ( !empty( $this->settings_sections ) ) {
            foreach ($this->settings_sections as $section) {
                register_setting($section['id'], $section['id'], array($this, 'sanitize_options'));
            }
        }
    }

    /**
     * Get field description for display
     *
     * @param array $args settings field args
     * @return string $desc
     */
    public function get_field_description( $args ) {
        if ( ! empty( $args['desc'] ) ) {
            $desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
        } else {
            $desc = '';
        }
        return $desc;
    }

    /**
     * Displays a heading for a settings field
     *
     * @param array   $args settings field args
     */
    //added by asad
    function callback_heading( $args ) {
        $html  = sprintf( '<h2>%1$s</h2>', $args['value'] );
        echo $html;
    }

    /**
     * Displays a heading for a settings field
     *
     * @param array   $args settings field args
     */
    //added by asad
    function callback_button( $args ) {
        $class        = isset( $args['class'] ) && !is_null( $args['class'] ) ? $args['class'] : 'regular';
        $id        = isset( $args['field_id'] ) && !is_null( $args['field_id'] ) ? $args['field_id'] : 'fieldID';
        $value      = isset( $args['value'] ) ? $args['value'] : '';
        $html        = sprintf( '<button id="%1$s" class="%2$s">', $id, $class );
        $html       .= $value;
        $html       .= sprintf( '</button>' );
        echo $html;
    }

    /**
     * Displays a heading for a settings field
     *
     * @param array   $args settings field args
     */

    function callback_repeater( $args ) {
        $class        = isset( $args['class'] ) && !is_null( $args['class'] ) ? $args['class'] : 'regular';
        $value      = isset( $args['value'] ) ? $args['value'] : '';
        $field_value       = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';
        $html       = sprintf( '<div class="%1$s-repeater-container">', $value);
        if ( $value == 'input' ) {
            if( !empty( $field_value ) ){
                foreach ( $field_value as $key => $val ){
                    $html .= sprintf('<div><input type="text" class="%1$s" name="%2$s[%3$s][]" %4$s value="%5$s"/>', $class, $args['section'], $args['id'], $placeholder, $val);
                    $html .= '<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span>
</button></div>';
                }
            }else {
                $html .= sprintf('<div><input type="text" class="%1$s" name="%2$s[%3$s][]" %4$s value="%5$s"/>', $class, $args['section'], $args['id'], $placeholder, '');
                $html .= '<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span>
</button></div>';
            }
        }
        $html       .= sprintf( '</div>' );
        echo $html;
    }

    /**
     * Displays a text field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_text( $args ) {
        $value       = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $class        = isset( $args['class'] ) && !is_null( $args['class'] ) ? $args['class'] : 'regular';
        $type        = isset( $args['type'] ) ? $args['type'] : 'text';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';
        $html        = sprintf( '<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s/>', $type, $class, $args['section'], $args['id'], $value, $placeholder );
        $html       .= $this->get_field_description( $args );
        echo $html;
    }

    /**
     * Displays a url field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_url( $args ) {
        $this->callback_text( $args );
    }

    /**
     * Displays a number field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_number( $args ) {
        $value       = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $class        = isset( $args['class'] ) && !is_null( $args['class'] ) ? $args['class'] : 'regular';
        $type        = isset( $args['type'] ) ? $args['type'] : 'number';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';
        $min         = ( $args['min'] == '' ) ? '' : ' min="' . $args['min'] . '"';
        $max         = ( $args['max'] == '' ) ? '' : ' max="' . $args['max'] . '"';
        $step        = ( $args['step'] == '' ) ? '' : ' step="' . $args['step'] . '"';
        $html        = sprintf( '<input type="%1$s" class="%2$s-number" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s%7$s%8$s%9$s/>', $type, $class, $args['section'], $args['id'], $value, $placeholder, $min, $max, $step );
        $html       .= $this->get_field_description( $args );
        echo $html;
    }

    /**
     * Displays a checkbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_checkbox( $args ) {
        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $html  = '<fieldset>';
        $html  .= sprintf( '<label for="wpuf-%1$s[%2$s]">', $args['section'], $args['id'] );
        $html  .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
        $html  .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />', $args['section'], $args['id'], checked( $value, 'on', false ) );
        $html  .= sprintf( '%1$s</label>', $args['desc'] );
        $html  .= '</fieldset>';
        echo $html;
    }

    /**
     * Displays a multicheckbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_multicheck( $args ) {
        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $html  = '<fieldset>';
        $html .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="" />', $args['section'], $args['id'] );
        foreach ( $args['options'] as $key => $label ) {
            $checked = isset( $value[$key] ) ? $value[$key] : '0';
            $html    .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
            $html    .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
            $html    .= sprintf( '%1$s</label><br>',  $label );
        }
        $html .= $this->get_field_description( $args );
        $html .= '</fieldset>';
        echo $html;
    }

    /**
     * Displays a radio button for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_radio( $args ) {
        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $html  = '<fieldset>';
        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">',  $args['section'], $args['id'], $key );
            $html .= sprintf( '<input type="radio" class="radio" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
            $html .= sprintf( '%1$s</label><br>', $label );
        }
        $html .= $this->get_field_description( $args );
        $html .= '</fieldset>';
        echo $html;
    }

    /**
     * Displays a selectbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_select( $args ) {
        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $class  = isset( $args['class'] ) && !is_null( $args['class'] ) ? $args['class'] : 'regular';
        $html  = sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $class, $args['section'], $args['id'] );
        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
        }
        $html .= sprintf( '</select>' );
        $html .= $this->get_field_description( $args );
        echo $html;
    }

    /**
     * Displays a textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_textarea( $args ) {
        $value       = esc_textarea( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $class        = isset( $args['class'] ) && !is_null( $args['class'] ) ? $args['class'] : 'regular';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="'.$args['placeholder'].'"';
        $html        = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]"%4$s>%5$s</textarea>', $class, $args['section'], $args['id'], $placeholder, $value );
        $html        .= $this->get_field_description( $args );
        echo $html;
    }

    /**
     * Displays the html for a settings field
     *
     * @param array   $args settings field args
     * @return string
     */
    function callback_html( $args ) {
        echo $this->get_field_description( $args );
    }

    /**
     * Displays a rich text textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_wysiwyg( $args ) {
        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        //$size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : '500px';
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : '50%';

        echo '<div style="max-width: ' . $size . '">';

        $editor_settings = array(
            'teeny'         => true,
            'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
            'textarea_rows' => 10
        );

        if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
            $editor_settings = array_merge( $editor_settings, $args['options'] );
        }

        wp_editor( $value, $args['section'] . '-' . $args['id'], $editor_settings );

        echo '</div>';

        echo $this->get_field_description( $args );
    }

    /**
     * Displays a file upload field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_file( $args ) {
        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $class  = isset( $args['class'] ) && !is_null( $args['class'] ) ? $args['class'] : 'regular';
        $id    = $args['section']  . '[' . $args['id'] . ']';
        $label = isset( $args['options']['button_label'] ) ? $args['options']['button_label'] : __( 'Choose File' );
        $html  = sprintf( '<input type="text" class="%1$s-text wpsa-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $class, $args['section'], $args['id'], $value );
        $html  .= '<input type="button" class="button wpsa-browse" value="' . $label . '" />';
        $html  .= $this->get_field_description( $args );
        echo $html;
    }

    /**
     * Displays a password field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_password( $args ) {
        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $class  = isset( $args['class'] ) && !is_null( $args['class'] ) ? $args['class'] : 'regular';
        $html  = sprintf( '<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $class, $args['section'], $args['id'], $value );
        $html  .= $this->get_field_description( $args );
        echo $html;
    }

    /**
     * Displays a color picker field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_color( $args ) {
        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $class  = isset( $args['class'] ) && !is_null( $args['class'] ) ? $args['class'] : 'regular';
        $html  = sprintf( '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $class, $args['section'], $args['id'], $value, $args['std'] );
        $html  .= $this->get_field_description( $args );
        echo $html;
    }


    /**
     * Displays a select box for creating the pages select box
     *
     * @param array   $args settings field args
     */
    function callback_pages( $args ) {
        $dropdown_args = array(
            'selected' => esc_attr($this->get_option($args['id'], $args['section'], $args['std'] ) ),
            'name'     => $args['section'] . '[' . $args['id'] . ']',
            'id'       => $args['section'] . '[' . $args['id'] . ']',
            'echo'     => 0
        );
        $html = wp_dropdown_pages( $dropdown_args );
        echo $html;
    }

    /**
     * Sanitize callback for Settings API
     *
     * @return mixed
     */
    function sanitize_options( $options ) {

        if ( !$options ) {
            return $options;
        }

        foreach( $options as $option_slug => $option_value ) {
            $sanitize_callback = $this->get_sanitize_callback( $option_slug );
//die();
            // If callback is set, call it
            if ( $sanitize_callback ) {
                $options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
                continue;
            }
        }

        return $options;
    }

    /**
     * Get sanitization callback for given option slug
     *
     * @param string $slug option slug
     *
     * @return mixed string or bool false
     */
    function get_sanitize_callback( $slug = '' ) {
        if ( empty( $slug ) ) {
            return false;
        }

        // Iterate over registered fields and see if we can find proper callback
        foreach( $this->settings_fields as $section => $options ) {
            foreach ( $options as $option ) {
                if ( $option['name'] != $slug ) {
                    continue;
                }

                if ( $option['type'] != 'wysiwyg' ) :
                    // Return the callback name
                    return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
                else:
                    return isset( $option['sanitize_callback'] ) ? array($this, $option['sanitize_callback']) : false;
                endif;
            }
        }

        return false;
    }

    /**
     * Get the value of a settings field
     *
     * @param string  $option  settings field name
     * @param string  $section the section name this field belongs to
     * @param string  $default default text if it's not found
     * @return string
     */
    function get_option( $option, $section, $default = '' ) {

        $options = get_option( $section );

        if ( isset( $options[$option] ) ) {
            return $options[$option];
        }

        return $default;
    }

    /**
     * Sanitize custom callback function for Text area field
     *
     * @return string
     */
    function pd_gdpr_sanitize_textarea_field( $text ) {
        $allowed_html = $this->pd_gdpr_allowed_html();
        $sanitized_text = wp_kses( $text, $allowed_html );
        return $sanitized_text;
    }

    /**
     * Allowed default html tags for plugin textarea settings field
     *
     * @return array
     */

    function pd_gdpr_allowed_html() {

        $allowed_tags = array(
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

        return $allowed_tags;
    }

    /**
     * Show navigations as tab
     *
     * Shows all the settings section labels as tab
     */
    function show_navigation() {
        $html = '<h2 class="nav-tab-wrapper">';
        $count = count( $this->settings_sections );
        // don't show the navigation if only one section exists
        if ( $count === 1 ) {
            return;
        }
        foreach ( $this->settings_sections as $tab ) {
            $html .= sprintf( '<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>', $tab['id'], $tab['title'] );
        }
        $html .= '</h2>';
        echo $html;
    }

    /**
     * Show the section settings forms
     *
     * This function displays every sections in a different form
     */
    function show_forms() {
        ?>
        <div class="metabox-holder gdpr-settings-con">
            <?php foreach ( $this->settings_sections as $form ) { ?>
                <div id="<?php echo $form['id']; ?>" class="group" style="display: none;">
                    <form method="post" action="options.php">
                        <?php
                        do_action( 'wsa_form_top_' . $form['id'], $form );
                        settings_fields( $form['id'] );
                        do_settings_sections( $form['id'] );
                        do_action( 'wsa_form_bottom_' . $form['id'], $form );
                        if ( isset( $this->settings_fields[ $form['id'] ] ) ):
                        ?>
                        <div style="padding-left: 10px">
                            <?php submit_button(); ?>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            <?php } ?>
        </div>
        <?php
        $this->script();
    }

    /**
     * Tabbable JavaScript codes & Initiate Color Picker
     *
     * This code uses localstorage for displaying active tabs
     */
    function script() {
        ?>
        <script>
            jQuery(document).ready(function($) {
                //Initiate Color Picker
                $('.wp-color-picker-field').wpColorPicker();

                // Switches option sections
                $('.group').hide();
                var activetab = '';
                if (typeof(localStorage) != 'undefined' ) {
                    activetab = localStorage.getItem("activetab");
                }

                //if url has section id as hash then set it as active or override the current local storage value
                if(window.location.hash){
                    activetab = window.location.hash;
                    if (typeof(localStorage) != 'undefined' ) {
                        localStorage.setItem("activetab", activetab);
                    }
                }

                if (activetab != '' && $(activetab).length ) {
                    $(activetab).fadeIn();
                } else {
                    $('.group:first').fadeIn();
                }
                $('.group .collapsed').each(function(){
                    $(this).find('input:checked').parent().parent().parent().nextAll().each(
                    function(){
                        if ($(this).hasClass('last')) {
                            $(this).removeClass('hidden');
                            return false;
                        }
                        $(this).filter('.hidden').removeClass('hidden');
                    });
                });

                if (activetab != '' && $(activetab + '-tab').length ) {
                    $(activetab + '-tab').addClass('nav-tab-active');
                }
                else {
                    $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
                }
                $('.nav-tab-wrapper a').click(function(evt) {
                    $('.nav-tab-wrapper a').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active').blur();
                    var clicked_group = $(this).attr('href');
                    if (typeof(localStorage) != 'undefined' ) {
                        localStorage.setItem("activetab", $(this).attr('href'));
                    }
                    $('.group').hide();
                    $(clicked_group).fadeIn();
                    evt.preventDefault();
                });

                $('.wpsa-browse').on('click', function (event) {
                    event.preventDefault();

                    var self = $(this);

                    // Create the media frame.
                    var file_frame = wp.media.frames.file_frame = wp.media({
                        title: self.data('uploader_title'),
                        button: {
                            text: self.data('uploader_button_text'),
                        },
                        multiple: false
                    });

                    file_frame.on('select', function () {
                        attachment = file_frame.state().get('selection').first().toJSON();
                        self.prev('.wpsa-url').val(attachment.url).change();
                    });

                    // Finally, open the modal
                    file_frame.open();
                });
        });
        </script>
        <?php
        $this->_style_fix();
    }

    function _style_fix() {
        global $wp_version;

        if ( version_compare( $wp_version, '3.8', '<=' ) ):
        ?>
        <style type="text/css">
            /** WordPress 3.8 Fix **/
            .form-table th { padding: 20px 10px; }
            #wpbody-content .metabox-holder { padding-top: 5px; }
        </style>
        <?php
        endif;
    }

}

endif;

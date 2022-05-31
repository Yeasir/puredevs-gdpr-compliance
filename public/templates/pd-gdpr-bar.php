<?php
$cookie_bar_style = ( $pd_general_settings['cookie_bar_style'] ? $pd_general_settings['cookie_bar_style'] : '' );
$banner_text_font_size = ( $pd_banner_settings['banner_text_font_size'] ? $pd_banner_settings['banner_text_font_size'] : '' );
if( !empty( $banner_text_font_size ) ){
    $banner_text_font_size = intval( $banner_text_font_size );
}

$banner_background_opacity = ( $pd_banner_settings['banner_background_opacity'] ? $pd_banner_settings['banner_background_opacity'] : '' );

if ( $cookie_bar_style === 'banner' ) {
    $cookie_bar_position = ( ! empty( $pd_general_settings['cookie_bar_position'] ) ? $pd_general_settings['cookie_bar_position'] : '' );
    $barshowafter = ( ! empty( $pd_general_settings['barshowafter'] ) ? $pd_general_settings['barshowafter'] : 'soe' );
    ?>
    <div class="pd-gdpr-panel-setting pd-gdpr-bg-gradient-default <?php if ( $cookie_bar_position == 'footer' ): ?>bottom-0 <?php else: ?> top-0 <?php endif; ?>panel-area pd-none" <?php if ( $barshowafter == 'time' ): ?> delay="<?php echo ( ! empty( $pd_general_settings['cookie_bar_time'] ) ? esc_attr($pd_general_settings['cookie_bar_time']) : 2000 ); ?>" <?php else: ?> scroll-data="<?php echo( ! empty( $pd_general_settings['scroll_offset'] ) ? esc_attr($pd_general_settings['scroll_offset']) : 120 ); ?>" <?php endif; ?> style="background-color: <?php echo( ! empty( $pd_banner_settings['banner_background_color'] ) ? $pd_banner_settings['banner_background_color'] : '#172b4d' ); ?>; <?php if( !empty( $banner_background_opacity ) && is_numeric( $banner_background_opacity ) ){?> opacity:<?php echo $banner_background_opacity;?><?php }?>">
        <div class="pd-gdpr-container">
            <div class="pd-gdpr-row align-items-center">
                <div class="col-lg-8 col-md-6 col-sm-12 pd-m-center">
                    <p style="color: <?php echo __( ( ! empty( $pd_banner_settings['banner_text_color'] ) ? $pd_banner_settings['banner_text_color'] : '#ffffff' ), 'pd_gdpr' ); ?>;<?php if( !empty( $banner_text_font_size ) ) :?>font-size:<?php echo $banner_text_font_size.'px';?><?php endif;?>">
                        <?php
                        echo wp_kses(__( do_shortcode( ( $pd_banner_settings['banner_content'] ? $pd_banner_settings['banner_content'] : 'This website uses cookies to provide you with the best browsing experience. Find out more or adjust your [settings].' ) ), 'pd_gdpr' ), Pd_gdpr::$allowed_html);
                        ?>
                    </p>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                    <?php
                    $pd_button_styling = Pd_gdpr::get_settings_by_section( 'puredevs_button_settings' );
                    ?>
                    <button class="pd-gdpr-btn accept-btn" style="background-color: <?php echo ! empty( $pd_button_styling['accept_button_background_color'] ) ? $pd_button_styling['accept_button_background_color'] : '#5e72e4'; ?>;color: <?php echo ! empty( $pd_button_styling['accept_button_text_color'] ) ? $pd_button_styling['accept_button_text_color'] : '#ffffff'; ?>">
                        <?php echo esc_html__( ( ! empty ( $pd_button_styling['accept_button_text'] ) ? $pd_button_styling['accept_button_text'] : 'Accept' ), 'pd_gdpr' ); ?>
                    </button>
                    <?php if ( ! empty( $pd_button_styling['show_reject_button'] ) && $pd_button_styling['show_reject_button'] != 'off' ) : ?>
                        <button class="pd-gdpr-btn pd-gdpr-btn-danger reject-btn" style="background-color: <?php echo ! empty( $pd_button_styling['reject_button_background_color'] ) ? $pd_button_styling['reject_button_background_color'] : '#ec0c38'; ?>;color: <?php echo ! empty( $pd_button_styling['reject_button_text_color'] ) ? $pd_button_styling['reject_button_text_color'] : '#ffffff'; ?>">
                            <?php echo esc_html__( ( ! empty ( $pd_button_styling['reject_button_text'] ) ? $pd_button_styling['reject_button_text'] : 'Reject' ), 'pd_gdpr' ); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    $barshowafter = ( ! empty( $pd_general_settings['barshowafter'] ) ? $pd_general_settings['barshowafter'] : 'soe' );
    ?>
    <div class="pd-gdpr-modal pd-gdpr-modal-panel" id="pd-gdpr-modal-panel" tabindex="-1" role="dialog" aria-labelledby="modal-panel" aria-hidden="true" <?php if ( $barshowafter == 'time' ): ?> delay="<?php echo( ! empty( $pd_general_settings['cookie_bar_time'] ) ? esc_attr($pd_general_settings['cookie_bar_time']) : 2000 ); ?>" <?php else: ?> scroll-data="<?php echo ( ! empty( $pd_general_settings['scroll_offset'] ) ? esc_attr($pd_general_settings['scroll_offset']) : 120 ); ?>" <?php endif; ?>>
        <div class="pd-gdpr-modal-dialog modal-default pd-gdpr-modal-dialog-centered modal-xl" role="document">
            <div class="pd-gdpr-modal-content  pd-gdpr-bg-gradient-default" style="background-color: <?php echo( ! empty( $pd_banner_settings['banner_background_color'] ) ? $pd_banner_settings['banner_background_color'] : '#172b4d' ); ?>; <?php if( !empty( $banner_background_opacity ) && is_numeric( $banner_background_opacity ) ){?> opacity:<?php echo $banner_background_opacity;?><?php }?>">
                <div class="pd-gdpr-modal-header bg-gradient-default border-0">
                    <h2 class="pd-gdpr-modal-title text-uppercase align-items-center d-flex h-100"></h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="pd-gdpr-modal-body p-0 ">
                    <div class="pd-gdpr-panel-area bg-gradient-default">
                        <div class="pd-gdpr-container">
                            <div class="pd-gdpr-row align-items-center">
                                <div class="col-lg-12 text-center ">
                                    <p style="color: <?php echo __( ( ! empty( $pd_banner_settings['banner_text_color'] ) ? $pd_banner_settings['banner_text_color'] : '#ffffff' ), 'pd_gdpr' ); ?>;<?php if( !empty( $banner_text_font_size ) ) :?>font-size:<?php echo $banner_text_font_size.'px';?><?php endif;?>">
		                                <?php
		                                echo wp_kses(__( do_shortcode( ( $pd_banner_settings['banner_content'] ? $pd_banner_settings['banner_content'] : 'This website uses cookies to provide you with the best browsing experience. Find out more or adjust your [settings].' ) ), 'pd_gdpr' ), Pd_gdpr::$allowed_html);
		                                ?>
                                    </p>
                                </div>
                                <div class="col-lg-12 text-center ">
	                                <?php
	                                $pd_button_styling = Pd_gdpr::get_settings_by_section( 'puredevs_button_settings' );
	                                ?>
                                    <button class="pd-gdpr-btn accept-btn" style="background-color: <?php echo ! empty( $pd_button_styling['accept_button_background_color'] ) ? $pd_button_styling['accept_button_background_color'] : '#5e72e4'; ?>;color: <?php echo ! empty( $pd_button_styling['accept_button_text_color'] ) ? $pd_button_styling['accept_button_text_color'] : '#ffffff'; ?>">
		                                <?php echo esc_html__( ( ! empty ($pd_button_styling['accept_button_text'] ) ? $pd_button_styling['accept_button_text'] : 'Accept' ), 'pd_gdpr' ); ?>
                                    </button>
	                                <?php if ( ! empty( $pd_button_styling['show_reject_button'] ) && $pd_button_styling['show_reject_button'] != 'off' ) : ?>
                                        <button class="pd-gdpr-btn pd-gdpr-btn-danger reject-btn" style="background-color: <?php echo ! empty( $pd_button_styling['reject_button_background_color'] ) ? $pd_button_styling['reject_button_background_color'] : '#ec0c38'; ?>;color: <?php echo ! empty( $pd_button_styling['reject_button_text_color'] ) ? $pd_button_styling['reject_button_text_color'] : '#ffffff'; ?>">
                                            <?php echo esc_html__( ( ! empty ($pd_button_styling['reject_button_text'] ) ? $pd_button_styling['reject_button_text'] : 'Reject' ), 'pd_gdpr' ); ?>
                                        </button>
	                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pd-gdpr-modal-footer bg-gradient-default border-0"></div>
            </div>
        </div>
    </div>
<?php }; ?>
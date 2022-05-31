<div class="pd-gdpr-modal pd-gdpr-modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="pd-gdpr-modal-dialog modal-default  pd-gdpr-modal-dialog-centered  modal-xl" role="document">
        <div class="pd-gdpr-modal-content pd-gdpr-bg-gradient-default">
            <div class="pd-gdpr-modal-header pd-gdpr-bg-white pd-notification-settings">
                <?php
                $cookie_settings_heading = Pd_gdpr::get_settings_by_section_and_fields( 'cookie_settings_heading', 'puredevs_general_settings' );
                $cookie_settings_logo = Pd_gdpr::get_settings_by_section_and_fields( 'cookie_settings_logo', 'puredevs_general_settings' );

                if( empty( $cookie_settings_heading ) ) {
                    $cookie_settings_heading = 'PureDevs GDPR Cookie Settings Options';
                }
                if( empty( $cookie_settings_logo ) ) {
                    $cookie_settings_logo = PD_GDPR_PLUGIN_DIR_URL.'/images/puredevs-gdpr-logo.png';
                }
                ?>
                <h2 class="pd-gdpr-modal-title" id="modal-title-notification"><img src="<?php echo esc_url($cookie_settings_logo);?>" alt=""/> <span><?php echo esc_html__($cookie_settings_heading, 'pd_gdpr');?></span> </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="pd-gdpr-modal-body">
                <div class="pd-gdpr-container ">
                    <div class="pd-gdpr-row">
                        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 ">
                            <div class="pd-gdpr-sidebar-modal ">
                                <ul class="pd-gdpr-tab clearfix">
                                    <?php
                                    $privacy_overview_settings = Pd_gdpr::get_settings_by_section( 'puredevs_privacy_overview_settings' );
                                    ?>
                                    <li class="tab-item ">
                                        <a class="active" href="javascript:void(0);" data-tag="overview">
                                            <i class="icofont-bullseye icofont-2x"></i><?php echo esc_html__( ( ! empty( $privacy_overview_settings['privacy_overview_tab_title'] ) ? $privacy_overview_settings['privacy_overview_tab_title'] : 'Overview' ), 'pd_gdpr' );?>
                                        </a>
                                    </li>
                                    <?php
                                    if ( isset( $this->cookie_categories['strictly_necessary_cookie'] ) && ( ! empty( $this->strictly_necessary_cookies_section ) && $this->strictly_necessary_cookies_section['snc_choose_functionality'] != 'always-enable-chfu' ) ) : ?>
                                        <li class="tab-item ">
                                            <a href="javascript:void(0);" data-tag="tabs-strictly-tab">
                                                <i class="icofont-tick-boxed icofont-2x"></i>
                                                <?php
                                                echo $strictly_necessary_cookie_tab_title = esc_html__( ( ! empty( $this->strictly_necessary_cookies_section['snec_tab_title'] ) ? $this->strictly_necessary_cookies_section['snec_tab_title'] : 'Strictly Necessary Cookies' ), 'pd_gdpr' );
                                                ?>
                                            </a>
                                        </li>
                                    <?php
                                    endif;
                                    if ( isset( $this->cookie_categories['3rd_party_cookie'] ) ) : ?>
                                        <li class="tab-item">
                                            <a href="javascript:void(0);"
                                               data-tag="tabs-3rd-cookie-tab">
                                                <i class="icofont-flask icofont-2x"></i>
                                                <?php
                                                echo $third_party_cookie_tab_title = esc_html__( ( ! empty( $this->third_party_cookies_section['3rd_party_cookie_tab_title'] ) ? $this->third_party_cookies_section['3rd_party_cookie_tab_title'] : '3rd party Cookie' ), 'pd_gdpr' );
                                                ?>
                                            </a>
                                        </li>
                                    <?php
                                    endif;
                                    if ( isset( $this->cookie_categories['additional_cookie'] ) ) : ?>
                                        <li class="tab-item">
                                            <a href="javascript:void(0);"
                                               data-tag="tabs-add-cookie-tab">
                                                <i class="icofont-plus-square icofont-2x "></i>
                                                <?php
                                                echo $additional_cookie_tab_title = esc_html__( ( ! empty( $this->additional_cookies_section['additional_cookie_tab_title'] ) ? $this->additional_cookies_section['additional_cookie_tab_title'] : 'Additional Cookies' ), 'pd_gdpr' );
                                                ?>
                                            </a>
                                        </li>
                                    <?php
                                    endif;
                                    if ( isset( $this->cookie_categories['required_cookies'] ) ) : ?>
                                        <li class="tab-item">
                                            <a href="javascript:void(0);" data-tag="tabs-required-tab">
                                                <i class="icofont-unlocked  icofont-2x"></i>
                                                <?php
                                                echo $required_cookie_tab_title = esc_html__( ( ! empty( $this->required_cookies_section['required_cookies_tab_title'] ) ? $this->required_cookies_section['required_cookies_tab_title'] : 'Required Cookies' ), 'pd_gdpr' );
                                                ?>
                                            </a>
                                        </li>
                                    <?php
                                    endif;
                                    if ( isset( $this->cookie_categories['functional_cookie'] ) ) : ?>
                                        <li class="tab-item">
                                            <a href="javascript:void(0);"
                                               data-tag="tabs-functional-tab">
                                                <i class="icofont-unique-idea  icofont-2x"></i>
                                                <?php
                                                echo $functional_cookie_tab_title = esc_html__( ( ! empty( $this->functional_cookies_section['functional_cookie_tab_title'] ) ? $this->functional_cookies_section['functional_cookie_tab_title'] : 'Functional Cookies' ), 'pd_gdpr' );
                                                ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php
                                    $cookie_policy_section = Pd_gdpr::get_settings_by_section( 'puredevs_privacy_and_policy_settings' );
                                    if ( isset( $cookie_policy_section['enable_disable_privacy_and_policy'] ) && $cookie_policy_section['enable_disable_privacy_and_policy'] !== 'off' ) :
                                    ?>
                                    <li class="tab-item">
                                        <a href="javascript:void(0);" data-tag="tabs-cookie-policy-tab">
                                            <i class="icofont-light-bulb  icofont-2x"></i>
                                            <?php
                                            echo $cookie_policy_tab_title = esc_html__( ( ! empty( $cookie_policy_section['privacy_and_policy_tab_title'] ) ? $cookie_policy_section['privacy_and_policy_tab_title'] : 'Cookie Policy' ), 'pd_gdpr' );
                                            ?>
                                        </a>
                                    </li>
                                    <?php endif;?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-8 col-lg-8 col-xl-8">
                            <div class="pd-gdpr-content-modal">
                                <div class="pd-gdpr-card">
                                    <div class="pd-gdpr-card-body">
                                        <form action="">
                                            <div class="pd-gdpr-tab-wrapper">
                                                <div class="list" id="overview">
                                                    <h6 class="pd-gdpr-title"><?php echo esc_html__( ( ! empty( $privacy_overview_settings['privacy_overview_tab_title'] ) ? $privacy_overview_settings['privacy_overview_tab_title'] : 'Overview' ), 'pd_gdpr' );?></h6>
                                                    <p><?php echo wp_kses(__( ( ! empty( $privacy_overview_settings['privacy_overview_tab_content'] ) ? $privacy_overview_settings['privacy_overview_tab_content'] : 'This website uses cookies so that we can provide you with the best user experience possible. Cookie information is stored in your browser and performs functions such as recognising you when you return to our website and helping our team to understand which sections of the website you find most interesting and useful.' ), 'pd_gdpr' ), Pd_gdpr::$allowed_html);?></p>
                                                    <div class="pd-gdpr-row align-items-center">
                                                        <div class="col-sm-12 ">
                                                            <small class="pd-gdpr-label"><?php echo esc_html__('Enable ALL', 'pd_gdpr');?></small>
                                                            <label class="custom-toggle re-custom">
                                                                <input type="checkbox">
                                                                <span class="custom-toggle-slider"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ( isset( $this->cookie_categories['strictly_necessary_cookie'] ) && ( ! empty( $this->strictly_necessary_cookies_section ) && $this->strictly_necessary_cookies_section['snc_choose_functionality'] != 'always-enable-chfu' ) ) : ?>
                                                    <div class="list hide" id="tabs-strictly-tab">
                                                        <h6 class="pd-gdpr-title">
                                                            <?php echo esc_html__($strictly_necessary_cookie_tab_title, 'pd_gdpr'); ?>
                                                        </h6>
                                                        <p> <?php echo wp_kses(__( ( !empty($this->strictly_necessary_cookies_section['snec_tab_content'] ) ? $this->strictly_necessary_cookies_section['snec_tab_content'] : 'Strictly Necessary Cookie should be enabled at all times so that we can save your preferences for cookie settings' ), 'pd_gdpr' ), Pd_gdpr::$allowed_html); ?>
                                                        </p>
                                                        <?php
                                                        if ( $this->strictly_necessary_cookies_section['snc_choose_functionality'] != 'always-enable' ) : ?>
                                                            <div class="pd-gdpr-row  align-items-center">
                                                                <div class="col-sm-12 ">
                                                                    <small class="pd-gdpr-label"><?php echo esc_html__('Enable', 'pd_gdpr');?></small>
                                                                    <label class="custom-toggle re-custom">
                                                                        <input type="checkbox" data-cookie-category="pd_strictly_necessary_cookie" <?php echo $_COOKIE['pd_strictly_necessary_cookie'] === 'true' ? 'checked' : ''; ?>>
                                                                        <span class="custom-toggle-slider"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php else:
                                                            echo '<input type="hidden" data-cookie-category="pd_strictly_necessary_cookie" data-checked="checked">';
                                                        endif; ?>
                                                    </div>
                                                <?php else:
                                                    echo '<input type="hidden" data-cookie-category="pd_strictly_necessary_cookie" data-checked="checked">';
                                                endif;
                                                if ( isset( $this->cookie_categories['3rd_party_cookie'] ) ) : ?>
                                                    <div class="list hide" id="tabs-3rd-cookie-tab">
                                                        <h6 class="pd-gdpr-title">
                                                            <?php echo esc_html__($third_party_cookie_tab_title, 'pd_gdpr'); ?>
                                                        </h6>
                                                        <p>
                                                            <?php echo wp_kses(__( ( ! empty( $this->third_party_cookies_section['3rd_party_cookie_tab_content'] ) ? $this->third_party_cookies_section['3rd_party_cookie_tab_content'] : '3rd Party Cookies should be enabled at all times so that we can save your preferences for cookie settings' ), 'pd_gdpr' ), Pd_gdpr::$allowed_html); ?>
                                                        </p>
                                                        <div class="pd-gdpr-row  align-items-center">
                                                            <div class="col-sm-12 ">
                                                                <small class="pd-gdpr-label"><?php echo esc_html__('Enable', 'pd_gdpr');?></small>
                                                                <label class="custom-toggle re-custom">
		                                                            <?php
		                                                            $checked = '';
		                                                            if ( $_COOKIE['pd_3rd_party_cookie'] == '' && $this->third_party_cookies_section['enable_disable_3rd_party_cookie'] == 'on' ) {
			                                                            $checked = 'checked';
		                                                            } elseif ( $_COOKIE['pd_3rd_party_cookie'] == 'true' && ( $this->third_party_cookies_section['enable_disable_3rd_party_cookie'] == 'on' || $this->third_party_cookies_section['enable_disable_3rd_party_cookie'] == 'off' ) ) {
			                                                            $checked = 'checked';
		                                                            }
		                                                            ?>
                                                                    <input type="checkbox" data-cookie-category="pd_3rd_party_cookie" <?php echo $checked; ?>>
                                                                    <span class="custom-toggle-slider"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                endif;
                                                if ( isset( $this->cookie_categories['additional_cookie'] ) ) : ?>
                                                    <div class="list hide" id="tabs-add-cookie-tab">
                                                        <h6 class="pd-gdpr-title">
                                                            <?php echo esc_html__($additional_cookie_tab_title, 'pd_gdpr'); ?>
                                                        </h6>
                                                        <p>
                                                            <?php echo wp_kses(__( ( ! empty( $this->additional_cookies_section['additional_cookie_tab_content'] ) ? $this->additional_cookies_section['additional_cookie_tab_content'] : 'Additional Cookies should be enabled at all times so that we can save your preferences for cookie settings' ), 'pd_gdpr' ), Pd_gdpr::$allowed_html); ?>
                                                        </p>
                                                        <div class="pd-gdpr-row  align-items-center">
                                                            <div class="col-sm-12 ">
                                                                <small class="pd-gdpr-label "><?php echo esc_html__('Enable', 'pd_gdpr')?></small>
                                                                <label class="custom-toggle re-custom">
                                                                    <input type="checkbox" data-cookie-category="pd_additional_cookie" <?php echo ( ! empty( $this->additional_cookies_section['enable_disable_additional_cookie'] ) && ( ( $_COOKIE['pd_additional_cookie'] == '' && $this->additional_cookies_section['enable_disable_additional_cookie'] == 'on' ) || ( $_COOKIE['pd_additional_cookie'] == 'true' && $this->additional_cookies_section['enable_disable_additional_cookie'] == 'on' ) || ( $_COOKIE['pd_additional_cookie'] == 'true' && $this->additional_cookies_section['enable_disable_additional_cookie'] == 'off' ) ) ) ? 'checked' : '' ?>>
                                                                    <span class="custom-toggle-slider"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                endif;
                                                if ( isset( $this->cookie_categories['required_cookies'] ) ) : ?>
                                                    <div class="list hide" id="tabs-required-tab">
                                                        <h6 class="pd-gdpr-title">
                                                            <?php echo esc_html__($required_cookie_tab_title, 'pd_gdpr'); ?>
                                                        </h6>
                                                        <p class="pd-gdpr-description">
                                                            <?php echo wp_kses(__( ( ! empty( $this->required_cookies_section['required_cookie_tab_content'] ) ? $this->required_cookies_section['required_cookie_tab_content'] : 'Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.' ), 'pd_gdpr' ), Pd_gdpr::$allowed_html); ?>
                                                        </p>
                                                        <div class="pd-gdpr-row  align-items-center">
                                                            <div class="col-sm-12 ">
                                                                <small class="pd-gdpr-label "><?php echo esc_html__('Enable', 'pd_gdpr');?></small>
                                                                <label class="custom-toggle re-custom">
                                                                    <input type="checkbox" data-cookie-category="pd_required_cookie" <?php echo ( ! empty( $this->required_cookies_section['enable_disable_required_cookies'] ) && ( ( $_COOKIE['pd_required_cookie'] == '' && $this->required_cookies_section['enable_disable_required_cookies'] == 'on' ) || ( $_COOKIE['pd_required_cookie'] == 'true' && $this->required_cookies_section['enable_disable_required_cookies'] == 'on' ) || ( $_COOKIE['pd_required_cookie'] == 'true' && $this->required_cookies_section['enable_disable_required_cookies'] == 'off' ) ) ) ? 'checked' : '' ?>>
                                                                    <span class="custom-toggle-slider"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                endif;
                                                if (isset($this->cookie_categories['functional_cookie'])) : ?>
                                                    <div class="list hide" id="tabs-functional-tab">
                                                        <h6 class="pd-gdpr-title">
                                                            <?php echo esc_html__($functional_cookie_tab_title, 'pd_gdpr'); ?>
                                                        </h6>
                                                        <p class="pd-gdpr-description">
                                                            <?php echo wp_kses(__( ( ! empty( $this->functional_cookies_section['functional_cookie_tab_content'] ) ? $this->functional_cookies_section['functional_cookie_tab_content'] : 'Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.' ), 'pd_gdpr' ), Pd_gdpr::$allowed_html); ?>
                                                        </p>
                                                        <div class="pd-gdpr-row  align-items-center">
                                                            <div class="col-sm-12 ">
                                                                <small class="pd-gdpr-label "><?php echo esc_html__('Enable', 'pd_gdpr');?></small>
                                                                <label class="custom-toggle re-custom">
                                                                    <input type="checkbox" data-cookie-category="pd_functional_cookie" <?php echo ( ! empty( $this->functional_cookies_section['enable_disable_functional_cookie'] ) && ( ( $_COOKIE['pd_functional_cookie'] == '' && $this->functional_cookies_section['enable_disable_functional_cookie'] == 'on' ) || ( $_COOKIE['pd_functional_cookie'] == 'true' && $this->functional_cookies_section['enable_disable_functional_cookie'] == 'on' ) || ( $_COOKIE['pd_functional_cookie'] == 'true' && $this->functional_cookies_section['enable_disable_functional_cookie'] == 'off' ) ) ) ? 'checked' : '' ?>>
                                                                    <span class="custom-toggle-slider "></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php
                                                if ( isset( $cookie_policy_section['enable_disable_privacy_and_policy'] ) && $cookie_policy_section['enable_disable_privacy_and_policy'] !== 'off' ) :
                                                ?>
                                                <div class="list hide" id="tabs-cookie-policy-tab">
                                                    <h6 class="pd-gdpr-title">
                                                        <?php echo esc_html__($cookie_policy_tab_title, 'pd_gdpr'); ?>
                                                    </h6>
                                                    <p class="pd-gdpr-description">
                                                        <?php echo wp_kses(__( ( ! empty( $cookie_policy_section['privacy_and_policy_message'] ) ? $cookie_policy_section['privacy_and_policy_message'] : 'Raw denim you probably haven\'t heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Reprehenderit butcher retro keffiyeh dreamcatcher synth.' ), 'pd_gdpr' ), Pd_gdpr::$allowed_html); ?>
                                                    </p>
                                                    <a href="<?php echo ! empty( $cookie_policy_section['cookie_policy_page_url'] ) ? esc_url($cookie_policy_section['cookie_policy_page_url']) : get_bloginfo( 'url' ) . '/cookie-policy'; ?>" target="_blank" class="pd-gdpr-btn pd-gdpr-btn-danger float-right"><?php echo esc_html__('View Cookie Policy', 'pd_gdpr');?></a>
                                                </div>
                                                <?php endif;?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
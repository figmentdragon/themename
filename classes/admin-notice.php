<?php
if ( !class_exists('Theme_Name_Dashboard_Notice') ):

    class Theme_Name_Dashboard_Notice
    {
        function __construct()
        {
            global $pagenow;

        	if( $this->themename_show_hide_notice() ){

	            add_action( 'admin_notices',array( $this,'themename_admin_notiece' ) );

	        }
	        add_action( 'wp_ajax_themename_notice_dismiss', array( $this, 'themename_notice_dismiss' ) );
			add_action( 'switch_theme', array( $this, 'themename_notice_clear_cache' ) );

            if( isset( $_GET['page'] ) && $_GET['page'] == 'themename-about' ){

                add_action('in_admin_header', array( $this,'themename_hide_all_admin_notice' ),1000 );

            }
        }

        public function themename_hide_all_admin_notice(){

            remove_all_actions('admin_notices');
            remove_all_actions('all_admin_notices');

        }

        public static function themename_show_hide_notice( $status = false ){

            if( $status ){

                if( (class_exists( 'Booster_Extension_Class' ) ) || get_option('themename_admin_notice') ){

                    return false;

                }else{

                    return true;

                }

            }

            // Check If current Page
            if ( isset( $_GET['page'] ) && $_GET['page'] == 'themename-about'  ) {
                return false;
            }

        	// Hide if dismiss notice
        	if( get_option('themename_admin_notice') ){
				return false;
			}
        	// Hide if all plugin active
        	if ( class_exists( 'Demo_Import_Kit_Class' ) && class_exists( 'CreativityArchitect_Import_Companion' ) ) {
				return false;
			}
			// Hide On TGMPA pages
			if ( ! empty( $_GET['tgmpa-nonce'] ) ) {
				return false;
			}
			// Hide if user can't access
        	if ( current_user_can( 'manage_options' ) ) {
				return true;
			}

        }

        // Define Global Value
        public static function themename_admin_notiece(){

            $theme_info      = wp_get_theme();
            $theme_name            = $theme_info->__get( 'Name' );
            ?>
           <div class="updated notice is-dismissible themename-notice">

                <h3><?php esc_html_e('Quick Setup','themename'); ?></h3>

                <p><strong><?php printf( __( '%1$s is now installed and ready to use. Are you looking for a better experience to set up your site?', 'themename' ), esc_html( $theme_name ) ); ?></strong></p>

                <small><?php esc_html_e("We've prepared a unique onboarding process through our",'themename'); ?> <a href="<?php echo esc_url( admin_url().'themes.php?page='.get_template().'-about') ?>"><?php esc_html_e('Getting started','themename'); ?></a> <?php esc_html_e("page. It helps you get started and configure your upcoming website with ease. Let's make it shine!",'themename'); ?></small>

                <p>
                    <a class="button button-primary install-active" href="javascript:void(0)"><?php esc_html_e('Install and activate recommended plugins','themename'); ?></a>
                    <span class="quick-loader-wrapper"><span class="quick-loader"></span></span>

                    <a target="_blank" class="button button-primary" href="<?php echo esc_url( 'https://preview.creativityarchitect.com/themename/' ); ?>"><?php esc_html_e('View Demo','themename'); ?></a>
                    <a target="_blank" class="button button-primary button-primary-upgrade" href="<?php echo esc_url( 'https://www.thecreativityarchitect.com/theme/themename-pro/' ); ?>"><?php esc_html_e('Upgrade to Pro','themename'); ?></a>
                    <a class="btn-dismiss custom-setup" href="javascript:void(0)"><?php esc_html_e('Dismiss this notice.','themename'); ?></a>

                </p>

            </div>

        <?php
        }

        public function themename_notice_dismiss(){

        	if ( isset( $_POST[ '_wpnonce' ] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ '_wpnonce' ] ) ), 'themename_ajax_nonce' ) ) {

	        	update_option('themename_admin_notice','hide');

	        }

            die();

        }

        public function themename_notice_clear_cache(){

        	update_option('themename_admin_notice','');

        }

    }
    new Theme_Name_Dashboard_Notice();
endif;

<?php

if ( !function_exists( 'kt_admin_enqueue_scripts' ) ) {

    /**
     * Add stylesheet and script for admin
     *
     * @since       1.0
     * @return      void
     * @access      public
     */
    function kt_admin_enqueue_scripts(){
        wp_enqueue_style( 'kt-font-awesome', THEME_FONTS.'font-awesome/css/font-awesome.min.css');
        wp_enqueue_style( 'framework-core', FW_CSS.'framework-core.css');
        wp_enqueue_style( 'chosen', FW_LIBS.'chosen/chosen.min.css');

        wp_enqueue_script( 'kt_image', FW_JS.'kt_image.js', array('jquery'), FW_VER, true);
        wp_enqueue_script( 'chosen', FW_LIBS.'chosen/chosen.jquery.min.js', array('jquery'), FW_VER, true);
        wp_enqueue_script( 'cookie', FW_JS.'jquery.cookie.js', array('jquery'), FW_VER, true);
        wp_enqueue_script( 'showhide_metabox', FW_JS.'kt_showhide_metabox.js', array('jquery'), FW_VER, true);
        wp_enqueue_script( 'kt_icons', FW_JS.'kt_icons.js', array('jquery'), FW_VER, true);
        wp_enqueue_script( 'kt_image', FW_JS.'kt_image.js', array('jquery'), FW_VER, true);


        wp_enqueue_media();
        wp_localize_script( 'kt_image', 'kt_image_lange', array(
            'frameTitle' => esc_html__('Select your image', 'aquila' )
        ));

        wp_register_script( 'framework-core', FW_JS.'framework-core.js', array('jquery', 'jquery-ui-tabs'), FW_VER, true);
        wp_enqueue_script('framework-core');

    } // End kt_admin_enqueue_scripts.
    add_action( 'admin_enqueue_scripts', 'kt_admin_enqueue_scripts' );
}

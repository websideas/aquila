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
        wp_enqueue_style( 'kt-font-awesome', KT_THEME_LIBS.'font-awesome/css/font-awesome.min.css');
        wp_enqueue_style( 'framework-core', KT_FW_CSS.'framework-core.css');
        wp_enqueue_style( 'chosen', KT_FW_LIBS.'chosen/chosen.min.css');

        wp_enqueue_script( 'kt_image', KT_FW_JS.'kt_image.js', array('jquery'), KT_FW_VER, true);
        wp_enqueue_script( 'chosen', KT_FW_LIBS.'chosen/chosen.jquery.min.js', array('jquery'), KT_FW_VER, true);
        wp_enqueue_script( 'cookie', KT_FW_JS.'jquery.cookie.js', array('jquery'), KT_FW_VER, true);
        wp_enqueue_script( 'showhide_metabox', KT_FW_JS.'kt_showhide_metabox.js', array('jquery'), KT_FW_VER, true);
        wp_enqueue_script( 'kt_icons', KT_FW_JS.'kt_icons.js', array('jquery'), KT_FW_VER, true);
        wp_enqueue_script( 'kt_image', KT_FW_JS.'kt_image.js', array('jquery'), KT_FW_VER, true);


        wp_enqueue_media();
        wp_localize_script( 'kt_image', 'kt_image_lange', array(
            'frameTitle' => esc_html__('Select your image', 'adroit' )
        ));

        wp_register_script( 'framework-core', KT_FW_JS.'framework-core.js', array('jquery', 'jquery-ui-tabs'), KT_FW_VER, true);
        wp_enqueue_script('framework-core');

    } // End kt_admin_enqueue_scripts.
    add_action( 'admin_enqueue_scripts', 'kt_admin_enqueue_scripts' );
}



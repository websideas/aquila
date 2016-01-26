<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



add_filter( 'kt_import_demo', 'kt_import_demo_adroit' );
function kt_import_demo_adroit( $demos ){
    $demos['demo1'] = array(
        'title' => 'Classic',
        'previewlink' => 'http://adroit.kitethemes.com/',
        'xml_count' => 1,
        'status' => sprintf(
            '<span class="%s">%s</span>',
            'demo-main',
            __('Main', 'adroit')
        )
    );

    return $demos;
}


if ( !function_exists( 'kt_extended_imported' ) ) {

    function kt_extended_imported( $demoid ) {


        /************************************************************************
         * Setting Menus
         *************************************************************************/

        $main_menu = get_term_by( 'name', __('Main menu', 'adroit'), 'nav_menu' );
        $mobile = get_term_by( 'name', __('Main Menu', 'adroit'), 'nav_menu' );
        $footer = get_term_by( 'name', __('Footer Navigation Menu', 'adroit'), 'nav_menu' );

        // array of demos/homepages to check/select from
        $kt_menus = array(
            'demo1' => array(
                'primary' => $main_menu->term_id,
                'mobile' => $mobile->term_id,
                'footer' => $footer->term_id
            ),
        );

        if ( isset( $kt_menus[$demoid]  ) ) {
            set_theme_mod( 'nav_menu_locations',$kt_menus[$demoid]);
        }


        /************************************************************************
         * Set HomePage
         *************************************************************************/

        // array of demos/homepages to check/select from
        $kt_home_pages = array(
            'demo1' => 'Home',
        );

        if ( isset( $kt_home_pages[$demoid]  ) ) {
            $page = get_page_by_title( $kt_home_pages[$demoid] );
            if ( isset( $page->ID ) ) {
                update_option( 'page_on_front', $page->ID );
                update_option( 'show_on_front', 'page' );
            }
        }

        /************************************************************************
         * Set Posts page
         *************************************************************************/

        // array of demos/Posts page to check/select from
        $kt_posts_pages = array(
            'demo1' => 'Blog',
        );

        if ( isset( $kt_posts_pages[$demoid]  ) ) {
            $page = get_page_by_title( $kt_posts_pages[$demoid] );
            if ( isset( $page->ID ) ) {
                update_option( 'page_for_posts', $page->ID );
            }
        }

    }
    add_action( 'kt_importer_after_content_import', 'kt_extended_imported');
}




function kt_importer_dir_adroit( ) {
    return KT_THEME_DATA_DIR.'/';
}
add_filter('kt_importer_dir', 'kt_importer_dir_adroit' );

function kt_importer_url_adroit( ) {

    return KT_THEME_DATA.'/';
}
add_filter('kt_importer_url', 'kt_importer_url_adroit' );

function kt_importer_opt_name_adroit(  ) {
    return KT_THEME_OPTIONS;
}
add_filter('kt_importer_opt_name', 'kt_importer_opt_name_adroit' );
<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/************************************************************************
* Extended Example:
* Way to set menu, import revolution slider, and set home page.
*************************************************************************/

if ( !function_exists( 'kt_wbc_extended_imported' ) ) {
    /**
     *
     *
     * @param $demo_active_import
     * @param $demo_directory_path
     */
	function kt_wbc_extended_imported( $demo_active_import , $demo_directory_path ) {

		reset( $demo_active_import );
		$current_key = key( $demo_active_import );

		/************************************************************************
		* Import slider(s) for the current demo being imported
		*************************************************************************/

		if ( class_exists( 'RevSlider' ) ) {

			$wbc_sliders_array = array(
                
			);

            foreach( $wbc_sliders_array as $k => $wbc_slider_import ){
                $revslider = THEME_DIR.'dummy-data/revslider/'.$wbc_slider_import;
                if ( file_exists( $revslider ) ) {
                    $slider = new RevSlider();
                    $slider->importSliderFromPost( true, true, $revslider );
                }
            }

        }

        /************************************************************************
         * Setting Menus
         *************************************************************************/

        $main_menu = get_term_by( 'name', esc_html__('Main menu', 'aquila'), 'nav_menu' );
        $mobile = get_term_by( 'name', esc_html__('(Mobile Devices) Main Navigation Menu', 'aquila'), 'nav_menu' );
        $footer_menu = get_term_by( 'name', esc_html__('Footer Navigation Menu', 'aquila'), 'nav_menu' );
        $bottom = get_term_by( 'name', esc_html__('Bottom Menu', 'aquila'), 'nav_menu' );

        set_theme_mod( 'nav_menu_locations', array(
                'primary' => $main_menu->term_id,
                'mobile'  => $main_menu->term_id,
                'footer'  => $footer_menu->term_id,
                'bottom'  => $bottom->term_id
            )
        );

        /************************************************************************
         * Set HomePage
         *************************************************************************/

        // array of demos/homepages to check/select from
        $wbc_home_pages = array(
            'demo1' => 'Home'
        );

        if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
            $page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
            if ( isset( $page->ID ) ) {
                update_option( 'page_on_front', $page->ID );
                update_option( 'show_on_front', 'page' );
            }
        }

    }
    add_action( 'wbc_importer_after_content_import', 'kt_wbc_extended_imported', 10, 2 );
}




if(!function_exists('wbc_change_demo_directory_path')){
    /**
     * Change the path to the directory that contains demo data folders.
     *
     * @param [string] $demo_directory_path
     *
     * @return [string]
     */

    function wbc_change_demo_directory_path( $demo_directory_path ) {
        $demo_directory_path = THEME_DIR.'dummy-data/';
        return $demo_directory_path;
    }
    add_filter('wbc_importer_dir_path', 'wbc_change_demo_directory_path' );
}

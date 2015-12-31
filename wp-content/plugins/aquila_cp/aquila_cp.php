<?php
/*
Plugin Name:  Aquila Custom Post
Plugin URI:   http://kitethemes.com/
Description:  Theme Aquila Custom Post
Version:      1.1
Author:       KiteThemes
Author URI:   http://themeforest.net/user/kite-themes

Copyright (C) 2014-2015, by Cuongdv
All rights reserved.
*/


add_action( 'init', 'register_kt_testimonial_init' );
function register_kt_testimonial_init(){
    $labels = array(
        'name'               => __( 'Post Slider', 'aquila_cp' ),
        'singular_name'      => __( 'Post Slider', 'aquila_cp' ),
        'add_new'            => __( 'Add New Slider', 'slide', 'aquila_cp' ),
        'add_new_item'       => __( 'Add New Slider', 'aquila_cp' ),
        'edit_item'          => __( 'Edit Slider', 'aquila_cp' ),
        'new_item'           => __( 'New Slider', 'aquila_cp' ),
        'view_item'          => __( 'View Slider', 'aquila_cp' ),
        'search_items'       => __( 'Search Sliders', 'aquila_cp' ),
        'not_found'          => __( 'No slider have been added yet', 'aquila_cp' ),
        'not_found_in_trash' => __( 'Nothing found in Trash', 'aquila_cp' ),
        'parent_item_colon'  => ''
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'exclude_from_search' => true,
        'menu_icon'           => 'dashicons-format-image',
        'hierarchical'        => false,
        'rewrite'             => false,
        'supports'            => array( 'title'),
        'has_archive'         => true,
    );

    register_post_type( 'kt-post-slider', $args );
}


/**
 * Remove Rev Slider Metabox
 */
if ( is_admin() ) {

    function remove_revolution_slider_meta_boxes() {
        remove_meta_box( 'mymetabox_revslider_0', 'page', 'normal' );
        remove_meta_box( 'mymetabox_revslider_0', 'post', 'normal' );
        remove_meta_box( 'mymetabox_revslider_0', 'kt-post-slider', 'normal' );
    }
    add_action( 'do_meta_boxes', 'remove_revolution_slider_meta_boxes' );

}
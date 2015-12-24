<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/** 
 * Widget content
 * 
 */

if ( function_exists('register_sidebar')) {

    function kt_register_sidebars(){

        register_sidebar( array(
            'name' => __( 'Primary Widget Area', THEME_LANG),
            'id' => 'primary-widget-area',
            'description' => __( 'The primary widget area', THEME_LANG),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s"><div class="widget-inner">',
            'after_widget' => '</div></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );

        register_sidebar( array(
            'name' => __( 'Side Area', THEME_LANG),
            'id' => 'side-widget-area',
            'description' => __( 'The side widget area', THEME_LANG),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );

        $count = 5;

        for($i=1; $i<=$count;$i++){
            register_sidebar( array(
                'name' => __( 'Sidebar '.$i, THEME_LANG),
                'id' => 'sidebar-column-'.$i,
                'description' => __( 'The sidebar column '.$i.' widget area', THEME_LANG),
                'before_widget' => '<div class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ) );
        }

        register_sidebar(array(
            'name' => __( 'Instagram Footer', THEME_LANG),
            'id' => 'instagram-footer',
            'before_widget' => '<div id="%1$s" class="instagram-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="instagram-title">',
            'after_title' => '</h4>',
            'description' => __('Use the Instagram widget here. IMPORTANT: For best result select "Large" under "Photo Size" and set number of photos to 6.', THEME_LANG),
        ));

        register_sidebar( array(
            'name' => __( 'Footer top', THEME_LANG),
            'id' => 'footer-top',
            'description' => __( 'The footer top widget area', THEME_LANG),
            'before_widget' => '<div id="%1$s" class="widget-container clearfix %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ) );


        $count = 4;

        for($i=1; $i<=$count;$i++){
            register_sidebar( array(
                'name' => __( 'Footer column '.$i, THEME_LANG),
                'id' => 'footer-column-'.$i,
                'description' => __( 'The footer column '.$i.' widget area', THEME_LANG),
                'before_widget' => '<div id="%1$s" class="widget-footer %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ) );
        }

        register_sidebar( array(
            'name' => __( 'Footer bottom column 1', THEME_LANG),
            'id' => 'footer-bottom-1',
            'description' => __( 'The footer bottom widget area', THEME_LANG),
            'before_widget' => '<div id="%1$s" class="widget-footer-bottom %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<!--',
            'after_title' => '-->',
        ) );

        register_sidebar( array(
            'name' => __( 'Footer bottom column 2', THEME_LANG),
            'id' => 'footer-bottom-2',
            'description' => __( 'The footer bottom widget area', THEME_LANG),
            'before_widget' => '<div id="%1$s" class="widget-footer-bottom %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<!--',
            'after_title' => '-->',
        ) );


        $sidebars =  kt_option('custom_sidebars');
        if( !empty( $sidebars ) && is_array( $sidebars ) ){
            foreach( $sidebars as $sidebar ){
                $sidebar =  wp_parse_args($sidebar, array('title'=>'','description'=>''));
                if(  $sidebar['title'] !='' ){
                    $id = sanitize_title( $sidebar['title'] );
                    register_sidebar( array(
                        'name' => $sidebar['title'],
                        'id' => $id,
                        'description' => $sidebar['description'],
                        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    ) );

                }
            }
        }

    }

    add_action( 'widgets_init', 'kt_register_sidebars' );

}

/**
 * This code filters the categories widget to include the post count inside the link
 */
 

add_filter('wp_list_categories', 'kt_cat_count_span');
function kt_cat_count_span($links) {

    if (strpos($links, '</a>') !== false) {
        $links = str_replace('</a> (', ' <span>(', $links);
        $links = str_replace('</a> <', ' <', $links);
        $links = str_replace(')', ')</span></a>', $links);
        $links = str_replace('</a></span>', '</a>', $links);
    }

    
    return $links;
}

/**
 * This code filters the Archive widget to include the post count inside the link
 */

add_filter('get_archives_link', 'kt_archive_count_span');
function kt_archive_count_span($links) {
    if ( strpos($links, '</a>') !== false ) {
        $links = str_replace('</a>&nbsp;(', ' <span>(', $links);
        $links = str_replace(')', ')</span></a>', $links);
    }
    return $links;
}

/**
 * Include widgets.
 *
 */

/* Widgets list */
$kt_widgets = array(
	'kt_image.php',
    'kt_facebook.php',
    'kt_googleplus.php',
    'kt_article.php',
    'kt_widget_tabs.php',
    'kt_ads.php',
    'kt_flickr.php',
    'kt_popular.php',
    'kt_aboutme.php',
    'kt_socials.php',
    'kt_contactinfo.php',
);

foreach ( $kt_widgets as $widget ) {
	require_once( FW_WIDGETS . $widget );

}



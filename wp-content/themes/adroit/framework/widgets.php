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
            'name' => esc_html__( 'Primary Widget Area', 'adroit'),
            'id' => 'primary-widget-area',
            'description' => esc_html__( 'The primary widget area', 'adroit'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s"><div class="widget-inner">',
            'after_widget' => '</div></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );

        register_sidebar( array(
            'name' => esc_html__( 'Blog Widget Area', 'adroit'),
            'id' => 'blog-widget-area',
            'description' => esc_html__( 'The blog widget area', 'adroit'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s"><div class="widget-inner">',
            'after_widget' => '</div></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );

        register_sidebar( array(
            'name' => esc_html__( 'Side Area', 'adroit'),
            'id' => 'side-widget-area',
            'description' => esc_html__( 'The side widget area', 'adroit'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s"><div class="widget-inner">',
            'after_widget' => '</div></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );

        register_sidebar( array(
            'name' => esc_html__( 'Promo Area', 'adroit'),
            'id' => 'promo-area',
            'description' => esc_html__( 'IMPORTANT: For best result select set number of widget to 3.', 'adroit'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s"><div class="widget-inner">',
            'after_widget' => '</div></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );

        $count = 5;

        for($i=1; $i<=$count;$i++){
            register_sidebar( array(
                'name' => sprintf(esc_html__( 'Sidebar %s', 'adroit'), $i) ,
                'id' => 'sidebar-column-'.$i,
                'description' => sprintf(esc_html__( 'The sidebar column %s widget area', 'adroit'),$i),
                'before_widget' => '<div class="widget-container %2$s"><div class="widget-inner">',
                'after_widget' => '</div></div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ) );
        }

        register_sidebar(array(
            'name' => esc_html__( 'Instagram Footer', 'adroit'),
            'id' => 'instagram-footer',
            'before_widget' => '<div id="%1$s" class="instagram-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="instagram-title">',
            'after_title' => '</h4>',
            'description' => esc_html__('Use the Instagram widget here. IMPORTANT: For best result select "Small" under "Photo Size" and set number of photos to 6.', 'adroit'),
        ));

        register_sidebar( array(
            'name' => esc_html__( 'Footer top', 'adroit'),
            'id' => 'footer-top',
            'description' => esc_html__( 'The footer top widget area', 'adroit'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s"><div class="widget-inner">',
            'after_widget' => '</div></div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ) );


        $count = 4;

        for($i=1; $i<=$count;$i++){
            register_sidebar( array(
                'name' => sprintf(esc_html__( 'Footer column %s', 'adroit'), $i) ,
                'id' => 'footer-column-'.$i,
                'description' => sprintf(esc_html__( 'The footer column %s widget area', 'adroit'),$i),
                'before_widget' => '<div id="%1$s" class="widget-container %2$s"><div class="widget-inner">',
                'after_widget' => '</div></div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ) );
        }

        register_sidebar( array(
            'name' => esc_html__( 'Footer bottom column 1', 'adroit'),
            'id' => 'footer-bottom-1',
            'description' => esc_html__( 'The footer bottom widget area', 'adroit'),
            'before_widget' => '<div id="%1$s" class="widget-footer-bottom %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<!--',
            'after_title' => '-->',
        ) );

        register_sidebar( array(
            'name' => esc_html__( 'Footer bottom column 2', 'adroit'),
            'id' => 'footer-bottom-2',
            'description' => esc_html__( 'The footer bottom widget area', 'adroit'),
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
                        'before_widget' => '<div id="%1$s" class="widget-container %2$s"><div class="widget-inner">',
                        'after_widget' => '</div></div>',
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
    'kt_article_carousel.php',
    'kt_widget_tabs.php',
    'kt_ads.php',
    'kt_flickr.php',
    'kt_popular.php',
    'kt_aboutme.php',
    'kt_socials.php',
    'kt_contactinfo.php',
    'kt_promo.php',
);

foreach ( $kt_widgets as $widget ) {
	require_once( KT_FW_WIDGETS . $widget );

}
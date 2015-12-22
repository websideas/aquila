<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Flag boolean.
 *
 * @param $input string
 * @return boolean
 */
function kt_sanitize_boolean( $input = '' ) {
    $input = (string)$input;
    return in_array($input, array('1', 'true', 'y', 'on'));
}
add_filter( 'sanitize_boolean', 'kt_sanitize_boolean', 15 );




/**
 * Add class to next button
 *
 * @param string $attr
 * @return string
 */
function kt_next_posts_link_attributes( $attr = '' ) {
    return "class='btn btn-default'";
}
add_filter( 'next_posts_link_attributes', 'kt_next_posts_link_attributes', 15 );


/**
 * Add class to prev button
 *p
 * @param string $attr
 * @return string
 */
function kt_previous_posts_link_attributes( $attr = '' ) {
    return "class='btn btn-default'";
}
add_filter( 'previous_posts_link_attributes', 'kt_previous_posts_link_attributes', 15 );



if ( ! function_exists( 'kt_track_post_views' ) ){
    /**
     * Track post views
     *
     * @param $post_id
     */
    function kt_track_post_views ($post_id) {

        if('post' == get_post_type() && is_single()) {
            if ( empty ( $post_id) ) {
                global $post;
                $post_id = $post->ID;
            }
            
            $count_key = 'kt_post_views_count';
            $count = get_post_meta($post_id, $count_key, true);
            if($count==''){
                $count = 0;
                delete_post_meta($post_id, $count_key);
                add_post_meta($post_id, $count_key, '0');
            }else{
                $count++;
                update_post_meta($post_id, $count_key, $count);
            }
        }
    }
}
add_action( 'wp_head', 'kt_track_post_views');

/**
 * Get settings archive
 *
 * @return array
 */
function kt_get_settings_archive(){
    if(is_author()){
        $settings = array(
            'blog_type' => kt_option('author_loop_style', 'classic'),
            'blog_columns' => kt_option('author_columns', 2),
            'blog_columns_tablet' => kt_option('author_columns_tablet', 2),
            'readmore' => kt_option('author_readmore', 'link'),
            'blog_pagination' => kt_option('author_pagination', 'classic'),
            'thumbnail_type' => kt_option('author_thumbnail_type', 'image'),
            'sharebox' => kt_option('author_sharebox', 1),
            'align' => kt_option('author_align', 'left'),
            'show_excerpt' => kt_option('author_excerpt', 1),
            'excerpt_length' => kt_option('author_excerpt_length', 30),
            'show_meta' => kt_option('author_meta', 1),
            'show_author' => kt_option('author_meta_author', 1),
            'show_category' => kt_option('author_meta_categories', 1),
            'show_comment' => kt_option('author_meta_comments', 1),
            'show_date' => kt_option('author_meta_date', 1),
            'date_format' => kt_option('author_date_format', 1),
            'show_like_post' => kt_option('author_like_post', 0),
            'show_view_number' => kt_option('author_view_number', 0),
            'image_size' => kt_option('author_image_size', 'blog_post'),
            'max_items' => get_option('posts_per_page')
        );
    }else{
        $settings = array(
            'blog_type' => kt_option('archive_loop_style', 'classic'),
            'blog_columns' => kt_option('archive_columns', 2),
            'blog_columns_tablet' => kt_option('archive_columns_tablet', 2),
            'readmore' => kt_option('archive_readmore', 'link'),
            'blog_pagination' => kt_option('archive_pagination', 'classic'),
            'thumbnail_type' => kt_option('archive_thumbnail_type', 'image'),
            'sharebox' => kt_option('archive_sharebox', 1),
            'align' => kt_option('archive_align', 'left'),
            'show_excerpt' => kt_option('archive_excerpt', 1),
            'excerpt_length' => kt_option('archive_excerpt_length', 30),
            'show_meta' => kt_option('archive_meta', 1),
            'show_author' => kt_option('archive_meta_author', 1),
            'show_category' => kt_option('archive_meta_categories', 1),
            'show_comment' => kt_option('archive_meta_comments', 1),
            'show_date' => kt_option('archive_meta_date', 1),
            'date_format' => kt_option('archive_date_format', 1),
            'show_like_post' => kt_option('archive_like_post', 0),
            'show_view_number' => kt_option('archive_view_number', 0),
            'image_size' => kt_option('archive_image_size', 'blog_post'),
            'max_items' => get_option('posts_per_page')
        );
    }
    return $settings;
}

/**
 * Get settings search
 *
 * @return array
 */
function kt_get_settings_search(){
    return array(
        'blog_type' => kt_option('search_loop_style', 'classic'),
        'blog_columns' => kt_option('search_columns', 3),
        'blog_columns_tablet' => kt_option('search_columns_tablet', 2),
        'align' => kt_option('archive_align', 'left'),
        'readmore' => kt_option('search_readmore', 'link'),
        'blog_pagination' => kt_option('search_pagination', 'classic'),
        'thumbnail_type' => kt_option('search_thumbnail_type', 'image'),
        'sharebox' => kt_option('search_sharebox', 0),
        'show_excerpt' => kt_option('search_excerpt', 1),
        'excerpt_length' => kt_option('search_excerpt_length', 30),
        'show_meta' => kt_option('search_meta', 1),
        'show_author' => kt_option('search_meta_author', 1),
        'show_category' => kt_option('search_meta_categories', 1),
        'show_comment' => kt_option('search_meta_comments', 1),
        'show_date' => kt_option('search_meta_date', 1),
        'date_format' => kt_option('search_date_format', 1),
        'show_like_post' => kt_option('search_like_post', 0),
        'show_view_number' => kt_option('search_view_number', 0),
        'image_size' => kt_option('search_image_size', 'blog_post'),
        'max_items' => get_option('posts_per_page'),

    );
}


/**
 * Extend the default WordPress body classes.
 *
 * @since 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function theme_body_classes( $classes ) {
    global $post;
    
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }
    
    /*
    if( is_page() || is_singular('post')){
        $classes[] = 'layout-'.kt_getlayout($post->ID);
        $classes[] = rwmb_meta('_kt_extra_page_class');
    }elseif(is_archive()){
        $classes[] = 'layout-'.kt_option('layout', 'boxed');
    }else{
        $classes[] = 'layout-'.kt_option('layout', 'boxed');
    }
    */

    //$classes[] = 'layout-boxed';
    return $classes;
}
add_filter( 'body_class', 'theme_body_classes' );




/**
 * Add class layout for main class
 *
 * @since 1.0
 *
 * @param string $classes current class
 * @param string $layout layout current of page 
 *  
 * @return array The filtered body class list.
 */
function kt_main_class_callback($classes, $layout){
    
    if($layout == 'left' || $layout == 'right'){
        $classes .= ' col-md-8 col-sm-12 col-xs-12';
    }else{
        $classes .= ' col-md-12 col-xs-12';
    }
    
    if($layout == 'left'){
         $classes .= ' pull-right';
    }
    return $classes;
}
add_filter('kt_main_class', 'kt_main_class_callback', 10, 2);


/**
 * Add class layout for sidebar class
 *
 * @since 1.0
 *
 * @param string $classes current class
 * @param string $layout layout current of page 
 *  
 * @return array The filtered body class list.
 */
function kt_sidebar_class_callback( $classes, $layout ){
    if($layout == 'left' || $layout == 'right'){
        $classes .= ' col-md-4 col-sm-12 col-xs-12';
    }
    return $classes;
}
add_filter('kt_sidebar_class', 'kt_sidebar_class_callback', 10, 2);



/**
 * Add class sticky to header
 */
function theme_header_class_callback($classes, $layout){
    $fixed_header = kt_option('fixed_header', 2);
    if($fixed_header == 2 || $fixed_header == 3 ){
        $classes .= ' sticky-header';
        if($fixed_header == 3){
            $classes .= ' sticky-header-down';
        }
    }

    $header_shadow = kt_option('header_shadow', true);
    if($header_shadow){
        $classes .= ' header-shadow';
    }

    if($layout == 'layout1' || $layout == 'layout2'){
        $classes .= ' header-layout-normal';
    }

    return $classes;
}

add_filter('theme_header_class', 'theme_header_class_callback', 10, 2);


/**
 * Add class sticky to header
 */
function theme_header_content_class_callback( $classes, $layout ){

    if(kt_option('header_full', 1)){
        $classes .= ' header-fullwidth';
    }


    return $classes;
}

add_filter('theme_header_content_class', 'theme_header_content_class_callback', 10, 2);

/**
 * Add slideshow header
 *
 * @since 1.0
 */
add_action( 'kt_slideshows_position', 'kt_slideshows_position_callback' );
function kt_slideshows_position_callback(){
    if(is_page() || is_singular()){
        kt_show_slideshow();
    }
}

add_action( 'comment_form_before_fields', 'kt_comment_form_before_fields', 1 );
function kt_comment_form_before_fields(){
    echo '<div class="comment-form-fields clearfix">';
}



/*
 * Add social media to author
 */

function kt_contactmethods( $contactmethods ) {

    // Add Twitter, Facebook
    $contactmethods['facebook'] = __('Facebook page/profile url', THEME_LANG);
    $contactmethods['twitter'] = __('Twitter username (without @)', THEME_LANG);
    $contactmethods['pinterest'] = __('Pinterest username', THEME_LANG);
    $contactmethods['googleplus'] = __('Google+ page/profile URL', THEME_LANG);
    $contactmethods['instagram'] = __('Instagram username', THEME_LANG);
    $contactmethods['behance'] = __('Behance username', THEME_LANG);
    $contactmethods['tumblr'] = __('Tumblr username', THEME_LANG);
    $contactmethods['dribbble'] = __('Dribbble username', THEME_LANG);

    return $contactmethods;
}
add_filter( 'user_contactmethods','kt_contactmethods', 10, 1 );


if(!function_exists('kt_placeholder_callback')) {
    /**
     * Return PlaceHolder Image
     * @param string $size
     * @return string
     */
    function kt_placeholder_callback($size = '')
    {

        $placeholder = kt_option('archive_placeholder');
        if(is_array($placeholder) && $placeholder['id'] != '' ){
            $obj = get_thumbnail_attachment($placeholder['id'], $size);
            $imgage = $obj['url'];
        }elseif($size == 'blog_post' || $size == 'blog_post_sidebar'){
            $imgage = THEME_IMG . 'placeholder-blogpost.png';
        }else{
            $imgage = THEME_IMG . 'placeholder-post.png';
        }

        return $imgage;
    }
    add_filter('kt_placeholder', 'kt_placeholder_callback');
}


if ( ! function_exists( 'kt_excerpt_more' ) ) :
    /**
     * Replaces "[...]" (appended to automatically generated excerpts) with ...
     *
     * @param string $more Default Read More excerpt link.
     * @return string Filtered Read More excerpt link.
     */
    function kt_excerpt_more( $more ) {
        return ' &hellip; ';
    }
    add_filter( 'excerpt_more', 'kt_excerpt_more' );
endif;


add_filter( 'the_content_more_link', 'kt_modify_read_more_link', 10, 2 );
function kt_modify_read_more_link( $link, $more_link_text ) {
    return '';
}


if ( ! function_exists( 'kt_page_loader' ) ) :
    /**
     * Add page loader to frontend
     *
     */
    function kt_page_loader(){
        $use_loader = kt_option( 'use_page_loader',1 );
        if( $use_loader ){
            $layout_loader = kt_option( 'layout_loader', 'style-1' );
            ?>
            <div class="kt_page_loader <?php echo esc_attr($layout_loader); ?>">
                <div class="page_loader_inner">
                    <div class="kt_spinner"></div>
                </div>
            </div>
        <?php }
    }
    add_action( 'theme_body_top', 'kt_page_loader');
endif;



function add_search_full(){
    if(kt_option('header_search', 1)){

        if(kt_is_wc()){
            $search = get_product_search_form(false);
        }else{
            $search = get_search_form(false);
        }

        printf(
            '<div id="%1$s" class="%2$s">%3$s</div>',
            'search-fullwidth',
            'mfp-hide mfp-with-anim',
            $search
        );
    }
}
add_action('theme_body_top', 'add_search_full');


//Remove Facebook comment box in the content
remove_filter ('the_content', 'fbcommentbox', 100);



add_filter('navigation_markup_template', 'kt_navigation_markup_template', 10, 2);
function kt_navigation_markup_template($template, $class){
    $disable_next = $disable_prev = '';
    if ( !get_previous_posts_link() ) {
        $disable_prev = '<span class="page-numbers prev disable">'._x( 'Previous', 'previous post' ).'</span>';
    }
    if ( !get_next_posts_link() ) {
        $disable_next = '<span class="page-numbers next disable">'._x( 'Next', 'next post' ).'</span>';
    }

    $template = '
	<nav class="navigation %1$s" role="navigation">
		<h2 class="screen-reader-text">%2$s</h2>
		<div class="nav-links">'.$disable_prev.'%3$s'.$disable_next.'</div>
	</nav>';
    return $template;
}





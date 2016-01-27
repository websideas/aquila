<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Flag boolean.
 *
 * @param $input string
 * @return boolean
 */
function kt_sanitize_boolean_callback( $input = '' ) {
    $input = (string)$input;
    return in_array($input, array('1', 'true', 'y', 'on'));
}
add_filter( 'kt_sanitize_boolean', 'kt_sanitize_boolean_callback', 15 );




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
            if($count == ''){
                delete_post_meta($post_id, $count_key);
                add_post_meta($post_id, $count_key, 0);
            }else{
                $count++;
                update_post_meta($post_id, $count_key, $count);
            }
        }
    }
}
add_action( 'wp_head', 'kt_track_post_views');



/**
 * Extend the default WordPress body classes.
 *
 * @since 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function kt_body_classes( $classes ) {
    global $post;

    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    if( is_page() || is_singular('post')){
        $classes[] = 'layout-'.kt_getlayout($post->ID);
        $classes[] = rwmb_meta('_kt_extra_page_class');

        if(is_page_template( 'frontpage.php' )){
            $content = get_post_meta($post->ID, '_kt_frontpage_content', true);
            if($content){
                $slideshow_type = get_post_meta($post->ID, '_kt_slideshow_type', true);
                if($slideshow_type == 'postslider'){
                    $slideshow_style = get_post_meta($post->ID, '_kt_slideshow_posts_style', true);
                    $classes[] = 'page-postslider-'.$slideshow_style;
                }
            }
        }

    }else{
        $classes[] = 'layout-'.kt_option('layout', 'boxed');
    }

    return $classes;
}
add_filter( 'body_class', 'kt_body_classes' );

/**
 * Add class sticky to header
 */
function kt_header_class_callback($classes, $layout){
    global $post;

    $fixed_header = kt_option('fixed_header', 2);
    if($fixed_header == 2 || $fixed_header == 3 ){
        $classes .= ' sticky-header';
        if($fixed_header == 3){
            $classes .= ' sticky-header-down';
        }
    }
    $header_shadow = '';



    if($layout == 1){
        if(is_page() || is_singular()){
            $post_id = $post->ID;
            $header_shadow = rwmb_meta('_kt_header_shadow', array(), $post_id);
            if($header_shadow == ''){
                $header_shadow = kt_option('header_shadow', true);
            }
        }else{
            $header_shadow = kt_option('header_shadow', true);
        }
    }else{
        $header_shadow = kt_option('header_shadow', true);
    }

    if($header_shadow == 'on' || $header_shadow === true || $header_shadow == 1){
        $classes .= ' header-shadow';
    }

    if($layout == 1 || $layout == 2){
        $classes .= ' header-layout-normal';
    }

    return $classes; 
}

add_filter('kt_header_class', 'kt_header_class_callback', 10, 2);


/**
 * Add slideshow header
 *
 * @since 1.0
 */
add_action( 'kt_slideshows_position', 'kt_slideshows_position_callback' );
function kt_slideshows_position_callback(){

    if(is_page()){
        kt_show_slideshow();
    }elseif(is_singular('post')){
        $layout = kt_post_option(null, '_kt_blog_post_layout', 'single_layout', 1, false);
        if( ! post_password_required( ) && $layout == 3 ){
            echo '<div class="entry-thumb-fullwidth">';
            kt_post_thumbnail('full', 'img-responsive', false);
            echo '</div>';
        }
    }
}

/**
 * Add CustomCss
 **/

add_action('wp_enqueue_scripts', 'kt_addFrontCss', 1000);
function kt_addFrontCss( $post_id = null ){

    if(is_page()){
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        if ( $post_id ) {
            if($page_id = rwmb_meta('_kt_slideshow_page', array(), $post_id)){
                $shortcodes_custom_css = get_post_meta( $page_id, '_wpb_shortcodes_custom_css', true );
            }
        }
    }elseif(is_404()){
        if($page_id = kt_option('notfound_page_id')){
            $shortcodes_custom_css = get_post_meta( $page_id, '_wpb_shortcodes_custom_css', true );
        }
    }
    if ( ! empty( $shortcodes_custom_css ) ) {
        $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
        wp_add_inline_style( 'kt-main', $shortcodes_custom_css );
    }
}


/**
 * Add div before fields
 */
add_action( 'comment_form_before_fields', 'kt_comment_form_before_fields', 1 );
function kt_comment_form_before_fields(){
    echo '<div class="comment-form-fields clearfix">';
}


/*
 * Add social media to author
 */

function kt_contactmethods( $contactmethods ) {

    // Add Twitter, Facebook
    $contactmethods['facebook'] = __('Facebook page/profile url', 'adroit');
    $contactmethods['twitter'] = __('Twitter username (without @)', 'adroit');
    $contactmethods['pinterest'] = __('Pinterest username', 'adroit');
    $contactmethods['googleplus'] = __('Google+ page/profile URL', 'adroit');
    $contactmethods['instagram'] = __('Instagram username', 'adroit');
    $contactmethods['behance'] = __('Behance username', 'adroit');
    $contactmethods['tumblr'] = __('Tumblr username', 'adroit');
    $contactmethods['dribbble'] = __('Dribbble username', 'adroit');

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
            $obj = kt_get_thumbnail_attachment($placeholder['id'], $size);
            $imgage = $obj['url'];
        }elseif($size == 'kt_recent_posts' || $size == 'kt_recent_posts_masonry') {
            $imgage = KT_THEME_IMG . 'placeholder-recent.jpg';
        }elseif ($size == 'kt_blog_post' || $size == 'kt_blog_post_sidebar'){
            $imgage = KT_THEME_IMG . 'placeholder-blogpost.jpg';
        }else{
            $imgage = KT_THEME_IMG . 'placeholder-post.jpg';
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
    add_action( 'kt_body_top', 'kt_page_loader');
endif;

function kt_add_socials_mobile(){
    $social = kt_option('footer_socials');

    $socials_arr = array(
        'facebook' => array('title' => esc_html__('Facebook', 'adroit'), 'icon' => 'fa fa-facebook', 'link' => '%s'),
        'twitter' => array('title' => esc_html__('Twitter', 'adroit'), 'icon' => 'fa fa-twitter', 'link' => 'http://www.twitter.com/%s'),
        'dribbble' => array('title' => esc_html__('Dribbble', 'adroit'), 'icon' => 'fa fa-dribbble', 'link' => 'http://www.dribbble.com/%s'),
        'vimeo' => array('title' => esc_html__('Vimeo', 'adroit'), 'icon' => 'fa fa-vimeo-square', 'link' => 'http://www.vimeo.com/%s'),
        'tumblr' => array('title' => esc_html__('Tumblr', 'adroit'), 'icon' => 'fa fa-tumblr', 'link' => 'http://%s.tumblr.com/'),
        'skype' => array('title' => esc_html__('Skype', 'adroit'), 'icon' => 'fa fa-skype', 'link' => 'skype:%s'),
        'linkedin' => array('title' => esc_html__('LinkedIn', 'adroit'), 'icon' => 'fa fa-linkedin', 'link' => '%s'),
        'googleplus' => array('title' => esc_html__('Google Plus', 'adroit'), 'icon' => 'fa fa-google-plus', 'link' => '%s'),
        'youtube' => array('title' => esc_html__('Youtube', 'adroit'), 'icon' => 'fa fa-youtube', 'link' => 'http://www.youtube.com/user/%s'),
        'pinterest' => array('title' => esc_html__('Pinterest', 'adroit'), 'icon' => 'fa fa-pinterest', 'link' => 'http://www.pinterest.com/%s'),
        'instagram' => array('title' => esc_html__('Instagram', 'adroit'), 'icon' => 'fa fa-instagram', 'link' => 'http://instagram.com/%s'),
    );
    
    foreach($socials_arr as $k => &$v){
        $val = kt_option($k);
        $v['val'] = ($val) ? $val : '';
    }
    $social_icons = '';
    if($social){
        $social_type = explode(',', $social);
        foreach ($social_type as $id) {
            $val = $socials_arr[$id];
            $social_text = '<i class="'.esc_attr($val['icon']).'"></i>';
            $social_icons .= '<a class="'.esc_attr($id).'" title="'.esc_attr($val['title']).'" href="'.esc_url(str_replace('%s', $val['val'], $val['link'])).'" target="_blank">'.$social_text.'</a>';
        }
    }else{
        foreach($socials_arr as $key => $val){
            $social_text = '<i class="'.esc_attr($val['icon']).'"></i>';
            $social_icons .= '<a class="'.esc_attr($key).'" title="'.esc_attr($val['title']).'" href="'.esc_url(str_replace('%s', $val['val'], $val['link'])).'" target="_blank">'.$social_text.'</a>';
        }
    }

    printf(
        '<div id="%1$s" class="%2$s"><div class="main-nav-socials">%3$s</div></div>',
        'socials-mobile',
        'mfp-hide mfp-with-anim',
        $social_icons
    );
}
add_action('kt_body_top', 'kt_add_socials_mobile', 10);


//Remove Facebook comment box in the content
remove_filter ('the_content', 'fbcommentbox', 100);


add_filter('navigation_markup_template', 'kt_navigation_markup_template', 10, 2);
function kt_navigation_markup_template($template, $class){
    $disable_next = $disable_prev = '';
    if ( !get_previous_posts_link() ) {
        $disable_prev = '<span class="page-numbers prev disable">'._x( 'Previous', 'previous post','adroit' ).'</span>';
    }
    if ( !get_next_posts_link() ) {
        $disable_next = '<span class="page-numbers next disable">'._x( 'Next', 'next post','adroit' ).'</span>';
    }

    $template = '
	<nav class="navigation %1$s">
		<h2 class="screen-reader-text">%2$s</h2>
		<div class="nav-links">'.$disable_prev.'%3$s'.$disable_next.'</div>
	</nav>';
    return $template;
}




/**
 * Add page header
 *
 * @since 1.0
 */
add_action( 'kt_before_content', 'kt_get_page_header', 20 );
function kt_get_page_header( ){
    global $post;
    $show_title = false;

    if ( is_front_page() && is_singular('page')){
        $show_title = rwmb_meta('_kt_page_header', array(), get_option('page_on_front', true));
        if( !$show_title ){
            $show_title = kt_option('show_page_header', 1);
        }
    }elseif(is_archive()){
        $show_title = kt_option('archive_page_header', 1);
    }elseif(is_search()){
        $show_title = kt_option('search_page_header', 1);
    }elseif(is_author()){
        $show_title = kt_option('author_page_header', 1);
    }elseif(is_404()){
        $show_title = kt_option('notfound_page_header', 1);
    }elseif(is_page()){
        $post_id = $post->ID;
        $show_title = rwmb_meta('_kt_page_header', array(), $post_id);
        if( !$show_title ){
            if(is_page()){
                $show_title = kt_option('show_page_header', 1);
            }elseif(is_singular('post')){
                $show_title = kt_option('single_page_header', 1);
            }
        }
    }

    $show_title = apply_filters( 'kt_show_title', $show_title );
    if($show_title == 'on' || $show_title == 1){
        $title = kt_get_page_title();
        $title = sprintf('<h1 class="page-title">%s</h1>', $title);
        $subtitle = kt_get_page_subtitle();
        printf(
            '<div class="page-header"><div class="container"><div class="page-header-content clearfix">%s</div></div></div>',
            $title.$subtitle
        );
    }
}
/**
 * Get page title
 *
 * @return mixed|void
 */
function kt_get_page_title(){
    global $post;
    $title = '';

    if ( is_front_page() && !is_singular('page') ) {
        $title = __( 'Blog', 'adroit' );
    } elseif(is_category()){
        $title = single_tag_title( '', false );
    } elseif( is_home() ){
        $page_for_posts = get_option('page_for_posts', true);
        if($page_for_posts){
            $title = get_the_title($page_for_posts) ;
        }
    } elseif(is_search()){

		$allowed_html = array(
			'i' => array('class'=>true),
			'span' => array(),
		);
        $title = sprintf( wp_kses(__( '<i class="fa fa-search"></i> <span>%s</span>','adroit' ), $allowed_html), get_search_query() );
    } elseif ( is_front_page() && is_singular('page') ){
        $page_on_front = get_option('page_on_front', true);
        $title = get_the_title($page_on_front) ;
    } elseif ( is_archive() ){
		$allowed_html = array(
			'span' => array(),
			'i' => array('class'=>true),
		);
        if(is_tag()){
            $title = sprintf( wp_kses(__( '<i class="fa fa-tags"></i> <span>%s</span>','adroit' ),$allowed_html), single_tag_title( '', false ) );
        } elseif(is_author()){
            $title = sprintf( wp_kses(__( '<i class="fa fa-user"></i> <span>%s</span>','adroit' ),$allowed_html), '<span class="vcard">' . get_the_author() . '</span>' );
        } elseif ( is_year() ) {
            $title = sprintf( wp_kses(__( '<i class="fa fa-clock-o"></i> <span>%s</span>','adroit' ),$allowed_html), get_the_date( _x( 'Y', 'yearly archives date format','adroit' ) ) );
        } elseif ( is_month() ) {
            $title = sprintf( wp_kses(__( '<i class="fa fa-clock-o"></i> <span>%s</span>','adroit' ),$allowed_html), get_the_date( _x( 'F Y', 'monthly archives date format','adroit' ) ) );
        } elseif ( is_day() ) {
            $title = sprintf( wp_kses(__( '<i class="fa fa-clock-o"></i> <span>%s</span>','adroit' ),$allowed_html), get_the_date( _x( 'F j, Y', 'daily archives date format','adroit' ) ) );
        }
    } elseif(is_page() || is_singular()){
        $post_id = $post->ID;
        $custom_text = rwmb_meta('_kt_page_header_custom', array(), $post_id);
        $title = ($custom_text != '') ? $custom_text : get_the_title($post_id);
    }

    return $title;

}
/**
 * Get page tagline
 *
 * @return mixed|void
 */

function kt_get_page_subtitle(){
    global $post;
    $subtitle = '';
    if ( is_front_page() && !is_singular('page') ) {
        $subtitle =  __('Lastest posts', 'adroit');
    }elseif( is_home() ){
        $page_for_posts = get_option('page_for_posts', true);
        $subtitle = nl2br(rwmb_meta('_kt_page_header_subtitle', array(), $page_for_posts))  ;
    }elseif ( is_front_page() && is_singular('page') ){
        $subtitle =  rwmb_meta('_kt_page_header_subtitle');
    }elseif ( is_archive() ){
        $subtitle =  get_the_archive_description( );
        if(!$subtitle){
            if(is_category()){
                $category_current = get_category( get_query_var( 'cat' ) );
                $categories = get_categories( array('child_of' => $category_current->term_id) );

                if(count($categories)){
                    $subtitle .= '<ul class="category_children">';
                    $subtitle .= sprintf(
                        '<li class="active"><a href="%s">%s</a></li>',
                        get_category_link($category_current->term_id),
                        __('All', 'adroit')
                    );
                    foreach($categories as $category){
                        $subtitle .= sprintf(
                            '<li><a href="%s">%s</a></li>',
                            get_category_link($category->term_id),
                            $category->cat_name
                        );
                    }
                    $subtitle .= '</ul>';
                }else{
                    $subtitle = sprintf( __('%s posts', 'adroit'), $category_current->count);
                }
            }elseif(is_tag() || is_author() || is_year() || is_month() || is_day()){
                global $wp_query;
                $subtitle = sprintf( __('%s posts', 'adroit'), $wp_query->found_posts);
            }
        }
    }elseif(is_search()){
        global $wp_query;
        $subtitle = sprintf( __('%s posts', 'adroit'), $wp_query->found_posts);
    }elseif( $post ){
        $post_id = $post->ID;
        $subtitle = nl2br(rwmb_meta('_kt_page_header_subtitle', array(), $post_id));
    }

    $subtitle = apply_filters( 'kt_subtitle', $subtitle );

    if($subtitle){
        $subtitle = sprintf('<div class="%s">%s</div>', 'page-subtitle', $subtitle);
    }

    return $subtitle;
}


/**
 * Get Share Count
 *
 */

/*== Facebook ==*/
function kt_get_facebook_post_share_count( $url ) {
    $response = wp_remote_get( 'https://graph.facebook.com/?id='.$url );
    if ( ! is_wp_error( $response ) && isset( $response['body'] ) ) {
        $data = json_decode( $response['body'] );
        if ( ! is_null( $data ) && isset( $data->shares ) )
            return intval($data->shares);
    }
    return 0;
}

/*== Pinterest ==*/
function kt_get_pinterest_post_share_count( $url ) {
    $response = wp_remote_get( '.http://api.pinterest.com/v1/urls/count.json?callback=receivecount&url='.$url );
    if ( ! is_wp_error( $response ) && isset( $response['body'] ) ) {
        $data = json_decode( substr( $response['body'], 13, - 1 ) );
        if ( ! is_null( $data ) && isset( $data->count ) )
            return intval($data->count);
    }
    return 0;
}

/*== Linked ==*/
function kt_get_linkedin_post_share_count( $url ) {
    $response = wp_remote_get( 'http://www.linkedin.com/countserv/count/share?url='.$url.'&format=json' );
    if ( ! is_wp_error( $response ) && isset( $response['body'] ) ) {
        $data = json_decode( $response['body'] );
        if ( ! is_null( $data ) && isset( $data->count ) )
            return intval($data->count);
    }
    return 0;
}

/*== Google Plus ==*/
function kt_get_googleplus_post_share_count( $url ) {
    $args       = array(
        'headers' => array( 'Content-type' => 'application/json' ),
        'body'    => '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"'.rawurldecode( $url ).'","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]',
    );
    $google_url = 'https://clients6.google.com/rpc';

    $response = wp_remote_post( $google_url, $args );
    if ( ! is_wp_error( $response ) && isset( $response['body'] ) ) {
        $data = json_decode( $response['body'] );
        if ( ! is_null( $data ) ) {
            if ( is_array( $data ) && count( $data ) == 1 )
                $data = array_shift( $data );

            if ( isset( $data->result->metadata->globalCounts->count ) )
                return intval($data->result->metadata->globalCounts->count);
        }
    }

    return 0;
}

function kt_total_post_share_count( $url ){
    $fb = kt_get_facebook_post_share_count( $url );
    $gp = kt_get_googleplus_post_share_count( $url );
    $pt = kt_get_pinterest_post_share_count( $url ) ;
    $li = kt_get_linkedin_post_share_count( $url ) ;

    $count =  $fb + $gp + $pt + $li;

    return $count;
}

/**
 * Custom password form
 *
 * @return string
 */
function kt_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    <p>' . __( "To view this protected post, enter the password below:", 'wingman' ) . '</p>
    <div class="input-group"><input name="post_password" type="password" size="20" maxlength="20" /><span class="input-group-btn"><input type="submit" class="btn btn-default" name="Submit" value="' . esc_attr__( "Submit", 'adroit' ) . '" /></span></div>
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'kt_password_form' );
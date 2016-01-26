<?php

/**
 * All helpers for theme
 *
 */

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Function check if WC Plugin installed
 */
function kt_is_wc(){
    return function_exists('is_woocommerce');
}

/**
 *  @true  if WPML installed.
 */
function  kt_is_wpml(){
    return class_exists('SitePress');
}


if (!function_exists('kt_sidebars')){
    /**
     * Get sidebars
     *
     * @return array
     */
    function kt_sidebars( ){
        $sidebars = array();
        foreach ( $GLOBALS['wp_registered_sidebars'] as $item ) {
            $sidebars[$item['id']] = $item['name'];
        }
        return $sidebars;
    }
}



if (!function_exists('kt_get_image_sizes')){
    /**
     * Get image sizes
     *
     * @return array
     */
    function kt_get_image_sizes( $full = true, $custom = false ) {

        global $_wp_additional_image_sizes;
        $get_intermediate_image_sizes = get_intermediate_image_sizes();
        $sizes = array();
        // Create the full array with sizes and crop info
        foreach( $get_intermediate_image_sizes as $_size ) {

            if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

                    $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
                    $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
                    $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );

            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

                    $sizes[ $_size ] = array(
                            'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                            'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                            'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
                    );

            }

            $option_text = array();
            $option_text[] = ucfirst(str_replace('_', ' ', $_size));
            if( isset($sizes[ $_size ]) ){
                $option_text[] = '('.$sizes[ $_size ]['width'].' x '.$sizes[ $_size ]['height'].')';
                if($sizes[ $_size ]['crop']){
                    $option_text[] = esc_html__('Crop', 'adroit');
                }
                $sizes[ $_size ] = implode(' - ', $option_text);
            }
        }

        if($full){
            $sizes[ 'full' ] = esc_html__('Full', 'adroit');
        }
        if($custom){
            $sizes[ 'custom' ] = esc_html__('Custom size', 'adroit');
        }


        return $sizes;
    }
}





if (!function_exists('kt_get_page_sidebar')) {
    /**
     * Get page sidebar
     *
     * @param null $post_id
     * @return mixed|void
     */
    function kt_get_page_sidebar( $post_id = null )
    {
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $sidebar = array(
            'sidebar' => rwmb_meta('_kt_sidebar', array(), $post_id),
            'sidebar_area' => '',
        );

        if(isset($_REQUEST['sidebar'])){
            $sidebar['sidebar'] = $_REQUEST['sidebar'];
        }

        if($sidebar['sidebar'] == '' || $sidebar['sidebar'] == 'default' ){
            $sidebar['sidebar'] = kt_option('page_sidebar');
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('page_sidebar_left', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('page_sidebar_right', 'primary-widget-area');
            }
        }elseif($sidebar['sidebar'] == 'left'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_left_sidebar', array(), $post_id);
        }elseif($sidebar['sidebar'] == 'right'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_right_sidebar', array(), $post_id);
        }elseif($sidebar['sidebar'] == 'full'){
            $sidebar['sidebar'] = '';
        }

        return apply_filters('page_sidebar', $sidebar);
    }
}

if (!function_exists('kt_get_single_sidebar')) {
    /**
     * Get Single post sidebar
     *
     * @param null $post_id
     * @return array
     */
    function kt_get_single_sidebar( $post_id = null )
    {
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $sidebar = array(
            'sidebar' => rwmb_meta('_kt_sidebar', array(), $post_id),
            'sidebar_area' => '',
        );
        if($sidebar['sidebar'] == '0' || $sidebar['sidebar'] == 'default' ){
            $sidebar['sidebar'] = kt_option('single_sidebar', 'right');
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('single_sidebar_left', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('single_sidebar_right', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'full'){
                $sidebar['sidebar'] = '';
            }
        }elseif($sidebar['sidebar'] == 'left'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_left_sidebar', array(), $post_id);
        }elseif($sidebar['sidebar'] == 'right'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_right_sidebar', array(), $post_id);
        }elseif($sidebar['sidebar'] == 'full'){
            $sidebar['sidebar'] = '';
        }
        return apply_filters('single_sidebar', $sidebar);
    }

}


if (!function_exists('kt_get_archive_sidebar')) {
    /**
     * Get Archive sidebar
     *
     * @return array
     */
    function kt_get_archive_sidebar()
    {
        if( isset($_REQUEST['sidebar'] )){
            $sidebar = array(
                'sidebar' => $_REQUEST['sidebar'],
                'sidebar_area' => 'primary-widget-area'
            );
            if($sidebar['sidebar'] == 'full'){
                $sidebar['sidebar'] = '';
            }
        }elseif(is_search()){
            $sidebar = array(
                'sidebar' => kt_option('search_sidebar', 'full'),
                'sidebar_area' => ''
            );
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('search_sidebar_left', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'full'){
                $sidebar['sidebar'] = '';
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('search_sidebar_right', 'primary-widget-area');
            }
        }elseif(is_author()){
            $sidebar = array(
                'sidebar' => kt_option('author_sidebar', 'full'),
                'sidebar_area' => '',
            );
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('author_sidebar_left', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'full'){
                $sidebar['sidebar'] = '';
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('author_sidebar_right', 'primary-widget-area');
            }
        }else{
            $default = false;
            if(is_home()) {
                $post_id = get_option('page_for_posts');
                $sidebar = array(
                    'sidebar' => rwmb_meta('_kt_sidebar', array(), $post_id),
                    'sidebar_area' => '',
                );

                if($sidebar['sidebar'] == 'left' ){
                    $sidebar['sidebar_area'] = rwmb_meta('_kt_left_sidebar', array(), $post_id);
                }elseif($sidebar['sidebar'] == 'right'){
                    $sidebar['sidebar_area'] = rwmb_meta('_kt_right_sidebar', array(), $post_id);
                }elseif($sidebar['sidebar'] == 'full'){
                    $sidebar['sidebar'] = '';
                }else{
                    $default = true;
                }
            }else{
                $default = true;
            }

            if($default){
                $sidebar = array(
                    'sidebar' => kt_option('archive_sidebar', 'right'),
                    'sidebar_area' => '',
                );
                if($sidebar['sidebar'] == 'left' ){
                    $sidebar['sidebar_area'] = kt_option('archive_sidebar_left', 'primary-widget-area');
                }elseif($sidebar['sidebar'] == 'right'){
                    $sidebar['sidebar_area'] = kt_option('archive_sidebar_right', 'primary-widget-area');
                }elseif($sidebar['sidebar'] == 'full'){
                    $sidebar['sidebar'] = '';
                }

            }
        }

        return apply_filters('archive_sidebar', $sidebar);
    }
}




if (!function_exists('kt_option')){
    /**
     * Function to get options in front-end
     * @param int $option The option we need from the DB
     * @param string $default If $option doesn't exist in DB return $default value
     * @return string
     */

    function kt_option( $option = false, $default = false ){
        if($option === FALSE){
            return FALSE;
        }
        $kt_options = wp_cache_get( KT_THEME_OPTIONS );
        if(  !$kt_options ){
            $kt_options = get_option( KT_THEME_OPTIONS );
            wp_cache_delete( KT_THEME_OPTIONS );
            wp_cache_add( KT_THEME_OPTIONS, $kt_options );
        }

        if(isset($kt_options[$option]) && $kt_options[$option] !== ''){
            return $kt_options[$option];
        }else{
            return $default;
        }
    }
}


if (!function_exists('kt_get_logo')){
    /**
     * Get logo of current page
     *
     * @return string
     *
     */
    function kt_get_logo(){
        $logo = array('default' => '', 'retina' => '');
        $logo_default = kt_option( 'logo' );
        $logo_retina = kt_option( 'logo_retina' );

        if(is_array($logo_default) && $logo_default['url'] != '' ){
            $logo['default'] = $logo_default['url'];
        }

        if(is_array($logo_retina ) && $logo_retina['url'] != '' ){
            $logo['retina'] = $logo_retina['url'];
        }

        if(!$logo['default']){
            $logo['default'] = KT_THEME_IMG.'logo.png';
            $logo['retina'] = KT_THEME_IMG.'logo-2x.png';
            $logo['alt'] = KT_THEME_IMG.'logo-alt.png';
            $logo['altretina'] = KT_THEME_IMG.'logo-alt-2x.png';
        } 

        return $logo;
    }
}

if (!function_exists('kt_getlayout')) {
    /**
     * Get Layout of post
     *
     * @param number $post_id Optional. ID of article or page.
     * @return string
     *
     */
    function kt_getlayout($post_id = null){
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $layout = rwmb_meta('_kt_layout', array(),  $post_id);
        if($layout == 'default' || !$layout){
            $layout = kt_option('layout', 'full');
        }

        return $layout;
    }
}

if (!function_exists('kt_show_slideshow')) {
    /**
     * Show slideshow of page or singular
     *
     * @param $post_id
     *
     */
    function kt_show_slideshow($post_id = null)
    {
        global $post;
        if (!$post_id) $post_id = $post->ID;

        $slideshow = rwmb_meta('_kt_slideshow_type', array(), $post_id);
        $sideshow_class = array();
        $output = '';

        if ($slideshow == 'revslider') {
            $revslider = rwmb_meta('_kt_rev_slider', array(), $post_id);
            if ($revslider && class_exists('RevSlider')) {
                ob_start();
                putRevSlider($revslider);
                $revslider_html = ob_get_contents();
                ob_end_clean();
                $output .= $revslider_html;
            }
        } elseif ($slideshow == 'layerslider') {
            $layerslider = rwmb_meta('_kt_layerslider', array(), $post_id);
            if ($layerslider && is_plugin_active('LayerSlider/layerslider.php')) {
                $layerslider_html = do_shortcode('[layerslider id="' . $layerslider . '"]');
                if($layerslider_html){
                    $output .= $layerslider_html;
                }
            }
        } elseif( $slideshow == 'postslider'){

            $postslider = rwmb_meta('_kt_slideshow_postslider', array(), $post_id);
            if($postslider){
                $output .= kt_render_postSlider($postslider);
                if($output != '') {
                    $style = rwmb_meta('_kt_slideshow_slider_style', array(), $postslider);
                    if (in_array($style, array('page', 'thumb', 'normal'))) {
                        $output = '<div class="container">' . $output . '</div>';
                    }
                    $sideshow_class[] = 'post-slider-'.$style;


                }

            }
        }elseif($slideshow == 'page'){
            if($page_id = rwmb_meta('_kt_slideshow_page', array(), $post_id)){
                $page = get_post($page_id);
                $output = '<div class="container">'.apply_filters( "the_content", $page->post_content ).'</div>';
                $sideshow_class[] = 'slideshow_page-graybg';
            }
        };

        if( $slideshow == 'postslider' ){
            $slick_arrow = '<div class="slick-prev slick-arrow"></div><div class="slick-next slick-arrow"></div>';
        }else{
            $slick_arrow = '';
        }

        if($output != ''){
            printf(
                '<div id="main-slideshow" class="%s"><div id="sideshow-inner">%s'.$slick_arrow.'</div></div>',
                esc_attr(implode(' ', $sideshow_class)),
                $output
            );
        }
    }
}


function kt_render_postSlider($post_id){
    $output = '';

    $orderby = get_post_meta($post_id, '_kt_slideshow_orderby', true);
    $order = get_post_meta($post_id, '_kt_slideshow_order', true);
    $per_page = get_post_meta($post_id, '_kt_slideshow_max_items', true);
    $style = rwmb_meta('_kt_slideshow_slider_style', array(), $post_id);


    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $per_page,
        'orderby' => $orderby,
        'order' => $order,
    );

    if($orderby == 'meta_value' || $orderby == 'meta_value_num'){
        $meta_key = get_post_meta($post_id, 'slideshow_meta_key', true);
        $args['meta_key'] = $meta_key;
    }

    $source = get_post_meta($post_id, '_kt_slideshow_source', true);

    if($source == 'categories'){
        $categories = rwmb_meta( '_kt_slideshow_categories', 'type=taxonomy_advanced&taxonomy=category', $post_id );
        if(count($categories)){
            $categories_arr = array();
            foreach($categories as $category){
                $categories_arr[] = $category->term_id;
            }
            $args['category__in'] = $categories_arr;
        }
    }elseif($source == 'posts'){
        $posts = rwmb_meta( '_kt_slideshow_posts', 'multiple=true', $post_id );

        if(count($posts)){
            $args['post__in'] = $posts;
        }
    }elseif($source == 'authors'){
        $authors = rwmb_meta( '_kt_slideshow_authors', 'multiple=true', $post_id );
        if(count($authors)){
            $args['author__in'] = $authors;
        }
    }

    $query = new WP_Query( $args );

    $slider_html = '';

    if ( $query->have_posts() ) {



        $slider_class = array('blog-posts-slick', 'posts-slick-'.$style);
        $image_size = 'kt_blog_post';
        $slider_option = '{}';
        $slider_thumbnail = '';

        if($style == 'big'){
            $slider_class[] = 'slideAnimation';
            $slider_class[] = 'slide-visible';
            $image_size = 'kt_blog_post_slider';
        } elseif ($style == 'thumb'){
            $slider_option = '{"arrows": false, "asNavFor": ".blog-posts-thumb", "fade": true}';
            $slider_thumbnail .= '<div class="blog-posts-thumb">';
        }elseif($style == 'slider'){
            $slider_class[] = 'slideAnimation';
        }elseif($style == 'carousel'){
            //$slider_option = '{"arrows": true, "slidesToShow": 3}';
        }else{
            $slider_class[] = 'slideAnimation';
        }

        while ( $query->have_posts() ) {
            $query->the_post();
            $slider_content = '';

            if($style != 'thumb'){
                $content_class = '';
                if($style == 'slider'){
                    $content_class = '';
                }

                $slider_content = sprintf(
                    '<div class="article-post-content %1$s"><div class="article-post-inner">%2$s %3$s</div></div>',
                    $content_class,
                    '<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>',
                    '<div class="article-post-meta">'.get_the_author().' - '. get_the_date().'</div>'
                );

            }

            if($style == 'slider'){
                $slider_html .= sprintf(
                    '<div class="article-post" style="%s">%s</div>',
                    "background-image: url('".get_the_post_thumbnail_url()."');",
                    $slider_content
                );
            }else{
                $slider_html .= sprintf(
                    '<div class="article-post"><div class="article-post-thumb">%1$s</div>%2$s</div>',
                    get_the_post_thumbnail(null, $image_size),
                    $slider_content
                );
            }

            if ($style == 'thumb') {
                $slider_thumbnail .= sprintf(
                    '<div style="%s"><div class="blog-posts-thumb-content">%s %s</div></div>',
                    "background-image: url('".get_the_post_thumbnail_url()."');",
                    '<h4><a href="' . get_the_permalink() . '"> ' . get_the_title() . '</a></h4>',
                    '<div class="article-thumb-meta">' . get_the_author() . ' - ' . get_the_date() . '</div>'
                );
            }
        }

        if ($style == 'thumb'){
            $slider_thumbnail .= '</div>';
        }

        $output .= sprintf(
            '<div class="%1$s" data-slick=\'%2$s\'>%3$s</div>%4$s',
            implode(' ', $slider_class),
            esc_attr($slider_option),
            $slider_html,
            $slider_thumbnail
        );
    }
    /* Restore original Post Data */
    wp_reset_postdata();




    return $output;
}

if (!function_exists('kt_get_header')) {
    /**
     * Get Header
     *
     * @return string
     *
     */
    function kt_get_header(){
        $header = 'default';
        $header_position = '';

        if(is_page() || is_singular()){
            $header_position = rwmb_meta('_kt_header_position');
        }

        if($header_position){
            $header = $header_position;
        }
        return $header;
    }
}

if (!function_exists('kt_get_header_layout')) {
    /**
     * Get Header Layout
     *
     * @return string
     *
     */
    function kt_get_header_layout(){
        $layout = kt_option('header', 'layout1');
        return $layout;
    }
}



if (!function_exists('kt_get_thumbnail_attachment')){
    /**
     * Get link attach from thumbnail_id.
     *
     * @param number $thumbnail_id ID of thumbnail.
     * @param string|array $size Optional. Image size. Defaults to 'post-thumbnail'
     * @return array
     */

    function kt_get_thumbnail_attachment($thumbnail_id ,$size = 'post-thumbnail'){
        if(!$thumbnail_id) return false;
        
        $attachment = get_post( $thumbnail_id );
        if(!$attachment) return false;
        
        $image = wp_get_attachment_image_src($thumbnail_id, $size);
    	return array(
    		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
    		'caption' => $attachment->post_excerpt,
    		'description' => $attachment->post_content,
            'src' => $attachment->guid,
    		'url' => $image[0],
    		'title' => $attachment->post_title
    	);
    }
}


if (!function_exists('kt_get_link_image_post')) {
    /**
     * Get image form meta.
     *
     * @param string $meta . meta id of article.
     * @param string|array $size Optional. Image size. Defaults to 'screen'.
     * @param number $post_id Optional. ID of article.
     * @return array
     */

    function kt_get_link_image_post($meta, $post_id = null, $size = 'screen')
    {
        global $post;
        if (!$post_id) $post_id = $post->ID;

        $media_image = rwmb_meta($meta, 'type=image&size=' . $size, $post_id);

        if (!$media_image) return;

        foreach ($media_image as $item) {
            return $item;
            break;
        }
    }
}


if (!function_exists('kt_get_galleries_post')) {
    /**
     * Get all image form meta box.
     *
     * @param string $meta . meta id of article.
     * @param string|array $size Optional. Image size. Defaults to 'screen'.
     * @param array $post_id Optional. ID of article.
     * @return array
     */
    function kt_get_galleries_post($meta, $size = 'screen', $post_id = null)
    {
        global $post;
        if (!$post_id) $post_id = $post->ID;

        $media_image = rwmb_meta($meta, 'type=image&size=' . $size, $post_id);

        return (count($media_image) ) ? $media_image : false;
    }
}
if (!function_exists('kt_get_single_file')) {
    /**
     * Get Single file form meta box.
     *
     * @param string $meta . meta id of article.
     * @param string|array $size Optional. Image size. Defaults to 'screen'.
     * @param array $post_id Optional. ID of article.
     * @return array
     */
    function kt_get_single_file($meta, $post_id = null)
    {
        global $post;
        if (!$post_id) $post_id = $post->ID;
        $medias = rwmb_meta($meta, 'type=file', $post_id);
        if (count($medias)) {
            foreach ($medias as $media) {
                return $media['url'];
            }
        }
        return false;
    }
}


if (!function_exists('kt_post_option')) {
    /**
     * Check option for in article
     *
     * @param number $post_id Optional. ID of article.
     * @param string $meta Optional. meta oftion in article
     * @param string $option Optional. if meta is Global, Check option in theme option.
     * @param string $default Optional. Default vaule if theme option don't have data
     * @return boolean
     */
    function kt_post_option($post_id = null, $meta = '', $option = '', $default = null, $boolean = true)
    {
        global $post;
        if (!$post_id) $post_id = $post->ID;
        $meta_v = get_post_meta($post_id, $meta, true);

        if ($meta_v == '' || $meta_v == 0) {
            $meta_v = kt_option($option, $default);
        }
        $ouput = ($boolean) ? apply_filters('kt_sanitize_boolean', $meta_v) : $meta_v;
        return $ouput;
    }
}

if (!function_exists('kt_render_custom_css')) {
    /**
     * Render custom css
     *
     * @param $meta
     * @param $selector
     * @param null $post_id
     */

    function kt_render_custom_css($meta , $selector, $post_id = null)
    {

        $ouput = '';
        if(!$post_id){
            global $post;
            $post_id = $post->ID;
        }

        $page_bg = rwmb_meta($meta, array(), $post_id);
        if(is_array($page_bg)){
            $page_arr = array();

            $page_color = $page_bg['color'];
            if( $page_color != '' && $page_color != '#'){
                $page_arr[] = 'background-color: '.$page_color;
            }
            if($page_url = $page_bg['url']){
                $page_arr[] = 'background-image: url('.$page_url.')';
            }
            if($page_repeat = $page_bg['repeat']){
                $page_arr[] = 'background-repeat: '.$page_repeat;
            }
            if($page_size = $page_bg['size']){
                $page_arr[] = 'background-size: '.$page_size;
            }
            if($page_attachment = $page_bg['attachment']){
                $page_arr[] = 'background-attachment: '.$page_attachment;
            }
            if($page_position = $page_bg['position']){
                $page_arr[] = 'background-position: '.$page_position;
            }
            if(count($page_arr)){
                $ouput = $selector.'{'.implode(';', $page_arr).'}';
            }
        }
        return $ouput;
    }
}


if(!function_exists('kt_colour_brightness')){
    /**
     * Convert hexdec color string to darken or lighten
     *
     * http://lab.clearpixel.com.au/2008/06/darken-or-lighten-colours-dynamically-using-php/
     *
     * $brightness = 0.5; // 50% brighter
     * $brightness = -0.5; // 50% darker
     *
     */

    function kt_colour_brightness($hex, $percent) {
        // Work out if hash given
        $hash = '';
        if (stristr($hex,'#')) {
            $hex = str_replace('#','',$hex);
            $hash = '#';
        }
        /// HEX TO RGB
        $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
        //// CALCULATE
        for ($i=0; $i<3; $i++) {
            // See if brighter or darker
            if ($percent > 0) {
                // Lighter
                $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
            } else {
                // Darker
                $positivePercent = $percent - ($percent*2);
                $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
            }
            // In case rounding up causes us to go to 256
            if ($rgb[$i] > 255) {
                $rgb[$i] = 255;
            }
        }
        //// RBG to Hex
        $hex = '';
        for($i=0; $i < 3; $i++) {
            // Convert the decimal digit to hex
            $hexDigit = dechex($rgb[$i]);
            // Add a leading zero if necessary
            if(strlen($hexDigit) == 1) {
                $hexDigit = "0" . $hexDigit;
            }
            // Append to the hex string
            $hex .= $hexDigit;
        }
        return $hash.$hex;
    }
}

if(!function_exists('kt_color2hecxa')){
    /**
     * Convert color to hex
     *
     * @param $color
     * @return string
     */
    function kt_color2Hex($color){
        switch ($color) {
            case 'mulled_wine': $color = '#50485b'; break;
            case 'vista_blue': $color = '#75d69c'; break;
            case 'juicy_pink': $color = '#f4524d'; break;
            case 'sandy_brown': $color = '#f79468'; break;
            case 'purple': $color = '#b97ebb'; break;
            case 'pink': $color = '#fe6c61'; break;
            case 'violet': $color = '#8d6dc4'; break;
            case 'peacoc': $color = '#4cadc9'; break;
            case 'chino': $color = '#cec2ab'; break;
            case 'grey': $color = '#ebebeb'; break;
            case 'orange': $color = '#f7be68'; break;
            case 'sky': $color = '#5aa1e3'; break;
            case 'green': $color = '#6dab3c'; break;
            case 'accent': $color = kt_option('styling_accent', '#d0a852'); break;

        }
        return $color;
    }
}

if(!function_exists('kt_video_youtube')) {
    /**
     * Video youtube Embed
     *
     * @param $video_id
     * @return string
     */
    function kt_video_youtube($video_id)
    {
        return '<iframe src="http://www.youtube.com/embed/' . $video_id . '?wmode=transparent" ></iframe>';
    }
}


if(!function_exists('kt_video_vimeo')) {
    /**
     * Video Vimeo Embed
     *
     * @param $video_id
     * @return string
     */
    function kt_video_vimeo($video_id, $args = 'title=0&amp;byline=0&amp;portrait=0?wmode=transparent')
    {
        return '<iframe src="http://player.vimeo.com/video/' . $video_id . '?'.$args.'"></iframe>';
    }
}

<?php


// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/*
 * Set up the content width value based on the theme's design.
 *
 * @see kt_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 1140;




add_action( 'after_setup_theme', 'kt_theme_setup' );
if ( ! function_exists( 'kt_theme_setup' ) ):

function kt_theme_setup() {
    /**
     * Editor style.
     */
    add_editor_style( array( 'assets/css/editor-style.css') );
    
    /**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

    /*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );


    /**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array('gallery', 'quote', 'video', 'audio') );

    /*
    * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
	 */
	add_theme_support( 'title-tag' );
    
    /**
	 * Allow shortcodes in widgets.
	 *
	 */
	add_filter( 'widget_text', 'do_shortcode' );
    
    
    /**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
    
    
    if (function_exists( 'add_image_size' ) ) {
        add_image_size( 'kt_recent_posts', 570, 355, true);
        add_image_size( 'kt_recent_posts_masonry', 570);
        add_image_size( 'kt_first_featured', 670, 500, true);

        add_image_size( 'kt_small', 170, 170, true );
        add_image_size( 'kt_blog_post', 1140, 600, true );

        add_image_size( 'kt_blog_post_sidebar', 1140 );
        add_image_size( 'kt_blog_post_slider', 1460, 800, true );

        add_image_size( 'kt_widget_article', 120, 75, true );
        add_image_size( 'kt_widget_article_carousel', 335, 250, true );

        add_image_size( 'kt_gallery_fullwidth', 5000, 730 );        
    }
    
    load_theme_textdomain( 'adroit', KT_THEME_DIR . '/languages' );
    
    /**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(array(
        'primary' => esc_html__('Main Navigation Menu', 'adroit'),
        'mobile' => esc_html__('(Mobile Devices) Main Navigation Menu', 'adroit'),
        'footer'	  => esc_html__( 'Footer Navigation Menu', 'adroit' ),
    ));

}
endif;



/**
 * Add stylesheet and script for frontend
 *
 * @since       1.0
 * @return      void
 * @access      public
 */

function kt_add_scripts() {

    wp_enqueue_style( 'kt-wp-style', get_stylesheet_uri(), array('mediaelement', 'wp-mediaelement') );
    wp_enqueue_style( 'bootstrap', KT_THEME_LIBS . 'bootstrap/css/bootstrap.css', array());
    wp_enqueue_style( 'font-awesome', KT_THEME_LIBS . 'font-awesome/css/font-awesome.min.css', array());
    wp_enqueue_style( 'kt-plugins', KT_THEME_CSS . 'plugins.css', array());

	// Load our main stylesheet.
    wp_enqueue_style( 'kt-main', KT_THEME_CSS . 'style.css');
    wp_enqueue_style( 'kt-queries', KT_THEME_CSS . 'queries.css');
    
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'kt-ie', KT_THEME_CSS . 'ie.css');
	wp_style_add_data( 'kt-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    wp_register_script('google-maps-api','http://maps.googleapis.com/maps/api/js?sensor=false', array( 'jquery' ), null, false);
    wp_enqueue_script( 'bootstrap', KT_THEME_LIBS . 'bootstrap/js/bootstrap.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'kt-plugins', KT_THEME_JS . 'plugins.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'kt-main-script', KT_THEME_JS . 'functions.js', array( 'jquery', 'mediaelement', 'wp-mediaelement', 'jquery-ui-tabs' ), null, true );

    global $wp_query;
    wp_localize_script( 'kt-main-script', 'ajax_frontend', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'ajax_frontend' ),
        'current_date' => date_i18n('Y-m-d H:i:s'),
        'query_vars' => json_encode( $wp_query->query ),
    ));
    
}
add_action( 'wp_enqueue_scripts', 'kt_add_scripts' );


/**
 * Theme Custom CSS
 *
 * @since       1.0
 * @return      void
 * @access      public
 */
function kt_setting_script() {
    $advanced_css = kt_option('advanced_editor_css');
    $accent = kt_option('styling_accent', '#82c14f');

    $css = $advanced_css;

    $styling_link = kt_option('styling_link');
    if($styling_link['hover']){
        $css .= 'a:hover,a:focus{color: '.$styling_link['hover'].';}';
    }
    if($styling_link['active']){
        $css .= 'a:active{color: '.$styling_link['active'].';}';
    }

    if( $accent !='#22dcce' ){
        $css .= '::-moz-selection{color:#fff;background:'.$accent.'}';
        $css .= '::selection{color:#fff;background:'.$accent.'}';
        $selections_color = array(
            '#main-nav-tool li a:hover',
            '.main-nav-socials a:hover',
            '#main-slideshow.post-slider-slider .slick-arrow:hover::before',
            '#main-slideshow.post-slider-normal .slick-arrow:hover::before',
            '.blog-posts-slick .article-post h3 a:hover', 
            '.blog-posts-slick .article-post h3 a:focus',
            '.widget_rss ul li a:hover', 
            '.widget_pages ul li a:hover', 
            '.widget_recent_comments ul li a:hover', 
            '.widget_recent_entries ul li a:hover', 
            '.widget_nav_menu ul li a:hover', 
            '.widget_meta ul li a:hover', 
            '.widget_archive ul li a:hover', 
            '.widget_categories ul li a:hover', 
            '.widget_product_categories ul li a:hover', 
            '.yith-woocompare-widget ul li a:hover',
            '.widget_recent_entries ul > li a:hover::before',
            '.widget_nav_menu ul > li a:hover::before',
            '.widget_meta ul > li a:hover::before',
            '.widget_archive ul > li a:hover::before',
            '.widget_categories ul > li a:hover::before',
            '.widget_product_categories ul > li a:hover::before',
            'div.post-item-content.first-featured .entry-title a:hover',
            'article.post-item-content.first-featured .entry-title a:hover',
            'div.post-item-content .cat-links a:hover',
            'article.post-item-content .cat-links a:hover',
            '.post-item-meta a:hover',
            '.post-item-share ul a:hover',
            'blockquote::before',
            '.widget_kt_aboutme .kt-aboutwidget-socials a:hover',
            '.widget_kt_aboutme .kt-aboutwidget-socials a:focus',
            'ul.kt_posts_widget li h3.title a:hover',
            '.main-content div.post-item-content .entry-title a:hover',
            '.main-content div.post-item-content .entry-title a:hover em',
            '.main-content article.post-item-content .entry-title a:hover',
            '.main-content article.post-item-content .entry-title a:hover em',
            'div.post-item-content .entry-title-featured a:hover',
            'article.post-item-content .entry-title-featured a:hover',
            'div.post-item-content .post-item-meta-featured > span a:hover',
            'article.post-item-content .post-item-meta-featured > span a:hover',
            '#footer-navigation ul li a:hover',
            '.post-single .post-edit-link:hover',
            '.post-single .kt_likepost:hover',
            '.post-single .post-single-share ul li a:hover',
            '.author-info .author-social a:hover',
            '#related-article .slick-arrow:hover',
            '#related-article .entry-title a:hover',
            '.widget_kt_posts_carousel ul.kt_posts_carousel_widget .article-widget .article-attr h3.title a:hover',
            '.author-info h2.author-title a:hover',
            '.post-single .tags-container .tags-links-text',
            '.post-single .tags-container a:hover',
            '.pagination a:hover',
            '.pagination a:focus',
            '.pagination .current',
            '#main-navigation > li.menu-item-object-category .megamenu-posts > a:hover',
            '.page-header .category_children li.active a',
            '.page-header .category_children li a:hover',
            '#close-side-slideout-right:hover'
        );
        $css .= implode($selections_color, ',').'{color: '.$accent.';}';

        $selections_color_important = array(
            '.social-style-light.social-text a:hover',
            '.social-style-light.social-background-empty a:hover',
            '.social-style-light.social-background-outline a:hover',
            '.social-style-accent.social-text a',
            '.social-style-accent.social-background-empty a',
            '.social-style-accent.social-background-outline a'
        );
        $css .= implode($selections_color_important, ',').'{color: '.$accent.'!important;}';


        $selections_background = array(
            '.btn-accent',
            '.hamburger-icon:hover .line', 
            '.hamburger-icon.active .line',
            '.widget_product_tag_cloud .tagcloud a:hover',
            '.widget_product_tag_cloud .tagcloud a:focus',
            '.widget_tag_cloud .tagcloud a:hover',
            '.widget_tag_cloud .tagcloud a:focus',
            'div.post-item-content.first-featured .post-item-meta::after',
            'article.post-item-content.first-featured .post-item-meta::after',
            '#footer-navigation ul li a::before',
            '#back-to-top',
            '.post-single .post-item-meta::after',
            '.btn-default:hover',
            '.btn-default:focus',
            '.btn-default:active',
            '.page-header .page-title',
            '.pagination .page-numbers::before',
            'ul.style-list.style3 li::after',
            '#side-slideout-right #side-widget-area .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar'
        );
        $css .= implode($selections_background, ',').'{background-color: '.$accent.';}';

        $selections_background_important = array(
            '.social-style-accent.social-background-fill a',
        );
        $css .= implode($selections_background_important, ',').'{background-color: '.$accent.'!important;}';

        $selections_border_color = array(
            '.btn-accent',
            '.widget_product_tag_cloud .tagcloud a:hover',
            '.widget_product_tag_cloud .tagcloud a:focus',
            '.widget_tag_cloud .tagcloud a:hover',
            '.widget_tag_cloud .tagcloud a:focus',
            'div.post-item-content.first-featured .entry-title a::before', 
            'article.post-item-content.first-featured .entry-title a::before',
            'div.post-item-content.first-featured .post-item-meta',
            'article.post-item-content.first-featured .post-item-meta',
            'blockquote.post-item-quote::before',
            'div.post-item-content.post-item-featured.format-gallery .entry-title a::before',
            'div.post-item-content.post-item-featured.format-video .entry-title a::before',
            'div.post-item-content.post-item-featured.format-standard .entry-title a::before',
            'div.post-item-content.post-item-featured.format-audio .entry-title a::before',
            'article.post-item-content.post-item-featured.format-gallery .entry-title a::before',
            'article.post-item-content.post-item-featured.format-video .entry-title a::before',
            'article.post-item-content.post-item-featured.format-standard .entry-title a::before',
            'article.post-item-content.post-item-featured.format-audio .entry-title a::before',
            '.social-style-light.social-text a:hover', 
            '.social-style-light.social-background-empty a:hover',
            '.social-style-light.social-background-outline a:hover',
            '.post-single .post-item-meta',
            '.post-single .post-edit-link:hover', 
            '.post-single .kt_likepost:hover',
            '.post-single .post-single-share ul li a:hover',
            'input[type="email"]:focus',
            'input[type="password"]:focus',
            'input[type="phone"]:focus',
            'input[type="tel"]:focus',
            'input[type="text"]:focus',
            'textarea:focus',
            '.btn-default:hover',
            '.btn-default:focus',
            '.btn-default:active',
            '.social-style-accent.social-text a',
            '.social-style-accent.social-background-empty a',
            '.social-style-accent.social-background-outline a'
        );
        $css .= implode($selections_border_color, ',').'{border-color: '.$accent.';}';
    }

    if(is_page() || is_singular()){

        global $post;
        $post_id = $post->ID;

        $pageh_spacing = rwmb_meta('_kt_page_top_spacing', array(), $post_id);
        if($pageh_spacing != ''){
            $css .= '#content{padding-top: '.$pageh_spacing.';}';
        }
        $pageh_spacing = rwmb_meta('_kt_page_bottom_spacing', array(), $post_id);
        if($pageh_spacing != ''){
            $css .= '#content{padding-bottom:'.$pageh_spacing.';}';
        }

        $css .= kt_render_custom_css('_kt_background_body', 'body.layout-boxed, body.layout-full', $post_id);
        $css .= kt_render_custom_css('_kt_background_inner', '.layout-boxed #page_outter', $post_id);

    }

    if($navigation_space = kt_option('navigation_space', 15)){
        $css .= '#main-navigation > li{margin-left: '.$navigation_space.'px;margin-right: '.$navigation_space.'px;}#main-navigation > li:first-child {margin-left: 0;}#main-navigation > li:last-child {margin-right: 0;}';
    }

    if($navigation_height = kt_option('navigation_height')){
        if(isset($navigation_height['height'])){
            $navigation_arr = array(
                '#main-navigation > li',
                '.header-layout1 #main-nav-tool > a',
                '.header-layout1 .nav-container-inner',
                '.header-layout1 #main-nav-tool > li > a',
                '.header-layout1 .main-nav-socials > a',
                '.header-layout1 .main-nav-socials > li > a',
                '.header-layout2 #main-nav-tool > a',
                '.header-layout2 #main-nav-tool > li > a',
                '.header-layout2 .main-nav-socials > a',
                '.header-layout2 .main-nav-socials > li > a'
            );
            $css .= implode($navigation_arr, ',').'{line-height: '.intval($navigation_height['height']).'px;}';
        }
    }
    if($navigation_height_fixed = kt_option('navigation_height_fixed')){
        if(isset($navigation_height_fixed['height'])){
            $navigation_arr_fixed = array(
                '.header-container.header-layout1.is-sticky #main-navigation > li',
                '.header-container.is-sticky.header-layout1 #main-nav-tool > a',
                '.header-container.is-sticky.header-layout1 #main-nav-tool > li > a',
                '.header-container.is-sticky.header-layout1 .main-nav-socials > a',
                '.header-container.is-sticky.header-layout1 .main-nav-socials > li > a',
                '.header-container.header-layout2.is-sticky #main-navigation > li',
                '.header-container.is-sticky.header-layout2 #main-nav-tool > a',
                '.header-container.is-sticky.header-layout2 #main-nav-tool > li > a',
                '.header-container.is-sticky.header-layout2 .main-nav-socials > a',
                '.header-container.is-sticky.header-layout2 .main-nav-socials > li > a'
            );
            $css .= implode($navigation_arr_fixed, ',').'{line-height: '.intval($navigation_height_fixed['height']).'px;}';
        }
    }

    $color_first_loader = kt_option('color_first_loader', $accent);
    $color_second_loader = kt_option('color_second_loader', '#cccccc');
    $css .= '.kt_page_loader.style-1 .page_loader_inner{border-color: '.$color_first_loader.';}';
    $css .= '.kt_page_loader.style-1 .kt_spinner,.kt_page_loader.style-2 .kt_spinner::after{background-color: '.$color_first_loader.';}';
    $css .= '.kt_page_loader.style-2 .kt_spinner,.kt_page_loader.style-3 .kt_spinner{ border-color:'.$color_second_loader.'; }';
    $css .= '.kt_page_loader.style-3 .kt_spinner{ border-bottom-color:'.$color_first_loader.'; }';



    wp_add_inline_style( 'kt-main', $css );

}
add_action('wp_enqueue_scripts', 'kt_setting_script');



if(!function_exists('kt_setting_script_footer')){
    /**
     * Add advanced js to footer
     *
     */
    function kt_setting_script_footer() {
        $advanced_js = kt_option('advanced_editor_js');
        if($advanced_js){
            echo sprintf('<script type="text/javascript">%s</script>', $advanced_js);
        }
    }
    add_action('wp_footer', 'kt_setting_script_footer', 100);
}


function kt_excerpt_length( ) {
    if(is_search()){
        $excerpt_length = kt_option('search_excerpt_length', 35);
    }elseif(is_author()){
        $excerpt_length = kt_option('author_excerpt_length', 35);
    }else{
        $excerpt_length = kt_option('archive_excerpt_length', 40);
    }
    return $excerpt_length;
}
add_filter( 'excerpt_length', 'kt_excerpt_length', 99 );

/**
 *
 *
 * Control the number of search results
 */
function kt_custom_posts_per_page( $query ) {
    if(!is_admin()){
        if(isset($_REQUEST['per_page'])){
            $posts_per_page = $_REQUEST['per_page'];
        }elseif(is_search()){
            $posts_per_page = kt_option('search_posts_per_page', 9);
        }elseif ( $query->is_author()) {
            $posts_per_page = kt_option('author_posts_per_page', 9);
        }elseif($query->is_archive()){
            $posts_per_page = kt_option('archive_posts_per_page', 14);
        }
        if(isset($posts_per_page)){
            set_query_var('posts_per_page', $posts_per_page);
        }
    }
}
add_action( 'pre_get_posts', 'kt_custom_posts_per_page' );


function kt_get_post_thumbnail_url($size = 'post-thumbnail', $post_id = null){
    global $post;
        if(!$post_id) $post_id = $post->ID;

    $image_url = false;
    if(has_post_thumbnail($post_id)){
        $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
        if($attachment_image){
            $image_url = $attachment_image[0];
        }
    }else{
        $image_url = apply_filters( 'kt_placeholder', $size );
    }
    return $image_url;
}


if ( ! function_exists( 'kt_post_thumbnail_image' ) ) :
    /**
     * Display an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     *
     */
    function kt_post_thumbnail_image($size = 'post-thumbnail', $class_img = '', $link = true, $placeholder = true, $echo = true) {
        if ( post_password_required() || is_attachment()) {
            return;
        }
        $class = 'entry-thumb';
        $attrs = '';
        if( $link ){
            $tag = 'a';
            $attrs .= 'href="'.get_the_permalink().'"';
        } else{
            $tag = 'div';
        }
        if(!has_post_thumbnail() && $placeholder){
            $class .= ' no-image';
        }

        if(!$echo){
            ob_start();
        }

        if(has_post_thumbnail() || $placeholder){ ?>
            <<?php echo $tag ?> <?php echo $attrs ?> class="<?php echo esc_attr($class); ?>">
            <?php if(has_post_thumbnail()){ ?>
                <?php the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) ); ?>
            <?php }elseif($placeholder){ ?>
                <?php
                    $image = apply_filters( 'kt_placeholder', $size );
                    printf(
                        '<img src="%s" alt="%s" class="%s"/>',
                        $image,
                        esc_html__('No image', 'adroit'),
                        $class_img.' no-image'
                    )
                ?>
            <?php } ?>
            </<?php echo $tag ?>><!-- .entry-thumb -->
        <?php }

        if(!$echo){
            return ob_get_clean();
        }
    }
endif;
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 */

if ( ! function_exists( 'kt_post_thumbnail' ) ) :

    function kt_post_thumbnail($size = 'post-thumbnail', $class_img = '', $link = true) {
        if ( post_password_required() || is_attachment()) {
            return;
        }
        $format = get_post_format();
        $post_id = get_the_ID();

        if(has_post_thumbnail() && $format == ''){ ?>

            <?php if ( $link ){ ?>
                <a href="<?php the_permalink(); ?>" aria-hidden="true" class="entry-thumb">
            <?php }else{ ?>
                <div class="entry-thumb">
            <?php } ?>
                <?php the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) ); ?>
            <?php if ( $link ){ ?>
                </a>
            <?php }else{ ?>
                </div><!-- .entry-thumb -->
            <?php } ?>
        <?php }elseif($format == 'gallery'){
            $type = get_post_meta($post_id, '_kt_gallery_type', true);
            if($type == 'slider' ||!$type){
                $images = kt_get_galleries_post('_kt_gallery_images', 'kt_blog_post');
                if($images){
                    $slider_class = array('blog-posts-slick');
                    $slider_option = '{}';
                    $slider_html = '';
                    foreach($images as $image){
                        $slider_html .= sprintf(
                            '<div class="gallery-slider-item">%1$s</div>',
                            '<img src="'.$image['url'].'" title="'.esc_attr($image['title']).'" alt="'.esc_attr($image['alt']).'">'
                        );
                    }
                    printf(
                        '<div class="entry-thumb"><div class="%1$s" data-slick=\'%2$s\'>%3$s</div></div><!-- .entry-thumb -->',
                        implode(' ', $slider_class),
                        esc_attr($slider_option),
                        $slider_html
                    );
                }
            }elseif($type == 'grid'){
                $images = kt_get_galleries_post('_kt_gallery_images', 'kt_gallery_fullwidth');
                $gallery = '';
                if($images){
                    foreach($images as $image){
                        $gallery .= sprintf(
                            '<div class="%s">%s</div>',
                            'gallery-image-item',
                            '<img src="'.$image['url'].'" title="'.esc_attr($image['title']).'" alt="'.esc_attr($image['alt']).'">'
                        );
                    }
                    printf(
                        '<div class="entry-thumb"><div class="%s">%s</div></div><!-- .entry-thumb -->',
                        'gallery-images gallery-fullwidth clearfix',
                        $gallery
                    );
                }
            }elseif($type == 'revslider' && class_exists( 'RevSlider' )){
                if ($rev = rwmb_meta('_kt_gallery_rev_slider')) {
                    echo '<div class="entry-thumb">';
                    putRevSlider($rev);
                    echo '</div><!-- .entry-thumb -->';
                }
            }elseif($type == 'layerslider' && is_plugin_active( 'LayerSlider/layerslider.php' )){
                if($layerslider = rwmb_meta('_kt_gallery_layerslider')){
                    echo '<div class="entry-thumb">';
                    echo do_shortcode('[layerslider id="'.rwmb_meta('_kt_gallery_layerslider').'"]');
                    echo '</div><!-- .entry-thumb -->';
                }
            }
        }elseif($format == 'video'){
            $type = rwmb_meta('_kt_video_type');
            if($type == 'upload'){
                $mp4 = kt_get_single_file('_kt_video_file_mp4');
                $webm = kt_get_single_file('_kt_video_file_webm');
                if($mp4 || $webm){
                    $video_shortcode = "[video ";
                    if($mp4) $video_shortcode .= 'mp4="'.$mp4.'" ';
                    if($webm) $video_shortcode .= 'webm="'.$webm.'" ';
                    $video_shortcode .= "]";
                    echo '<div class="entry-thumb">'.do_shortcode($video_shortcode).'</div><!-- .entry-thumb -->';
                }

            }elseif($type == 'external'){

                $video = get_post_meta($post_id, '_kt_choose_video', true);
                $video_id = get_post_meta($post_id, '_kt_video_id', true);

                if($video == 'youtube'){
                    printf(
                        '<div class="entry-thumb"><div class="embed-responsive embed-responsive-16by9">%s</div></div><!-- .entry-thumb -->',
                        kt_video_youtube($video_id)
                    );
                }elseif($video == 'vimeo'){
                    printf(
                        '<div class="entry-thumb"><div class="embed-responsive embed-responsive-16by9">%s</div></div><!-- .entry-thumb -->',
                        kt_video_vimeo($video_id)
                    );
                }
            }
        }elseif($format == 'audio'){
            $type = rwmb_meta('_kt_audio_type');
            if($type == 'upload'){
                if($audios = rwmb_meta('_kt_audio_mp3', 'type=file')){

                    printf(
                        '<div class="entry-thumb entry-thumb-audio" style="%s">',
                        "background-image: url('".get_the_post_thumbnail_url()."');"
                    );
                    foreach($audios as $audio) {
                        echo do_shortcode('[audio src="'.$audio['url'].'"][/audio]');
                        break;
                    }
                    echo '</div><!-- .entry-thumb-audio -->';

                }
            } elseif( $type == 'soundcloud' ){
                if($soundcloud = rwmb_meta('_kt_audio_soundcloud')){
                    echo '<div class="entry-thumb">';
                    echo do_shortcode($soundcloud);
                    echo '</div><!-- .entry-thumb -->';
                }
            }
        } elseif ( $format == 'quote' ){ ?>
            <div class="entry-thumb post-quote-wrapper">
                <blockquote class="post-item-quote">
                    <p><?php echo rwmb_meta('_kt_quote_content'); ?></p>
                    <footer><?php echo rwmb_meta('_kt_quote_author'); ?></footer>
                </blockquote>
                <?php if ( $link ){ ?>
                    <a href="<?php the_permalink(); ?>" aria-hidden="true" class="post-quote-link"><?php the_title(); ?></a>
                <?php } ?>
            </div><!-- .post-quote-wrapper -->
        <?php }
    }
endif;



if ( ! function_exists( 'kt_comment_nav' ) ) :
    /**
     * Display navigation to next/previous comments when applicable.
     *
     */
    function kt_comment_nav() {
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
            <nav class="navigation comment-navigation clearfix">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'adroit' ); ?></h2>
                <div class="nav-links">
                    <?php
                    if ( $prev_link = get_previous_comments_link( '<i class="fa fa-angle-double-left"></i> '.esc_html__( 'Older Comments', 'adroit' ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', $prev_link );
                    endif;

                    if ( $next_link = get_next_comments_link( '<i class="fa fa-angle-double-right"></i> '.esc_html__( 'Newer Comments',  'adroit' ) ) ) :
                        printf( '<div class="nav-next">%s</div>', $next_link );
                    endif;

                    ?>
                </div><!-- .nav-links -->
            </nav><!-- .comment-navigation -->
        <?php
        endif;
    }
endif;


if ( ! function_exists( 'kt_entry_meta_comments' ) ) :
    /**
     * Prints HTML with meta information for comments.
     *
     */
    function kt_entry_meta_comments() {
        if ( !shortcode_exists( 'fbcomments' ) ) {
            if (! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                echo '<span class="comments-link">';
                comments_popup_link( 0, 1, '%');
                echo '</span>';
            }
        }
    }
endif;

/**
 *
 * Custom call back function for default post type
 *
 * @param $comment
 * @param $args
 * @param $depth
 */
function kt_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( '' ); ?>>
            <div class="comment-body">
                <?php _e( 'Pingback:', '_tk' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', '_tk' ), '<span class="edit-link">', '</span>' ); ?>
            </div>

	<?php else : ?>

        <li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID() ?>">
            <div  id="comment-<?php comment_ID(); ?>" class="comment-item clearfix">

                <div class="comment-avatar">
                    <?php echo get_avatar($comment->comment_author_email, $size='100',$default='' ); ?>
                </div>
                <div class="comment-content">
                    <div class="comment-meta">
                        <h5 class="author_name">
                            <?php comment_author_link(); ?>
                        </h5>
                        <span class="comment-date">
                            <?php printf( _x( '%s ago', '%s = human-readable time difference', 'adroit' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                        </span>
                    </div>
                    <div class="comment-entry entry-content">
                        <?php comment_text() ?>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em><?php esc_html_e('Your comment is awaiting moderation.', 'adroit') ?></em>
                        <?php endif; ?>
                    </div>
                    <div class="comment-actions">
                        <?php edit_comment_link( '<span class="icon-pencil"></span> '.esc_html__('Edit', 'adroit'),'  ',' ') ?>
                        <?php comment_reply_link( array_merge( $args,
                            array('depth' => $depth,
                                'max_depth' => $args['max_depth'],
                                'reply_text' =>'<span class="icon-action-undo"></span> '.esc_html__('Reply','adroit')
                            ))) ?>
                    </div>
                </div>
            </div>
        <?php
    endif;
}


if ( ! function_exists( 'kt_post_nav' ) ) :
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function kt_post_nav($post_id = null) {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
        $next     = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous ) return;

        ?>
        <nav class="navigation post-navigation clearfix">
            <div class="nav-links">
                <?php
                    if( get_option( 'page_for_posts' ) ){
                        $link_blog = get_permalink( get_option( 'page_for_posts' ) );
                    }else{
                        $link_blog = get_site_url();
                    }
                    echo '<div class="nav-blog meta-nav"><a href="'.$link_blog.'"><span>
							<i class="b1 c1"></i><i class="b1 c2"></i><i class="b1 c3"></i>
							<i class="b2 c1"></i><i class="b2 c2"></i><i class="b2 c3"></i>
							<i class="b3 c1"></i><i class="b3 c2"></i><i class="b3 c3"></i>
						</span></a></div>';

                    
                    if(!get_previous_post_link('&laquo; %link', '', true)){
                        printf('<div class="nav-previous meta-nav"><span>%s</span></div>', __( '<span>Previous Article</span>', 'adroit' ));
                    }else{
                        previous_post_link('<div class="nav-previous meta-nav">%link</div>', __( '<span>Previous Article</span>', 'adroit' ), TRUE);
                    }

                    if(!get_next_post_link('&laquo; %link', '', true)){
                        printf('<div class="nav-next meta-nav"><span>%s</span></div>', __( '<span>Next Article</span>', 'adroit' ));
                    }else{
                        next_post_link('<div class="nav-next meta-nav">%link</div>', __( '<span>Next Article</span>', 'adroit' ), TRUE);
                    }
                ?>
            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
    <?php
}
endif;



if ( ! function_exists( 'kt_paging_nav' ) ) :
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function kt_paging_nav( $type = 'normal' ) {

        global $wp_query;

        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        if($type == 'none'){
            return ;
        }elseif($type == 'button'){ ?>
            <nav class="navigation post-navigation clearfix">
                <h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'adroit' ); ?></h1>
                <div class="nav-links">
                    <?php if ( get_next_posts_link() ) : ?>
                        <div class="nav-previous"><?php next_posts_link( '<i class="fa fa-long-arrow-left"></i> '.esc_html__( 'Older posts', 'adroit' ) ); ?></div>
                    <?php endif; ?>
                    <?php if ( get_previous_posts_link() ) : ?>
                        <div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'adroit' ).' <i class="fa fa-long-arrow-right"></i>' ); ?></div>
                    <?php endif; ?>
                </div><!-- .nav-links -->
            </nav><!-- .navigation -->

        <?php }else{

            the_posts_pagination();
        }
    }
endif;




if ( ! function_exists( 'kt_entry_meta_categories' ) ) :
    /**
     * Prints HTML with meta information for categories.
     *
     */
    function kt_entry_meta_categories( $separator = ', ') {
        if ( 'post' == get_post_type() ) {
            $categories_list = get_the_category_list(  $separator );
            if ( $categories_list ) {
                printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span> %2$s</span>',
                    _x( 'Categories', 'Used before category names.', 'adroit' ),
                    $categories_list
                );
            }
        }
    }
endif;

if ( ! function_exists( 'kt_entry_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own kt_entry_excerpt() function to override in a child theme.
	 *
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function kt_entry_excerpt( $class = 'entry-summary' ) {
		$class = esc_attr( $class );
		 ?>
			<div class="<?php echo esc_attr($class); ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo esc_attr($class); ?> -->
		<?php
	}
endif;

if ( ! function_exists( 'kt_entry_meta_tags' ) ) :
    /**
     * Prints HTML with meta information for tags.
     *
     */
    function kt_entry_meta_tags($before = '', $after = '') {
        if ( 'post' == get_post_type() ) {
            $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'adroit' ) );
            if ( $tags_list ) {
                printf( '%3$s<span class="tags-links"><span class="tags-links-text">%1$s</span> %2$s</span>%4$s',
                    _x( 'Tags: ', 'Used before tag names.', 'adroit' ),
                    $tags_list,
                    $before,
                    $after
                );
            }
        }
    }
endif;



if ( ! function_exists( 'kt_entry_meta_author' ) ) :
    /**
     * Prints HTML with meta information for author.
     *
     */
    function kt_entry_meta_author() {
        if ( 'post' === get_post_type() ) {
            printf( '<span class="author vcard">%4$s <span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span>',
                _x( 'Author', 'Used before post author name.', 'adroit' ),
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                get_the_author(),
                esc_html__('By:', 'adroit' )
            );
        }
    }
endif;


if ( ! function_exists( 'kt_entry_meta' ) ) {
    /**
     * Prints HTML with meta information for the categories, tags.
     *
     * Create your own kt_entry_meta() function to override in a child theme.
     *
     */
    function kt_entry_meta( $share = false ) {
        echo '<div class="post-item-meta">';
        echo '<div class="post-item-metaleft pull-left">';
            kt_entry_meta_author( );
            kt_entry_date( );
        echo '</div><!-- .post-item-metaleft -->';
        echo '<div class="post-item-metaright pull-right">';
            if($share){
                kt_share_box();
            }
            kt_get_post_views( );
            kt_entry_meta_comments( );
        echo '</div><!-- .post-item-metaright -->';
        echo '<div class="clearfix"></div></div><!-- .post-item-meta -->';
    }
}


if ( ! function_exists( 'kt_entry_date' ) ) {
    /**
     * Prints HTML with date information for current post.
     *
     */
    function kt_entry_date($format = 'd F Y') {
        if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
            $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

            if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }

            $time_show = ($format == 'time') ? human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__(' ago', 'adroit') : get_the_date($format);

            $time_string = sprintf( $time_string,
                esc_attr( get_the_date( 'c' ) ),
                $time_show,
                esc_attr( get_the_modified_date( 'c' ) ),
                get_the_modified_date()
            );

            printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                _x( 'Posted on', 'Used before publish date.', 'adroit' ),
                //esc_url( get_permalink() ),
                $time_string
            );
        }
    }
}

/* ---------------------------------------------------------------------------
 * Posts Views Number
 * --------------------------------------------------------------------------- */

if ( ! function_exists( 'kt_get_post_views' ) ){
    /**
     * Prints HTML with date information for current post.
     *
     * Create your own kt_get_post_views() function to override in a child theme.
     *
     */
    function kt_get_post_views($post_id = null){
        if('post' == get_post_type()) {
            global $post;
            if(!$post_id){ $post_id = $post->ID; }
            $count_key = 'kt_post_views_count';
            $count = get_post_meta($post_id, $count_key, true);
            if( $count == '' || $count == 0 ){
                delete_post_meta($post_id, $count_key);
                add_post_meta($post_id, $count_key, '0');
                $count = 0;
            }
            $text = ($count == 0 || $count == 1) ? esc_html__('View','adroit') : esc_html__('Views','adroit');
            printf(
                '<span class="post-view">%s<span class="screen-reader-text">%s</span></span>',
                $count,
                $text
            );
        }
    }
}

if ( ! function_exists( 'kt_like_post' ) ){
    function kt_like_post( $before = '', $after = '', $post_id = null ) {
        global $post;
        if(!$post_id){ $post_id = $post->ID; }

        $like_count = get_post_meta($post_id, '_like_post', true);

        if( !$like_count ){
            $like_count = 0;
            add_post_meta($post_id, '_like_post', $like_count, true);
        }

        $class = 'kt_likepost';
        $title = esc_html__('Like this post', 'adroit');
        $already =  esc_html__('You already like this!', 'adroit');

        if( isset($_COOKIE['like_post_'. $post_id]) ){
            $class .= ' liked';
            $title = $already;
        }

        $output = "<a data-id='".$post_id."' data-already='".esc_attr($already)."' class='".esc_attr($class)."' href='".get_the_permalink($post_id)."#".$post_id."' title='".esc_attr($title)."'>".$like_count.'</a>';

        echo $before . $output . $after;
    }
}

/* ---------------------------------------------------------------------------
 * Share Box [share_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'kt_share_box' ) ){
    function kt_share_box($post_id = null, $style = "", $class = 'post-item-share'){
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $link = urlencode(get_permalink($post_id));
        $title = urlencode(addslashes(get_the_title($post_id)));
        $excerpt = urlencode(get_the_excerpt());
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');

        $html = '';

        $social_share = kt_option('social_share');

        $count = kt_total_post_share_count($link);

        foreach($social_share as $key => $val){
            if($val){
                if($key == 'facebook'){
                    // Facebook
                    $html .= '<li><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $link.'\', \'sharer\', \'toolbar=0,status=0,width=620,height=280\');popUp.focus();return false;">';
                    $html .= '<i class="fa fa-facebook"></i><span>'.esc_html__('Facebook', 'adroit').'</span>';
                    $html .= '</a></li>';
                }elseif($key == 'twitter'){
                    // Twitter
                    $html .= '<li><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://twitter.com/home?status=' . $link . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;">';
                    $html .= '<i class="fa fa-twitter"></i><span>'.esc_html__('Twitter', 'adroit').'</span>';
                    $html .= '</a></li>';
                }elseif($key == 'google_plus'){
                    // Google plus
                    $html .= '<li><a class="'.$style.'" href="#" onclick="popUp=window.open(\'https://plus.google.com/share?url=' . $link . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                    $html .= '<i class="fa fa-google-plus"></i><span>'.esc_html__('Google+', 'adroit').'</span>';
                    $html .= "</a></li>";
                }elseif($key == 'pinterest'){
                    // Pinterest
                    $html .= '<li><a class="share_link" href="#" onclick="popUp=window.open(\'http://pinterest.com/pin/create/button/?url=' . $link . '&amp;description=' . $title . '&amp;media=' . urlencode($image[0]) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                    $html .= '<i class="fa fa-pinterest"></i><span>'.esc_html__('Pinterest', 'adroit').'</span>';
                    $html .= "</a></li>";
                }elseif($key == 'linkedin'){
                    // linkedin
                    $html .= '<li><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://linkedin.com/shareArticle?mini=true&amp;url=' . $link . '&amp;title=' . $title. '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                    $html .= '<i class="fa fa-linkedin"></i><span>'.esc_html__('LinkedIn', 'adroit').'</span>';
                    $html .= "</a></li>";
                }elseif($key == 'tumblr'){
                    // Tumblr
                    $html .= '<li><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://www.tumblr.com/share/link?url=' . $link . '&amp;name=' . $title . '&amp;description=' . $excerpt . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                    $html .= '<i class="fa fa-tumblr"></i><span>'.esc_html__('Tumblr', 'adroit').'</span>';
                    $html .= "</a></li>";
                }elseif($key == 'email'){
                    // Email
                    $html .= '<li><a class="'.$style.'" href="mailto:?subject='.$title.'&amp;body='.$link.'">';
                    $html .= '<i class="fa fa-envelope-o"></i><span>'.esc_html__('Mail', 'adroit').'</span>';
                    $html .= "</a></li>";
                }
            }
        }

 

        if($html){
            printf(
                '<div class="%s"> <a href="#">%s</a><ul>%s</ul></div>',
                $class,
                $count,
                $html
            );
        }
    }
}


/* ---------------------------------------------------------------------------
 * Related Article [related_article]
 * --------------------------------------------------------------------------- */
if ( ! function_exists( 'kt_related_article' ) ) :
    function kt_related_article($post_id = null, $type = 'categories'){
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $posts_per_page = kt_option('blog_related_sidebar', 5);

        $args = array(
            'posts_per_page' => $posts_per_page,
            'post__not_in' => array($post_id)
        );
        if($type == 'tags'){
            $tags = wp_get_post_tags($post_id);
            if(!$tags) return false;
            $tag_ids = array();
            foreach($tags as $tag)
                $tag_ids[] = $tag->term_id;
            $args['tag__in'] = $tag_ids;
        }elseif($type == 'author'){
            $args['author'] = get_the_author();
        }else{
            $categories = get_the_category($post_id);
            if(!$categories) return false;
            $category_ids = array();
            foreach($categories as $category)
                $category_ids[] = $category->term_id;
            $args['category__in'] = $category_ids;
        }
        $query = new WP_Query( $args );
        ?>
        <?php if($query->have_posts()){ ?>
            <div id="related-article">
                <h3 class="post-single-heading"><?php esc_html_e('Related Article', 'adroit'); ?></h3>
                <div class="blog-posts-related">
                <?php
                while ( $query->have_posts() ) : $query->the_post();
                    get_template_part( 'templates/blog/grid/content', get_post_format());
                endwhile;
                ?>
                </div>
            </div><!-- #related-article -->
    <?php }
        wp_reset_postdata();
    }
endif;
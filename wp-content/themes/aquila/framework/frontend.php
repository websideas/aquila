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




add_action( 'after_setup_theme', 'theme_setup' );
if ( ! function_exists( 'theme_setup' ) ):

function theme_setup() {
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
        add_image_size( 'recent_posts', 570, 355, true);
        add_image_size( 'recent_posts_masonry', 570);
        add_image_size( 'first_featured', 670, 500, true);

        add_image_size( 'small', 170, 170, true );
        add_image_size( 'blog_post', 1140, 600, true );

        add_image_size( 'blog_post_sidebar', 1140 );
        add_image_size( 'blog_post_slider', 1460, 800, true );
    }
    
    load_theme_textdomain( THEME_LANG, THEME_DIR . '/languages' );
    
    /**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(array(
        'primary' => __('Main Navigation Menu', THEME_LANG),
        'mobile' => __('(Mobile Devices) Main Navigation Menu', THEME_LANG),
        'footer'	  => __( 'Footer Navigation Menu', THEME_LANG ),
        'bottom'	  => __( 'Bottom Menu', THEME_LANG ),
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

    wp_enqueue_style( 'mediaelement-style', get_stylesheet_uri(), array('mediaelement', 'wp-mediaelement') );
    wp_enqueue_style( 'bootstrap-css', THEME_LIBS . 'bootstrap/css/bootstrap.css', array());
    wp_enqueue_style( 'font-awesome', THEME_FONTS . 'font-awesome/css/font-awesome.min.css', array());
    wp_enqueue_style( 'plugins', THEME_CSS . 'plugins.css', array());

	// Load our main stylesheet.
    wp_enqueue_style( 'kitetheme-main', THEME_CSS . 'style.css', array( 'mediaelement-style' ) );
    wp_enqueue_style( 'queries', THEME_CSS . 'queries.css', array('kitetheme-main') );
    
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'kitetheme-ie', THEME_CSS . 'ie.css', array( 'kitetheme-main' ) );
	wp_style_add_data( 'kitetheme-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    wp_register_script('google-maps-api','http://maps.googleapis.com/maps/api/js?sensor=false', array( 'jquery' ), null, false);
    wp_enqueue_script( 'bootstrap-script', THEME_LIBS . 'bootstrap/js/bootstrap.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'plugins-script', THEME_JS . 'plugins.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'main-script', THEME_JS . 'functions.js', array( 'jquery', 'mediaelement', 'wp-mediaelement', 'jquery-ui-tabs' ), null, true );


    global $wp_query;
    wp_localize_script( 'main-script', 'ajax_frontend', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'ajax_frontend' ),
        'current_date' => date_i18n('Y-m-d H:i:s'),
        'query_vars' => json_encode( $wp_query->query ),
        'days' => __('Days', THEME_LANG),
        'hours' => __('Hours', THEME_LANG),
        'minutes' => __('Minutes', THEME_LANG),
        'seconds' => __('Seconds', THEME_LANG),
    ));
    
}
add_action( 'wp_enqueue_scripts', 'kt_add_scripts' , 69 );


/**
 * Add scroll to top
 *
 */
add_action( 'theme_before_footer_top', 'theme_after_footer_top_addscroll' );
function theme_after_footer_top_addscroll(){
    echo "<a href='#top' id='backtotop'></a>";
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
function custom_posts_per_page( $query ) {
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
add_action( 'pre_get_posts', 'custom_posts_per_page' );


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
            <<?php echo $tag ?> <?php echo $attrs ?> class="<?php echo $class; ?>">
            <?php if(has_post_thumbnail()){ ?>
                <?php the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) ); ?>
            <?php }elseif($placeholder){ ?>
                <?php
                    $image = apply_filters( 'kt_placeholder', $size );
                    printf(
                        '<img src="%s" alt="%s" class="%s"/>',
                        $image,
                        __('No image', THEME_LANG),
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
                $images = get_galleries_post('_kt_gallery_images', 'blog_post');
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
                $images = get_galleries_post('_kt_gallery_images', 'recent_posts_masonry');
                $gallery = '';
                if($images){
                    foreach($images as $image){
                        $gallery .= sprintf(
                            '<div class="%s">%s</div>',
                            'gallery-image-item',
                            '<a href="'.$image['full_url'].'"><span></span><img src="'.$image['url'].'" title="'.esc_attr($image['title']).'" alt="'.esc_attr($image['alt']).'"></a>'
                        );
                    }
                    printf(
                        '<div class="entry-thumb"><div class="%s">%s</div></div><!-- .entry-thumb -->',
                        'gallery-images gallery-images-justified  clearfix',
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
                        video_youtube($video_id)
                    );
                }elseif($video == 'vimeo'){
                    printf(
                        '<div class="entry-thumb"><div class="embed-responsive embed-responsive-16by9">%s</div></div><!-- .entry-thumb -->',
                        video_vimeo($video_id)
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
                <h2 class="screen-reader-text"><?php _e( 'Comment navigation', THEME_LANG ); ?></h2>
                <div class="nav-links">
                    <?php
                    if ( $prev_link = get_previous_comments_link( '<i class="fa fa-angle-double-left"></i> '.__( 'Older Comments', THEME_LANG ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', $prev_link );
                    endif;

                    if ( $next_link = get_next_comments_link( '<i class="fa fa-angle-double-right"></i> '.__( 'Newer Comments',  THEME_LANG ) ) ) :
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
    ?>

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
                    <?php printf( _x( '%s ago', '%s = human-readable time difference', THEME_LANG ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                </span>
            </div>
            <div class="comment-entry entry-content">
                <?php comment_text() ?>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php _e('Your comment is awaiting moderation.', THEME_LANG) ?></em>
                <?php endif; ?>
            </div>
            <div class="comment-actions">
                <?php edit_comment_link( '<span class="icon-pencil"></span> '.__('Edit', THEME_LANG),'  ',' ') ?>
                <?php comment_reply_link( array_merge( $args,
                    array('depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' =>'<span class="icon-action-undo"></span> '.__('Reply')
                    ))) ?>
            </div>
        </div>
    </div>
<?php
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
                        printf('<div class="nav-previous meta-nav"><span>%s</span></div>', __( '<span>Previous Article</span>', THEME_LANG ));
                    }else{
                        previous_post_link('<div class="nav-previous meta-nav">%link</div>', __( '<span>Previous Article</span>', THEME_LANG ), TRUE);
                    }

                    if(!get_next_post_link('&laquo; %link', '', true)){
                        printf('<div class="nav-next meta-nav"><span>%s</span></div>', __( '<span>Next Article</span>', THEME_LANG ));
                    }else{
                        next_post_link('<div class="nav-next meta-nav">%link</div>', __( '<span>Next Article</span>', THEME_LANG ), TRUE);
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
                <h1 class="screen-reader-text"><?php _e( 'Posts navigation', THEME_LANG ); ?></h1>
                <div class="nav-links">
                    <?php if ( get_next_posts_link() ) : ?>
                        <div class="nav-previous"><?php next_posts_link( '<i class="fa fa-long-arrow-left"></i> '.__( 'Older posts', THEME_LANG ) ); ?></div>
                    <?php endif; ?>
                    <?php if ( get_previous_posts_link() ) : ?>
                        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts', THEME_LANG ).' <i class="fa fa-long-arrow-right"></i>' ); ?></div>
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
            $categories_list = get_the_category_list( _x( $separator, 'Used between list items, there is a space after the comma.', THEME_LANG ) );
            if ( $categories_list ) {
                printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span> %2$s</span>',
                    _x( 'Categories', 'Used before category names.', THEME_LANG ),
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
			<div class="<?php echo $class; ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo $class; ?> -->
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
            $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', THEME_LANG ) );
            if ( $tags_list ) {
                printf( '%3$s<span class="tags-links"><span class="tags-links-text">%1$s</span> %2$s</span>%4$s',
                    _x( 'Tags: ', 'Used before tag names.', THEME_LANG ),
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
                _x( 'Author', 'Used before post author name.', THEME_LANG ),
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                get_the_author(),
                __('By:', THEME_LANG )
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
     * Create your own twentysixteen_entry_date() function to override in a child theme.
     *
     */
    function kt_entry_date($format = 'd F Y') {
        if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
            $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

            if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }

            $time_show = ($format == 'time') ? human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago', THEME_LANG) : get_the_date($format);

            $time_string = sprintf( $time_string,
                esc_attr( get_the_date( 'c' ) ),
                $time_show,
                esc_attr( get_the_modified_date( 'c' ) ),
                get_the_modified_date()
            );

            printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                _x( 'Posted on', 'Used before publish date.', THEME_LANG ),
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
            $text = ($count == 0 || $count == 1) ? __('View',THEME_LANG) : __('Views',THEME_LANG);
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
        $title = __('Like this post', THEME_LANG);
        $already =  __('You already like this!', THEME_LANG);

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



        foreach($social_share as $key => $val){
            if($val){
                if($key == 'facebook'){
                    // Facebook
                    $html .= '<li><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $link.'\', \'sharer\', \'toolbar=0,status=0,width=620,height=280\');popUp.focus();return false;">';
                    $html .= '<i class="fa fa-facebook"></i><span>'.__('Facebook', THEME_LANG).'</span>';
                    $html .= '</a></li>';
                }elseif($key == 'twitter'){
                    // Twitter
                    $html .= '<li><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://twitter.com/home?status=' . $link . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;">';
                    $html .= '<i class="fa fa-twitter"></i><span>'.__('Twitter', THEME_LANG).'</span>';
                    $html .= '</a></li>';
                }elseif($key == 'google_plus'){
                    // Google plus
                    $html .= '<li><a class="'.$style.'" href="#" onclick="popUp=window.open(\'https://plus.google.com/share?url=' . $link . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                    $html .= '<i class="fa fa-google-plus"></i><span>'.__('Google+', THEME_LANG).'</span>';
                    $html .= "</a></li>";
                }elseif($key == 'pinterest'){
                    // Pinterest
                    $html .= '<li><a class="share_link" href="#" onclick="popUp=window.open(\'http://pinterest.com/pin/create/button/?url=' . $link . '&amp;description=' . $title . '&amp;media=' . urlencode($image[0]) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                    $html .= '<i class="fa fa-pinterest"></i><span>'.__('Pinterest', THEME_LANG).'</span>';
                    $html .= "</a></li>";
                }elseif($key == 'linkedin'){
                    // linkedin
                    $html .= '<li><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://linkedin.com/shareArticle?mini=true&amp;url=' . $link . '&amp;title=' . $title. '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                    $html .= '<i class="fa fa-linkedin"></i><span>'.__('LinkedIn', THEME_LANG).'</span>';
                    $html .= "</a></li>";
                }elseif($key == 'tumblr'){
                    // Tumblr
                    $html .= '<li><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://www.tumblr.com/share/link?url=' . $link . '&amp;name=' . $title . '&amp;description=' . $excerpt . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                    $html .= '<i class="fa fa-tumblr"></i><span>'.__('Tumblr', THEME_LANG).'</span>';
                    $html .= "</a></li>";
                }elseif($key == 'email'){
                    // Email
                    $html .= '<li><a class="'.$style.'" href="mailto:?subject='.$title.'&amp;body='.$link.'">';
                    $html .= '<i class="fa fa-envelope-o"></i><span>'.__('Mail', THEME_LANG).'</span>';
                    $html .= "</a></li>";
                }
            }
        }



        if($html){
            printf(
                '<div class="%s"> <a href="#">5</a><ul>%s</ul></div>',
                $class,
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
                <h3 class="post-single-heading"><?php _e('Related Article', THEME_LANG); ?></h3>
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
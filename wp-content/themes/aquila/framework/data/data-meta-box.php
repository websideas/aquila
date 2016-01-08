<?php
/**
 * All helpers for theme
 *
 */
 
 
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;




add_filter( 'rwmb_meta_boxes', 'kt_register_meta_boxes' );
function kt_register_meta_boxes( $meta_boxes )
{

    $prefix = '_kt_';
    $menus = wp_get_nav_menus();

    $menus_arr = array('' => esc_html__('Default', 'aquila'));
    foreach ( $menus as $menu ) {
        $menus_arr[$menu->term_id] = esc_html( $menu->name );
    }

    $sidebars = array();

    foreach($GLOBALS['wp_registered_sidebars'] as $sidebar){
        $sidebars[$sidebar['id']] = ucwords( $sidebar['name'] );
    }

    /**
     * For Post Audio
     *
     */
    $meta_boxes[] = array(
        'title'  => esc_html__('Audio Settings','aquila'),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Audio'),
        ),
        'fields' => array(
            array(
                'name' => esc_html__('Audio Type', 'aquila'),
                'id' => $prefix . 'audio_type',
                'type'     => 'select',
                'options'  => array(
                    '' => esc_html__('Select Option', 'aquila'),
                    'upload' => esc_html__('Upload', 'aquila'),
                    'soundcloud' => esc_html__('Soundcloud', 'aquila'),
                ),
            ),
            array(
                'name'             => __( 'Upload MP3 File', 'aquila' ),
                'id'               => "{$prefix}audio_mp3",
                'type'             => 'file_advanced',
                'max_file_uploads' => 1,
                'mime_type'        => 'audio', // Leave blank for all file types
                'visible' => array($prefix . 'audio_type', '=', 'upload')
            ),
            array(
                'name' => esc_html__( 'Soundcloud', 'aquila' ),
                'desc' => esc_html__( 'Paste embed iframe or Wordpress shortcode.', 'aquila' ),
                'id'   => "{$prefix}audio_soundcloud",
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 3,
                'visible' => array($prefix . 'audio_type', '=', 'soundcloud')
            ),
        ),
    );

    /**
     * For Video
     *
     */

    $meta_boxes[] = array(
        'title'  => esc_html__('Video Settings','aquila'),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Video'),
        ),

        'fields' => array(
            array(
                'name' => esc_html__('Video Type', 'aquila'),
                'id' => $prefix . 'video_type',
                'type'     => 'select',
                'options'  => array(
                    '' => esc_html__('Select Option', 'aquila'),
                    'external' => esc_html__('External url', 'aquila'),
                ),
            ),
            array(
                'name' => esc_html__('Choose Video', 'aquila'),
                'id' => $prefix . 'choose_video',
                'type'     => 'select',
                'options'  => array(
                    'youtube' => esc_html__('Youtube', 'aquila'),
                    'vimeo' => esc_html__('Vimeo', 'aquila'),
                ),
                'visible' => array($prefix . 'video_type', '=', 'external')
            ),
            array(
                'name' => esc_html__( 'Video id', 'aquila' ),
                'id' => $prefix . 'video_id',
                'desc' => sprintf( esc_html__( 'Enter id of video .Example: <br />- Link video youtube: https://www.youtube.com/watch?v=nPOO1Coe2DI id of video: nPOO1Coe2DI <br /> -Link vimeo: https://vimeo.com/70296428 id video: 70296428.', 'aquila' ) ),
                'type'  => 'text',
                'visible' => array($prefix . 'video_type', '=', 'external')
            ),
        ),
    );

    /**
     * For Gallery
     *
     */

    $meta_boxes[] = array(
        'title'  => esc_html__('Gallery Settings','aquila'),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Gallery'),
        ),

        'fields' => array(
            array(
                'name' => esc_html__('Gallery Type', 'aquila'),
                'id' => $prefix . 'gallery_type',
                'type'     => 'select',
                'options'  => array(
                    'slider' => esc_html__('Default', 'aquila'),
                    'grid' => esc_html__('Grid', 'aquila'),
                    'revslider' => esc_html__('Revolution Slider', 'aquila'),
                    'layerslider' => esc_html__('Layer Slider', 'aquila')
                ),
            ),
            array(
                'name' => esc_html__('Select Revolution Slider', 'aquila'),
                'id' => $prefix . 'gallery_rev_slider',
                'default' => true,
                'type' => 'revSlider',
                'visible' => array($prefix . 'gallery_type','=', 'revslider' ),
            ),
            array(
                'name' => esc_html__('Select Layer Slider', 'aquila'),
                'id' => $prefix . 'gallery_layerslider',
                'default' => true,
                'type' => 'layerslider',
                'visible' => array($prefix . 'gallery_type','=', 'layerslider' ),
            ),
            array(
                'name' => esc_html__( 'Gallery images', 'aquila' ),
                'id'  => "{$prefix}gallery_images",
                'type' => 'image_advanced',
                'desc' => esc_html__( "You can drag and drop for change order image", 'aquila' ),
                'visible' => array($prefix . 'gallery_type', 'in', array('slider', 'grid' )),
            ),
        ),
    );



    /**
     * For Link
     *
     */
    /*
    $meta_boxes[] = array(
        'title'  => esc_html__('Link Settings','aquila'),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Link'),
        ),
        'fields' => array(
            array(
                'name' => esc_html__( 'External URL', 'aquila' ),
                'id' => $prefix . 'external_url',
                'desc' => esc_html__( "Input your link in here", 'aquila' ),
                'type'  => 'text',
            ),

        ),
    );
    */

    /**
     * For Quote
     *
     */

    $meta_boxes[] = array(
        'title'  => esc_html__('Quote Settings','aquila'),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Quote'),
        ),
        'fields' => array(
            array(
                'name' => esc_html__( 'Quote Content', 'aquila' ),
                'desc' => esc_html__( 'Please type the text for your quote here.', 'aquila' ),
                'id'   => "{$prefix}quote_content",
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 3,
            ),
            array(
                'name' => esc_html__( 'Author', 'aquila' ),
                'id' => $prefix . 'quote_author',
                'desc' => esc_html__( "Please type the text for author quote here.", 'aquila' ),
                'type'  => 'text',
            ),

        ),
    );

    /**
     * For Post slider
     *
     */

    $meta_boxes[] = array(
        'title'  => esc_html__('Post Slider Settings','aquila'),
        'pages'  => array( 'kt-post-slider' ),
        'fields' => array(

            array(
                'name' => esc_html__('Data source', 'aquila'),
                'id'   => "{$prefix}slideshow_source",
                'type' => 'select',
                'options' => array(
                    ''              => esc_html__('All', 'aquila'),
                    'categories'    => esc_html__('Specific Categories', 'aquila'),
                    'authors'		=> esc_html__('Specific Authors', 'aquila'),
                    'posts'		=> esc_html__('Specific Posts', 'aquila'),
                ),
                'std'  => '',
            ),
            // Categories
            array(
                'name'    => esc_html__( 'Specific Categories', 'aquila' ),
                'id'      => "{$prefix}slideshow_categories",
                'type'    => 'taxonomy_advanced',
                'multiple'=> true,
                'options' => array(
                    'taxonomy' => 'category',
                    'type'     => 'select_advanced',
                    'args'     => array()
                ),
                'visible' => array($prefix . 'slideshow_source', '=', 'categories'),
            ),

            // Authors
            array(
                'name'    => esc_html__( 'Specific Authors', 'aquila' ),
                'id'      => "{$prefix}slideshow_authors",
                'type'    => 'user',
                'multiple'=> true,
                'options' => array(
                    'type'     => 'select_advanced'
                ),
                'visible' => array($prefix . 'slideshow_source', '=', 'authors'),
            ),
            // Posts
            array(
                'name'        => esc_html__( 'Posts', 'aquila' ),
                'id'          => "{$prefix}slideshow_posts",
                'type'        => 'post',
                'post_type'   => 'post',
                'field_type'  => 'select_advanced',
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
                'multiple'=> true,
                'visible' => array($prefix . 'slideshow_source', '=', 'posts'),
            ),
            array(
                'name' => esc_html__('Posts Slider style', 'aquila'),
                'id'   => "{$prefix}slideshow_slider_style",
                'type' => 'select',
                'options' => array(
                    'normal'        => esc_html__('Normal Carousel', 'aquila'),
                    'big'           => esc_html__('Big Carousel', 'aquila'),
                    'slider'        => esc_html__('Posts slider', 'aquila'),
                    'thumb'         => esc_html__('Thumb slider', 'aquila'),
                    //'carousel'      => esc_html__('Small Carousel', 'aquila'),
                ),
                'std'  => '',
            ),
            array(
                'type' => 'text',
                'name' => esc_html__( 'Number of items', 'aquila' ),
                'id' => $prefix.'slideshow_max_items',
                'std' => 10, // default value
                'desc' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'aquila' ),
            ),
            array(
                'type' => 'select',
                'name' => esc_html__( 'Order by', 'aquila' ),
                'id' => $prefix.'slideshow_orderby',
                'options' => array(
                    'date' => esc_html__( 'Date', 'aquila' ),
                    'ID' => esc_html__( 'Order by post ID', 'aquila' ),
                    'author' => esc_html__( 'Author', 'aquila' ),
                    'title' => esc_html__( 'Title', 'aquila' ),
                    'modified' => esc_html__( 'Last modified date', 'aquila' ),
                    'parent' => esc_html__( 'Post/page parent ID', 'aquila' ),
                    'comment_count' => esc_html__( 'Number of comments', 'aquila' ),
                    'menu_order' => esc_html__( 'Menu order/Page Order', 'aquila' ),
                    'meta_value' => esc_html__( 'Meta value', 'aquila' ),
                    'meta_value_num' => esc_html__( 'Meta value number', 'aquila' )
                ),
                'desc' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'aquila' ),
            ),
            array(
                'type' => 'text',
                'name' => esc_html__( 'Meta key', 'aquila' ),
                'id' => $prefix.'slideshow_meta_key',
                'visible' => array($prefix . 'slideshow_orderby', 'in', array('meta_value', 'meta_value_num'))
            ),
            array(
                'type' => 'select',
                'name' => esc_html__( 'Sorting', 'aquila' ),
                'id' => $prefix.'slideshow_order',
                'tab' => 'slideshow_displays',
                'options' => array(
                    'DESC' => esc_html__( 'Descending', 'aquila' ),
                    'ASC' => esc_html__( 'Ascending', 'aquila' ),
                ),
                'desc' => esc_html__( 'Select sorting order.', 'aquila' ),
            ),
        ),
    );



    /**
     * For Front page
     *
     */

    $meta_boxes[] = array(
        'id' => 'frontpage_meta_boxes',
        'title' => 'Front page Options',
        'pages' => array('page'),
        'context' => 'normal',
        'show'   => array(
            'template' => array( 'frontpage.php'),
        ),
        'tabs'      => array(
            'frontpage_general'  => array(
                'label' => esc_html__( 'General', 'aquila' ),
                'icon'  => 'fa fa-cogs',
            ),
            'frontpage_layout'  => array(
                'label' => esc_html__( 'Layout', 'aquila' ),
                'icon'  => 'fa fa-columns',
            ),
            'frontpage_displays'  => array(
                'label' => esc_html__( 'Displays', 'aquila' ),
                'icon'  => 'fa fa-paint-brush',
            ),
        ),
        'fields' => array(
            //General
            array(
                'name' => esc_html__('Content', 'aquila'),
                'id'   => "{$prefix}frontpage_content",
                'type' => 'select',
                'options' => array(
                    0		=> esc_html__('This content', 'aquila'),
                    1		=> esc_html__('Special content', 'aquila'),
                    //2		=> esc_html__('Both', 'aquila'),
                ),
                'std'  => -1,
                'tab'  => 'frontpage_general',
            ),
            array(
                'name' => esc_html__('Data source', 'aquila'),
                'id'   => "{$prefix}frontpage_source",
                'type' => 'select',
                'options' => array(
                    ''              => esc_html__('All', 'aquila'),
                    'categories'    => esc_html__('Specific Categories', 'aquila'),
                    'authors'		=> esc_html__('Specific Authors', 'aquila'),
                    'posts'		=> esc_html__('Specific Posts', 'aquila'),
                ),
                'std'  => '',
                'tab'  => 'frontpage_general',
                'visible' => array($prefix . 'frontpage_content', '=', '1')
            ),
            array(
                'name' => esc_html__('Show Promo Widget', 'aquila'),
                'id'   => "{$prefix}promo_widget",
                'type' => 'select',
                'options' => array(
                    'no'    => esc_html__('No', 'aquila'),
                    'yes'       => esc_html__('Yes', 'aquila'),
                ),
                'std'  => 'no',
                'tab'  => 'frontpage_general',
            ),
            // Categories
            array(
                'name'    => esc_html__( 'Specific Categories', 'aquila' ),
                'id'      => "{$prefix}categories",
                'type'    => 'taxonomy_advanced',
                'multiple'=> true,
                'options' => array(
                    'taxonomy' => 'category',
                    'type'     => 'select_advanced',
                    'args'     => array()
                ),
                'tab'  => 'frontpage_general',
                'visible' => array($prefix . 'frontpage_source', '=', 'categories')
            ),
            // Authors
            array(
                'name'    => esc_html__( 'Specific Authors', 'aquila' ),
                'id'      => "{$prefix}authors",
                'type'    => 'user',
                'multiple'=> true,
                'options' => array(
                    'type'     => 'select_advanced'
                ),
                'tab'  => 'frontpage_general',
                'visible' => array($prefix . 'frontpage_source', '=', 'authors')
            ),
            // POST
            array(
                'name'        => esc_html__( 'Posts', 'aquila' ),
                'id'          => "{$prefix}posts",
                'type'        => 'post',
                'post_type'   => 'post',
                'field_type'  => 'select_advanced',
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                ),
                'multiple'=> true,
                'tab'  => 'frontpage_general',
                'visible' => array($prefix . 'frontpage_source', '=', 'posts')
            ),

            array(
                'name' => esc_html__('Blog type', 'aquila'),
                'id'   => "{$prefix}frontpage_type",
                'type' => 'select',
                'options' => array(
                    'list'      => esc_html__('List', 'aquila'),
                    'medium'    => esc_html__('Medium', 'aquila'),
                    'grid'		=> esc_html__('Grid', 'aquila'),
                    'masonry'   => esc_html__('Masonry', 'aquila'),
                ),
                'std'  => 'standard',
                'tab'  => 'frontpage_layout',
            ),

            array(
                'name' => esc_html__('Blog columns', 'aquila'),
                'id'   => "{$prefix}frontpage_columns",
                'type' => 'select',
                'options' => array(
                    '2'    => esc_html__('2', 'aquila'),
                    '3'    => esc_html__('3', 'aquila'),
                    '4'    => esc_html__('4', 'aquila'),
                ),
                'std'  => '2',
                'tab'  => 'frontpage_layout',
                'visible' => array($prefix . 'frontpage_type','in', array('masonry', 'grid' )),
            ),
            array(
                'name' => esc_html__( 'First featured', 'aquila' ),
                'id'   => "{$prefix}first_featured",
                'type' => 'checkbox',
                'std'  => 1,
                'tab'  => 'frontpage_layout',
                'desc' => esc_html__( 'Check it if you want the first article is featured.', 'js_composer' ),
            ),




            /*
            array(
                'name' => esc_html__('Blog type', 'aquila'),
                'id'   => "{$prefix}frontpage_type",
                'type' => 'select',
                'options' => array(
                    'full' => esc_html__('Full text', 'aquila'),
                    'summary' => esc_html__('Summary', 'aquila')
                ),
                'std'  => 'summary',
                'tab'  => 'frontpage_layout',
            ),
            */

            //Displays
            array(
                'type' => 'text',
                'name' => esc_html__( 'Number of items', 'aquila' ),
                'id' => $prefix.'max_items',
                'std' => 10, // default value
                'desc' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'aquila' ),
                'tab'  => 'frontpage_displays',
            ),
            array(
                'type' => 'select',
                'name' => esc_html__( 'Order by', 'aquila' ),
                'id' => $prefix.'frontpage_orderby',
                'options' => array(
                    'date' => esc_html__( 'Date', 'aquila' ),
                    'ID' => esc_html__( 'Order by post ID', 'aquila' ),
                    'author' => esc_html__( 'Author', 'aquila' ),
                    'title' => esc_html__( 'Title', 'aquila' ),
                    'modified' => esc_html__( 'Last modified date', 'aquila' ),
                    'parent' => esc_html__( 'Post/page parent ID', 'aquila' ),
                    'comment_count' => esc_html__( 'Number of comments', 'aquila' ),
                    'menu_order' => esc_html__( 'Menu order/Page Order', 'aquila' ),
                    'meta_value' => esc_html__( 'Meta value', 'aquila' ),
                    'meta_value_num' => esc_html__( 'Meta value number', 'aquila' )
                ),
                'desc' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'aquila' ),
                'tab' => 'frontpage_displays'
            ),
            array(
                'type' => 'text',
                'name' => esc_html__( 'Meta key', 'aquila' ),
                'id' => $prefix.'frontpage_meta_key',
                'tab' => 'frontpage_displays',
                'visible' => array($prefix . 'frontpage_orderby', 'in', array('meta_value', 'meta_value_num'))

            ),
            array(
                'type' => 'select',
                'name' => esc_html__( 'Sorting', 'aquila' ),
                'id' => $prefix.'frontpage_order',
                'tab' => 'frontpage_displays',
                'options' => array(
                    'DESC' => esc_html__( 'Descending', 'aquila' ),
                    'ASC' => esc_html__( 'Ascending', 'aquila' ),
                ),
                'desc' => esc_html__( 'Select sorting order.', 'aquila' ),
            ),
            array(
                'type' => 'text',
                'name' => esc_html__( 'Excerpt Length', 'aquila' ),
                'id' => $prefix.'excerpt_length',
                'std' => 30, // default value
                'desc' => esc_html__( 'Insert the number of words you want to show in the post excerpts.','aquila' ),
                'tab'  => 'frontpage_displays',
            ),
        )
    );



    $tabs = array(
        'page_layout' => array(
            'label' => esc_html__( 'Layout', 'aquila' ),
            'icon'  => 'fa fa-columns',
        ),
        'page_background' => array(
            'label' => esc_html__( 'Background', 'aquila' ),
            'icon'  => 'fa fa-picture-o',
        )

    );

    $fields = array(



        //Page layout
        array(
            'name' => esc_html__('Page layout', 'aquila'),
            'id' => $prefix . 'layout',
            'desc' => esc_html__("Please choose this page's layout.", 'aquila'),
            'type' => 'select',
            'options' => array(
                'default' => esc_html__('Default', 'aquila'),
                'full' => esc_html__('Full width Layout', 'aquila'),
                'boxed' => esc_html__('Boxed Layout', 'aquila'),
            ),
            'std' => 'default',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Sidebar configuration', 'aquila'),
            'id' => $prefix . 'sidebar',
            'desc' => esc_html__("Choose the sidebar configuration for the detail page.<br/><b>Note: Cart and checkout, My account page always use no sidebars.</b>", 'aquila'),
            'type' => 'select',
            'options' => array(
                0 => esc_html__('Default', 'aquila'),
                'full' => esc_html__('No sidebars', 'aquila'),
                'left' => esc_html__('Left Sidebar', 'aquila'),
                'right' => esc_html__('Right Sidebar', 'aquila')
            ),
            'std' => 'default',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Left sidebar', 'aquila'),
            'id' => $prefix . 'left_sidebar',
            'type' => 'select',
            'tab'  => 'page_layout',
            'options' => $sidebars,
            'desc' => esc_html__("Select your sidebar.", 'aquila'),
            'visible' => array($prefix . 'sidebar','=', 'left' ),
        ),
        array(
            'name' => esc_html__('Right sidebar', 'aquila'),
            'id' => $prefix . 'right_sidebar',
            'type' => 'select',
            'tab'  => 'page_layout',
            'options' => $sidebars,
            'desc' => esc_html__("Select your sidebar.", 'aquila'),
            'visible' => array($prefix . 'sidebar','=', 'right' ),
        ),
        array(
            'name' => esc_html__('Page top spacing', 'aquila'),
            'id' => $prefix . 'page_top_spacing',
            'desc' => esc_html__("Enter your page top spacing (Example: 100px).", 'aquila' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Page bottom spacing', 'aquila'),
            'id' => $prefix . 'page_bottom_spacing',
            'desc' => esc_html__("Enter your page bottom spacing (Example: 100px).", 'aquila' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Extra page class', 'aquila'),
            'id' => $prefix . 'extra_page_class',
            'desc' => esc_html__('If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.', 'aquila' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Background', 'aquila'),
            'id' => $prefix.'background_body',
            'type'  => 'background',
            'tab'  => 'page_background',
            'desc' => esc_html__('The option that will be used as the OUTER page.', 'aquila' ),
        ),
        array(
            'name' => esc_html__('Inner Background', 'aquila'),
            'id' => $prefix.'background_inner',
            'type'  => 'background',
            'tab'  => 'page_background',
            'desc' => esc_html__('The option that will be used as the INNER page.', 'aquila' ),
        )
    );



    $tabs_page = array(
        'header'  => array(
            'label' => esc_html__( 'Header', 'aquila' ),
            'icon'  => 'fa fa-desktop',
        ),
        'page_header' => array(
            'label' => esc_html__( 'Page Header', 'aquila' ),
            'icon'  => 'fa fa-bars',
        )
    );

    $fields_page = array(
        // Page Header
        array(

            'name' => esc_html__( 'Page Header', 'aquila' ),
            'id' => $prefix . 'page_header',
            'desc' => esc_html__( "Show Page Header.", 'aquila' ),
            'type' => 'select',
            'options' => array(
                ''          => esc_html__('Default', 'aquila'),
                'off'	    => esc_html__('Hidden', 'aquila'),
                'on'		=> esc_html__('Show', 'aquila'),
            ),
            'std'  => '',
            'tab'  => 'page_header',
        ),
        array(
            'name' => esc_html__( 'Page Header Custom Text', 'aquila' ),
            'id' => $prefix . 'page_header_custom',
            'desc' => esc_html__( "Enter cstom Text for page header.", 'aquila' ),
            'type'  => 'text',
            'tab'  => 'page_header',
            'visible' => array($prefix . 'page_header', '!=', 'off')
        ),
        array(
            'name' => esc_html__( 'Page header subtitle', 'aquila' ),
            'id' => $prefix . 'page_header_subtitle',
            'desc' => esc_html__( "Enter subtitle for page.", 'aquila' ),
            'type'  => 'text',
            'tab'  => 'page_header',
            'visible' => array($prefix . 'page_header', '!=', 'off')
        ),

        // Header
        array(
            'name' => esc_html__('Header shadow', 'aquila'),
            'id'   => "{$prefix}header_shadow",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'aquila'),
                'off'		=> esc_html__('Hidden', 'aquila'),
                'on'		=> esc_html__('Show', 'aquila'),
            ),
            'std'  => '',
            'tab'  => 'header',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'aquila')
        ),
        array(
            'name'    => esc_html__( 'Header position', 'aquila' ),
            'type'     => 'select',
            'id'       => $prefix.'header_position',
            'desc'     => esc_html__( "Please choose header position", 'aquila' ),
            'options'  => array(
                'default' => esc_html__('Default', 'aquila'),
                'below' => esc_html__('Below Slideshow', 'aquila'),
            ),
            'std'  => 'default',
            'tab'  => 'header',
        ),
        array(
            'name' => esc_html__('Select Your Slideshow Type', 'aquila'),
            'id' => $prefix . 'slideshow_type',
            'desc' => esc_html__("You can select the slideshow type using this option.", 'aquila'),
            'type' => 'select',
            'options' => array(
                '' => esc_html__('Select Option', 'aquila'),
                'postslider' => esc_html__('Post Slider', 'aquila'),
                'revslider' => esc_html__('Revolution Slider', 'aquila'),
                'layerslider' => esc_html__('Layer Slider', 'aquila'),
                'page' => esc_html__('From Page content', 'aquila'),
            ),
            'tab'  => 'header',
        ),
        array(
            'name'        => esc_html__( 'Post Slider', 'aquila' ),
            'id'          => "{$prefix}slideshow_postslider",
            'type'        => 'post',
            'post_type'   => 'kt-post-slider',
            'field_type'  => 'select',
            'title'    => esc_html__( 'Slider Select Option', 'aquila' ),
            'query_args'  => array(
                'post_status'    => 'publish',
                'posts_per_page' => - 1,
            ),
            'tab'  => 'header',
            'visible' => array($prefix . 'slideshow_type', '=', 'postslider')
        ),
        array(
            'name' => esc_html__('Select Revolution Slider', 'aquila'),
            'id' => $prefix . 'rev_slider',
            'default' => true,
            'type' => 'revSlider',
            'tab'  => 'header',
            'desc' => esc_html__('Select the Revolution Slider.', 'aquila'),
            'visible' => array($prefix . 'slideshow_type', '=', 'revslider')
        ),
        array(
            'name' => esc_html__('Select Layer Slider', 'aquila'),
            'id' => $prefix . 'layerslider',
            'default' => true,
            'type' => 'layerslider',
            'tab'  => 'header',
            'desc' => esc_html__('Select the Layer Slider.', 'aquila'),
            'visible' => array($prefix . 'slideshow_type', '=', 'layerslider')
        ),
        array(
            'name'        => esc_html__( 'Page', 'aquila' ),
            'id'          => "{$prefix}slideshow_page",
            'type'        => 'post',
            'post_type'   => 'page',
            'field_type'  => 'select',
            'title'    => esc_html__( 'Page Select Option', 'aquila' ),
            'query_args'  => array(
                'post_status'    => 'publish',
                'posts_per_page' => - 1,
            ),
            'tab'  => 'header',
            'visible' => array($prefix . 'slideshow_type', '=', 'page')
        )
    );

    /**
     * For Page Options
     *
     */
    $meta_boxes[] = array(
        'id'        => 'page_meta_boxes',
        'title'     => esc_html__('Page Options', 'aquila'),
        'pages'     => array( 'page' ),
        'tabs'      => array_merge( $tabs,$tabs_page),
        'fields'    => array_merge( $fields,$fields_page),
    );


    $tabs_post = array(
        'post_general'  => array(
            'label' => esc_html__( 'General', 'aquila' ),
            'icon'  => 'fa fa-bars',
        )
    );

    $fields_post = array(
        //General
        array(
            'name' => esc_html__('Featured Post', 'aquila'),
            'id'   => "{$prefix}post_featured",
            'type' => 'select',
            'options' => array(
                'no'		=> esc_html__('No', 'aquila'),
                'yes'		=> esc_html__('Yes', 'aquila'),
            ),
            'std'  => 'no',
            'tab'  => 'post_general',
            'desc' => esc_html__('Make this post featured', 'aquila')
        ),

        array(
            'type' => 'select',
            'name' => esc_html__('Post layouts', 'aquila'),
            'desc' => esc_html__('Select the your post layout.', 'aquila'),
            'id'   => "{$prefix}blog_post_layout",
            'options' => array(
                ''    => esc_html__('Default', 'aquila'),
                1 => esc_html__( 'Layout 1', 'aquila' ),
                2 => esc_html__( 'layout 2', 'aquila' ),
                3 => esc_html__( 'layout 3', 'aquila' ),
                4 => esc_html__( 'layout 4', 'aquila' ),
                5 => esc_html__( 'layout 5', 'aquila' ),
                6 => esc_html__( 'layout 6', 'aquila' ),
            ),
            'std' => '',
            'tab'  => 'post_general',
        ),
        array(
            'name' => esc_html__('Previous & next buttons', 'aquila'),
            'id'   => "{$prefix}prev_next",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'aquila'),
                'off'		=> esc_html__('Hidden', 'aquila'),
                'on'		=> esc_html__('Show', 'aquila'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'aquila')
        ),
        array(
            'name' => esc_html__('Author info', 'aquila'),
            'id'   => "{$prefix}author_info",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'aquila'),
                'off'		=> esc_html__('Hidden', 'aquila'),
                'on'		=> esc_html__('Show', 'aquila'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'aquila')
        ),
        array(
            'name' => esc_html__('Social sharing', 'aquila'),
            'id'   => "{$prefix}social_sharing",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'aquila'),
                'off'		=> esc_html__('Hidden', 'aquila'),
                'on'		=> esc_html__('Show', 'aquila'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'aquila')
        ),
        array(
            'name' => esc_html__('Related articles', 'aquila'),
            'id'   => "{$prefix}related_acticles",
            'type' => 'select',
            'options' => array(
                ''      => esc_html__('Default', 'aquila'),
                'off'    => esc_html__('Hidden', 'aquila'),
                'on'	=> esc_html__('Show', 'aquila'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'aquila')
        )
    );

    /**
     * For Posts Options
     *
     */
    $meta_boxes[] = array(
        'id' => 'post_meta_boxes',
        'title' => 'Post Options',
        'pages' => array('post'),
        'tabs'      => array_merge( $tabs_post, $tabs ),
        'fields'    => array_merge( $fields_post, $fields),
    );

    return $meta_boxes;
}



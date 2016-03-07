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

    $menus_arr = array('' => esc_html__('Default', 'adroit'));
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
        'title'  => esc_html__('Audio Settings','adroit'),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Audio'),
        ),
        'fields' => array(
            array(
                'name' => esc_html__('Audio Type', 'adroit'),
                'id' => $prefix . 'audio_type',
                'type'     => 'select',
                'options'  => array(
                    '' => esc_html__('Select Option', 'adroit'),
                    'upload' => esc_html__('Upload', 'adroit'),
                    'soundcloud' => esc_html__('Soundcloud', 'adroit'),
                ),
            ),
            array(
                'name'             => __( 'Upload MP3 File', 'adroit' ),
                'id'               => "{$prefix}audio_mp3",
                'type'             => 'file_advanced',
                'max_file_uploads' => 1,
                'mime_type'        => 'audio', // Leave blank for all file types
                'visible' => array($prefix . 'audio_type', '=', 'upload')
            ),
            array(
                'name' => esc_html__( 'Soundcloud', 'adroit' ),
                'desc' => esc_html__( 'Paste embed iframe or Wordpress shortcode.', 'adroit' ),
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
        'title'  => esc_html__('Video Settings','adroit'),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Video'),
        ),

        'fields' => array(
            array(
                'name' => esc_html__('Video Type', 'adroit'),
                'id' => $prefix . 'video_type',
                'type'     => 'select',
                'options'  => array(
                    '' => esc_html__('Select Option', 'adroit'),
                    'external' => esc_html__('External url', 'adroit'),
                ),
            ),
            array(
                'name' => esc_html__('Choose Video', 'adroit'),
                'id' => $prefix . 'choose_video',
                'type'     => 'select',
                'options'  => array(
                    'youtube' => esc_html__('Youtube', 'adroit'),
                    'vimeo' => esc_html__('Vimeo', 'adroit'),
                ),
                'visible' => array($prefix . 'video_type', '=', 'external')
            ),
            array(
                'name' => esc_html__( 'Video id', 'adroit' ),
                'id' => $prefix . 'video_id',
                'desc' => sprintf( esc_html__( 'Enter id of video .Example: <br />- Link video youtube: https://www.youtube.com/watch?v=nPOO1Coe2DI id of video: nPOO1Coe2DI <br /> -Link vimeo: https://vimeo.com/70296428 id video: 70296428.', 'adroit' ) ),
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
        'title'  => esc_html__('Gallery Settings','adroit'),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Gallery'),
        ),

        'fields' => array(
            array(
                'name' => esc_html__('Gallery Type', 'adroit'),
                'id' => $prefix . 'gallery_type',
                'type'     => 'select',
                'options'  => array(
                    'slider' => esc_html__('Default', 'adroit'),
                    'grid' => esc_html__('Grid', 'adroit'),
                    'revslider' => esc_html__('Revolution Slider', 'adroit'),
                    'layerslider' => esc_html__('Layer Slider', 'adroit')
                ),
            ),
            array(
                'name' => esc_html__('Select Revolution Slider', 'adroit'),
                'id' => $prefix . 'gallery_rev_slider',
                'default' => true,
                'type' => 'revSlider',
                'visible' => array($prefix . 'gallery_type','=', 'revslider' ),
            ),
            array(
                'name' => esc_html__('Select Layer Slider', 'adroit'),
                'id' => $prefix . 'gallery_layerslider',
                'default' => true,
                'type' => 'layerslider',
                'visible' => array($prefix . 'gallery_type','=', 'layerslider' ),
            ),
            array(
                'name' => esc_html__( 'Gallery images', 'adroit' ),
                'id'  => "{$prefix}gallery_images",
                'type' => 'image_advanced',
                'desc' => esc_html__( "You can drag and drop for change order image", 'adroit' ),
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
        'title'  => esc_html__('Link Settings','adroit'),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Link'),
        ),
        'fields' => array(
            array(
                'name' => esc_html__( 'External URL', 'adroit' ),
                'id' => $prefix . 'external_url',
                'desc' => esc_html__( "Input your link in here", 'adroit' ),
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
        'title'  => esc_html__('Quote Settings','adroit'),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Quote'),
        ),
        'fields' => array(
            array(
                'name' => esc_html__( 'Quote Content', 'adroit' ),
                'desc' => esc_html__( 'Please type the text for your quote here.', 'adroit' ),
                'id'   => "{$prefix}quote_content",
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 3,
            ),
            array(
                'name' => esc_html__( 'Author', 'adroit' ),
                'id' => $prefix . 'quote_author',
                'desc' => esc_html__( "Please type the text for author quote here.", 'adroit' ),
                'type'  => 'text',
            ),

        ),
    );

    /**
     * For Post slider
     *
     */

    $meta_boxes[] = array(
        'title'  => esc_html__('Post Slider Settings','adroit'),
        'pages'  => array( 'kt-post-slider' ),
        'fields' => array(

            array(
                'name' => esc_html__('Data source', 'adroit'),
                'id'   => "{$prefix}slideshow_source",
                'type' => 'select',
                'options' => array(
                    ''              => esc_html__('All', 'adroit'),
                    'categories'    => esc_html__('Specific Categories', 'adroit'),
                    'authors'		=> esc_html__('Specific Authors', 'adroit'),
                    'posts'		=> esc_html__('Specific Posts', 'adroit'),
                ),
                'std'  => '',
            ),
            // Categories
            array(
                'name'    => esc_html__( 'Specific Categories', 'adroit' ),
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
                'name'    => esc_html__( 'Specific Authors', 'adroit' ),
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
                'name'        => esc_html__( 'Posts', 'adroit' ),
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
                'name' => esc_html__('Posts Slider style', 'adroit'),
                'id'   => "{$prefix}slideshow_slider_style",
                'type' => 'select',
                'options' => array(
                    'normal'        => esc_html__('Normal Carousel', 'adroit'),
                    'big'           => esc_html__('Big Carousel', 'adroit'),
                    'slider'        => esc_html__('Posts slider', 'adroit'),
                    'thumb'         => esc_html__('Thumb slider', 'adroit'),
                    //'carousel'      => esc_html__('Small Carousel', 'adroit'),
                ),
                'std'  => '',
            ),
            array(
                'type' => 'text',
                'name' => esc_html__( 'Number of items', 'adroit' ),
                'id' => $prefix.'slideshow_max_items',
                'std' => 10, // default value
                'desc' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'adroit' ),
            ),
            array(
                'type' => 'select',
                'name' => esc_html__( 'Order by', 'adroit' ),
                'id' => $prefix.'slideshow_orderby',
                'options' => array(
                    'date' => esc_html__( 'Date', 'adroit' ),
                    'ID' => esc_html__( 'Order by post ID', 'adroit' ),
                    'author' => esc_html__( 'Author', 'adroit' ),
                    'title' => esc_html__( 'Title', 'adroit' ),
                    'modified' => esc_html__( 'Last modified date', 'adroit' ),
                    'parent' => esc_html__( 'Post/page parent ID', 'adroit' ),
                    'comment_count' => esc_html__( 'Number of comments', 'adroit' ),
                    'menu_order' => esc_html__( 'Menu order/Page Order', 'adroit' ),
                    'meta_value' => esc_html__( 'Meta value', 'adroit' ),
                    'meta_value_num' => esc_html__( 'Meta value number', 'adroit' )
                ),
                'desc' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'adroit' ),
            ),
            array(
                'type' => 'text',
                'name' => esc_html__( 'Meta key', 'adroit' ),
                'id' => $prefix.'slideshow_meta_key',
                'visible' => array($prefix . 'slideshow_orderby', 'in', array('meta_value', 'meta_value_num'))
            ),
            array(
                'type' => 'select',
                'name' => esc_html__( 'Sorting', 'adroit' ),
                'id' => $prefix.'slideshow_order',
                'tab' => 'slideshow_displays',
                'options' => array(
                    'DESC' => esc_html__( 'Descending', 'adroit' ),
                    'ASC' => esc_html__( 'Ascending', 'adroit' ),
                ),
                'desc' => esc_html__( 'Select sorting order.', 'adroit' ),
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
                'label' => esc_html__( 'General', 'adroit' ),
                'icon'  => 'fa fa-cogs',
            ),
            'frontpage_layout'  => array(
                'label' => esc_html__( 'Layout', 'adroit' ),
                'icon'  => 'fa fa-columns',
            ),
            'frontpage_displays'  => array(
                'label' => esc_html__( 'Displays', 'adroit' ),
                'icon'  => 'fa fa-paint-brush',
            ),
        ),
        'fields' => array(
            //General
            array(
                'name' => esc_html__('Content', 'adroit'),
                'id'   => "{$prefix}frontpage_content",
                'type' => 'select',
                'options' => array(
                    0		=> esc_html__('This content', 'adroit'),
                    1		=> esc_html__('Special content', 'adroit'),
                    //2		=> esc_html__('Both', 'adroit'),
                ),
                'std'  => -1,
                'tab'  => 'frontpage_general',
            ),
            array(
                'name' => esc_html__('Data source', 'adroit'),
                'id'   => "{$prefix}frontpage_source",
                'type' => 'select',
                'options' => array(
                    ''              => esc_html__('All', 'adroit'),
                    'categories'    => esc_html__('Specific Categories', 'adroit'),
                    'authors'		=> esc_html__('Specific Authors', 'adroit'),
                    'posts'		=> esc_html__('Specific Posts', 'adroit'),
                ),
                'std'  => '',
                'tab'  => 'frontpage_general',
                'visible' => array($prefix . 'frontpage_content', '=', '1')
            ),
            array(
                'name' => esc_html__('Show Promo Widget', 'adroit'),
                'id'   => "{$prefix}promo_widget",
                'type' => 'select',
                'options' => array(
                    'no'    => esc_html__('No', 'adroit'),
                    'yes'       => esc_html__('Yes', 'adroit'),
                ),
                'std'  => 'no',
                'tab'  => 'frontpage_general',
            ),
            // Categories
            array(
                'name'    => esc_html__( 'Specific Categories', 'adroit' ),
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
                'name'    => esc_html__( 'Specific Authors', 'adroit' ),
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
                'name'        => esc_html__( 'Posts', 'adroit' ),
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
                'name' => esc_html__('Blog type', 'adroit'),
                'id'   => "{$prefix}frontpage_type",
                'type' => 'select',
                'options' => array(
                    'list'      => esc_html__('List', 'adroit'),
                    'medium'    => esc_html__('Medium', 'adroit'),
                    'grid'		=> esc_html__('Grid', 'adroit'),
                    'masonry'   => esc_html__('Masonry', 'adroit'),
                ),
                'std'  => 'standard',
                'tab'  => 'frontpage_layout',
            ),

            array(
                'name' => esc_html__('Blog columns', 'adroit'),
                'id'   => "{$prefix}frontpage_columns",
                'type' => 'select',
                'options' => array(
                    '2'    => esc_html__('2', 'adroit'),
                    '3'    => esc_html__('3', 'adroit'),
                    '4'    => esc_html__('4', 'adroit'),
                ),
                'std'  => '2',
                'tab'  => 'frontpage_layout',
                'visible' => array($prefix . 'frontpage_type','in', array('masonry', 'grid' )),
            ),
            array(
                'name' => esc_html__( 'First featured', 'adroit' ),
                'id'   => "{$prefix}first_featured",
                'type' => 'checkbox',
                'std'  => 1,
                'tab'  => 'frontpage_layout',
                'desc' => esc_html__( 'Check it if you want the first article is featured.', 'js_composer' ),
            ),




            /*
            array(
                'name' => esc_html__('Blog type', 'adroit'),
                'id'   => "{$prefix}frontpage_type",
                'type' => 'select',
                'options' => array(
                    'full' => esc_html__('Full text', 'adroit'),
                    'summary' => esc_html__('Summary', 'adroit')
                ),
                'std'  => 'summary',
                'tab'  => 'frontpage_layout',
            ),
            */

            //Displays
            array(
                'type' => 'text',
                'name' => esc_html__( 'Number of items', 'adroit' ),
                'id' => $prefix.'max_items',
                'std' => 10, // default value
                'desc' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'adroit' ),
                'tab'  => 'frontpage_displays',
            ),
            array(
                'type' => 'select',
                'name' => esc_html__( 'Order by', 'adroit' ),
                'id' => $prefix.'frontpage_orderby',
                'options' => array(
                    'date' => esc_html__( 'Date', 'adroit' ),
                    'ID' => esc_html__( 'Order by post ID', 'adroit' ),
                    'author' => esc_html__( 'Author', 'adroit' ),
                    'title' => esc_html__( 'Title', 'adroit' ),
                    'modified' => esc_html__( 'Last modified date', 'adroit' ),
                    'parent' => esc_html__( 'Post/page parent ID', 'adroit' ),
                    'comment_count' => esc_html__( 'Number of comments', 'adroit' ),
                    'menu_order' => esc_html__( 'Menu order/Page Order', 'adroit' ),
                    'meta_value' => esc_html__( 'Meta value', 'adroit' ),
                    'meta_value_num' => esc_html__( 'Meta value number', 'adroit' )
                ),
                'desc' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'adroit' ),
                'tab' => 'frontpage_displays'
            ),
            array(
                'type' => 'text',
                'name' => esc_html__( 'Meta key', 'adroit' ),
                'id' => $prefix.'frontpage_meta_key',
                'tab' => 'frontpage_displays',
                'visible' => array($prefix . 'frontpage_orderby', 'in', array('meta_value', 'meta_value_num'))

            ),
            array(
                'type' => 'select',
                'name' => esc_html__( 'Sorting', 'adroit' ),
                'id' => $prefix.'frontpage_order',
                'tab' => 'frontpage_displays',
                'options' => array(
                    'DESC' => esc_html__( 'Descending', 'adroit' ),
                    'ASC' => esc_html__( 'Ascending', 'adroit' ),
                ),
                'desc' => esc_html__( 'Select sorting order.', 'adroit' ),
            ),
            array(
                'type' => 'text',
                'name' => esc_html__( 'Excerpt Length', 'adroit' ),
                'id' => $prefix.'excerpt_length',
                'std' => 30, // default value
                'desc' => esc_html__( 'Insert the number of words you want to show in the post excerpts.','adroit' ),
                'tab'  => 'frontpage_displays',
            ),
        )
    );



    $tabs = array(
        'page_layout' => array(
            'label' => esc_html__( 'Layout', 'adroit' ),
            'icon'  => 'fa fa-columns',
        ),
        'page_background' => array(
            'label' => esc_html__( 'Background', 'adroit' ),
            'icon'  => 'fa fa-picture-o',
        )

    );

    $fields = array(



        //Page layout
        array(
            'name' => esc_html__('Page layout', 'adroit'),
            'id' => $prefix . 'layout',
            'desc' => esc_html__("Please choose this page's layout.", 'adroit'),
            'type' => 'select',
            'options' => array(
                'default' => esc_html__('Default', 'adroit'),
                'full' => esc_html__('Full width Layout', 'adroit'),
                'boxed' => esc_html__('Boxed Layout', 'adroit'),
            ),
            'std' => 'default',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Sidebar configuration', 'adroit'),
            'id' => $prefix . 'sidebar',
            'desc' => esc_html__("Choose the sidebar configuration for the detail page.<br/><b>Note: Cart and checkout, My account page always use no sidebars.</b>", 'adroit'),
            'type' => 'select',
            'options' => array(
                0 => esc_html__('Default', 'adroit'),
                'full' => esc_html__('No sidebars', 'adroit'),
                'left' => esc_html__('Left Sidebar', 'adroit'),
                'right' => esc_html__('Right Sidebar', 'adroit')
            ),
            'std' => 'default',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Left sidebar', 'adroit'),
            'id' => $prefix . 'left_sidebar',
            'type' => 'select',
            'tab'  => 'page_layout',
            'options' => $sidebars,
            'desc' => esc_html__("Select your sidebar.", 'adroit'),
            'visible' => array($prefix . 'sidebar','=', 'left' ),
        ),
        array(
            'name' => esc_html__('Right sidebar', 'adroit'),
            'id' => $prefix . 'right_sidebar',
            'type' => 'select',
            'tab'  => 'page_layout',
            'options' => $sidebars,
            'desc' => esc_html__("Select your sidebar.", 'adroit'),
            'visible' => array($prefix . 'sidebar','=', 'right' ),
        ),
        array(
            'name' => esc_html__('Page top spacing', 'adroit'),
            'id' => $prefix . 'page_top_spacing',
            'desc' => esc_html__("Enter your page top spacing (Example: 100px).", 'adroit' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Page bottom spacing', 'adroit'),
            'id' => $prefix . 'page_bottom_spacing',
            'desc' => esc_html__("Enter your page bottom spacing (Example: 100px).", 'adroit' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Extra page class', 'adroit'),
            'id' => $prefix . 'extra_page_class',
            'desc' => esc_html__('If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.', 'adroit' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Background', 'adroit'),
            'id' => $prefix.'background_body',
            'type'  => 'background',
            'tab'  => 'page_background',
            'desc' => esc_html__('The option that will be used as the OUTER page.', 'adroit' ),
        ),
        array(
            'name' => esc_html__('Inner Background', 'adroit'),
            'id' => $prefix.'background_inner',
            'type'  => 'background',
            'tab'  => 'page_background',
            'desc' => esc_html__('The option that will be used as the INNER page.', 'adroit' ),
        )
    );



    $tabs_page = array(
        'header'  => array(
            'label' => esc_html__( 'Header', 'adroit' ),
            'icon'  => 'fa fa-desktop',
        ),
        'page_header' => array(
            'label' => esc_html__( 'Page Header', 'adroit' ),
            'icon'  => 'fa fa-bars',
        )
    );

    $fields_page = array(
        // Page Header
        array(

            'name' => esc_html__( 'Page Header', 'adroit' ),
            'id' => $prefix . 'page_header',
            'desc' => esc_html__( "Show Page Header.", 'adroit' ),
            'type' => 'select',
            'options' => array(
                ''          => esc_html__('Default', 'adroit'),
                'off'	    => esc_html__('Hidden', 'adroit'),
                'on'		=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'page_header',
        ),
        array(
            'name' => esc_html__( 'Page Header Custom Text', 'adroit' ),
            'id' => $prefix . 'page_header_custom',
            'desc' => esc_html__( "Enter cstom Text for page header.", 'adroit' ),
            'type'  => 'text',
            'tab'  => 'page_header',
            'visible' => array($prefix . 'page_header', '!=', 'off')
        ),
        array(
            'name' => esc_html__( 'Page header subtitle', 'adroit' ),
            'id' => $prefix . 'page_header_subtitle',
            'desc' => esc_html__( "Enter subtitle for page.", 'adroit' ),
            'type'  => 'text',
            'tab'  => 'page_header',
            'visible' => array($prefix . 'page_header', '!=', 'off')
        ),

        // Header
        array(
            'name' => esc_html__('Header shadow', 'adroit'),
            'id'   => "{$prefix}header_shadow",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'adroit'),
                'off'		=> esc_html__('Hidden', 'adroit'),
                'on'		=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'header',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'adroit')
        ),
        array(
            'name'    => esc_html__( 'Header position', 'adroit' ),
            'type'     => 'select',
            'id'       => $prefix.'header_position',
            'desc'     => esc_html__( "Please choose header position", 'adroit' ),
            'options'  => array(
                'default' => esc_html__('Default', 'adroit'),
                'below' => esc_html__('Below Slideshow', 'adroit'),
            ),
            'std'  => 'default',
            'tab'  => 'header',
        ),
        array(
            'name' => esc_html__('Select Your Slideshow Type', 'adroit'),
            'id' => $prefix . 'slideshow_type',
            'desc' => esc_html__("You can select the slideshow type using this option.", 'adroit'),
            'type' => 'select',
            'options' => array(
                '' => esc_html__('Select Option', 'adroit'),
                'postslider' => esc_html__('Post Slider', 'adroit'),
                'revslider' => esc_html__('Revolution Slider', 'adroit'),
                'layerslider' => esc_html__('Layer Slider', 'adroit'),
                'page' => esc_html__('From Page content', 'adroit'),
            ),
            'tab'  => 'header',
        ),
        array(
            'name'        => esc_html__( 'Post Slider', 'adroit' ),
            'id'          => "{$prefix}slideshow_postslider",
            'type'        => 'post',
            'post_type'   => 'kt-post-slider',
            'field_type'  => 'select',
            'title'    => esc_html__( 'Slider Select Option', 'adroit' ),
            'query_args'  => array(
                'post_status'    => 'publish',
                'posts_per_page' => - 1,
            ),
            'tab'  => 'header',
            'visible' => array($prefix . 'slideshow_type', '=', 'postslider')
        ),
        array(
            'name' => esc_html__('Select Revolution Slider', 'adroit'),
            'id' => $prefix . 'rev_slider',
            'default' => true,
            'type' => 'revSlider',
            'tab'  => 'header',
            'desc' => esc_html__('Select the Revolution Slider.', 'adroit'),
            'visible' => array($prefix . 'slideshow_type', '=', 'revslider')
        ),
        array(
            'name' => esc_html__('Select Layer Slider', 'adroit'),
            'id' => $prefix . 'layerslider',
            'default' => true,
            'type' => 'layerslider',
            'tab'  => 'header',
            'desc' => esc_html__('Select the Layer Slider.', 'adroit'),
            'visible' => array($prefix . 'slideshow_type', '=', 'layerslider')
        ),
        array(
            'name'        => esc_html__( 'Page', 'adroit' ),
            'id'          => "{$prefix}slideshow_page",
            'type'        => 'post',
            'post_type'   => 'page',
            'field_type'  => 'select',
            'title'    => esc_html__( 'Page Select Option', 'adroit' ),
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
        'title'     => esc_html__('Page Options', 'adroit'),
        'pages'     => array( 'page' ),
        'tabs'      => array_merge( $tabs,$tabs_page),
        'fields'    => array_merge( $fields,$fields_page),
    );


    $tabs_post = array(
        'post_general'  => array(
            'label' => esc_html__( 'General', 'adroit' ),
            'icon'  => 'fa fa-bars',
        ),
        'post_header'  => array(
            'label' => esc_html__( 'Header', 'adroit' ),
            'icon'  => 'fa fa-desktop',
        )
    );

    $fields_post = array(
        //General
        array(
            'name' => esc_html__('Featured Post', 'adroit'),
            'id'   => "{$prefix}post_featured",
            'type' => 'select',
            'options' => array(
                'no'		=> esc_html__('No', 'adroit'),
                'yes'		=> esc_html__('Yes', 'adroit'),
            ),
            'std'  => 'no',
            'tab'  => 'post_general',
            'desc' => esc_html__('Make this post featured', 'adroit')
        ),

        array(
            'type' => 'image_radio',
            'name' => esc_html__('Post layouts', 'adroit'),
            'desc' => esc_html__('Select the your post layout.', 'adroit'),
            'id'   => "{$prefix}blog_post_layout",
            'options' => array(
                ''    => array('url' => KT_FW_IMG . 'single/default.jpg', 'alt' => esc_html__('Default', 'adroit')),
                1     => array('url' => KT_FW_IMG . 'single/layout-1.jpg', 'alt' => esc_html__('Layout 1', 'adroit')),
                2     => array('url' => KT_FW_IMG . 'single/layout-2.jpg', 'alt' => esc_html__('Layout 2', 'adroit')),
                3     => array('url' => KT_FW_IMG . 'single/layout-3.jpg', 'alt' => esc_html__('Layout 3', 'adroit')),
                4     => array('url' => KT_FW_IMG . 'single/layout-4.jpg', 'alt' => esc_html__('Layout 4', 'adroit')),
                5     => array('url' => KT_FW_IMG . 'single/layout-5.jpg', 'alt' => esc_html__('Layout 5', 'adroit')),
                6     => array('url' => KT_FW_IMG . 'single/layout-6.jpg', 'alt' => esc_html__('Layout 6', 'adroit')),
            ),
            'attributes' => '',
            'std' => '',
            'tab'  => 'post_general',
        ),
        array(
            'name' => esc_html__('Previous & next buttons', 'adroit'),
            'id'   => "{$prefix}prev_next",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'adroit'),
                'off'		=> esc_html__('Hidden', 'adroit'),
                'on'		=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'adroit')
        ),
        array(
            'name' => esc_html__('Author info', 'adroit'),
            'id'   => "{$prefix}author_info",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'adroit'),
                'off'		=> esc_html__('Hidden', 'adroit'),
                'on'		=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'adroit')
        ),
        array(
            'name' => esc_html__('Social sharing', 'adroit'),
            'id'   => "{$prefix}social_sharing",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'adroit'),
                'off'		=> esc_html__('Hidden', 'adroit'),
                'on'		=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'adroit')
        ),
        array(
            'name' => esc_html__('Related articles', 'adroit'),
            'id'   => "{$prefix}related_acticles",
            'type' => 'select',
            'options' => array(
                ''      => esc_html__('Default', 'adroit'),
                'off'    => esc_html__('Hidden', 'adroit'),
                'on'	=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'adroit')
        ),


        //Header
        array(
            'name' => esc_html__('Header shadow', 'adroit'),
            'id'   => "{$prefix}header_shadow",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'adroit'),
                'off'       => esc_html__('Hidden', 'adroit'),
                'on'        => esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'post_header',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'adroit')
        ),
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



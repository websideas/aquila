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
    $image_sizes = kt_get_image_sizes();
    $menus = wp_get_nav_menus();

    $menus_arr = array('' => __('Default', THEME_LANG));
    foreach ( $menus as $menu ) {
        $menus_arr[$menu->term_id] = esc_html( $menu->name );
    }

    /**
     * For Post Audio
     *
     */
    $meta_boxes[] = array(
        'title'  => __('Audio Settings',THEME_LANG),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Audio'),
        ),
        'fields' => array(
            array(
                'name' => __('Audio Type', THEME_LANG),
                'id' => $prefix . 'audio_type',
                'type'     => 'select',
                'options'  => array(
                    '' => __('Select Option', THEME_LANG),
                    'upload' => __('Upload', THEME_LANG),
                    'soundcloud' => __('Soundcloud', THEME_LANG),
                ),
            ),
            array(
                'name'             => __( 'Upload MP3 File', THEME_LANG ),
                'id'               => "{$prefix}audio_mp3",
                'type'             => 'file_advanced',
                'max_file_uploads' => 1,
                'mime_type'        => 'audio', // Leave blank for all file types
                'visible' => array($prefix . 'audio_type', '=', 'upload')
            ),
            array(
                'name' => __( 'Soundcloud', THEME_LANG ),
                'desc' => __( 'Paste embed iframe or Wordpress shortcode.', THEME_LANG ),
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
        'title'  => __('Video Settings',THEME_LANG),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Video'),
        ),

        'fields' => array(
            array(
                'name' => __('Video Type', THEME_LANG),
                'id' => $prefix . 'video_type',
                'type'     => 'select',
                'options'  => array(
                    '' => __('Select Option', THEME_LANG),
                    'external' => __('External url', THEME_LANG),
                ),
            ),
            array(
                'name' => __('Choose Video', THEME_LANG),
                'id' => $prefix . 'choose_video',
                'type'     => 'select',
                'options'  => array(
                    'youtube' => __('Youtube', THEME_LANG),
                    'vimeo' => __('Vimeo', THEME_LANG),
                ),
                'visible' => array($prefix . 'video_type', '=', 'external')
            ),
            array(
                'name' => __( 'Video id', THEME_LANG ),
                'id' => $prefix . 'video_id',
                'desc' => sprintf( __( 'Enter id of video .Example: <br />- Link video youtube: https://www.youtube.com/watch?v=nPOO1Coe2DI id of video: nPOO1Coe2DI <br /> -Link vimeo: https://vimeo.com/70296428 id video: 70296428.', THEME_LANG ) ),
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
        'title'  => __('Gallery Settings',THEME_LANG),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Gallery'),
        ),

        'fields' => array(
            array(
                'name' => __('Gallery Type', THEME_LANG),
                'id' => $prefix . 'gallery_type',
                'type'     => 'select',
                'options'  => array(
                    'slider' => __('Default', THEME_LANG),
                    'gird' => __('Gird', THEME_LANG),
                    'revslider' => __('Revolution Slider', THEME_LANG),
                    'layerslider' => __('Layer Slider', THEME_LANG)
                ),
            ),
            array(
                'name' => __('Select Revolution Slider', THEME_LANG),
                'id' => $prefix . 'gallery_rev_slider',
                'default' => true,
                'type' => 'revSlider',
                'visible' => array($prefix . 'gallery_type','=', 'revslider' ),
            ),
            array(
                'name' => __('Select Layer Slider', THEME_LANG),
                'id' => $prefix . 'gallery_layerslider',
                'default' => true,
                'type' => 'layerslider',
                'visible' => array($prefix . 'gallery_type','=', 'layerslider' ),
            ),
            array(
                'name' => __( 'Gallery images', THEME_LANG ),
                'id'  => "{$prefix}gallery_images",
                'type' => 'image_advanced',
                'desc' => __( "You can drag and drop for change order image", THEME_LANG ),
                'visible' => array($prefix . 'gallery_type','in', array('slider', 'gird' )),
            ),
        ),
    );



    /**
     * For Link
     *
     */
    /*
    $meta_boxes[] = array(
        'title'  => __('Link Settings',THEME_LANG),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Link'),
        ),
        'fields' => array(
            array(
                'name' => __( 'External URL', THEME_LANG ),
                'id' => $prefix . 'external_url',
                'desc' => __( "Input your link in here", THEME_LANG ),
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
        'title'  => __('Quote Settings',THEME_LANG),
        'pages'  => array( 'post' ),
        'show'   => array(
            'post_format' => array( 'Quote'),
        ),
        'fields' => array(
            array(
                'name' => __( 'Quote Content', THEME_LANG ),
                'desc' => __( 'Please type the text for your quote here.', THEME_LANG ),
                'id'   => "{$prefix}quote_content",
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 3,
            ),
            array(
                'name' => __( 'Author', THEME_LANG ),
                'id' => $prefix . 'quote_author',
                'desc' => __( "Please type the text for author quote here.", THEME_LANG ),
                'type'  => 'text',
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
            'template' => array( 'page-templates/front-page.php'),
        ),
        'tabs'      => array(
            'frontpage_general'  => array(
                'label' => __( 'General', THEME_LANG ),
                'icon'  => 'fa fa-cogs',
            ),
            'frontpage_layout'  => array(
                'label' => __( 'Layout', THEME_LANG ),
                'icon'  => 'fa fa-columns',
            ),
            'frontpage_displays'  => array(
                'label' => __( 'Displays', THEME_LANG ),
                'icon'  => 'fa fa-paint-brush',
            ),
        ),
        'fields' => array(
            //General
            array(
                'name' => __('Content', THEME_LANG),
                'id'   => "{$prefix}frontpage_content",
                'type' => 'select',
                'options' => array(
                    0		=> __('This content', THEME_LANG),
                    1		=> __('Special content', THEME_LANG),
                    //2		=> __('Both', THEME_LANG),
                ),
                'std'  => -1,
                'tab'  => 'frontpage_general',
            ),
            array(
                'name' => __('Data source', THEME_LANG),
                'id'   => "{$prefix}frontpage_source",
                'type' => 'select',
                'options' => array(
                    ''              => __('All', THEME_LANG),
                    'categories'    => __('Specific Categories', THEME_LANG),
                    'authors'		=> __('Specific Authors', THEME_LANG),
                    'posts'		=> __('Specific Posts', THEME_LANG),
                ),
                'std'  => '',
                'tab'  => 'frontpage_general',
                'visible' => array($prefix . 'frontpage_content', '=', '1')
            ),
            // Categories
            array(
                'name'    => __( 'Specific Categories', THEME_LANG ),
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
                'name'    => __( 'Specific Authors', THEME_LANG ),
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
                'name'        => __( 'Posts', THEME_LANG ),
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
                'name' => __('Blog type', THEME_LANG),
                'id'   => "{$prefix}frontpage_type",
                'type' => 'select',
                'options' => array(
                    'list'              => __('List', THEME_LANG),
                    'medium'              => __('Medium', THEME_LANG),
                    'masonry'    => __('Masonry', THEME_LANG),
                    'gird'		=> __('Gird', THEME_LANG),
                ),
                'std'  => 'standard',
                'tab'  => 'frontpage_layout',
            ),

            //Displays
            array(
                'type' => 'text',
                'name' => __( 'Number of items', 'js_composer' ),
                'id' => $prefix.'max_items',
                'std' => 10, // default value
                'desc' => __( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'js_composer' ),
                'tab'  => 'frontpage_displays',
            ),
            array(
                'type' => 'select',
                'name' => __( 'Order by', THEME_LANG ),
                'id' => $prefix.'frontpage_orderby',
                'options' => array(
                    'date' => __( 'Date', THEME_LANG ),
                    'ID' => __( 'Order by post ID', THEME_LANG ),
                    'author' => __( 'Author', THEME_LANG ),
                    'title' => __( 'Title', THEME_LANG ),
                    'modified' => __( 'Last modified date', THEME_LANG ),
                    'parent' => __( 'Post/page parent ID', THEME_LANG ),
                    'comment_count' => __( 'Number of comments', THEME_LANG ),
                    'menu_order' => __( 'Menu order/Page Order', THEME_LANG ),
                    'meta_value' => __( 'Meta value', THEME_LANG ),
                    'meta_value_num' => __( 'Meta value number', THEME_LANG )
                ),
                'desc' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', THEME_LANG ),
                'tab' => 'frontpage_displays'
            ),
            array(
                'type' => 'text',
                'name' => __( 'Meta key', THEME_LANG ),
                'id' => $prefix.'meta_key',
                'tab' => 'frontpage_displays',
                'visible' => array($prefix . 'frontpage_orderby', '=', 'meta_value')
            ),
            array(
                'type' => 'select',
                'name' => __( 'Sorting', THEME_LANG ),
                'id' => $prefix.'order',
                'tab' => 'frontpage_displays',
                'options' => array(
                    'DESC' => __( 'Descending', THEME_LANG ),
                    'ASC' => __( 'Ascending', THEME_LANG ),
                ),
                'desc' => __( 'Select sorting order.', THEME_LANG ),
            )
        )
    );


    /**
     * For Layout option for post
     *
     */
    $meta_boxes[] = array(
        'id' => 'post_meta_boxes',
        'title' => 'Post Options',
        'pages' => array('post'),
        'tabs'      => array(
            'post_general'  => array(
                'label' => __( 'General', THEME_LANG ),
                'icon'  => 'fa fa-bars',
            ),
            'post_displays'  => array(
                'label' => __( 'Displays', THEME_LANG ),
                'icon'  => 'fa fa-bars',
            ),

        ),
        'fields' => array(
            //General

            array(
                'name' => __('Featured Post', THEME_LANG),
                'id'   => "{$prefix}post_featured",
                'type' => 'select',
                'options' => array(
                    'no'		=> __('No', THEME_LANG),
                    'yes'		=> __('Yes', THEME_LANG),
                ),
                'std'  => 'no',
                'tab'  => 'post_general',
                'desc' => __('Make this post featured', THEME_LANG)
            ),

            array(
                'name' => __('Detail Media', THEME_LANG),
                'id'   => "{$prefix}post_detail_media",
                'type' => 'select',
                'options' => array(
                    0    => __('Default', THEME_LANG),
                    1		=> __('Hidden', THEME_LANG),
                    2		=> __('Post format', THEME_LANG),
                    3       => __('Thumbnail content', THEME_LANG)
                ),
                'std'  => 0,
                'tab'  => 'post_general',
            ),


            array(
                'type' => 'select',
                'name' => __('Post layouts', THEME_LANG),
                'desc' => __('Select the your post layout.', THEME_LANG),
                'id'   => "{$prefix}blog_post_layout",
                'options' => array(
                    0    => __('Default', THEME_LANG),
                    1 => __( 'Layout 1', THEME_LANG ),
                    2 => __( 'layout 2', THEME_LANG ),
                ),
                'std' => '',
                'tab'  => 'post_general',
            ),

            array(
                'type' => 'select',
                'name' => __('Post image size', THEME_LANG),
                'desc' => __('Select the format position.', THEME_LANG),
                'id'   => "{$prefix}blog_image_size",
                'options' => array_merge(array('' => __('Default', THEME_LANG)), $image_sizes),
                'std' => '',
                'tab'  => 'post_general',
            ),
            array(
                'name' => __('Meta info', THEME_LANG),
                'id'   => "{$prefix}meta_info",
                'type' => 'select',
                'options' => array(
                    ''    => __('Default', THEME_LANG),
                    'no'		=> __('Hidden', THEME_LANG),
                    'yes'		=> __('Show', THEME_LANG),
                ),
                'std'  => -1,
                'tab'  => 'post_displays',
                'desc' => __('Select "Default" to use settings in Theme Options', THEME_LANG)
            ),
            array(
                'name' => __('Previous & next buttons', THEME_LANG),
                'id'   => "{$prefix}prev_next",
                'type' => 'select',
                'options' => array(
                    ''    => __('Default', THEME_LANG),
                    'no'		=> __('Hidden', THEME_LANG),
                    'yes'		=> __('Show', THEME_LANG),
                ),
                'std'  => '',
                'tab'  => 'post_displays',
                'desc' => __('Select "Default" to use settings in Theme Options', THEME_LANG)
            ),
            array(
                'name' => __('Author info', THEME_LANG),
                'id'   => "{$prefix}author_info",
                'type' => 'select',
                'options' => array(
                    ''    => __('Default', THEME_LANG),
                    'no'		=> __('Hidden', THEME_LANG),
                    'yes'		=> __('Show', THEME_LANG),
                ),
                'std'  => '',
                'tab'  => 'post_displays',
                'desc' => __('Select "Default" to use settings in Theme Options', THEME_LANG)
            ),
            array(
                'name' => __('Social sharing', THEME_LANG),
                'id'   => "{$prefix}social_sharing",
                'type' => 'select',
                'options' => array(
                    ''    => __('Default', THEME_LANG),
                    'no'		=> __('Hidden', THEME_LANG),
                    'yes'		=> __('Show', THEME_LANG),
                ),
                'std'  => '',
                'tab'  => 'post_displays',
                'desc' => __('Select "Default" to use settings in Theme Options', THEME_LANG)
            ),
            array(
                'name' => __('Related articles', THEME_LANG),
                'id'   => "{$prefix}related_acticles",
                'type' => 'select',
                'options' => array(
                    ''      => __('Default', THEME_LANG),
                    'no'    => __('Hidden', THEME_LANG),
                    'yes'	=> __('Show', THEME_LANG),
                ),
                'std'  => '',
                'tab'  => 'post_displays',
                'desc' => __('Select "Default" to use settings in Theme Options', THEME_LANG)
            ),



        )
    );





    /**
     * For Layout option
     *
     */
    $meta_boxes[] = array(
        'id' => 'page_meta_boxes',
        'title' => 'Page Options',
        'pages' => array( 'page', 'post' ),
        'tabs'      => array(
            'header'  => array(
                'label' => __( 'Header', THEME_LANG ),
                'icon'  => 'fa fa-desktop',
            ),
            'page_header' => array(
                'label' => __( 'Page Header', THEME_LANG ),
                'icon'  => 'fa fa-bars',
            ),
            'page_layout' => array(
                'label' => __( 'Page layout', THEME_LANG ),
                'icon'  => 'fa fa-columns',
            )
        ),
        'fields' => array(


            //Header
            array(
                'name'    => __( 'Header position', THEME_LANG ),
                'type'     => 'select',
                'id'       => $prefix.'header_position',
                'desc'     => __( "Please choose header position", THEME_LANG ),
                'options'  => array(
                    'default' => __('Default', THEME_LANG),
                    'below' => __('Below Slideshow', THEME_LANG),
                ),
                'std'  => 'default',
                'tab'  => 'header',
            ),


            array(
                'name' => __('Select Your Slideshow Type', THEME_LANG),
                'id' => $prefix . 'slideshow_type',
                'desc' => __("You can select the slideshow type using this option.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    '' => __('Select Option', THEME_LANG),
                    'postslider' => __('Post Slider', THEME_LANG),
                    'revslider' => __('Revolution Slider', THEME_LANG),
                    'layerslider' => __('Layer Slider', THEME_LANG),
                ),
                'tab'  => 'header',
            ),

            array(
                'name' => __('Posts Slider style', THEME_LANG),
                'id'   => "{$prefix}slideshow_posts_style",
                'type' => 'select',
                'options' => array(
                    'big'           => __('Big Carousel', THEME_LANG),
                    'slider'        => __('Posts slider', THEME_LANG),
                    'thumb'         => __('Thumb slider', THEME_LANG),
                    'carousel'      => __('Small Carousel', THEME_LANG),
                ),
                'std'  => '',
                'tab'  => 'header',
                'visible' => array($prefix . 'slideshow_type', '=', 'postslider')
            ),

            array(
                'name' => __('Data source', THEME_LANG),
                'id'   => "{$prefix}slideshow_source",
                'type' => 'select',
                'options' => array(
                    ''              => __('All', THEME_LANG),
                    'categories'    => __('Specific Categories', THEME_LANG),
                    'authors'		=> __('Specific Authors', THEME_LANG),
                ),
                'std'  => '',
                'tab'  => 'header',
                'visible' => array($prefix . 'slideshow_type', '=', 'postslider')
            ),


            // Categories
            array(
                'name'    => __( 'Specific Categories', THEME_LANG ),
                'id'      => "{$prefix}slideshow_categories",
                'type'    => 'taxonomy_advanced',
                'multiple'=> true,
                'options' => array(
                    'taxonomy' => 'category',
                    'type'     => 'select_advanced',
                    'args'     => array()
                ),
                'tab'  => 'header',
                'visible' => array($prefix . 'slideshow_source', '=', 'categories')
            ),

            // Authors
            array(
                'name'    => __( 'Specific Categories', THEME_LANG ),
                'id'      => "{$prefix}slideshow_authors",
                'type'    => 'user',
                'multiple'=> true,
                'options' => array(
                    'type'     => 'select_advanced'
                ),
                'tab'  => 'header',
                'visible' => array($prefix . 'slideshow_source', '=', 'authors')
            ),


            array(
                'name' => __('Select Revolution Slider', THEME_LANG),
                'id' => $prefix . 'rev_slider',
                'default' => true,
                'type' => 'revSlider',
                'tab'  => 'header',
                'desc' => __('Select the Revolution Slider.', THEME_LANG),
                'visible' => array($prefix . 'slideshow_type', '=', 'revslider')
            ),
            array(
                'name' => __('Select Layer Slider', THEME_LANG),
                'id' => $prefix . 'layerslider',
                'default' => true,
                'type' => 'layerslider',
                'tab'  => 'header',
                'desc' => __('Select the Layer Slider.', THEME_LANG),
                'visible' => array($prefix . 'slideshow_type', '=', 'layerslider')
            ),

            // Page Header
            array(
                'name' => __( 'Page Header Custom Text', THEME_LANG ),
                'id' => $prefix . 'page_header_custom',
                'desc' => __( "Enter cstom Text for page header.", THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_header',
                'visible' => array($prefix . 'page_header', '!=', '0')
            ),

            array(
                'name' => __( 'Page header subtitle', THEME_LANG ),
                'id' => $prefix . 'page_header_subtitle',
                'desc' => __( "Enter subtitle for page.", THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_header',
                'visible' => array($prefix . 'page_header', '!=', '0')
            ),

            array(
                'id'       => "{$prefix}page_header_align",
                'type'     => 'select',
                'name'    => __( 'Page Header align', THEME_LANG ),
                'desc'     => __( 'Please select Page Header align', THEME_LANG ),
                'options'  => array(
                    ''    => __('Default', THEME_LANG),
                    'left' => __('Left', THEME_LANG ),
                    'center' => __('Center', THEME_LANG),
                    'right' => __('Right', THEME_LANG)
                ),
                'std'  => '',
                'tab'  => 'page_header',
                'visible' => array($prefix . 'page_header', '!=', '0')
            ),

            //Page layout
            array(
                'name' => __('Sidebar configuration', THEME_LANG),
                'id' => $prefix . 'sidebar',
                'desc' => __("Choose the sidebar configuration for the detail page.<br/><b>Note: Cart and checkout, My account page always use no sidebars.</b>", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'default' => __('Default', THEME_LANG),
                    'full' => __('No sidebars', THEME_LANG),
                    'left' => __('Left Sidebar', THEME_LANG),
                    'right' => __('Right Sidebar', THEME_LANG)
                ),
                'std' => 'default',
                'tab'  => 'page_layout',
            ),
            array(
                'name' => __('Left sidebar', THEME_LANG),
                'id' => $prefix . 'left_sidebar',
                'default' => false,
                'type' => 'sidebars',
                'tab'  => 'page_layout',
                'desc' => __("Select your sidebar.", THEME_LANG),
                'compare' => array($prefix . 'sidebar','=', 'left' ),
            ),
            array(
                'name' => __('Right sidebar', THEME_LANG),
                'id' => $prefix . 'right_sidebar',
                'default' => false,
                'type' => 'sidebars',
                'tab'  => 'page_layout',
                'desc' => __("Select your sidebar.", THEME_LANG),
                'compare' => array($prefix . 'sidebar','=', 'right' ),
            ),
            array(
                'name' => __('Page top spacing', THEME_LANG),
                'id' => $prefix . 'page_top_spacing',
                'desc' => __("Enter your page top spacing (Example: 100px).", THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_layout',
            ),
            array(
                'name' => __('Page bottom spacing', THEME_LANG),
                'id' => $prefix . 'page_bottom_spacing',
                'desc' => __("Enter your page bottom spacing (Example: 100px).", THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_layout',
            ),
            array(
                'name' => __('Extra page class', THEME_LANG),
                'id' => $prefix . 'extra_page_class',
                'desc' => __('If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.', THEME_LANG ),
                'type'  => 'text',
                'tab'  => 'page_layout',
            ),


            //The image that will be used as the OUTER page background image.
            //Inner Background

        )
    );


    return $meta_boxes;
}



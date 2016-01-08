<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


if ( ! class_exists( 'KT_config' ) ) {
    class KT_config1{
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if ( ! class_exists( 'ReduxFramework' ) ) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            }
        }
        
        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }
            
            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }
        
        
        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'             => KT_THEME_OPTIONS,
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'         => $theme->get( 'Name' ),
                // Name that appears at the top of your panel
                'display_version'      => $theme->get( 'Version' ),
                // Version that appears at the top of your panel
                'menu_type'            => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'       => false,
                // Show the sections below the admin menu item or not
                'menu_title'           => __( 'Theme Options', 'aquila' ),
                
                'page_title'           => $theme->get( 'Name' ).' '.esc_html__( 'Theme Options', 'aquila' ),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key'       => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography'     => false,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar'            => false,
                // Show the panel pages on the admin bar
                'admin_bar_icon'     => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable'      => '',
                // Set a different name for your global variable other than the opt_name
                'dev_mode'             => false,
                // Show the time the page took to load, etc
                'update_notice'        => false,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer'           => true,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'        => 61,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'          => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'     => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon'            => 'dashicons-art',
                // Specify a custom URL to an icon
                'last_tab'             => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon'            => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug'            => 'theme_options',
                // Page slug used to denote the panel
                'save_defaults'        => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show'         => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark'         => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export'   => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time'       => 60 * MINUTE_IN_SECONDS,
                'output'               => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'           => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'             => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'          => false,
                // REMOVE
            );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => '#',
                'title' => esc_html__('Like us on Facebook', 'aquila'),
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => '#',
                'title' => esc_html__('Follow us on Twitter', 'aquila'),
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => '#',
                'title' => esc_html__('Find us on LinkedIn', 'aquila'),
                'icon'  => 'el-icon-linkedin'
            );
            
        }
        
        public function setSections() {
            



            /**
             *  Styling General
             **/
            $this->sections[] = array(
                'id'            => 'styling_general',
                'title'         => esc_html__( 'General', 'aquila' ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'styling_accent',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Main Color', 'aquila' ),
                        'default'  => '#82c14f',
                        'transparent' => false,
                    ),

                    array(
                        'id'       => 'styling_link',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Links Color', 'aquila' ),
                        'output'   => array( 'a' ),
                        'default'  => array(
                            'regular' => '#82c14f',
                            'hover' => '#689a3f',
                            'active' => '#689a3f'
                        )
                    ),
                )
            );
            
            /**
             *  Styling Header
             **/
            $this->sections[] = array(
                'id'            => 'styling_header',
                'title'         => esc_html__( 'Header', 'aquila' ),
                'subsection' => true,
                'fields'        => array(



                    /*



                        array(
                            'id'   => 'divide_id',
                            'type' => 'divide'
                        ),

                        array(
                            'id'       => 'header_background',
                            'type'     => 'background',
                            'title'    => esc_html__( 'Header background', 'aquila' ),
                            'subtitle' => esc_html__( 'Header with image, color, etc.', 'aquila' ),
                            'default'   => '',
                            'output'      => array( '.header-background' ),
                        ),
                        array(
                            'id'            => 'header_opacity',
                            'type'          => 'slider',
                            'title'         => esc_html__( 'Background opacity', 'aquila' ),
                            'default'       => 1,
                            'min'           => 0,
                            'step'          => .1,
                            'max'           => 1,
                            'resolution'    => 0.1,
                            'display_value' => 'text'
                        ),
                    */
                )
            );
        }
        
    }

    class KT_config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct()
        {

            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }

        public function initSettings()
        {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }


        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments()
        {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => KT_THEME_OPTIONS,
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type' => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true,
                // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Theme Options', 'aquila'),

                'page_title' => $theme->get('Name') . ' ' . esc_html__('Theme Options', 'aquila'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography' => true,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar' => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon' => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable' => '',
                // Set a different name for your global variable other than the opt_name
                'dev_mode' => false,
                // Show the time the page took to load, etc
                'update_notice' => false,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer' => false,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority' => 61,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon' => 'dashicons-art',
                // Specify a custom URL to an icon
                'last_tab' => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug' => 'theme_options',
                // Page slug used to denote the panel
                'save_defaults' => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info' => true,
                // REMOVE
            );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url' => 'https://www.facebook.com/kitethemes/',
                'title' => esc_html__('Like us on Facebook', 'aquila'),
                'icon' => 'el-icon-facebook'
            );

            $this->args['share_icons'][] = array(
                'url' => 'http://themeforest.net/user/Kite-Themes/follow?ref=Kite-Themes',
                'title' => esc_html__('Follow us on Themeforest', 'aquila'),
                'icon' => 'fa fa-wordpress'
            );

            $this->args['share_icons'][] = array(
                'url' => '#',
                'title' => esc_html__('Get Email Newsletter', 'aquila'),
                'icon' => 'fa fa-envelope-o'
            );

            $this->args['share_icons'][] = array(
                'url' => 'http://themeforest.net/user/kite-themes/portfolio',
                'title' => esc_html__('Check out our works', 'aquila'),
                'icon' => 'fa fa-briefcase'
            );
        }

        public function setSections()
        {

            $image_sizes = kt_get_image_sizes();

            $this->sections[] = array(
                'id'    => 'general',
                'title'  => esc_html__( 'General', 'aquila' ),
                'icon'  => 'fa fa-cogs'
            );

            $this->sections[] = array(
                'id'    => 'general_layout',
                'title'  => esc_html__( 'General', 'aquila' ),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'layout',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Site boxed mod(?)', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose page layout", 'aquila' ),
                        'options'  => array(
                            'full' => esc_html__('Full width Layout', 'aquila'),
                            'boxed' => esc_html__('Boxed Layout', 'aquila'),
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'archive_placeholder',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Placeholder', 'aquila' ),
                        'subtitle'     => esc_html__( "Placeholder for none image", 'aquila' ),
                    ),
                )
            );
            /**
             *  Logos
             **/
            $this->sections[] = array(
                'id'            => 'logos_favicon',
                'title'         => esc_html__( 'Logos', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'logos_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Logos settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'logo',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Logo', 'aquila' ),
                    ),
                    array(
                        'id'       => 'logo_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Logo (Retina Version @2x)', 'aquila' ),
                        'desc'     => esc_html__('Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', 'aquila')
                    ),
                )
            );


            /**
             *  Header
             **/
            $this->sections[] = array(
                'id'            => 'Header',
                'title'         => esc_html__( 'Header', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(

                    array(
                        'id'       => 'header',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Header layout', 'aquila' ),
                        'subtitle' => esc_html__( 'Please choose header layout', 'aquila' ),
                        'options'  => array(
                            1 => array( 'alt' => esc_html__( 'Layout 1', 'aquila' ), 'img' => KT_FW_IMG . 'header/header-v1.jpg' ),
                            2 => array( 'alt' => esc_html__( 'Layout 2', 'aquila' ), 'img' => KT_FW_IMG . 'header/header-v2.jpg' ),
                        ),
                        'default'  => 1
                    ),
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'header_shadow',
                        'type' => 'switch',
                        'title' => esc_html__('Header shadow', 'aquila'),
                        "default" => 1,
                        'on'        => esc_html__( 'Enabled', 'aquila' ),
                        'off'       => esc_html__( 'Disabled', 'aquila' ),
                    ),
                    array(
                        'id' => 'header_search',
                        'type' => 'switch',
                        'title' => esc_html__('Search Icon', 'aquila'),
                        'desc' => esc_html__('Enable the search Icon in the header.', 'aquila'),
                        "default" => 1,
                        'on'        => esc_html__( 'Enabled', 'aquila' ),
                        'off'       => esc_html__( 'Disabled', 'aquila' ),
                    ),
                    
                    
                    array(
                         'id'   => 'footer_socials',
                         'type' => 'kt_socials',
                         'title'    => __( 'Select your socials', 'aquila' ),
                    ),
                )
            );
            /**
             *    Footer
             **/
            $this->sections[] = array(
                'id' => 'footer',
                'title' => esc_html__('Footer', 'aquila'),
                'desc' => '',
                'subsection' => true,
                'fields' => array(
                    // Footer settings

                    array(
                        'id' => 'backtotop',
                        'type' => 'switch',
                        'title' => esc_html__('Back to top', 'aquila'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' => esc_html__('Disabled', 'aquila'),
                    ),

                    array(
                        'id' => 'footer_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer settings', 'aquila') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer',
                        'type' => 'switch',
                        'title' => esc_html__('Footer enable', 'aquila'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' => esc_html__('Disabled', 'aquila'),
                    ),

                    // Footer Top settings
                    array(
                        'id' => 'footer_top_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer top settings', 'aquila') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_top',
                        'type' => 'switch',
                        'title' => esc_html__('Footer top enable', 'aquila'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' => esc_html__('Disabled', 'aquila'),
                    ),

                    // Footer widgets settings
                    array(
                        'id' => 'footer_widgets_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer widgets settings', 'aquila') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_widgets',
                        'type' => 'switch',
                        'title' => esc_html__('Footer widgets enable', 'aquila'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' => esc_html__('Disabled', 'aquila'),
                    ),

                    array(
                        'id' => 'footer_widgets_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Footer widgets layout', 'aquila'),
                        'subtitle' => esc_html__('Select your footer widgets layout', 'aquila'),
                        'options' => array(
                            '3-3-3-3' => array('alt' => esc_html__('Layout 1', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-1.png'),
                            '6-3-3' => array('alt' => esc_html__('Layout 2', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-2.png'),
                            '3-3-6' => array('alt' => esc_html__('Layout 3', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-3.png'),
                            '6-6' => array('alt' => esc_html__('Layout 4', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-4.png'),
                            '4-4-4' => array('alt' => esc_html__('Layout 5', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-5.png'),
                            '8-4' => array('alt' => esc_html__('Layout 6', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-6.png'),
                            '4-8' => array('alt' => esc_html__('Layout 7', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-7.png'),
                            '3-6-3' => array('alt' => esc_html__('Layout 8', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-8.png'),
                            '12' => array('alt' => esc_html__('Layout 9', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-9.png'),
                        ),
                        'default' => '4-4-4'
                    ),
                    /* Footer Bottom */
                    array(
                        'id' => 'footer_bottom_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer bottom settings', 'aquila') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_bottom',
                        'type' => 'switch',
                        'title' => esc_html__('Footer bottom enable', 'aquila'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' => esc_html__('Disabled', 'aquila'),
                    ),
                    array(
                        'id' => 'footer_bottom_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Footer bottom layout', 'aquila'),
                        'subtitle' => esc_html__('Select your footer bottom layout', 'aquila'),
                        'options' => array(
                            '1' => array('alt' => esc_html__('Layout 1', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-bottom-1.png'),
                            '2' => array('alt' => esc_html__('Layout 2', 'aquila'), 'img' => KT_FW_IMG . 'footer/footer-bottom-2.png'),
                        ),
                        'default' => '1'
                    ),
                    /* Footer copyright */
                    array(
                        'id' => 'footer_copyright_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer copyright settings', 'aquila') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_copyright',
                        'type' => 'switch',
                        'title' => esc_html__('Footer copyright enable', 'aquila'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' => esc_html__('Disabled', 'aquila'),
                    ),
                    array(
                        'id' => 'footer_copyright_text',
                        'type' => 'editor',
                        'title' => esc_html__('Footer Copyright Text', 'aquila'),
                        'default' => '&copy; Copyright Alitstudio 2015 .All Rights Reserved.'
                    ),
                )
            );

            /**
             * Page Loader
             *
             */
            $this->sections[] = array(
                'title' => esc_html__('Page Loader', 'aquila'),
                'desc' => esc_html__('Page Loader Options', 'aquila'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'use_page_loader',
                        'type' => 'switch',
                        'title' => esc_html__('Use Page Loader?', 'aquila'),
                        'default' => 1,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id'       => 'layout_loader',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Loader layout', 'aquila' ),
                        'subtitle' => esc_html__( 'Please choose loader layout', 'aquila' ),
                        'options'  => array(
                            'style-1' => array( 'alt' => esc_html__( 'Style 1', 'aquila' ), 'img' => KT_FW_IMG . 'loader/loader_v1.png' ),
                            'style-2' => array( 'alt' => esc_html__( 'Style 2', 'aquila' ), 'img' => KT_FW_IMG . 'loader/loader_v2.png' ),
                            'style-3' => array( 'alt' => esc_html__( 'Style 2', 'aquila' ), 'img' => KT_FW_IMG . 'loader/loader_v3.png' ),
                        ),
                        'default'  => 'style-1',
                    ),
                    array(
                        'id'       => 'background_page_loader',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Background Color Page Loader', 'aquila' ),
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-size'       => false,
                        'preview'               => false,
                        'transparent'           => false,
                        'default'   => array(
                            'background-color'      => '#FFFFFF',
                        ),
                        'output'   => array( '.kt_page_loader' ),
                        'required' => array( 'use_page_loader', 'equals', array( 1 ) ),
                    ),
                    array(
                        'id'       => 'color_first_loader',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Color Loader', 'aquila' ),
                        'default'  => '#22dcce',
                        'transparent' => false,
                        'required' => array( 'use_page_loader', 'equals', array( 1 ) ),
                    ),
                    array(
                        'id'       => 'color_second_loader',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Color Second Loader', 'aquila' ),
                        'default'  => '#cccccc',
                        'transparent' => false,
                        'required' => array( 'use_page_loader', 'equals', array( 1 ) ),
                    ),
                )
            );


            $this->sections[] = array(
                'icon'      => 'el-icon-cog',
                'title'     => esc_html__('Preset', 'wingman'),
                'fields'    => array(
                    array(
                        'id'       => 'kt-presets',
                        'type'     => 'image_select', 
                        'presets'  => true,
                        'title'    => esc_html__('Color Preset', 'wingman'),
                        'subtitle' => esc_html__('Select the color you want to use for the theme.', 'wingman'),
                        'default'  => 0,
                        'options'  => array(
                            'color_default'      => array(
                                'alt'   => 'Default', 
                                'img'   => KT_FW_IMG.'/preset/default.jpg',
                                'presets'   => array(
                                    'color_second_loader' => '#22dcce',
                                    'navigation_color_hover' => '#22dcce',
                                    'dropdown_color_hover' => '#22dcce',
                                    'mega_title_color_hover' => '#22dcce',
                                    'mega_color_hover' => '#22dcce',
                                    'navigation_color_hover' => '#22dcce',
                                    'dropdown_color_hover' => '#22dcce',
                                )
                            ),
                        )
                    ),
                )
            );


            /**
             *  Styling
             **/
            $this->sections[] = array(
                'id'            => 'styling',
                'title'         => esc_html__( 'Styling', 'aquila' ),
                'desc'          => '',
                'icon'  => 'dashicons dashicons-art',
            );

            /**
             *  Styling General
             **/
            $this->sections[] = array(
                'id'            => 'styling_general',
                'title'         => esc_html__( 'General', 'wingman' ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'styling_accent',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Main Color', 'wingman' ),
                        'default'  => '#82c14f',
                        'transparent' => false,
                    ),

                    array(
                        'id'       => 'styling_link',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Links Color', 'wingman' ),
                        'output'   => array( 'a' ),
                        'default'  => array(
                            'regular' => '#22dcce',
                            'hover' => '#000000',
                            'active' => '#000000'
                        )
                    ),
                )
            );

            /**
             *  Styling Logo
             **/
            $this->sections[] = array(
                'id'            => 'styling-logo',
                'title'         => esc_html__( 'Logo', 'aquila' ),
                'subsection' => true,
                'fields'        => array(

                    array(
                        'id'             => 'logo_width',
                        'type'           => 'dimensions',
                        'units'          => array( 'px'),
                        'units_extended' => 'true',
                        'title'          => esc_html__( 'Logo width', 'aquila' ),
                        'height'         => false,
                        'default'        => array( 'width'  => 25, 'unit'   => 'px' ),
                        'output'   => array( '.site-branding .site-logo img' ),
                    ),
                    array(
                        'id'       => 'logo_margin_spacing',
                        'type'     => 'spacing',
                        'mode'     => 'margin',
                        'output'   => array( '.site-branding' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Logo margin spacing Option', 'aquila' ),
                        'default'  => array(
                            'margin-top'    => '27px',
                            'margin-right'  => '65px',
                            'margin-bottom' => '27px',
                            'margin-left'   => '0'
                        )
                    ),
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'             => 'logo_mobile_width',
                        'type'           => 'dimensions',
                        'units'          => array( 'px'),
                        'units_extended' => 'true',
                        'title'          => esc_html__( 'Logo mobile width', 'aquila' ),
                        'height'         => false,
                        'default'        => array(
                            'width'  => 25,
                            'unit'   => 'px'
                        ),
                        'output'   => array( '#header-content-mobile .site-branding .site-logo img' ),
                    ),
                    array(
                        'id'       => 'logo_mobile_margin_spacing',
                        'type'     => 'spacing',
                        'mode'     => 'margin',
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Logo mobile margin spacing Option', 'aquila' ),
                        'default'  => array(
                            'margin-top'    => '20px',
                            'margin-right'  => '0px',
                            'margin-bottom' => '20px',
                            'margin-left'   => '0px'
                        ),
                        'output'   => array( '#header-content-mobile .site-branding' ),
                    ),

                )
            );



            /**
             *  Styling Sticky
             **/
            $this->sections[] = array(
                'id'            => 'styling_sticky',
                'title'         => esc_html__( 'Sticky', 'aquila' ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'fixed_header',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Sticky header', 'aquila' ),
                        'options'  => array(
                            '1' => esc_html__('Disabled', 'aquila'),
                            '2' => esc_html__('Fixed Sticky', 'aquila'),
                            '3' => esc_html__('Slide Down', 'aquila'),
                        ),
                        'default'  => '3',
                        'desc' => esc_html__('Choose your sticky effect.', 'aquila')
                    ),
                    array(
                        'id'             => 'logo_sticky_width',
                        'type'           => 'dimensions',
                        'units'          => array( 'px'),
                        'title'          => esc_html__( 'Logo width', 'aquila' ),
                        'height'         => false,
                        'default'        => array(
                            'width'  => '25',
                            'units'  => 'px'
                        ),
                        'output'   => array( '.header-layout1.header-container.is-sticky .site-branding .site-logo img' ),
                    ),

                    array(
                        'id'       => 'logo_sticky_margin_spacing',
                        'type'     => 'spacing',
                        'mode'     => 'margin',
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Logo sticky margin spacing Option', 'aquila' ),
                        'default'  => array(
                            'margin-top'    => '17px',
                            'margin-right'  => '65px',
                            'margin-bottom' => '17px',
                            'margin-left'   => '0'
                        ),
                        'output'   => array( '.header-layout1.header-container.is-sticky .site-branding'),
                    ),

                    array(
                        'id'             => 'navigation_height_fixed',
                        'type'           => 'dimensions',
                        'units'          => array('px'),
                        'units_extended' => 'true',
                        'title'          => esc_html__( 'Main Navigation Sticky Height', 'aquila' ),
                        'desc'          => esc_html__( 'Change height of main navigation sticky', 'aquila' ),
                        'width'         => false,
                        'default'        => array(
                            'height'  => '60',
                            'units'  => 'px'
                        ),

                        'output'   => array(
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
                        ),
                    ),
                    array(
                        'id'       => 'header_sticky_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Header sticky background', 'aquila' ),
                        'desc' => esc_html__( 'Header sticky with image, color, etc.', 'aquila' ),
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-size'       => false,
                        'preview'               => false,
                        'transparent'           => false,
                        'default'   => array(
                            'background-color'      => '#ffffff',
                        ),
                        'output'      => array( '.header-container.is-sticky .header-sticky-background' ),
                    ),

                    array(
                        'id'            => 'header_sticky_opacity',
                        'type'          => 'slider',
                        'title'         => esc_html__( 'Sticky Background opacity', 'aquila' ),
                        'default'       => 1,
                        'min'           => 0,
                        'step'          => .1,
                        'max'           => 1,
                        'resolution'    => 0.1,
                        'display_value' => 'text'
                    ),

                )
            );



            /**
             *  Styling Footer
             **/
            $this->sections[] = array(
                'id'            => 'styling_footer',
                'title'         => esc_html__( 'Footer', 'aquila' ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'footer_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer Background', 'aquila' ),
                        'subtitle' => esc_html__( 'Footer Background with image, color, etc.', 'aquila' ),
                        'default'   => array( 'background-color' => '#222222' ),
                        'output'      => array( '#footer' ),
                    ),

                    array(
                        'id'       => 'footer_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'Footer Border', 'aquila' ),
                        'output'   => array( '#footer' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'bottom'   => false,
                        'default'  => array( )
                    ),

                    // Footer top settings
                    array(
                        'id'       => 'footer_top_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer top settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_top_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer top Background', 'aquila' ),
                        'subtitle' => esc_html__( 'Footer top Background with image, color, etc.', 'aquila' ),
                        'default'   => array( ),
                        'output'      => array( '#footer-top' ),
                    ),
                    array(
                        'id'       => 'footer_top_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-top' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Footer top padding', 'aquila' ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'footer_top_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'Footer top Border', 'aquila' ),
                        'output'   => array( '#footer-top' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'top'      => false,
                        'default'  => array(

                        )
                    ),

                    //Footer navigation settings
                    array(
                        'id'       => 'footer_navigation_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer Navigation settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),


                    array(
                        'id'       => 'footer_navigation_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer navigation Background', 'aquila' ),
                        'subtitle' => esc_html__( 'Footer Background with image, color, etc.', 'aquila' ),
                        'default'   => array( ),
                        'output'      => array( '#footer-navigation' ),
                    ),
                    array(
                        'id'       => 'footer_navigation_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-navigation' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Footer navigation padding', 'aquila' ),
                        'default'  => array( )
                    ),

                    // Footer widgets settings
                    array(
                        'id'       => 'footer_widgets_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer widgets settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_widgets_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer widgets Background', 'aquila' ),
                        'subtitle' => esc_html__( 'Footer widgets Background with image, color, etc.', 'aquila' ),
                        'default'   => array(  ),
                        'output'      => array( '#footer-area' ),
                    ),
                    array(
                        'id'       => 'footer_widgets_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-area' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Footer widgets padding', 'aquila' ),
                        'default'  => array( )
                    ),

                    array(
                        'id'       => 'footer_widgets_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'Footer widgets Border', 'aquila' ),
                        'output'   => array( '#footer-area' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'top'      => false,
                        'default'  => array( )
                    ),

                    // Footer widgets settings
                    array(
                        'id'       => 'footer_bottom_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer bottom settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_bottom_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer bottom Background', 'aquila' ),
                        'subtitle' => esc_html__( 'Footer bottom Background with image, color, etc.', 'aquila' ),
                        'default'   => array(  ),
                        'output'      => array( '#footer-bottom' ),
                    ),
                    array(
                        'id'       => 'footer_bottom_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-bottom.footer-bottom-2', '#footer-bottom.footer-bottom-1' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Footer bottom padding', 'aquila' ),
                        'default'  => array( )
                    ),

                    array(
                        'id'       => 'footer_bottom_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'Footer bottom Border', 'aquila' ),
                        'output'   => array( '#footer-bottom' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'top'      => false,
                        'default'  => array( )
                    ),

                    //Footer copyright settings
                    array(
                        'id'       => 'footer_copyright_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer copyright settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),


                    array(
                        'id'       => 'footer_copyright_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer Background', 'aquila' ),
                        'subtitle' => esc_html__( 'Footer Background with image, color, etc.', 'aquila' ),
                        'default'   => array( ),
                        'output'      => array( '#footer-copyright' ),
                    ),
                    array(
                        'id'       => 'footer_copyright_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-copyright' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Footer copyright padding', 'aquila' ),
                        'default'  => array( )
                    ),
                )
            );



            /**
             *  Main Navigation
             **/
            $this->sections[] = array(
                'id'            => 'styling_navigation',
                'title'         => esc_html__( 'Main Navigation', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'styling_navigation_general',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'General', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'             => 'navigation_height',
                        'type'           => 'dimensions',
                        'units'          => array('px'),
                        'units_extended' => 'true',
                        'title'          => esc_html__( 'Main Navigation Height', 'aquila' ),
                        'subtitle'          => esc_html__( 'Change height of main navigation', 'aquila' ),
                        'width'         => false,
                        'default'        => array(
                            'height'  => '80',
                            'units'  => 'px'
                        ),
                        'output'   => array(
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
                        ),
                    ),

                    array(
                        'id'       => 'navigation_box_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'MegaMenu & Dropdown Box background', 'aquila' ),
                        'default'   => array(
                            'background-color'      => '#222222',
                        ),
                        'output'      => array(
                            '#main-navigation > li ul.sub-menu-dropdown',
                            '#main-navigation > li > .kt-megamenu-wrapper'
                        ),
                        'transparent'           => false,
                    ),
                    array(
                        'id'       => 'styling_navigation_general',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Top Level', 'aquila' ).'</div>',
                        'full_width' => true
                    ),

                    array(
                        'id'            => 'navigation_space',
                        'type'          => 'slider',
                        'title'         => esc_html__( 'Top Level space', 'aquila' ),
                        'default'       => 25,
                        'min'           => 0,
                        'step'          => 1,
                        'max'           => 50,
                        'resolution'    => 1,
                        'display_value' => 'text',
                        'subtitle' => esc_html__( 'Margin left between top level.', 'aquila' ),
                    ),

                    array(
                        'id'       => 'navigation_color',
                        'type'     => 'color',
                        'output'   => array(
                            '#main-navigation > li > a'
                        ),
                        'title'    => esc_html__( 'Top Level Color', 'aquila' ),
                        'default'  => '#999999',
                        'transparent' => false
                    ),
                    array(
                        'id'       => 'navigation_color_hover',
                        'type'     => 'color',
                        'output'   => array(
                            '#main-navigation > li > a:hover',
                            '#main-navigation > li > a:focus',
                            '#main-navigation > li.current-menu-item > a',
                            '#main-navigation > li.current-menu-parent > a',
                            '#main-navigation > li.hovered > a',
                        ),
                        'title'    => esc_html__( 'Top Level hover Color', 'aquila' ),
                        'default'  => '#22dcce',
                        'transparent' => false
                    ),


                    array(
                        'id'       => 'styling_navigation_dropdown',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Drop down', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'             => 'navigation_dropdown',
                        'type'           => 'dimensions',
                        'units'          => array('px'),
                        'units_extended' => 'true',
                        'title'          => esc_html__( 'Dropdown width', 'aquila' ),
                        'subtitle'          => esc_html__( 'Change width of Dropdown', 'aquila' ),
                        'height'         => false,
                        'default'        => array( 'width'  => 300, 'units' => 'px' ),
                        'output'   => array( '#main-navigation > li ul.sub-menu-dropdown'),
                    ),
                    array(
                        'id'       => 'dropdown_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Dropdown Background Color', 'aquila' ),
                        'default'  => array(
                            'background-color'      => '',
                        ),
                        'output'   => array(
                            '#main-navigation > li ul.sub-menu-dropdown > li > a'
                        ),
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-size'       => false,
                        'preview'               => false,
                        'transparent'           => true,
                    ),

                    array(
                        'id'       => 'dropdown_background_hover',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Dropdown Background Hover Color', 'aquila' ),
                        'default'  => array(
                            'background-color'      => '',
                        ),
                        'output'   => array(
                            '#main-navigation > li ul.sub-menu-dropdown > li.current-menu-item > a',
                            '#main-navigation > li ul.sub-menu-dropdown > li.current-menu-parent > a',
                            '#main-navigation > li ul.sub-menu-dropdown > li.hovered > a',
                            '#main-navigation > li ul.sub-menu-dropdown > li > a:hover',
                        ),
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-size'       => false,
                        'preview'               => false,
                        'transparent'           => true,
                    ),
                    array(
                        'id'       => 'dropdown_color',
                        'type'     => 'color',
                        'output'   => array(
                            '#main-nav-tool .kt-wpml-languages ul li > a',
                            '#main-navigation > li ul.sub-menu-dropdown > li > a',
                        ),
                        'title'    => esc_html__( 'Dropdown Text Color', 'aquila' ),
                        'default'  => '#999999',
                        'transparent' => false
                    ),

                    array(
                        'id'       => 'dropdown_color_hover',
                        'type'     => 'color',
                        'output'   => array(
                            '#main-navigation > li ul.sub-menu-dropdown > li.current-menu-item > a',
                            '#main-navigation > li ul.sub-menu-dropdown > li.current-menu-parent > a',
                            '#main-nav-tool .kt-wpml-languages ul li > a:hover',
                            '#main-navigation > li ul.sub-menu-dropdown > li:hover > a',
                            '#main-navigation > li ul.sub-menu-dropdown > li > a:hover',
                        ),
                        'title'    => esc_html__( 'Dropdown Text Hover Color', 'aquila' ),
                        'default'  => '#22dcce',
                        'transparent' => false
                    ),

                    array(
                        'id'       => 'dropdown_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'DropDown Border', 'aquila' ),
                        'output'   => array( '#main-navigation > li ul.sub-menu-dropdown li' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'style'    => false,
                        'top'      => false,
                        'default'  => array(
                            'border-style'  => 'solid',
                            'border-bottom'    => '1px',
                            'border-color' => '#333333'
                        )
                    ),
                    array(
                        'id'       => 'styling_navigation_mega',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Mega', 'aquila' ).'</div>',
                        'full_width' => true
                    ),

                    array(
                        'id'       => 'megamenu_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'MegaMenu Background color', 'aquila' ),
                        'default'  => array('background-color' => '#222222', ),
                        'output'   => array(
                            '#main-navigation > li > .kt-megamenu-wrapper'
                        ),
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-size'       => false,
                        'preview'               => false,
                        'transparent'           => true,
                        'transparent' => false
                    ),
                    array(
                        'id'       => 'mega_title_color',
                        'type'     => 'color',
                        'output'   => array(
                            '#main-navigation > li.menu-item-object-category > .kt-megamenu-wrapper .blog-posts-menu .post-item-content .entry-title a',
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li > a', 
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li > span',
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li .widget-title',
                        ),
                        'title'    => esc_html__( 'MegaMenu Title color', 'aquila' ),
                        'default'  => '#FFFFFF',
                        'transparent' => false
                    ),
                    array(
                        'id'       => 'mega_title_color_hover',
                        'type'     => 'color',
                        'output'   => array(
                            '#main-navigation > li.menu-item-object-category > .kt-megamenu-wrapper .blog-posts-menu .post-item-content .entry-title a:hover',
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li > a:hover', 
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li > span:hover',
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li .widget-title:hover',
                        ),
                        'title'    => esc_html__( 'MegaMenu Title Hover Color', 'aquila' ),
                        'default'  => '#22dcce',
                        'transparent' => false
                    ),
                    array(
                        'id'       => 'mega_color',
                        'type'     => 'color',
                        'output'   => array(
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li > ul.sub-menu-megamenu a',
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li > ul.sub-menu-megamenu span',
                        ),
                        'title'    => esc_html__( 'MegaMenu Text color', 'aquila' ),
                        'default'  => '#999999',
                        'transparent' => false
                    ),

                    array(
                        'id'       => 'mega_color_hover',
                        'type'     => 'color',
                        'output'   => array(
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li > ul.sub-menu-megamenu  > li.current-menu-item a:hover',
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li > ul.sub-menu-megamenu a:hover',
                            '#main-navigation > li:not(.menu-item-object-category) .kt-megamenu-ul > li > ul.sub-menu-megamenu span:hover',
                        ),
                        'title'    => esc_html__( 'MegaMenu Text Hover color', 'aquila' ),
                        'default'  => '#22dcce',
                        'transparent' => false
                    ),




                    array(
                        'id'       => 'mega_menu_spacing',
                        'type'     => 'raw',
                        'content'  => '<div style="height:150px"></div>',
                        'full_width' => true
                    ),
                )
            );

            /**
             *  Mobile Navigation
             **/
            $this->sections[] = array(
                'id'            => 'styling_mobile_menu',
                'title'         => esc_html__( 'Mobile Menu', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'mobile_menu_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Background', 'aquila' ),
                        'default'   => array(
                            'background-color'      => '#FFFFFF',
                        ),
                        'output'      => array( '#main-nav-mobile'),
                        'transparent'           => false,
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),

                    array(
                        'id'       => 'mobile_menu_color',
                        'type'     => 'color',
                        'output'   => array(
                            'ul.navigation-mobile > li > a'
                        ),
                        'title'    => esc_html__( 'Top Level Color', 'aquila' ),
                        'default'  => '#999999',
                        'transparent' => false
                    ),
                    array(
                        'id'       => 'mobile_menu_color_hover',
                        'type'     => 'color',
                        'output'   => array(
                            'ul.navigation-mobile > li:hover > a',
                            'ul.navigation-mobile > li > a:hover'
                        ),
                        'title'    => esc_html__( 'Top Level hover Color', 'aquila' ),
                        'default'  => '#22dcce',
                        'transparent' => false
                    ),
                    array(
                        'id'       => 'mobile_menu_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Top Level Background Color', 'aquila' ),
                        'default'  => array(
                            'background-color'      => '#FFFFFF',
                        ),
                        'output'   => array(
                            'ul.navigation-mobile > li > a'
                        ),
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-size'       => false,
                        'preview'               => false,
                        'transparent'           => false,
                    ),

                    array(
                        'id'       => 'mobile_menu_background_hover',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Top Level Hover Color', 'aquila' ),
                        'default'  => array(
                            'background-color'      => '#F5F5F5',
                        ),
                        'output'   => array(
                            'ul.navigation-mobile > li:hover > a',
                            'ul.navigation-mobile > li > a:hover',
                        ),
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-size'       => false,
                        'preview'               => false,
                        'transparent'           => false,
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id'       => 'mobile_sub_color',
                        'type'     => 'color',
                        'output'   => array(
                            '.main-nav-mobile > ul > li ul.sub-menu li a',
                            '.main-nav-mobile > ul > li ul.sub-menu-megamenu li a',
                            '.main-nav-mobile > ul > li ul.sub-menu-dropdown li a',
                            'ul.navigation-mobile > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > .sub-menu-megamenu > li > a',
                        ),
                        'title'    => esc_html__( 'Text color', 'aquila' ),
                        'default'  => '#999999',
                        'transparent' => false
                    ),

                    array(
                        'id'       => 'mobile_sub_color_hover',
                        'type'     => 'color',
                        'output'   => array(
                            '.main-nav-mobile > ul > li ul.sub-menu li a:hover',
                            '.main-nav-mobile > ul > li ul.sub-menu-megamenu li a:hover',
                            '.main-nav-mobile > ul > li ul.sub-menu-dropdown li a:hover',
                            'ul.navigation-mobile > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > .sub-menu-megamenu > li > a:hover',
                        ),
                        'title'    => esc_html__( 'Text Hover color', 'aquila' ),
                        'default'  => '#22dcce',
                        'transparent' => false
                    ),

                    array(
                        'id'       => 'mobile_menu_spacing',
                        'type'     => 'raw',
                        'content'  => '<div style="height:150px"></div>',
                        'full_width' => true
                    ),
                )
            );


            /**
             *  Typography
             **/
            $this->sections[] = array(
                'id'            => 'typography',
                'title'         => esc_html__( 'Typography', 'aquila' ),
                'desc'          => '',
                'icon_class'    => 'fa fa-font',
            );


            /**
             *  Typography General
             **/
            $this->sections[] = array(
                'id'            => 'typography_general',
                'title'         => esc_html__( 'General', 'aquila' ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography_body',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Body Font', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the body font properties.', 'aquila' ),
                        'text-align' => false,
                        'letter-spacing'  => true,
                        'output'      => array(
                            'body' ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'typography_pragraph',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Pragraph', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the pragraph font properties.', 'aquila' ),
                        'output'   => array( 'p' ),
                        'default'  => array( ),
                        'color'    => false,
                        'text-align' => false,
                    ),
                    array(
                        'id'       => 'typography_button',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Button', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the button font properties.', 'aquila' ),
                        'output'   => array(
                            '.button',
                            '.wpcf7-submit',
                            '.btn',
                        ),
                        'default'  => array( ),
                        'color'    => false,
                        'text-align'    => false,
                        'font-size'    => false,
                        'text-transform' => true,
                        'letter-spacing'  => true,
                        'font-weight' => false
                    ),
                    array(
                        'id'       => 'typography_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Typography Heading settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_heading1',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Heading 1', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the heading 1 font properties.', 'aquila' ),
                        'letter-spacing'  => true,
                        'text-transform' => true,
                        'text-align' => false,
                        'output'      => array( 'h1', '.h1' ),
                        'default'  => array( ),
                    ),
                    array(
                        'id'       => 'typography_heading2',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Heading 2', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the heading 2 font properties.', 'aquila' ),
                        'letter-spacing'  => true,
                        'output'      => array( 'h2', '.h2' ),
                        'text-transform' => true,
                        'text-align' => false,
                        'default'  => array( ),
                    ),
                    array(
                        'id'       => 'typography_heading3',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Heading 3', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the heading 3 font properties.', 'aquila' ),
                        'letter-spacing'  => true,
                        'output'      => array( 'h3', '.h3' ),
                        'text-transform' => true,
                        'text-align' => false,
                        'default'  => array( ),
                    ),
                    array(
                        'id'       => 'typography_heading4',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Heading 4', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the heading 4 font properties.', 'aquila' ),
                        'letter-spacing'  => true,
                        'output'      => array( 'h4', '.h4' ),
                        'text-transform' => true,
                        'text-align' => false,
                        'default'  => array( ),
                    ),
                    array(
                        'id'       => 'typography_heading5',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Heading 5', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the heading 5 font properties.', 'aquila' ),
                        'letter-spacing'  => true,
                        'output'      => array( 'h5', '.h5' ),
                        'text-transform' => true,
                        'text-align' => false,
                        'default'  => array( ),
                    ),
                    array(
                        'id'       => 'typography_heading6',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Heading 6', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the heading 6 font properties.', 'aquila' ),
                        'letter-spacing'  => true,
                        'output'      => array( 'h6', '.h6' ),
                        'text-transform' => true,
                        'text-align' => false,
                        'default'  => array( ),
                    ),
                )
            );


            /**
             *  Typography footer
             **/
            $this->sections[] = array(
                'id'            => 'typography_footer',
                'title'         => esc_html__( 'Footer', 'aquila' ),
                'desc'          => '',
                'subsection'    => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography_footer_top_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Typography Footer top settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_footer_top',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Footer top', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the footer top font properties.', 'aquila' ),
                        'google'   => true,
                        'text-align'      => false,
                        'output'      => array( '#footer-top' ),
                        'default'  => array(
                            'color'       => '',
                            'font-size'   => '',
                            'font-weight' => '',
                            'line-height' => ''
                        ),
                    ),
                    array(
                        'id'       => 'typography_footer_widgets_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Typography Footer widgets settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_footer_widgets',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Footer widgets', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the footer widgets font properties.', 'aquila' ),
                        'google'   => true,
                        'text-align'      => false,
                        'output'      => array( '#footer-area' ),
                        'default'  => array(
                            'color'       => '#999999',
                            'font-size'   => '',
                            'font-weight' => '',
                            'line-height' => ''
                        ),
                    ),
                    array(
                        'id'       => 'typography_footer_widgets_title',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Footer widgets title', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the footer widgets title font properties.', 'aquila' ),
                        'letter-spacing'  => true,
                        'text-align'      => true,
                        'text-transform' => true,
                        'output'      => array( '#footer-area h3.widget-title' ),
                        'default'  => array( ),
                    ),
                    array(
                        'id'       => 'typography_footer_widgets_link',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Footer widgets Links Color', 'aquila' ),
                        'output'      => array( '#footer-area a' ),
                        'default'  => array(
                            'regular' => '#ffffff',
                            'hover'   => '#22dcce',
                            'active'  => '#22dcce'
                        )
                    ),

                    array(
                        'id'       => 'typography_footer_copyright_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Typography Footer Bottom settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_footer_bottom_link',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Footer Bottom Links Color', 'aquila' ),
                        'output'      => array( '#footer-bottom a', '#footer-bottom button' ),
                        'default'  => array(
                            'regular' => '#ffffff',
                            'hover'   => '#22dcce',
                            'active'  => '#22dcce'
                        )
                    ),
                    array(
                        'id'       => 'typography_footer_bottom',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Footer Bottom', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the footer font properties.', 'aquila' ),
                        'text-align'      => false,
                        'output'      => array( '#footer-bottom' ),
                        'default'  => array(
                            'color'       => '#999999',
                            'font-size'   => '',
                            'font-weight' => '',
                            'line-height' => ''
                        ),
                    ),

                    array(
                        'id'       => 'typography_footer_copyright_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Typography Footer copyright settings', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_footer_copyright_link',
                        'type'     => 'link_color',
                        'title'    => esc_html__( 'Footer Copyright Links Color', 'aquila' ),
                        'output'      => array( '#footer-copyright a' ),
                        'default'  => array(
                            'regular' => '#999999',
                            'hover'   => '#ffffff',
                            'active'  => '#ffffff'
                        )
                    ),
                    array(
                        'id'       => 'typography_footer_copyright',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Footer copyright', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the footer font properties.', 'aquila' ),
                        'text-align'      => false,
                        'output'      => array( '#footer-copyright' ),
                        'default'  => array(
                            'color'       => '',
                            'font-size'   => '',
                            'font-weight' => '',
                            'line-height' => ''
                        ),
                    ),

                )
            );


            /**
             *  Typography header
             **/
            $this->sections[] = array(
                'id'            => 'typography_header',
                'title'         => esc_html__( 'Header', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography_header_content',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Header', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the header title font properties.', 'aquila' ),
                        'google'   => true,
                        'text-align' => false,
                        'output'      => array( '#header' )
                    )
                )
            );

            /**
             *  Typography sidebar
             **/
            $this->sections[] = array(
                'id'            => 'typography_sidebar',
                'title'         => esc_html__( 'Sidebar', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography_sidebar',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Sidebar title', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the sidebar title font properties.', 'aquila' ),
                        'letter-spacing'  => true,
                        'text-transform' => true,
                        'output'      => array(
                            '.sidebar .widget-title',
                            '.wpb_widgetised_column .widget-title'
                        ),
                        'default'  => array(
                            'text-transform' => 'uppercase',
                        ),
                    ),
                    array(
                        'id'       => 'typography_sidebar_content',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Sidebar text', 'aquila' ),
                        'subtitle' => esc_html__( 'Specify the sidebar title font properties.', 'aquila' ),
                        'text-algin' => true,
                        'output'      => array( '.sidebar', '.wpb_widgetised_column' ),
                        'default'  => array(

                        ),
                    ),
                )
            );

            /**
             *  Typography Navigation
             **/

            $this->sections[] = array(
                'id'            => 'typography_navigation',
                'title'         => esc_html__( 'Main Navigation', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography-navigation_top',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Top Menu Level', 'aquila' ),
                        'letter-spacing'  => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'text-transform' => true,
                        'output'      => array( '#main-navigation > li > a' ),
                        'default'  => array(
                            'text-transform' => 'uppercase',
                            'font-weight'    => '600'
                        ),
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id'       => 'typography_navigation_dropdown',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Dropdown menu', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_navigation_second',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Second Menu Level', 'aquila' ),
                        'letter-spacing'  => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'text-transform' => true,
                        'output'      => array(
                            '#main-navigation > li ul.sub-menu-dropdown li > a'
                        ),
                        'default'  => array(

                        ),
                    ),
                    array(
                        'id'       => 'typography_navigation_mega',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Mega menu', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_navigation_heading',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Heading title', 'aquila' ),
                        'letter-spacing'  => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'text-transform' => true,
                        'output'      => array(
                            '#main-navigation > li > .kt-megamenu-wrapper > .kt-megamenu-ul > li > a',
                            '#main-navigation > li > .kt-megamenu-wrapper > .kt-megamenu-ul > li > span',
                            '#main-navigation > li > .kt-megamenu-wrapper > .kt-megamenu-ul > li .widget-title'
                        ),
                        'default'  => array(
                            'font-family'     => 'Josefin Slab',
                            'text-transform' => 'uppercase',
                            'font-weight'  => '700'
                        ),
                    ),
                    array(
                        'id'       => 'typography_navigation_mega_link',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Mega menu', 'aquila' ),
                        'google'   => true,
                        'text-align'      => false,
                        'color'           => false,
                        'text-transform' => true,
                        'line-height'     => false,
                        'output'      => array(
                            '#main-navigation > li > .kt-megamenu-wrapper > .kt-megamenu-ul > li ul.sub-menu-megamenu a'
                        ),
                        'default'  => array( ),
                    )

                )
            );


            /**
             *  Typography mobile Navigation
             **/

            $this->sections[] = array(
                'id'            => 'typography_mobile_navigation',
                'title'         => esc_html__( 'Mobile Navigation', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography_mobile_navigation_top',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Top Menu Level', 'aquila' ),
                        'letter-spacing'  => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'text-transform' => true,
                        'output'      => array( 'ul.navigation-mobile > li > a' ),
                        'default'  => array(
                            'text-transform' => 'uppercase',
                        ),
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id'       => 'typography_mobile_navigation_second',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Sub Menu Level', 'aquila' ),
                        'letter-spacing'  => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'text-transform' => true,
                        'output'      => array(
                            '.main-nav-mobile > ul > li ul.sub-menu-dropdown li a',
                            '.main-nav-mobile > ul > li ul.sub-menu-megamenu li a'
                        ),
                    ),
                    array(
                        'id'       => 'typography_mobile_navigation_heading',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Heading title', 'aquila' ),
                        'letter-spacing'  => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'text-transform' => true,
                        'output'      => array(
                            '.main-nav-mobile > ul > li div.kt-megamenu-wrapper > ul > li > a',
                            '.main-nav-mobile > ul > li div.kt-megamenu-wrapper > ul > li > span',
                            '.main-nav-mobile > ul > li div.kt-megamenu-wrapper > ul > li .widget-title'
                        ),
                        'default'  => array(
                            'text-transform' => 'uppercase',
                            'font-weight'  => '700'
                        ),
                    ),
                )
            );

            /**
             * General page
             *
             */
            $this->sections[] = array(
                'title' => esc_html__('Page', 'aquila'),
                'desc' => esc_html__('General Page Options', 'aquila'),
                'icon' => 'fa fa-suitcase',
                'fields' => array(
                    array(
                        'id' => 'show_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'aquila'),
                        'desc' => esc_html__('Show page header or?.', 'aquila'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id'       => 'page_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar configuration', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose archive page ", 'aquila' ),
                        'options'  => array(
                            '' => esc_html__('No sidebars', 'aquila'),
                            'left' => esc_html__('Left Sidebar', 'aquila'),
                            'right' => esc_html__('Right Layout', 'aquila')
                        ),
                        'default'  => 'right',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'page_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Sidebar left area', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose default layout", 'aquila' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('page_sidebar','equals','left')
                        //'clear' => false
                    ),

                    array(
                        'id'       => 'page_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar right area', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose page layout", 'aquila' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('page_sidebar','equals','right')
                        //'clear' => false
                    ),

                    array(
                        'id' => 'show_page_comment',
                        'type' => 'switch',
                        'title' => esc_html__('Show comments on page ?', 'aquila'),
                        'desc' => esc_html__('Show or hide the readmore button.', 'aquila'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),

                )
            );

            /**
             * General Blog
             *
             */
            $this->sections[] = array(
                'title' => esc_html__('Blog', 'aquila'),
                'icon' => 'fa fa-pencil',
                'desc' => esc_html__('General Blog Options', 'aquila')
            );

            /**
             *  Archive settings
             **/
            $this->sections[] = array(
                'id'            => 'archive_section',
                'title'         => esc_html__( 'Archive', 'aquila' ),
                'desc'          => 'Archive post settings',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'archive_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Archive post general', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'archive_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'aquila'),
                        'desc' => esc_html__('Show page header or?.', 'aquila'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id'       => 'archive_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar configuration', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose archive page ", 'aquila' ),
                        'options'  => array(
                            'full' => esc_html__('No sidebars', 'aquila'),
                            'left' => esc_html__('Left Sidebar', 'aquila'),
                            'right' => esc_html__('Right Layout', 'aquila')
                        ),
                        'default'  => 'right',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'archive_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Sidebar left area', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'aquila' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('archive_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'archive_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar right area', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'aquila' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('archive_sidebar','equals','right'),
                        'clear' => false
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'archive_loop_style',
                        'type' => 'select',
                        'title' => esc_html__('Loop Style', 'aquila'),
                        'desc' => '',
                        'options' => array(
                            'list' => esc_html__( 'List', 'aquila' ),
                            'medium' => esc_html__( 'Medium', 'aquila' ),
                            'grid' => esc_html__( 'Grid', 'aquila' ),
                            'masonry' => esc_html__( 'Masonry', 'aquila' ),
                        ),
                        'default' => 'grid'
                    ),
                    array(
                        'id' => 'archive_first_featured',
                        'type' => 'switch',
                        'title' => esc_html__('First featured', 'aquila'),
                        'desc' => esc_html__('Show First article featured or?.', 'aquila'),
                        "default" => 0,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id' => 'archive_columns',
                        'type' => 'select',
                        'title' => esc_html__('Columns on desktop', 'aquila'),
                        'desc' => '',
                        'options' => array(
                            '2' => esc_html__( '2 columns', 'js_composer' ) ,
                            '3' => esc_html__( '3 columns', 'js_composer' ) ,
                            '4' => esc_html__( '4 columns', 'js_composer' ) ,
                        ),
                        'default' => '2',
                        'required' => array('archive_loop_style','equals', array( 'grid', 'masonry' ) ),
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'archive_posts_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Posts per page', 'aquila'),
                        'desc' => esc_html__("Insert the total number of pages.", 'aquila'),
                        'default' => 14,
                    ),
                    array(
                        'id' => 'archive_excerpt_length',
                        'type' => 'text',
                        'title' => esc_html__('Excerpt Length', 'aquila'),
                        'desc' => esc_html__("Insert the number of words you want to show in the post excerpts.", 'aquila'),
                        'default' => 35,
                    ),
                    array(
                        'id' => 'archive_pagination',
                        'type' => 'select',
                        'title' => esc_html__('Pagination Type', 'aquila'),
                        'desc' => esc_html__('Select the pagination type.', 'aquila'),
                        'options' => array(
                            'normal' => esc_html__( 'Normal pagination', 'aquila' ),
                            'button' => esc_html__( 'Next - Previous button', 'aquila' ),
                        ),
                        'default' => 'normal'
                    ),
                )
            );


            /**
             *  Author settings
             **/
            $this->sections[] = array(
                'id'            => 'author_section',
                'title'         => esc_html__( 'Author', 'aquila' ),
                'desc'          => 'Author post settings',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'author_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Author post general', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'author_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'aquila'),
                        'desc' => esc_html__('Show page header or?.', 'aquila'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id'       => 'author_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar configuration', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose archive page ", 'aquila' ),
                        'options'  => array(
                            'full' => esc_html__('No sidebars', 'aquila'),
                            'left' => esc_html__('Left Sidebar', 'aquila'),
                            'right' => esc_html__('Right Layout', 'aquila')
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'author_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Sidebar left area', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'aquila' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('author_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'author_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar right area', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'aquila' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('author_sidebar','equals','right'),
                        'clear' => false
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'author_posts_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Posts per page', 'aquila'),
                        'desc' => esc_html__("Insert the total number of pages.", 'aquila'),
                        'default' => 9,
                    ),
                    array(
                        'id' => 'author_loop_style',
                        'type' => 'select',
                        'title' => esc_html__('Loop Style', 'aquila'),
                        'desc' => '',
                        'options' => array(
                            'list' => esc_html__( 'List', 'aquila' ),
                            'medium' => esc_html__( 'Medium', 'aquila' ),
                            'grid' => esc_html__( 'Grid', 'aquila' ),
                            'masonry' => esc_html__( 'Masonry', 'aquila' ),
                        ),
                        'default' => 'grid'
                    ),
                    array(
                        'id' => 'author_first_featured',
                        'type' => 'switch',
                        'title' => esc_html__('First featured', 'aquila'),
                        'desc' => esc_html__('Show First article featured or?.', 'aquila'),
                        "default" => 0,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id' => 'author_columns',
                        'type' => 'select',
                        'title' => esc_html__('Columns on desktop', 'aquila'),
                        'desc' => '',
                        'options' => array(
                            '2' => esc_html__( '2 columns', 'js_composer' ) ,
                            '3' => esc_html__( '3 columns', 'js_composer' ) ,
                            '4' => esc_html__( '4 columns', 'js_composer' ) ,
                        ),
                        'default' => 3,
                        'required' => array('author_loop_style','equals', array( 'grid', 'masonry' ) ),
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'author_excerpt_length',
                        'type' => 'text',
                        'title' => esc_html__('Excerpt Length', 'aquila'),
                        'desc' => esc_html__("Insert the number of words you want to show in the post excerpts.", 'aquila'),
                        'default' => 35,
                    ),
                    array(
                        'id' => 'author_pagination',
                        'type' => 'select',
                        'title' => esc_html__('Pagination Type', 'aquila'),
                        'desc' => esc_html__('Select the pagination type.', 'aquila'),
                        'options' => array(
                            'normal' => esc_html__( 'Normal pagination', 'aquila' ),
                            'button' => esc_html__( 'Next - Previous button', 'aquila' ),
                        ),
                        'default' => 'normal'
                    ),
                )
            );

            /**
             *  Single post settings
             **/
            $this->sections[] = array(
                'id'            => 'post_single_section',
                'title'         => esc_html__( 'Single Post', 'aquila' ),
                'desc'          => 'Single post settings',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'blog_single_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Single post general', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'single_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Single layout', 'aquila' ),
                        'subtitle' => esc_html__( 'Please choose header layout', 'aquila' ),
                        'options'  => array(
                            1 => array( 'alt' => esc_html__( 'Layout 1', 'aquila' ), 'img' => KT_FW_IMG . 'single/layout-1.jpg' ),
                            2 => array( 'alt' => esc_html__( 'Layout 1', 'aquila' ), 'img' => KT_FW_IMG . 'single/layout-2.jpg' ),
                            3 => array( 'alt' => esc_html__( 'Layout 1', 'aquila' ), 'img' => KT_FW_IMG . 'single/layout-3.jpg' ),
                            4 => array( 'alt' => esc_html__( 'Layout 1', 'aquila' ), 'img' => KT_FW_IMG . 'single/layout-4.jpg' ),
                            5 => array( 'alt' => esc_html__( 'Layout 1', 'aquila' ), 'img' => KT_FW_IMG . 'single/layout-5.jpg' ),
                            6 => array( 'alt' => esc_html__( 'Layout 1', 'aquila' ), 'img' => KT_FW_IMG . 'single/layout-6.jpg' ),
                        ),
                        'default'  => 1
                    ),
                    array(
                        'id'       => 'single_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar configuration', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose sidebar for single post", 'aquila' ),
                        'options'  => array(
                            '' => esc_html__('No sidebars', 'aquila'),
                            'left' => esc_html__('Left Sidebar', 'aquila'),
                            'right' => esc_html__('Right Layout', 'aquila')
                        ),
                        'default'  => 'right',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'single_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Single post: Sidebar left area', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'aquila' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('single_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'single_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Single post: Sidebar right area', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'aquila' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('single_sidebar','equals','right'),
                        'clear' => false
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id'   => 'single_image_size',
                        'type' => 'select',
                        'options' => $image_sizes,
                        'title'    => esc_html__( 'Image size', 'aquila' ),
                        'desc' => esc_html__("Select image size.", 'aquila'),
                        'default' => 'blog_post'
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'single_share_box',
                        'type' => 'switch',
                        'title' => esc_html__('Share box in posts', 'aquila'),
                        'desc' => esc_html__('Show share box in blog posts.', 'aquila'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id' => 'single_like_post',
                        'type' => 'switch',
                        'title' => esc_html__('Show like article', 'aquila'),
                        'desc' => esc_html__('Show like article or?', 'aquila'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id' => 'single_next_prev',
                        'type' => 'switch',
                        'title' => esc_html__('Previous & next buttons', 'aquila'),
                        'desc' => esc_html__('Show Previous & next buttons in blog posts.', 'aquila'),
                        "default" => 0,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id' => 'single_author',
                        'type' => 'switch',
                        'title' => esc_html__('Author info in posts', 'aquila'),
                        'desc' => esc_html__('Show author info in blog posts.', 'aquila'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id' => 'single_related',
                        'type' => 'switch',
                        'title' => esc_html__('Related posts', 'aquila'),
                        'desc' => esc_html__('Show related posts in blog posts.', 'aquila'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id'       => 'single_related_type',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Related Query Type', 'aquila' ),
                        'options'  => array(
                            'categories' => esc_html__('Categories', 'aquila'),
                            'tags' => esc_html__('Tags', 'aquila'),
                            'author' => esc_html__('Author', 'aquila')
                        ),
                        'default'  => 'categories',
                        'clear' => false,
                    )
                )
            );

            /**
             *  Search settings
             **/
            $this->sections[] = array(
                'id'            => 'search_section',
                'title'         => esc_html__( 'Search', 'aquila' ),
                'desc'          => 'Search settings',
                'icon'          => 'fa fa-search',
                'fields'        => array(
                    array(
                        'id'       => 'search_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Search post general', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'search_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'aquila'),
                        'desc' => esc_html__('Show page header or?.', 'aquila'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id'       => 'search_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar configuration', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose archive page ", 'aquila' ),
                        'options'  => array(
                            'full' => esc_html__('No sidebars', 'aquila'),
                            'left' => esc_html__('Left Sidebar', 'aquila'),
                            'right' => esc_html__('Right Layout', 'aquila')
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'search_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Sidebar left area', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'aquila' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('search_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'search_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Search: Sidebar right area', 'aquila' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'aquila' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('search_sidebar','equals','right'),
                        'clear' => false
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'search_posts_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Posts per page', 'aquila'),
                        'desc' => esc_html__("Insert the total number of pages.", 'aquila'),
                        'default' => 9,
                    ),
                    array(
                        'id' => 'search_loop_style',
                        'type' => 'select',
                        'title' => esc_html__('Search Loop Style', 'aquila'),
                        'desc' => '',
                        'options' => array(
                            'grid' => esc_html__( 'Grid', 'js_composer' ),
                            'medium' => esc_html__( 'medium', 'js_composer' ),
                            'masonry' => esc_html__( 'Masonry', 'js_composer' ),
                        ),
                        'default' => 'grid'
                    ),
                    array(
                        'id' => 'search_first_featured',
                        'type' => 'switch',
                        'title' => esc_html__('First featured', 'aquila'),
                        'desc' => esc_html__('Show First article featured or?.', 'aquila'),
                        "default" => 0,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),
                    array(
                        'id' => 'search_columns',
                        'type' => 'select',
                        'title' => esc_html__('Columns on desktop', 'aquila'),
                        'desc' => '',
                        'options' => array(
                            '2' => esc_html__( '2 columns', 'js_composer' ) ,
                            '3' => esc_html__( '3 columns', 'js_composer' ) ,
                            '4' => esc_html__( '4 columns', 'js_composer' ) ,
                        ),
                        'default' => '3',
                        'required' => array('search_loop_style','equals', array( 'grid', 'masonry' ) ),
                    ),
                    array(
                        'id' => 'search_pagination',
                        'type' => 'select',
                        'title' => esc_html__('Pagination Type', 'aquila'),
                        'desc' => esc_html__('Select the pagination type.', 'aquila'),
                        'options' => array(
                            'normal' => esc_html__( 'Normal pagination', 'aquila' ),
                            'button' => esc_html__( 'Next - Previous button', 'aquila' ),
                        ),
                        'default' => 'normal'
                    ),
                    array(
                        'id' => 'search_excerpt_length',
                        'type' => 'text',
                        'title' => esc_html__('Excerpt Length', 'aquila'),
                        'desc' => esc_html__("Insert the number of words you want to show in the post excerpts.", 'aquila'),
                        'default' => 35,
                    )
                )
            );

            $this->sections[] = array(
                'id'            => 'social',
                'title'         => esc_html__( 'Socials', 'aquila' ),
                'desc'          => esc_html__('Social and share settings', 'aquila'),
                'icon'  => 'fa fa-facebook',
                'fields'        => array(

                    array(
                        'id' => 'twitter',
                        'type' => 'text',
                        'title' => esc_html__('Twitter', 'aquila'),
                        'subtitle' => esc_html__("Your Twitter username (no @).", 'aquila'),
                        'default' => '#'
                    ),
                    array(
                        'id' => 'facebook',
                        'type' => 'text',
                        'title' => esc_html__('Facebook', 'aquila'),
                        'subtitle' => esc_html__("Your Facebook page/profile url", 'aquila'),
                        'default' => '#'
                    ),
                    array(
                        'id' => 'pinterest',
                        'type' => 'text',
                        'title' => esc_html__('Pinterest', 'aquila'),
                        'subtitle' => esc_html__("Your Pinterest username", 'aquila'),
                        'default' => '#'
                    ),
                    array(
                        'id' => 'dribbble',
                        'type' => 'text',
                        'title' => esc_html__('Dribbble', 'aquila'),
                        'subtitle' => esc_html__("Your Dribbble username", 'aquila'),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'vimeo',
                        'type' => 'text',
                        'title' => esc_html__('Vimeo', 'aquila'),
                        'subtitle' => esc_html__("Your Vimeo username", 'aquila'),
                        'desc' => '',
                        'default' => '#'
                    ),
                    array(
                        'id' => 'tumblr',
                        'type' => 'text',
                        'title' => esc_html__('Tumblr', 'aquila'),
                        'subtitle' => esc_html__("Your Tumblr username", 'aquila'),
                        'desc' => '',
                        'default' => '#'
                    ),
                    array(
                        'id' => 'skype',
                        'type' => 'text',
                        'title' => esc_html__('Skype', 'aquila'),
                        'subtitle' => esc_html__("Your Skype username", 'aquila'),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'linkedin',
                        'type' => 'text',
                        'title' => esc_html__('LinkedIn', 'aquila'),
                        'subtitle' => esc_html__("Your LinkedIn page/profile url", 'aquila'),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'googleplus',
                        'type' => 'text',
                        'title' => esc_html__('Google+', 'aquila'),
                        'subtitle' => esc_html__("Your Google+ page/profile URL", 'aquila'),
                        'desc' => '',
                        'default' => '#'
                    ),
                    array(
                        'id' => 'youtube',
                        'type' => 'text',
                        'title' => esc_html__('YouTube', 'aquila'),
                        'subtitle' => esc_html__("Your YouTube username", 'aquila'),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'instagram',
                        'type' => 'text',
                        'title' => esc_html__('Instagram', 'aquila'),
                        'subtitle' => esc_html__("Your Instagram username", 'aquila'),
                        'desc' => '',
                        'default' => ''
                    )
                )
            );

            /**
             *  Sidebar
             **/
            $this->sections[] = array(
                'id'            => 'sidebar_section',
                'title'         => esc_html__( 'Sidebar Widgets', 'aquila' ),
                'desc'          => '',
                'icon'          => 'fa fa-columns',
                'fields'        => array(

                    array(
                        'id'          => 'custom_sidebars',
                        'type'        => 'slides',
                        'title'       => esc_html__('Slides Options', 'aquila' ),
                        'subtitle'    => esc_html__('Unlimited sidebar with drag and drop sortings.', 'aquila' ),
                        'desc'        => '',
                        'class'       => 'slider-no-image-preview',
                        'content_title' =>'Sidebar',
                        'show' => array(
                            'title' => true,
                            'description' => true,
                            'url' => false,
                        ),
                        'placeholder' => array(
                            'title'           => esc_html__('Sidebar title', 'aquila' ),
                            'description'     => esc_html__('Sidebar Description', 'aquila' ),
                        ),
                    ),
                )
            );

            /**
             *  404 Page
             **/
            $this->sections[] = array(
                'id'            => '404_section',
                'title'         => esc_html__( '404 Page', 'aquila' ),
                'desc'          => '404 Page settings',
                'icon'          => 'fa fa-times-circle',
                'fields'        => array(
                    array(
                        'id'       => 'notfound_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( '404 Page general', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'notfound_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'aquila'),
                        'desc' => esc_html__('Show page header or?.', 'aquila'),
                        "default" => 0,
                        'on' => esc_html__('Enabled', 'aquila'),
                        'off' =>esc_html__('Disabled', 'aquila')
                    ),

                    array(
                        'id' => 'notfound_page_type',
                        'type' => 'select',
                        'title' => esc_html__('404 Page', 'aquila'),
                        'desc' => '',
                        'options' => array(
                            'default' => esc_html__( 'Default', 'aquila' ) ,
                            'page' => esc_html__( 'From Page', 'aquila' ) ,
                            'home' => esc_html__( 'Redirect Home', 'aquila' ) ,
                        ),
                        'default' => 'default',
                    ),

                    array(
                        'id'       => 'notfound_page_id',
                        'type'     => 'select',
                        'data'     => 'pages',
                        'title'    => esc_html__( 'Pages Select Option', 'aquila' ),
                        'desc'     => esc_html__( 'Select your page 404 you want use', 'aquila' ),
                        'required' => array( 'notfound_page_type', '=', 'page' ),
                    ),

                )
            );

            /**
             *  Advanced
             **/
            $this->sections[] = array(
                'id'            => 'advanced',
                'title'         => esc_html__( 'Advanced', 'aquila' ),
                'desc'          => '',
                'icon'  => 'fa fa-cog',
            );

            /**
             *  Advanced Social Share
             **/
            $this->sections[] = array(
                'id'            => 'share_section',
                'title'         => esc_html__( 'Social Share', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'social_share',
                        'type'     => 'sortable',
                        'mode'     => 'checkbox', // checkbox or text
                        'title'    => esc_html__( 'Social Share', 'aquila' ),
                        'desc'     => esc_html__( 'Reorder and Enable/Disable Social Share Buttons.', 'aquila' ),
                        'options'  => array(
                            'facebook' => esc_html__('Facebook', 'aquila'),
                            'twitter' => esc_html__('Twitter', 'aquila'),
                            'google_plus' => esc_html__('Google+', 'aquila'),
                            'pinterest' => esc_html__('Pinterest', 'aquila'),
                            'linkedin' => esc_html__('Linkedin', 'aquila'),
                            'tumblr' => esc_html__('Tumblr', 'aquila'),
                            'mail' => esc_html__('Mail', 'aquila'),
                        ),
                        'default'  => array(
                            'facebook' => true,
                            'twitter' => true,
                            'google_plus' => true,
                            'pinterest' => false,
                            'linkedin' => false,
                            'tumblr' => false,
                            'mail' => false,
                        )
                    )
                )
            );


            /**
             *  Advanced Socials API
             **/
            $this->sections[] = array(
                'id'            => 'socials_api_section',
                'title'         => esc_html__( 'Socials API', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'facebook_app_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Facebook App', 'aquila' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'facebook_app',
                        'type' => 'text',
                        'title' => esc_html__('Facebook App ID', 'aquila'),
                        'subtitle' => esc_html__("Add Facebook App ID.", 'aquila'),
                        'default' => '417674911655656'
                    )
                )
            );


            /**
             *  Advanced Custom CSS
             **/
            $this->sections[] = array(
                'id'            => 'advanced_css',
                'title'         => esc_html__( 'Custom CSS', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'advanced_editor_css',
                        'type'     => 'ace_editor',
                        'title'    => esc_html__( 'CSS Code', 'aquila' ),
                        'subtitle' => esc_html__( 'Paste your CSS code here.', 'aquila' ),
                        'mode'     => 'css',
                        'theme'    => 'chrome',
                        'full_width' => true
                    ),
                )
            );
            /**
             *  Advanced Custom CSS
             **/
            $this->sections[] = array(
                'id'            => 'advanced_js',
                'title'         => esc_html__( 'Custom JS', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'advanced_editor_js',
                        'type'     => 'ace_editor',
                        'title'    => esc_html__( 'JS Code', 'aquila' ),
                        'subtitle' => esc_html__( 'Paste your JS code here.', 'aquila' ),
                        'mode'     => 'javascript',
                        'theme'    => 'chrome',
                        'default'  => "jQuery(document).ready(function(){\n\n});",
                        'full_width' => true
                    ),
                )
            );
            /**
             *  Advanced Tracking Code
             **/
            $this->sections[] = array(
                'id'            => 'advanced_tracking',
                'title'         => esc_html__( 'Tracking Code', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'advanced_tracking_code',
                        'type'     => 'textarea',
                        'title'    => esc_html__( 'Tracking Code', 'aquila' ),
                        'desc'     => esc_html__( 'Paste your Google Analytics (or other) tracking code here. This will be added into the header template of your theme. Please put code inside script tags.', 'aquila' ),
                    )
                )
            );

            $info_arr = array();
            $theme = wp_get_theme();

            $info_arr[] = "<li><span>".esc_html__('Theme Name:', 'aquila')." </span>". $theme->get('Name').'</li>';
            $info_arr[] = "<li><span>".esc_html__('Theme Version:', 'aquila')." </span>". $theme->get('Version').'</li>';
            $info_arr[] = "<li><span>".esc_html__('Theme URI:', 'aquila')." </span>". $theme->get('ThemeURI').'</li>';
            $info_arr[] = "<li><span>".esc_html__('Author:', 'aquila')." </span>". $theme->get('Author').'</li>';

            $system_info = sprintf("<div class='troubleshooting'><ul>%s</ul></div>", implode('', $info_arr));

            /**
             *  Advanced Troubleshooting
             **/
            $this->sections[] = array(
                'id'            => 'advanced_troubleshooting',
                'title'         => esc_html__( 'Troubleshooting', 'aquila' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'opt-raw_info_4',
                        'type'     => 'raw',
                        'content'  => $system_info,
                        'full_width' => true
                    ),
                )
            );

        }
    }
    
    global $reduxConfig;
    $reduxConfig = new KT_config();
    
} else {
    echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
}


<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

//  0 - unsorted and appended to bottom Default  
//  1 - Appended to top)


$visibilities_arr = array('vc_empty_space');
foreach($visibilities_arr as $item){
    vc_add_param($item, array(
        "type" => "dropdown",
        "heading" => __("Visibility",THEME_LANG),
        "param_name" => "visibility",
        "value" => array(
            __('Always Visible', THEME_LANG) => '',
            __('Visible on Phones', THEME_LANG) => 'visible-xs-block',
            __('Visible on Tablets', THEME_LANG) => 'visible-sm-block',
            __('Visible on Desktops', THEME_LANG) => 'visible-md-block',
            __('Visible on Desktops Large', THEME_LANG) => 'visible-lg-block',

            __('Hidden on Phones', THEME_LANG) => 'hidden-xs',
            __('Hidden on Tablets', THEME_LANG) => 'hidden-sm',
            __('Hidden on Desktops', THEME_LANG) => 'hidden-md',
            __('Hidden on Desktops Large', THEME_LANG) => 'hidden-lg',
        ),
        "description" => __("",THEME_LANG),
        "admin_label" => true,
    ));
}

vc_add_params("vc_custom_heading", array(
    array(
        "type" => "kt_number",
        "heading" => __("Letter spacing", THEME_LANG),
        "param_name" => "letter_spacing",
        "min" => 0,
        "suffix" => "px",
        'group' => __( 'Extra', 'js_composer' )
    )
));


$composer_addons = array(
    //'dropcap.php',
    'blockquote.php',
    'googlemap.php',
    'socials.php',
    'gallery-grid.php',
    'gallery-justified.php',
    'kt_image_gallery.php'
);

foreach ( $composer_addons as $addon ) {
	require_once( FW_DIR . 'js_composer/vc_addons/' . $addon );
}

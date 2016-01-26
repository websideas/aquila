<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

//  0 - unsorted and appended to bottom Default  
//  1 - Appended to top)


$visibilities_arr = array('vc_empty_space');
foreach($visibilities_arr as $item){
    vc_add_param($item, array(
        "type" => "dropdown",
        "heading" => esc_html__("Visibility",'adroit'),
        "param_name" => "visibility",
        "value" => array(
            esc_html__('Always Visible', 'adroit') => '',
            esc_html__('Visible on Phones', 'adroit') => 'visible-xs-block',
            esc_html__('Visible on Tablets', 'adroit') => 'visible-sm-block',
            esc_html__('Visible on Desktops', 'adroit') => 'visible-md-block',
            esc_html__('Visible on Desktops Large', 'adroit') => 'visible-lg-block',

            esc_html__('Hidden on Phones', 'adroit') => 'hidden-xs',
            esc_html__('Hidden on Tablets', 'adroit') => 'hidden-sm',
            esc_html__('Hidden on Desktops', 'adroit') => 'hidden-md',
            esc_html__('Hidden on Desktops Large', 'adroit') => 'hidden-lg',
        ),
        "admin_label" => true,
    ));
}

vc_add_params("vc_custom_heading", array(
    array(
        "type" => "kt_number",
        "heading" => esc_html__("Letter spacing", 'adroit'),
        "param_name" => "letter_spacing",
        "min" => 0,
        "suffix" => "px",
        'group' => esc_html__( 'Extra', 'js_composer' )
    )
));


$composer_addons = array(
    //'dropcap.php',
    'blockquote.php',
    'googlemap.php',
    'socials.php',
    'gallery-grid.php',
    'gallery_fullwidth.php',
    'gallery-justified.php'
);

foreach ( $composer_addons as $addon ) {
	require_once( KT_FW_DIR . 'js_composer/vc_addons/' . $addon );
}

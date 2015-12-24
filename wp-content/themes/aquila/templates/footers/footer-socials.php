<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$footer_socials = kt_option('footer_socials');
$footer_socials_style = kt_option('footer_socials_style', 'custom');
$footer_socials_size = kt_option('footer_socials_size', 'small');
$footer_socials_space_between_item = kt_option('footer_socials_space_between_item', 18);
$footer_custom_color = kt_option( 'custom_color_social', '#999999' );

echo do_shortcode('[socials social="'.$footer_socials.'" align="center" space_between_item="'.$footer_socials_space_between_item.'" size="'.$footer_socials_size.'" style="'.$footer_socials_style.'" custom_color="'.$footer_custom_color.'" background_style="text"]');
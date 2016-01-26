<?php
function adroit_child_scripts() {
    wp_enqueue_style( 'adroit-child-stylesheet', get_template_directory_uri() . '/style.css' );
}
add_action('wp_enqueue_scripts', 'adroit_child_scripts');
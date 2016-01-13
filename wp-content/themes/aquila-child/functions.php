<?php
function aquila_child_scripts() {
    wp_enqueue_style( 'aquila-child-stylesheet', get_template_directory_uri() . '/style.css' );
}
add_action('wp_enqueue_scripts', 'aquila_child_scripts');
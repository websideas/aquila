<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**==============================
***  Like Post
===============================**/


add_action( 'wp_ajax_fronted_likepost', 'wp_ajax_fronted_likepost_callback' );
add_action( 'wp_ajax_nopriv_fronted_likepost', 'wp_ajax_fronted_likepost_callback' );


function wp_ajax_fronted_likepost_callback() {
    check_ajax_referer( 'ajax_frontend', 'security' );
    
    if(!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) return;
     
    $post_id = $_POST['post_id'];
     
    $output = array();    
    
    $like_count = get_post_meta($post_id, '_like_post', true);

    if( !isset($_COOKIE['like_post_'. $post_id]) ){
        $like_count++;
        update_post_meta($post_id, '_like_post', $like_count);

        //The cookie will expire after 30 days
        setcookie('like_post_'. $post_id, $post_id, time() + (86400 * 30), '/');
    }
    $text = ($like_count == 0 || $like_count == 1) ? __('like',THEME_LANG) : __('likes',THEME_LANG);

    $output['count'] = $like_count. ' '.$text;
    echo json_encode($output);
    die();
}

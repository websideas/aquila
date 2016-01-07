<?php
//session_start();
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

// Script version, used to add version for scripts and styles
define( 'KT_THEME_VER', '1.0' );

define( 'KT_THEME_OPTIONS', 'aquila_option' );

define( 'KT_THEME_DIR', trailingslashit(get_template_directory()));
define( 'KT_THEME_URL', trailingslashit(get_template_directory_uri()));
define( 'KT_THEME_TEMP', trailingslashit(KT_THEME_DIR.'templates'));

define( 'KT_THEME_ASSETS', trailingslashit( KT_THEME_URL . 'assets' ) );
define( 'KT_THEME_FONTS', trailingslashit( KT_THEME_ASSETS . 'fonts' ) );
define( 'KT_THEME_LIBS', trailingslashit( KT_THEME_ASSETS . 'libs' ) );
define( 'KT_THEME_JS', trailingslashit( KT_THEME_ASSETS . 'js' ) );
define( 'KT_THEME_CSS', trailingslashit( KT_THEME_ASSETS . 'css' ) );
define( 'KT_THEME_IMG', trailingslashit( KT_THEME_ASSETS . 'images' ) );

//Include framework
require_once ( KT_THEME_DIR .'framework/core.php');


// Get All meta box for all post type.
if ( class_exists( 'KT_Meta_Box' ) ) {
	require_once (THEME_KT_FW_DATA . 'data-metaboxes.php');
}

<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$position = kt_get_header();

?>
<div id="header-inner" class="clearfix apply-sticky">
    <?php
    if($position == 'below'){
        /**
         * @hooked kt_slideshows_position_callback 10
         */
        do_action( 'kt_slideshows_position' );
    }
    ?>
    <div class="container">
        <div class="header-branding-outer clearfix">
            <div class="site-branding">
                <?php get_template_part( 'templates/headers/header',  'branding'); ?>
            </div><!-- .site-branding -->
            <div class="nav-container">
                <nav id="nav" class="nav-main">
                    <?php get_template_part( 'templates/headers/header',  'menu'); ?>
                </nav><!-- #main-nav -->
            </div><!-- .nav-container -->
            <?php get_template_part( 'templates/headers/header',  'tool'); ?>
            <?php get_template_part( 'templates/headers/header',  'socials'); ?>
        </div>
    </div><!-- .container -->
    <?php
    if($position != 'below'){
        /**
         * @hooked kt_slideshows_position_callback 10
         */
        do_action( 'kt_slideshows_position' );
    }
    ?>
</div>
<?php get_template_part( 'templates/headers/header',  'brandingalt'); ?>
<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<div id="header-inner">
    <div id="header-content" class="clearfix apply-sticky">
        <div class="header-sticky-background"></div>
        <div class="container">
            <div class="header-branding-outer clearfix">

                <div class="nav-container">
                    <nav id="nav" class="nav-main">
                        <?php get_template_part( 'templates/headers/header',  'menu'); ?>
                    </nav><!-- #main-nav -->
                </div><!-- .nav-container -->
                <?php get_template_part( 'templates/headers/header',  'tool'); ?>
                <?php get_template_part( 'templates/headers/header',  'socials'); ?>
            </div>
        </div><!-- .container -->
    </div>
    <?php get_template_part( 'templates/headers/header',  'brandingalt'); ?>

</div>

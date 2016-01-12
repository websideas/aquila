<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?>

<ul id="main-nav-tool" class="hidden-xs hidden-sm">
    <?php do_action('kt_main_tool'); ?>
    <?php if ( kt_option('header_search', 1) ) { ?>
        <li class="mini-search">
            <a href="#"><i class="fa fa-search"></i></a>
            <?php get_search_form(); ?>
        </li>
    <?php } ?>
    <?php if ( kt_option('header_bars', 1) && is_active_sidebar( 'side-widget-area' ) ) { ?>
        <li class="mini-hamburger">
            <a data-side="left" class="menu-bars-link hamburger-icon" href="#">
                <span class="hamburger-icon-inner">
                    <span class="line line-1"></span>
                    <span class="line line-2"></span>
                    <span class="line line-3"></span>
                </span>
            </a>
        </li>
    <?php } ?>
</ul>


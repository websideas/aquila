<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?>

<ul id="main-nav-tool" class="hidden-xs hidden-sm">
    <?php if ( kt_option('header_bars', 1) ) { ?>
        <a data-side="left" class="menu-bars-link" href="#">
            <i class="fa fa-bars"></i>
        </a>
    <?php } ?>
    <?php if ( kt_option('header_search', 1) ) { ?>
        <li class="mini-search">
            <a href="#"><i class="fa fa-search"></i></a>
        </li>
    <?php } ?>
    <?php do_action('theme_main_tool'); ?>
</ul>


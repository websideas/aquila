<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

if ( has_nav_menu( 'primary' ) ) {

    $search_html = $search = $socials = '';
    if ( kt_option('header_search', 1) ) {
        if(kt_is_wc()){
            $search = get_product_search_form(false);
        }else{
            $search = get_search_form(false);
        }
    }
    $socials = '<div class="main-nav-socials">
                    <a href="#"><i class="fa fa-facebook"></i> </a>
                    <a href="#"><i class="fa fa-twitter"></i> </a>
                    <a href="#"><i class="fa fa-linkedin"></i> </a>
                    <a href="#"><i class="fa fa-behance"></i> </a>
                    <a href="#"><i class="fa fa-instagram"></i> </a>
                    <a href="#"><i class="fa fa-dribbble"></i> </a>
                </div><!-- .menu-bars-socials -->';

    $search_html = sprintf('<li class="menu-item menu-item-search-form">%s</li>', $search);
    $socials_html = sprintf('<li class="menu-item menu-item-socials">%s</li>', $socials);

    wp_nav_menu( array(
        'theme_location' => 'primary',
        'container' => 'nav',
        'container_class' => 'main-nav-mobile',
        'container_id' => 'main-nav-mobile',
        'menu_class' => 'menu navigation-mobile',
        'link_before'     => '<span>',
        'link_after'      => '</span>',
        'walker' => new KTMegaWalker(),
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s'.$search_html.$socials_html.'</ul>',
    ) );

}
<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<div id="header-content-mobile">
    <div class="container">
        <div id="header-mobile-inner" class="clearfix">
            <div class="site-branding">
                <?php
                $logo = kt_get_logo();
                $logo_class = ($logo['retina']) ? 'retina-logo-wrapper' : '';
                ?>
                <p class="site-logo <?php echo esc_attr($logo_class); ?>">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img src="<?php echo esc_url($logo['default']); ?>" class="default-logo" alt="<?php bloginfo( 'name' ); ?>" />
                        <?php if($logo['retina']){ ?>
                            <img src="<?php echo esc_url($logo['retina']); ?>" class="retina-logo" alt="<?php bloginfo( 'name' ); ?>" />
                        <?php } ?>
                    </a>
                </p><!-- .site-logo -->
            </div><!-- .site-branding -->
            <div class="header-mobile-tools">
                <a class="socials-mobile" href="#socials-mobile">
                    <i class="fa fa-share-alt"></i>
                </a>
                <a title="Menu" href="#" id="hamburger-icon" class="">
                    <span class="hamburger-icon-inner">
                        <span class="line line-1"></span>
                        <span class="line line-2"></span>
                        <span class="line line-3"></span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
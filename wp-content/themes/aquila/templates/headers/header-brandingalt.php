<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$logo = kt_get_logo();
$logo_class = ($logo['retina']) ? 'retina-logo-wrapper' : '';

?>
<div class="site-brandingalt">
    <p class="site-logo <?php echo esc_attr($logo_class); ?>">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img src="<?php echo esc_url($logo['alt']); ?>" class="default-logo" alt="<?php bloginfo( 'name' ); ?>" />
            <?php if($logo['altretina']){ ?>
                <img src="<?php echo esc_url($logo['altretina']); ?>" class="retina-logo" alt="<?php bloginfo( 'name' ); ?>" />
            <?php } ?>
        </a>
    </p><!-- .site-logo -->
    <p class="site-desc"><?php bloginfo( 'description' ); ?></p>
</div>
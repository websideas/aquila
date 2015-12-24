<?php

    $layout = kt_option('footer_bottom_layout', 1);

?>

<?php if($layout == 1){ ?>
    <?php if( is_active_sidebar( 'footer-bottom-1' ) ) { ?>
        <footer id="footer-bottom" class="footer-bottom-1">
            <div class="container">
                <p class="logo-footer">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img src="<?php echo THEME_IMG.'footer-logo.png' ?>"  alt="<?php bloginfo( 'name' ); ?>"/>
                    </a>
                </p>
                <?php dynamic_sidebar('footer-bottom-1') ?>
            </div><!-- .container -->
        </footer><!-- #footer-bottom -->
    <?php } ?>
<?php }else{ ?>
    <?php if( is_active_sidebar( 'footer-bottom-1' ) || is_active_sidebar( 'footer-bottom-2' )){ ?>
        <footer id="footer-bottom" class="footer-bottom-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <?php dynamic_sidebar('footer-bottom-1') ?>
                    </div>
                    <div class="col-md-4">
                        <?php dynamic_sidebar('footer-bottom-2') ?>
                    </div>
                </div>

            </div><!-- .container -->
        </footer><!-- #footer-bottom -->
    <?php } ?>
<?php } ?>

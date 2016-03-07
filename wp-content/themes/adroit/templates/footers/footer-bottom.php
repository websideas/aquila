<?php

    $layout = kt_option('footer_bottom_layout', 1);
?>

<?php if($layout == 1){ ?>
    <footer id="footer-bottom" class="footer-bottom-1">
        <div class="container">
            <div class="logo-footer">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php
                        $logo_footer = kt_option('logo_footer');
                        if( $logo_footer['url'] ){
                            $logo_footer_url = $logo_footer['url'];
                        }else{
                            $logo_footer_url = KT_THEME_IMG.'footer-logo.png';
                        }
                    ?>
                    <img src="<?php echo $logo_footer_url; ?>"  alt="<?php bloginfo( 'name' ); ?>"/>
                </a>
            </div>
            <?php if( is_active_sidebar( 'footer-bottom-1' ) ) { ?>
                <div class="footer-bottom-content">
                    <?php dynamic_sidebar('footer-bottom-1') ?>
                </div>
            <?php } ?>
        </div><!-- .container -->
    </footer><!-- #footer-bottom -->
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

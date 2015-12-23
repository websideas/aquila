<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 */
?>
                <?php
                /**
                 * @hooked
                 *
                 */
                do_action( 'theme_content_bottom' ); ?>
            </div><!-- #content -->
        </div><!-- #wrapper-content -->
        <?php if(kt_option('footer', true)){ ?>
            <?php
        	/**
        	 * @hooked 
             * theme_after_footer_addscroll 10
             * 
        	 */
        	do_action( 'theme_before_footer' ); ?>
            <div id="footer">
                <?php if(is_active_sidebar( 'instagram-footer' )){ ?>
                    <footer id="instagram-footer">
                        <?php dynamic_sidebar('instagram-footer') ?>
                    </footer><!-- #footer-top -->
                <?php } ?>
                <?php if( is_active_sidebar( 'footer-top' ) ){ ?>
                    <footer id="footer-top">
                        <?php dynamic_sidebar('footer-top') ?>
                    </footer><!-- #footer-top -->
                <?php } ?>
                <?php

                get_template_part( 'templates/footers/footer', 'navigation');

                get_template_part( 'templates/footers/footer', 'socials');

                if(kt_option('footer_widgets', true)){
                    get_template_part( 'templates/footers/footer', 'widgets');
                }
                ?>

                <?php if(kt_option('footer_copyright', true)){ ?>
                    <footer id="footer-copyright">
                        <div class="container">
                            <?php get_template_part( 'templates/footers/footer', 'copyright'); ?>
                        </div><!-- .container -->
                    </footer><!-- #footer-copyright -->
                <?php } ?>
            </div><!-- #footer -->
            <?php
        	/**
        	 * @hooked 
        	 */
        	do_action( 'theme_after_footer' ); ?>
        <?php } ?>
    </div><!-- #page -->
</div><!-- #page_outter -->
<?php wp_footer(); ?>

</body>
</html>

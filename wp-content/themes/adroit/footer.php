<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 */
?>
                <?php do_action( 'kt_content_bottom' ); ?>
            </div><!-- #content -->
        </div><!-- #wrapper-content -->
        <?php if(kt_option('footer', true)){ ?>
            <?php do_action( 'kt_before_footer' ); ?>
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

                if(kt_option('footer_widgets', true)){
                    get_template_part( 'templates/footers/footer', 'widgets');
                }

                if(kt_option('footer_bottom', true)){
                    get_template_part( 'templates/footers/footer', 'bottom');
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
            <?php do_action( 'kt_after_footer' ); ?>
        <?php } ?>
    </div><!-- #page -->
</div><!-- #page_outter -->
<?php wp_footer(); ?>
</body>
</html>

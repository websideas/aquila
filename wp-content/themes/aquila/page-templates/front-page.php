<?php
/**
 * Template Name: Front Page
 *
 * @package aquila
 */

$sidebar = kt_get_archive_sidebar();
$settings = kt_get_settings_archive();

get_header(); ?>
    <div class="container">
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_before_main' ); ?>
        <div class="row">
            <div id="main" class="<?php echo apply_filters('kt_main_class', 'main-class', $sidebar['sidebar']); ?>" role="main">
                <?php do_action('before_blog_posts_loop'); ?>
                <?php if ( have_posts() ) : ?>

                <?php
                // If no content, include the "No posts found" template.
                else :
                get_template_part( 'templates/content', 'none' );

                endif;
                ?>
                <?php do_action('after_blog_posts_loop'); ?>
            </div>
            <?php if($sidebar['sidebar'] != 'full'){ ?>
                <div class="<?php echo apply_filters('kt_sidebar_class', 'sidebar', $sidebar['sidebar']); ?>">
                    <?php dynamic_sidebar($sidebar['sidebar_area']); ?>
                </div><!-- .sidebar -->
            <?php } ?>

        </div><!-- .row -->
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_after_main' ); ?>
    </div><!-- .container -->


<?php get_footer(); ?>
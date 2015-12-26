<?php
/**
 * The template for displaying single post
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 */

get_header();

$post_id = get_the_ID();

$layout = get_post_meta($post_id, '_kt_blog_post_layout', true);
$sidebar = array('sidebar' => 'right', 'sidebar_area' => 'primary-widget-area');
$post_id = get_the_ID();
$imagesize = 'full';

?>

    <?php if( ! post_password_required( ) && $layout == 3 ){ ?>
        <div class="entry-thumb-fullwidth"><?php kt_post_thumbnail($imagesize, 'img-responsive', false); ?></div>
    <?php } ?>
    <div class="container">
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_before_main' ); ?>


        <?php
            $main_column = ($sidebar['sidebar']) ? '8' : '12';
            $sidebar_class = ($sidebar['sidebar']) ? 'sidebar-'.$sidebar['sidebar'] : 'no-sidebar';
            $pull_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';
        ?>
        <?php if( ! post_password_required( ) && $layout == 4 ){ ?>
            <div class="entry-thumb-fullwidth"><?php kt_post_thumbnail($imagesize, 'img-responsive', false); ?></div>
        <?php } ?>
        <div class="row main <?php echo $sidebar_class; ?>">

            <?php echo '<div class="main-content col-md-'.$main_column.' '.$pull_class.'">'; ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php
                        // Include the page content template.
                        get_template_part( 'templates/content', 'single' );
                    ?>
                <?php endwhile; // end of the loop. ?>
            </div><!-- .main-content -->

            <?php if($sidebar['sidebar']){ ?>
                <?php echo '<div class="col-md-4 sidebar">'; ?>
                    <?php dynamic_sidebar($sidebar['sidebar_area']); ?>
                </div><!-- .sidebar -->
            <?php } ?>

        </div><!-- .main -->
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_after_main' ); ?>
    </div><!-- .container -->
<?php get_footer(); ?>